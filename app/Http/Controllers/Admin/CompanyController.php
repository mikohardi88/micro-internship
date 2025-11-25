<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::check() || !Auth::user()->hasRole('admin')) {
                abort(403, 'Unauthorized action.');
            }
            return $next($request);
        });
    }
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

        $companies = $query->latest()->paginate(15);
        return view('admin.companies.index', compact('companies'));
    }

    public function create()
    {
        $users = User::whereDoesntHave('companies')->get();
        return view('admin.companies.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'industry' => 'nullable|string|max:100',
            'website' => 'nullable|url|max:255',
            'size' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
            'phone' => 'nullable|string|max:20',
        ]);

        $validated['slug'] = Str::slug($validated['name']) . '-' . time();

        Company::create($validated);

        return redirect()->route('admin.companies.index')
            ->with('success', 'Company created successfully.');
    }

    public function show(Company $company)
    {
        $company->load(['user', 'projects']);
        return view('admin.companies.show', compact('company'));
    }

    public function edit(Company $company)
    {
        $users = User::all();
        return view('admin.companies.edit', compact('company', 'users'));
    }

    public function update(Request $request, Company $company)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'industry' => 'nullable|string|max:100',
            'website' => 'nullable|url|max:255',
            'size' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
            'phone' => 'nullable|string|max:20',
        ]);

        if ($request->has('name') && $request->name !== $company->name) {
            $validated['slug'] = Str::slug($validated['name']) . '-' . time();
        }

        $company->update($validated);

        return redirect()->route('admin.companies.index')
            ->with('success', 'Company updated successfully.');
    }

    public function destroy(Company $company)
    {
        $company->delete();

        return redirect()->route('admin.companies.index')
            ->with('success', 'Company deleted successfully.');
    }
}

