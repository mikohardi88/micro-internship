<?php

namespace App\Http\Controllers;

use App\Models\Placement;
use App\Models\Project;
use Illuminate\Http\Request;

class PlacementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Placement::with(['project', 'user']);

        if ($request->has('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $placements = $query->paginate(15);
        return response()->json($placements);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'user_id' => 'required|exists:users,id',
            'status' => 'nullable|in:matched,in_progress,completed,terminated',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'supervisor_name' => 'nullable|string|max:255',
            'supervisor_email' => 'nullable|email|max:255',
            'supervisor_phone' => 'nullable|string|max:20',
        ]);

        $validated['status'] = $validated['status'] ?? 'matched';

        $placement = Placement::create($validated);

        return response()->json($placement, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Placement $placement)
    {
        $placement->load(['project', 'user', 'deliverables', 'certificates']);
        return response()->json($placement);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Placement $placement)
    {
        $validated = $request->validate([
            'status' => 'nullable|in:matched,in_progress,completed,terminated',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'supervisor_name' => 'nullable|string|max:255',
            'supervisor_email' => 'nullable|email|max:255',
            'supervisor_phone' => 'nullable|string|max:20',
        ]);

        $placement->update($validated);

        return response()->json($placement);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Placement $placement)
    {
        $placement->delete();

        return response()->json(['message' => 'Placement deleted successfully'], 200);
    }
}

