<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\CourseCompletion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseCompletionController extends Controller
{
    public function index(Request $request)
    {
        $query = CourseCompletion::where('user_id', Auth::id());

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('course_name', 'like', "%{$search}%")
                  ->orWhere('institution', 'like', "%{$search}%");
            });
        }

        $courseCompletions = $query->latest()->paginate(15);
        return view('student.course-completions.index', compact('courseCompletions'));
    }

    public function create()
    {
        return view('student.course-completions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_name' => 'required|string|max:255',
            'institution' => 'nullable|string|max:255',
            'completion_date' => 'nullable|date',
            'certificate_url' => 'nullable|url|max:255',
            'skills_learned' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();

        CourseCompletion::create($validated);

        return redirect()->route('student.course-completions.index')
            ->with('success', 'Course completion added successfully.');
    }

    public function show(CourseCompletion $courseCompletion)
    {
        if ($courseCompletion->user_id !== Auth::id()) {
            abort(403);
        }

        return view('student.course-completions.show', compact('courseCompletion'));
    }

    public function edit(CourseCompletion $courseCompletion)
    {
        if ($courseCompletion->user_id !== Auth::id()) {
            abort(403);
        }

        return view('student.course-completions.edit', compact('courseCompletion'));
    }

    public function update(Request $request, CourseCompletion $courseCompletion)
    {
        if ($courseCompletion->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'course_name' => 'required|string|max:255',
            'institution' => 'nullable|string|max:255',
            'completion_date' => 'nullable|date',
            'certificate_url' => 'nullable|url|max:255',
            'skills_learned' => 'nullable|string',
        ]);

        $courseCompletion->update($validated);

        return redirect()->route('student.course-completions.index')
            ->with('success', 'Course completion updated successfully.');
    }

    public function destroy(CourseCompletion $courseCompletion)
    {
        if ($courseCompletion->user_id !== Auth::id()) {
            abort(403);
        }

        $courseCompletion->delete();

        return redirect()->route('student.course-completions.index')
            ->with('success', 'Course completion deleted successfully.');
    }
}

