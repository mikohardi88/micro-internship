<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Skill::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        $skills = $query->paginate(15);
        return response()->json($skills);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:skills',
            'description' => 'nullable|string',
        ]);

        $skill = Skill::create($validated);

        return response()->json($skill, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Skill $skill)
    {
        $skill->load(['users', 'projects']);
        return response()->json($skill);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Skill $skill)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:skills,name,' . $skill->id,
            'description' => 'nullable|string',
        ]);

        $skill->update($validated);

        return response()->json($skill);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Skill $skill)
    {
        $skill->delete();

        return response()->json(['message' => 'Skill deleted successfully'], 200);
    }
}

