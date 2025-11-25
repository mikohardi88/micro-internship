<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectApplication;
use App\Models\Placement;
use App\Notifications\ApplicationSubmittedNotification;
use App\Notifications\PlacementCreatedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentProjectController extends Controller
{
    // List approved projects with simple filters
    public function index(Request $request)
    {
        $query = Project::query()
            ->where('status', 'approved')  // Change from 'open' to 'approved' to show all approved projects
            ->whereHas('company')
            ->with(['company'])
            ->withCount('applications');

        if ($search = $request->get('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%");
            });
        }

        if ($duration = $request->get('duration_weeks')) {
            $query->where('duration_weeks', $duration);
        }

        $projects = $query->latest()->paginate(10);
        return response()->json($projects);
    }

    // Show browse page (Blade) for students
    public function browse(Request $request)
    {
        $query = Project::query()
            ->where('status', 'approved')  // Change from 'open' to 'approved' to show all approved projects
            ->whereHas('company')
            ->with(['company'])
            ->withCount('applications');
        if ($search = $request->get('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%");
            });
        }
        if ($duration = $request->get('duration_weeks')) {
            $query->where('duration_weeks', $duration);
        }
        $projects = $query->latest()->paginate(10);
        return view('student.projects.browse', compact('projects'));
    }

    // Apply to a project
    public function apply(Request $request, Project $project)
    {
        if ($project->status !== 'approved') {
            return redirect()
                ->route('student.projects.browse')
                ->with('error', 'Project ini belum disetujui untuk aplikasi.');
        }

        $data = $request->validate([
            'cover_letter' => 'nullable|string',
        ]);

        // Prevent duplicate application
        $existing = ProjectApplication::where('project_id', $project->id)
            ->where('user_id', Auth::id())
            ->first();
        if ($existing) {
            return redirect()
                ->route('student.projects.browse')
                ->with('error', 'Anda sudah mendaftar untuk proyek ini.');
        }

        // Check if project already has placement
        if (Placement::where('project_id', $project->id)->exists()) {
            return redirect()
                ->route('student.projects.browse')
                ->with('error', 'Proyek ini sudah memiliki penempatan.');
        }

        // Create application
        $app = new ProjectApplication();
        $app->project_id = $project->id;
        $app->user_id = Auth::id();
        $app->cover_letter = $data['cover_letter'] ?? null;
        $app->status = 'accepted'; // Auto-accept based on student choice
        $app->applied_at = now();
        $app->decided_at = now();
        $app->decision_notes = 'Mahasiswa memilih proyek ini secara langsung';
        $app->save();

        // Create placement immediately based on student's choice
        $placement = new Placement();
        $placement->project_id = $project->id;
        $placement->user_id = Auth::id();
        $placement->status = 'matched';
        $placement->started_at = now();
        $placement->save();

        // Update project status
        $project->status = 'in_progress';
        $project->save();

        // Send notification to student about placement
        Auth::user()->notify(new PlacementCreatedNotification($placement));

        // Send notification to company about new placement
        $project->company->user->notify(new ApplicationSubmittedNotification($app));

        return redirect()
            ->route('student.placements.show', $placement)
            ->with('success', 'Selamat! Anda telah ditempatkan di proyek magang ' . $project->title);
    }

    // Apply form (Blade)
    public function applyForm(Project $project)
    {
        if ($project->status !== 'approved') {
            return redirect()
                ->route('student.projects.browse')
                ->with('error', 'Project ini belum disetujui untuk aplikasi.');
        }

        return view('student.projects.apply', compact('project'));
    }

    // Cancel application by the same user
    public function cancel(Project $project)
    {
        $app = ProjectApplication::where('project_id', $project->id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        abort_if(in_array($app->status, ['accepted','rejected']), 422, 'Cannot cancel after decision.');
        $app->delete();

        return response()->json(['cancelled' => true]);
    }

    // Helper: get current user's placement for a project (if exists)
    public function myPlacement(Project $project)
    {
        $placement = Placement::where('project_id', $project->id)
            ->where('user_id', Auth::id())
            ->first();
        return response()->json($placement);
    }
}
