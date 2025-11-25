<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Notifications\ProjectApprovedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of projects needing approval.
     */
    public function index(Request $request)
    {
        // Check if user has admin role
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        $status = $request->get('status', 'pending');

        $projects = Project::with('company')
            ->when($status === 'pending', function($q) {
                return $q->where('status', 'pending');
            })
            ->when($status === 'approved', function($q) {
                return $q->where('status', 'approved');
            })
            ->when($status === 'rejected', function($q) {
                return $q->where('status', 'rejected');
            })
            ->latest()
            ->paginate(10);

        return view('admin.projects.index', compact('projects', 'status'));
    }

    /**
     * Show the specified project for review.
     */
    public function show(Project $project)
    {
        // Check if user has admin role
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        $project->load(['company', 'approvedBy']);
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Approve a pending project.
     */
    public function approve(Request $request, Project $project)
    {
        // Check if user has admin role
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        if ($project->status !== 'pending') {
            return back()->with('error', 'Only pending projects can be approved.');
        }

        $project->update([
            'status' => 'approved',
            'admin_notes' => $request->input('notes'),
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        // Send notification to company about approved project
        $project->company->user->notify(new ProjectApprovedNotification($project));

        return redirect()
            ->route('admin.projects.show', $project)
            ->with('success', 'Project has been approved.');
    }

    /**
     * Reject a pending project.
     */
    public function reject(Request $request, Project $project)
    {
        // Check if user has admin role
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'reject_reason' => 'required|string|min:10',
        ]);

        if ($project->status !== 'pending') {
            return back()->with('error', 'Only pending projects can be rejected.');
        }

        $project->update([
            'status' => 'rejected',
            'admin_notes' => $request->input('reject_reason'),
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Project has been rejected.');
    }

    /**
     * Update project status to open for applications.
     */
    public function publish(Project $project)
    {
        // Check if user has admin role
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        if ($project->status !== 'approved') {
            return back()->with('error', 'Only approved projects can be published.');
        }

        $project->update([
            'status' => 'open',
        ]);

        return back()->with('success', 'Project is now open for applications.');
    }
}
