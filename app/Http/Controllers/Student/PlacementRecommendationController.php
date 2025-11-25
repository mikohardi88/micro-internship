<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\PlacementMatchingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlacementRecommendationController extends Controller
{
    private PlacementMatchingService $matchingService;

    public function __construct(PlacementMatchingService $matchingService)
    {
        $this->matchingService = $matchingService;
    }

    /**
     * Show placement recommendations for the student
     */
    public function index(Request $request)
    {
        $student = Auth::user();
        $recommendations = $this->matchingService->getRecommendationsForStudent($student, 10);

        return view('student.recommendations.index', compact('recommendations'));
    }

    /**
     * Get API recommendations
     */
    public function apiRecommendations(Request $request)
    {
        $student = Auth::user();
        $limit = $request->get('limit', 5);
        $recommendations = $this->matchingService->getRecommendationsForStudent($student, $limit);

        return response()->json($recommendations);
    }
}
