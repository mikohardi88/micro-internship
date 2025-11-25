<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Company;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CompanyProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $company = Company::where('user_id', Auth::id())->firstOrFail();
        $projects = Project::with(['skills', 'applications'])
            ->where('company_id', $company->id)
            ->withCount('applications')
            ->latest()
            ->paginate(10);
            
        return view('company.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $project = new Project();
        return view('company.project_create', [
            'project' => $project,
            'method' => 'POST',
            'action' => route('company.projects.store'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'brief' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'duration_weeks' => 'required|integer|min:1|max:12',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'max_applicants' => 'nullable|integer|min:1',
            'budget' => 'nullable|integer|min:0',
            'category' => 'required|string|max:255',
            'requirements' => 'nullable|string',
            'deliverables' => 'required|string',
            'skills' => 'required|string',
        ]);

        $company = Company::where('user_id', Auth::id())->firstOrFail();

        DB::beginTransaction();
        try {
            // Handle file upload
            if ($request->hasFile('brief')) {
                $file = $request->file('brief');
                $filename = 'brief_' . time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('project_briefs', $filename, 'public');
                $validated['brief_path'] = $path;
            }

            $validated['company_id'] = $company->id;
            $validated['status'] = 'pending'; // Awaiting admin approval
            $validated['slug'] = Str::slug($validated['title']) . '-' . time();

            // Extract skills from comma-separated string
            $skillNames = collect(explode(',', $request->input('skills', '')))
                ->map(fn ($name) => trim($name))
                ->filter()
                ->unique();

            if ($skillNames->isEmpty()) {
                return back()->withInput()->withErrors(['skills' => 'Minimal satu skill harus diisi.']);
            }

            // Store skills_text on project
            $validated['skills_text'] = $skillNames->implode(',');

            // Create project
            $project = Project::create($validated);

            // Store skills_text on project
            $validated['skills_text'] = $skillNames->implode(',');

            // Ensure Skill records exist and sync
            $skillIds = [];
            foreach ($skillNames as $name) {
                $skill = Skill::firstOrCreate(['name' => $name]);
                $skillIds[] = $skill->id;
            }

            $project->update($validated);

            $project->skills()->sync($skillIds);

            DB::commit();
            
            return redirect()->route('company.projects.index')
                ->with('success', 'Project created successfully! Waiting for admin approval.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to create project: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $this->authorizeProject($project);
        $project->load(['skills', 'applications']);
        return view('company.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $this->authorizeProject($project);
        return view('company.project_create', [
            'project' => $project,
            'method' => 'POST', // HTML forms don't support PUT directly; we spoof with _method
            'action' => route('company.projects.update', $project),
            'isEdit' => true,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $this->authorizeProject($project);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'brief' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'duration_weeks' => 'required|integer|min:1|max:12',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'sometimes|required|string|in:draft,pending,approved,rejected,open,completed,closed',
            'max_applicants' => 'nullable|integer|min:1',
            'budget' => 'nullable|integer|min:0',
            'category' => 'required|string|max:255',
            'requirements' => 'nullable|string',
            'deliverables' => 'required|string',
            'skills' => 'required|string',
            'remove_brief' => 'sometimes|boolean',
        ]);

        DB::beginTransaction();
        try {
            // Handle file upload
            if ($request->hasFile('brief')) {
                // Delete old file if exists
                if ($project->brief_path) {
                    Storage::disk('public')->delete($project->brief_path);
                }
                
                $file = $request->file('brief');
                $filename = 'brief_' . time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('project_briefs', $filename, 'public');
                $validated['brief_path'] = $path;
            } elseif ($request->boolean('remove_brief') && $project->brief_path) {
                // Remove existing file if remove_brief is checked
                Storage::disk('public')->delete($project->brief_path);
                $validated['brief_path'] = null;
            }

            // If status is being changed to open, ensure it's approved first
            if (isset($validated['status']) && $validated['status'] === 'open' && $project->status !== 'approved') {
                $validated['status'] = 'pending'; // Needs admin approval again
            }

            // Update slug if title changed
            if (isset($validated['title']) && $validated['title'] !== $project->title) {
                $validated['slug'] = Str::slug($validated['title']) . '-' . time();
            }

            // Extract skills from comma-separated string
            $skillNames = collect(explode(',', $request->input('skills', '')))
                ->map(fn ($name) => trim($name))
                ->filter()
                ->unique();

            if ($skillNames->isEmpty()) {
                return back()->withInput()->withErrors(['skills' => 'Minimal satu skill harus diisi.']);
            }

            // Ensure Skill records exist and sync
            $skillIds = [];
            foreach ($skillNames as $name) {
                $skill = Skill::firstOrCreate(['name' => $name]);
                $skillIds[] = $skill->id;
            }

            $project->skills()->sync($skillIds);

            DB::commit();
            
            return redirect()->route('company.projects.show', $project)
                ->with('success', 'Project updated successfully!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to update project: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $this->authorizeProject($project);
        
        DB::beginTransaction();
        try {
            // Delete associated files
            if ($project->brief_path) {
                Storage::disk('public')->delete($project->brief_path);
            }
            
            // Delete related records
            $project->skills()->detach();
            
            // Delete the project
            $project->delete();
            
            DB::commit();
            
            return redirect()->route('company.projects.index')
                ->with('success', 'Project deleted successfully!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete project: ' . $e->getMessage());
        }
    }

    /**
     * Download project brief file.
     */
    public function downloadBrief(Project $project)
    {
        $this->authorizeProject($project);
        
        if (!$project->brief_path) {
            return back()->with('error', 'No brief file available for this project.');
        }
        
        return Storage::disk('public')->download($project->brief_path);
    }

    /**
     * Close project for new applications.
     */
    public function close(Project $project)
    {
        $this->authorizeProject($project);
        
        if ($project->status !== 'open') {
            return back()->with('error', 'Only open projects can be closed.');
        }
        
        $project->update(['status' => 'in_progress']);
        
        return back()->with('success', 'Project has been closed for new applications.');
    }

    /**
     * Authorize that the user owns the project.
     */
    protected function authorizeProject(Project $project)
    {
        $company = Company::where('user_id', Auth::id())->firstOrFail();
        if ($project->company_id !== $company->id) {
            abort(403, 'Unauthorized action.');
        }
    }
}
