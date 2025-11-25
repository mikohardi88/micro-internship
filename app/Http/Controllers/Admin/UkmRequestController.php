<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UkmRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UkmRequestController extends Controller
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
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $requests = UkmRequest::with(['user', 'company'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.ukm-requests.index', compact('requests'));
    }

    /**
     * Display the specified resource.
     */
    public function show(UkmRequest $ukmRequest)
    {
        $ukmRequest->load(['user', 'company', 'resolver']);

        return view('admin.ukm-requests.show', compact('ukmRequest'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UkmRequest $ukmRequest)
    {
        return view('admin.ukm-requests.edit', compact('ukmRequest'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UkmRequest $ukmRequest)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,resolved,rejected',
            'admin_notes' => 'nullable|string',
        ]);

        $ukmRequest->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
            'resolved_at' => $request->status === 'resolved' ? now() : null,
            'resolved_by' => $request->status === 'resolved' ? Auth::id() : null,
        ]);

        return redirect()->route('admin.ukm-requests.index')
            ->with('success', 'Permintaan UKM berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UkmRequest $ukmRequest)
    {
        $ukmRequest->delete();

        return redirect()->route('admin.ukm-requests.index')
            ->with('success', 'Permintaan UKM berhasil dihapus.');
    }
}
