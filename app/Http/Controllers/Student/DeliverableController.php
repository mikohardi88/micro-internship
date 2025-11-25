<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Deliverable;
use App\Models\Placement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DeliverableController extends Controller
{
    public function index(Request $request)
    {
        $query = Deliverable::with(['placement.project.company'])
            ->whereHas('placement', function($q) {
                $q->where('user_id', Auth::id());
            });

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $deliverables = $query->latest()->paginate(15);
        return view('student.deliverables.index', compact('deliverables'));
    }

    public function create(Placement $placement)
    {
        if ($placement->user_id !== Auth::id()) {
            abort(403);
        }
        return view('student.deliverables.create', compact('placement'));
    }

    public function store(Request $request, Placement $placement)
    {
        if ($placement->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|max:10240',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = 'deliverable_' . time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('deliverables', $filename, 'public');
            $validated['file_path'] = $path;
        }

        $validated['placement_id'] = $placement->id;
        $validated['status'] = 'submitted';
        $validated['submitted_at'] = now();

        Deliverable::create($validated);

        return redirect()->route('student.deliverables.index')
            ->with('success', 'Deliverable submitted successfully.');
    }

    public function show(Deliverable $deliverable)
    {
        if ($deliverable->placement->user_id !== Auth::id()) {
            abort(403);
        }

        $deliverable->load(['placement.project.company']);
        return view('student.deliverables.show', compact('deliverable'));
    }
}

