<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectApplication;
use App\Models\Placement;
use App\Models\CourseCompletion;
use App\Models\Company;
use App\Notifications\ApplicationDecisionNotification;
use App\Notifications\PlacementCreatedNotification;
use App\Services\PlacementMatchingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyApplicationController extends Controller
{
    private PlacementMatchingService $matchingService;

    public function __construct(PlacementMatchingService $matchingService)
    {
        $this->matchingService = $matchingService;
    }
    // List all applications for the company
    public function allApplications()
    {
        $company = Company::where('user_id', Auth::id())->firstOrFail();
        
        $allApplications = ProjectApplication::with(['user', 'project'])
            ->whereHas('project', function($query) use ($company) {
                $query->where('company_id', $company->id);
            })
            ->orderByDesc('applied_at')
            ->get()
            ->map(function ($app) {
                $score = $this->matchingScore($app->user->id);
                $app->matching_score = $score;
                return $app;
            });

        // Filter by status if requested
        $status = request('status', 'all');
        if ($status !== 'all') {
            $applications = $allApplications->where('status', $status);
        } else {
            $applications = $allApplications;
        }

        // Get counts for tabs
        $pendingApplications = $allApplications->where('status', 'pending');
        $acceptedApplications = $allApplications->where('status', 'accepted');
        $rejectedApplications = $allApplications->where('status', 'rejected');

        return view('company.applications.index', compact(
            'applications', 
            'allApplications',
            'pendingApplications',
            'acceptedApplications',
            'rejectedApplications'
        ));
    }

    // List applications for a project with a simple matching score
    public function index(Project $project)
    {
        $this->authorizeProject($project);

        $applications = ProjectApplication::with('user')
            ->where('project_id', $project->id)
            ->orderByDesc('applied_at')
            ->get()
            ->map(function ($app) {
                $score = $this->matchingScore($app->user->id);
                return array_merge($app->toArray(), [
                    'matching_score' => $score,
                ]);
            });

        return view('company.projects.applications.index', compact('project', 'applications'));
    }

    // Decide accept or reject an application
    public function decide(Request $request, Project $project, ProjectApplication $application)
    {
        $this->authorizeProject($project);
        abort_unless($application->project_id === $project->id, 404);

        $data = $request->validate([
            'decision' => 'required|string|in:accept,reject',
            'note' => 'nullable|string',
        ]);

        $application->status = $data['decision'] === 'accept' ? 'accepted' : 'rejected';
        $application->decided_at = now();
        $application->decision_notes = $data['note'] ?? null;
        $application->save();

        // Send notification to applicant about the decision
        $application->user->notify(new ApplicationDecisionNotification($application, $data['decision']));

        if ($data['decision'] === 'accept') {
            // Ensure project not already placed
            if (Placement::where('project_id', $project->id)->exists()) {
                return redirect()
                    ->route('company.applications.index')
                    ->with('error', 'Proyek ini sudah memiliki penempatan.');
            }

            // Create placement for the accepted student
            $placement = new Placement();
            $placement->project_id = $project->id;
            $placement->user_id = $application->user_id;
            $placement->status = 'in_progress';
            $placement->started_at = now();
            $placement->save();

            // Update project status
            $project->status = 'in_progress';
            $project->save();

            // Reject all other pending applications for this project
            ProjectApplication::where('project_id', $project->id)
                ->where('status', 'pending')
                ->where('id', '!=', $application->id)
                ->update([
                    'status' => 'rejected',
                    'decided_at' => now(),
                    'decision_notes' => 'Project has been filled'
                ]);

            // Send placement notification to student
            $application->user->notify(new PlacementCreatedNotification($placement));
        }

        return redirect()
            ->route('company.applications.index')
            ->with('success', 'Aplikasi berhasil ' . ($data['decision'] === 'accept' ? 'diterima' : 'ditolak'));
    }

    /**
     * Automatic placement based on matching algorithm
     */
    public function autoPlace(Project $project)
    {
        $this->authorizeProject($project);

        $placement = $this->matchingService->processApplications($project);

        if ($placement) {
            return redirect()
                ->route('company.projects.applications.index', $project)
                ->with('success', 'Penempatan otomatis berhasil dilakukan untuk ' . $placement->user->name);
        }

        return redirect()
            ->route('company.projects.applications.index', $project)
            ->with('info', 'Tidak ada kandidat yang cocok untuk penempatan otomatis');
    }

    protected function authorizeProject(Project $project): void
    {
        $company = Company::where('user_id', Auth::id())->firstOrFail();
        abort_unless($project->company_id === $company->id, 403);
    }

    // Very simple matching score based on course completions count (0-100)
    protected function matchingScore(int $userId): int
    {
        $count = CourseCompletion::where('user_id', $userId)->count();
        // Cap at 5 courses => 100 pts
        $score = min($count, 5) * 20;
        return $score;
    }

    // Helper: get placement for a project (if exists)
    public function placement(Project $project)
    {
        $this->authorizeProject($project);
        $placement = Placement::where('project_id', $project->id)->first();
        return response()->json($placement);
    }
}
