<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InternshipRequest;
use App\Models\Company;
use App\Models\Skill;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class InternshipRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $requests = InternshipRequest::where('student_id', Auth::id())
            ->with(['company'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('student.internship-requests.index', compact('requests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::orderBy('name')->get();
        $skills = Skill::orderBy('name')->get();

        return view('student.internship-requests.create', compact('companies', 'skills'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_id' => 'required|exists:companies,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'duration_weeks' => 'required|integer|min:1|max:12',
            'skills_needed' => 'nullable|array',
            'skills_needed.*' => 'exists:skills,id',
            'additional_notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        InternshipRequest::create([
            'student_id' => Auth::id(),
            'company_id' => $request->company_id,
            'title' => $request->title,
            'description' => $request->description,
            'duration_weeks' => $request->duration_weeks,
            'skills_needed' => $request->skills_needed ?? [],
            'additional_notes' => $request->additional_notes,
        ]);

        return redirect()->route('student.internship-requests.index')
            ->with('success', 'Permintaan magang berhasil dikirim ke perusahaan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(InternshipRequest $internshipRequest)
    {
        // Ensure the authenticated user can view this request
        if ($internshipRequest->student_id != Auth::id()) {
            abort(403);
        }

        return view('student.internship-requests.show', compact('internshipRequest'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InternshipRequest $internshipRequest)
    {
        // Ensure the authenticated user can edit this request
        if ($internshipRequest->student_id != Auth::id()) {
            abort(403);
        }

        if ($internshipRequest->status !== 'pending') {
            return redirect()->route('student.internship-requests.index')
                ->with('error', 'Hanya permintaan yang masih menunggu yang dapat diedit.');
        }

        $companies = Company::orderBy('name')->get();
        $skills = Skill::orderBy('name')->get();

        return view('student.internship-requests.edit', compact('internshipRequest', 'companies', 'skills'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InternshipRequest $internshipRequest)
    {
        // Ensure the authenticated user can update this request
        if ($internshipRequest->student_id != Auth::id()) {
            abort(403);
        }

        if ($internshipRequest->status !== 'pending') {
            return redirect()->route('student.internship-requests.index')
                ->with('error', 'Hanya permintaan yang masih menunggu yang dapat diperbarui.');
        }

        $validator = Validator::make($request->all(), [
            'company_id' => 'required|exists:companies,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'duration_weeks' => 'required|integer|min:1|max:12',
            'skills_needed' => 'nullable|array',
            'skills_needed.*' => 'exists:skills,id',
            'additional_notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $internshipRequest->update([
            'company_id' => $request->company_id,
            'title' => $request->title,
            'description' => $request->description,
            'duration_weeks' => $request->duration_weeks,
            'skills_needed' => $request->skills_needed ?? [],
            'additional_notes' => $request->additional_notes,
        ]);

        return redirect()->route('student.internship-requests.index')
            ->with('success', 'Permintaan magang berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InternshipRequest $internshipRequest)
    {
        // Ensure the authenticated user can delete this request
        if ($internshipRequest->student_id != Auth::id()) {
            abort(403);
        }

        if ($internshipRequest->status !== 'pending') {
            return redirect()->route('student.internship-requests.index')
                ->with('error', 'Hanya permintaan yang masih menunggu yang dapat dihapus.');
        }

        $internshipRequest->delete();

        return redirect()->route('student.internship-requests.index')
            ->with('success', 'Permintaan magang berhasil dihapus.');
    }
}
