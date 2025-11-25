<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Company::with('user');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('industry', 'like', "%{$search}%");
            });
        }

        $companies = $query->paginate(15);
        return response()->json($companies);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'industry' => 'nullable|string|max:100',
            'website' => 'nullable|url|max:255',
            'logo_path' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
            'phone' => 'nullable|string|max:20',
            'company_size' => 'nullable|in:1-10,11-50,51-200,201-500,501-1000,1000+',
            'founded_year' => 'nullable|integer|min:1800|max:' . date('Y'),
        ]);

        $validated['slug'] = Str::slug($validated['name']) . '-' . time();

        $company = Company::create($validated);

        return response()->json($company, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        $company->load(['user', 'projects']);
        return response()->json($company);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'industry' => 'nullable|string|max:100',
            'website' => 'nullable|url|max:255',
            'logo_path' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
            'phone' => 'nullable|string|max:20',
            'company_size' => 'nullable|in:1-10,11-50,51-200,201-500,501-1000,1000+',
            'founded_year' => 'nullable|integer|min:1800|max:' . date('Y'),
        ]);

        if ($request->has('name') && $request->name !== $company->name) {
            $validated['slug'] = Str::slug($validated['name']) . '-' . time();
        }

        $company->update($validated);

        return response()->json($company);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $company->delete();

        return response()->json(['message' => 'Company deleted successfully'], 200);
    }
}

