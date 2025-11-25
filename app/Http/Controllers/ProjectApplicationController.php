<?php

namespace App\Http\Controllers;

use App\Models\ProjectApplication;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ProjectApplication::with(['project', 'user']);

        if ($request->has('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $applications = $query->paginate(15);
        return response()->json($applications);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'user_id' => 'nullable|exists:users,id',
            'cover_letter' => 'nullable|string',
        ]);

        // Use authenticated user if user_id not provided
        if (!isset($validated['user_id'])) {
            $validated['user_id'] = Auth::id();
        }

        // Check if user already applied
        $existing = ProjectApplication::where('project_id', $validated['project_id'])
            ->where('user_id', $validated['user_id'])
            ->first();

        if ($existing) {
            return response()->json(['message' => 'You have already applied to this project'], 422);
        }

        $validated['status'] = 'pending';
        $validated['applied_at'] = now();

        $application = ProjectApplication::create($validated);

        return response()->json($application, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectApplication $projectApplication)
    {
        $projectApplication->load(['project', 'user']);
        return response()->json($projectApplication);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProjectApplication $projectApplication)
    {
        $validated = $request->validate([
            'cover_letter' => 'nullable|string',
            'status' => 'nullable|in:pending,shortlisted,accepted,rejected,withdrawn',
            'decision_notes' => 'nullable|string',
        ]);

        if (isset($validated['status']) && $validated['status'] !== $projectApplication->status) {
            $validated['decided_at'] = now();
        }

        $projectApplication->update($validated);

        return response()->json($projectApplication);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectApplication $projectApplication)
    {
        $projectApplication->delete();

        return response()->json(['message' => 'Application deleted successfully'], 200);
    }
}

