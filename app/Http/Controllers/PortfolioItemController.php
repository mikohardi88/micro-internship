<?php

namespace App\Http\Controllers;

use App\Models\PortfolioItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PortfolioItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PortfolioItem::with(['user', 'project']);

        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('visibility')) {
            $query->where('visibility', $request->visibility);
        }

        if ($request->has('featured')) {
            $query->where('featured', $request->featured);
        }

        $portfolioItems = $query->paginate(15);
        return response()->json($portfolioItems);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'project_id' => 'nullable|exists:projects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file_path' => 'nullable|string|max:255',
            'url' => 'nullable|url|max:255',
            'visibility' => 'nullable|in:public,private',
            'featured' => 'nullable|boolean',
        ]);

        if (!isset($validated['user_id'])) {
            $validated['user_id'] = Auth::id();
        }

        $validated['visibility'] = $validated['visibility'] ?? 'public';
        $validated['featured'] = $validated['featured'] ?? false;

        $portfolioItem = PortfolioItem::create($validated);

        return response()->json($portfolioItem, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(PortfolioItem $portfolioItem)
    {
        $portfolioItem->load(['user', 'project']);
        return response()->json($portfolioItem);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PortfolioItem $portfolioItem)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'file_path' => 'nullable|string|max:255',
            'url' => 'nullable|url|max:255',
            'visibility' => 'nullable|in:public,private',
            'featured' => 'nullable|boolean',
        ]);

        $portfolioItem->update($validated);

        return response()->json($portfolioItem);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PortfolioItem $portfolioItem)
    {
        $portfolioItem->delete();

        return response()->json(['message' => 'Portfolio item deleted successfully'], 200);
    }
}

