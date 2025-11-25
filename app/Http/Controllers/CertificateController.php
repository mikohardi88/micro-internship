<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Placement;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Certificate::with(['placement', 'user']);

        if ($request->has('placement_id')) {
            $query->where('placement_id', $request->placement_id);
        }

        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $certificates = $query->paginate(15);
        return response()->json($certificates);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'placement_id' => 'required|exists:placements,id',
            'user_id' => 'required|exists:users,id',
            'certificate_number' => 'nullable|string|max:50|unique:certificates',
            'issued_at' => 'nullable|date',
            'file_path' => 'nullable|string|max:255',
        ]);

        if (!isset($validated['certificate_number'])) {
            $validated['certificate_number'] = 'CERT-' . strtoupper(Str::random(10)) . '-' . time();
        }

        if (!isset($validated['issued_at'])) {
            $validated['issued_at'] = now();
        }

        $certificate = Certificate::create($validated);

        return response()->json($certificate, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Certificate $certificate)
    {
        $certificate->load(['placement', 'user']);
        return response()->json($certificate);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Certificate $certificate)
    {
        $validated = $request->validate([
            'certificate_number' => 'nullable|string|max:50|unique:certificates,certificate_number,' . $certificate->id,
            'issued_at' => 'nullable|date',
            'file_path' => 'nullable|string|max:255',
        ]);

        $certificate->update($validated);

        return response()->json($certificate);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Certificate $certificate)
    {
        $certificate->delete();

        return response()->json(['message' => 'Certificate deleted successfully'], 200);
    }
}

