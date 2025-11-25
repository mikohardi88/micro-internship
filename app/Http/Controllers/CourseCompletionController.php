<?php

namespace App\Http\Controllers;

use App\Models\CourseCompletion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseCompletionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = CourseCompletion::with('user');

        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('course_name', 'like', "%{$search}%")
                  ->orWhere('institution', 'like', "%{$search}%");
            });
        }

        $courseCompletions = $query->paginate(15);
        return response()->json($courseCompletions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'course_name' => 'required|string|max:255',
            'institution' => 'nullable|string|max:255',
            'completion_date' => 'nullable|date',
            'certificate_url' => 'nullable|url|max:255',
            'skills_learned' => 'nullable|string',
        ]);

        if (!isset($validated['user_id'])) {
            $validated['user_id'] = Auth::id();
        }

        $courseCompletion = CourseCompletion::create($validated);

        return response()->json($courseCompletion, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(CourseCompletion $courseCompletion)
    {
        $courseCompletion->load('user');
        return response()->json($courseCompletion);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CourseCompletion $courseCompletion)
    {
        $validated = $request->validate([
            'course_name' => 'nullable|string|max:255',
            'institution' => 'nullable|string|max:255',
            'completion_date' => 'nullable|date',
            'certificate_url' => 'nullable|url|max:255',
            'skills_learned' => 'nullable|string',
        ]);

        $courseCompletion->update($validated);

        return response()->json($courseCompletion);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseCompletion $courseCompletion)
    {
        $courseCompletion->delete();

        return response()->json(['message' => 'Course completion deleted successfully'], 200);
    }
}

