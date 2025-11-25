<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\PortfolioItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    public function index(Request $request)
    {
        $query = PortfolioItem::with(['project'])
            ->where('user_id', Auth::id());

        if ($request->has('visibility')) {
            $query->where('visibility', $request->visibility);
        }

        $portfolioItems = $query->latest()->paginate(15);
        return view('student.portfolio.index', compact('portfolioItems'));
    }

    public function create()
    {
        return view('student.portfolio.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'nullable|exists:projects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|max:10240',
            'url' => 'nullable|url|max:255',
            'visibility' => 'nullable|in:public,private',
            'featured' => 'nullable|boolean',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = 'portfolio_' . time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('portfolio', $filename, 'public');
            $validated['file_path'] = $path;
        }

        $validated['user_id'] = Auth::id();
        $validated['visibility'] = $validated['visibility'] ?? 'public';
        $validated['featured'] = $validated['featured'] ?? false;

        PortfolioItem::create($validated);

        return redirect()->route('student.portfolio.index')
            ->with('success', 'Portfolio item created successfully.');
    }

    public function show(PortfolioItem $portfolioItem)
    {
        if ($portfolioItem->user_id !== Auth::id()) {
            abort(403);
        }

        $portfolioItem->load(['project', 'user']);
        return view('student.portfolio.show', compact('portfolioItem'));
    }

    public function edit(PortfolioItem $portfolioItem)
    {
        if ($portfolioItem->user_id !== Auth::id()) {
            abort(403);
        }

        return view('student.portfolio.edit', compact('portfolioItem'));
    }

    public function update(Request $request, PortfolioItem $portfolioItem)
    {
        if ($portfolioItem->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'project_id' => 'nullable|exists:projects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|max:10240',
            'url' => 'nullable|url|max:255',
            'visibility' => 'nullable|in:public,private',
            'featured' => 'nullable|boolean',
        ]);

        if ($request->hasFile('file')) {
            if ($portfolioItem->file_path) {
                Storage::disk('public')->delete($portfolioItem->file_path);
            }
            $file = $request->file('file');
            $filename = 'portfolio_' . time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('portfolio', $filename, 'public');
            $validated['file_path'] = $path;
        }

        $portfolioItem->update($validated);

        return redirect()->route('student.portfolio.index')
            ->with('success', 'Portfolio item updated successfully.');
    }

    public function destroy(PortfolioItem $portfolioItem)
    {
        if ($portfolioItem->user_id !== Auth::id()) {
            abort(403);
        }

        if ($portfolioItem->file_path) {
            Storage::disk('public')->delete($portfolioItem->file_path);
        }

        $portfolioItem->delete();

        return redirect()->route('student.portfolio.index')
            ->with('success', 'Portfolio item deleted successfully.');
    }
}

