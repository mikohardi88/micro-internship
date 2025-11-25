<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Project::with(['company', 'skills', 'applications']);

        if ($request->has('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $projects = $query->paginate(15);
        return response()->json($projects);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'duration_weeks' => 'required|integer|min:1|max:52',
            'status' => 'nullable|in:draft,pending,approved,rejected,open,in_progress,completed',
            'admin_notes' => 'nullable|string',
            'max_applicants' => 'nullable|integer|min:1',
            'budget' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'skills' => 'nullable|array',
            'skills.*.id' => 'required|exists:skills,id',
            'skills.*.proficiency_level' => 'nullable|in:beginner,intermediate,advanced',
        ]);

        $validated['slug'] = Str::slug($validated['title']) . '-' . time();
        $validated['status'] = $validated['status'] ?? 'draft';

        $skills = [];
        if (isset($validated['skills'])) {
            foreach ($validated['skills'] as $skill) {
                $skills[$skill['id']] = ['proficiency_level' => $skill['proficiency_level'] ?? 'beginner'];
            }
            unset($validated['skills']);
        }

        $project = Project::create($validated);

        if (!empty($skills)) {
            $project->skills()->sync($skills);
        }

        $project->load(['company', 'skills']);

        return response()->json($project, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $project->load(['company', 'skills', 'applications', 'approvedBy']);
        return response()->json($project);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'duration_weeks' => 'nullable|integer|min:1|max:52',
            'status' => 'nullable|in:draft,pending,approved,rejected,open,in_progress,completed',
            'admin_notes' => 'nullable|string',
            'max_applicants' => 'nullable|integer|min:1',
            'budget' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'skills' => 'nullable|array',
            'skills.*.id' => 'required|exists:skills,id',
            'skills.*.proficiency_level' => 'nullable|in:beginner,intermediate,advanced',
        ]);

        if (isset($validated['title']) && $validated['title'] !== $project->title) {
            $validated['slug'] = Str::slug($validated['title']) . '-' . time();
        }

        $skills = null;
        if (isset($validated['skills'])) {
            $skills = [];
            foreach ($validated['skills'] as $skill) {
                $skills[$skill['id']] = ['proficiency_level' => $skill['proficiency_level'] ?? 'beginner'];
            }
            unset($validated['skills']);
        }

        $project->update($validated);

        if ($skills !== null) {
            $project->skills()->sync($skills);
        }

        $project->load(['company', 'skills']);

        return response()->json($project);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return response()->json(['message' => 'Project deleted successfully'], 200);
    }
}

