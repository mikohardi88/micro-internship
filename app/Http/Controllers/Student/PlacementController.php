<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Placement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlacementController extends Controller
{
    public function index(Request $request)
    {
        $query = Placement::with(['project.company'])
            ->where('user_id', Auth::id());

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $placements = $query->latest()->paginate(15);
        return view('student.placements.index', compact('placements'));
    }

    public function show(Placement $placement)
    {
        if ($placement->user_id !== Auth::id()) {
            abort(403);
        }

        $placement->load(['project.company', 'deliverables', 'certificates']);
        return view('student.placements.show', compact('placement'));
    }
}

