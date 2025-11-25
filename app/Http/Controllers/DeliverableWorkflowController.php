<?php

namespace App\Http\Controllers;

use App\Models\Placement;
use App\Models\Deliverable;
use App\Models\Certificate;
use App\Models\PortfolioItem;
use App\Models\Project;
use App\Models\Company;
use App\Notifications\DeliverableSubmittedNotification;
use App\Notifications\DeliverableVerifiedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DeliverableWorkflowController extends Controller
{
    // Show form to submit a deliverable for a placement
    public function create(Placement $placement)
    {
        abort_unless($placement->user_id === Auth::id(), 403);
        return view('deliverables.create', compact('placement'));
    }

    // Student submits a deliverable for a placement they own
    public function submit(Request $request, Placement $placement)
    {
        abort_unless($placement->user_id === Auth::id(), 403);
        abort_if(!in_array($placement->status, ['matched','in_progress']), 422, 'Placement not active.');

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file',
        ]);

        $path = $request->file('file')->store('deliverables', 'public');

        $d = new Deliverable();
        $d->placement_id = $placement->id;
        $d->submitted_by = Auth::id();
        $d->title = $data['title'];
        $d->description = $data['description'] ?? null;
        $d->file_path = $path;
        $d->status = 'submitted';
        $d->submitted_at = now();
        $d->save();

        // Ensure placement is in progress
        if ($placement->status !== 'in_progress') {
            $placement->status = 'in_progress';
            $placement->start_date = $placement->start_date ?: now()->toDateString();
            $placement->save();
        }

        // Send notification to company about submitted deliverable
        $placement->project->company->user->notify(new DeliverableSubmittedNotification($d));

        return response()->json($d, 201);
    }

    // Company verifies a deliverable -> create certificate and portfolio item
    public function verify(Deliverable $deliverable)
    {
        // authorize company owns the project
        $project = Project::findOrFail($deliverable->placement->project_id);
        $company = Company::where('user_id', Auth::id())->firstOrFail();
        abort_unless($project->company_id === $company->id, 403);

        abort_unless($deliverable->status === 'submitted', 422);

        $deliverable->status = 'verified';
        $deliverable->reviewed_at = now();
        $deliverable->save();

        // Close placement and project
        $placement = $deliverable->placement;
        $placement->status = 'completed';
        $placement->end_date = now()->toDateString();
        $placement->save();

        $project->status = 'completed';
        $project->save();

        // Create certificate
        $cert = new Certificate();
        $cert->placement_id = $placement->id;
        $cert->user_id = $placement->user_id;
        $cert->certificate_number = 'VINIX-'.date('Ymd').'-'.$placement->id;
        $cert->issued_at = now();
        $cert->file_path = null; // could be generated later
        $cert->verifier = 'Vinix';
        $cert->meta = json_encode([
            'project_title' => $project->title,
        ]);
        $cert->save();

        // Create portfolio item
        $pi = new PortfolioItem();
        $pi->user_id = $placement->user_id;
        $pi->project_id = $project->id;
        $pi->title = $project->title;
        $pi->description = 'Output micro internship terverifikasi.';
        $pi->file_path = $deliverable->file_path;
        $pi->visibility = 'public';
        $pi->save();

        // Send notification to student about verified deliverable
        $placement->user->notify(new DeliverableVerifiedNotification($deliverable));

        return response()->json([
            'verified' => true,
            'certificate_id' => $cert->id,
            'portfolio_item_id' => $pi->id,
        ]);
    }
}
