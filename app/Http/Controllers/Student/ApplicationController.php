<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ProjectApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::check() || !Auth::user()->hasRole('student')) {
                abort(403, 'Unauthorized action.');
            }
            return $next($request);
        });
    }
    public function index(Request $request)
    {
        $query = ProjectApplication::with(['project.company'])
            ->where('user_id', Auth::id());

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $applications = $query->latest()->paginate(15);
        return view('student.applications.index', compact('applications'));
    }

    public function show(ProjectApplication $application)
    {
        if ($application->user_id !== Auth::id()) {
            abort(403);
        }

        $application->load(['project.company', 'project.skills']);
        return view('student.applications.show', compact('application'));
    }
}

