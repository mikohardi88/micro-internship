<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Company;
use App\Models\Project;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles if not exist
        $roles = ['student', 'company', 'admin'];
        foreach ($roles as $r) {
            Role::findOrCreate($r);
        }

        // Create sample users
        $admin = User::firstOrCreate(
            ['email' => 'admin@vinix.local'],
            [
                'name' => 'Admin Vinix',
                // Precomputed bcrypt hash for the string "password"
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            ]
        );
        $admin->assignRole('admin');

        $companyUser = User::firstOrCreate(
            ['email' => 'umkm@vinix.local'],
            [
                'name' => 'UMKM Owner',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            ]
        );
        $companyUser->assignRole('company');

        $student = User::firstOrCreate(
            ['email' => 'student@vinix.local'],
            [
                'name' => 'Mahasiswa Percobaan',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            ]
        );
        $student->assignRole('student');

        // Create a company for the company user
        $company = Company::firstOrCreate([
            'user_id' => $companyUser->id,
            'name' => 'UMKM Contoh',
        ], [
            'industry' => 'F&B',
            'size' => '1-10',
            'website' => 'https://umkm.example',
            'description' => 'UMKM contoh untuk micro internship Vinix.',
            'verified_at' => now(),
        ]);

        // Create a sample project
        $projectTitle = 'Riset Pasar Produk Minuman';
        Project::firstOrCreate([
            'company_id' => $company->id,
            'title' => $projectTitle,
        ], [
            'slug' => Str::slug($projectTitle) . '-' . time(),
            'description' => 'Lakukan riset pasar singkat untuk segmen Gen-Z, output: laporan 5 halaman + insight actionable.',
            'duration_weeks' => 2,
            'status' => 'open',
            'max_applicants' => 3,
            'budget' => 0,
        ]);
    }
}
