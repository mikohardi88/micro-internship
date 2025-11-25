<?php

namespace App\Http\Controllers;

use App\Models\Deliverable;
use App\Models\Placement;
use Illuminate\Http\Request;

class DeliverableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Deliverable::with('placement');

        if ($request->has('placement_id')) {
            $query->where('placement_id', $request->placement_id);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $deliverables = $query->paginate(15);
        return response()->json($deliverables);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'placement_id' => 'required|exists:placements,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file_path' => 'required|string|max:255',
            'status' => 'nullable|in:submitted,under_review,revision_requested,accepted,rejected',
        ]);

        $validated['status'] = $validated['status'] ?? 'submitted';
        $validated['submitted_at'] = now();

        $deliverable = Deliverable::create($validated);

        return response()->json($deliverable, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Deliverable $deliverable)
    {
        $deliverable->load('placement');
        return response()->json($deliverable);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Deliverable $deliverable)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'file_path' => 'nullable|string|max:255',
            'status' => 'nullable|in:submitted,under_review,revision_requested,accepted,rejected',
            'feedback' => 'nullable|string',
        ]);

        if (isset($validated['status']) && in_array($validated['status'], ['accepted', 'rejected', 'revision_requested'])) {
            $validated['reviewed_at'] = now();
        }

        $deliverable->update($validated);

        return response()->json($deliverable);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Deliverable $deliverable)
    {
        $deliverable->delete();

        return response()->json(['message' => 'Deliverable deleted successfully'], 200);
    }
}

