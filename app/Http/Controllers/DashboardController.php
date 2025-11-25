<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Arahkan pengguna ke dashboard yang sesuai dengan peran mereka
        if ($user->hasRole('admin')) {
            return view('admin.dashboard.index');
        } elseif ($user->hasRole('company')) {
            // Arahkan ke dashboard perusahaan, tetapi beri notifikasi jika profil belum lengkap
            if (!$user->company) {
                return view('company.dashboard.index')->with('warning', 'Silakan lengkapi profil perusahaan Anda untuk pengalaman terbaik.');
            }
            return view('company.dashboard.index');
        } elseif ($user->hasRole('student')) {
            return view('student.dashboard.index');
        } else {
            // Jika tidak memiliki role khusus, arahkan ke dashboard default
            return view('dashboard');
        }
    }
}
