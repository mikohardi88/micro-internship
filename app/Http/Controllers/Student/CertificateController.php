<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    public function index(Request $request)
    {
        $query = Certificate::with(['placement.project.company'])
            ->where('user_id', Auth::id());

        $certificates = $query->latest()->paginate(15);
        return view('student.certificates.index', compact('certificates'));
    }

    public function show(Certificate $certificate)
    {
        if ($certificate->user_id !== Auth::id()) {
            abort(403);
        }

        $certificate->load(['placement.project.company', 'user']);
        return view('student.certificates.show', compact('certificate'));
    }
}

