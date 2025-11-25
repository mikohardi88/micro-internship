<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Precomputed bcrypt hash for the string "password"
        $passwordHash = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';

        // Admin user
        User::firstOrCreate(
            ['email' => 'admin@vinix.test'],
            [
                'name' => 'Admin Vinix',
                'password' => $passwordHash,
                'role' => 'admin',
            ]
        );

        // Mahasiswa user
        User::firstOrCreate(
            ['email' => 'mahasiswa@vinix.test'],
            [
                'name' => 'Mahasiswa Demo',
                'password' => $passwordHash,
                'role' => 'mahasiswa',
            ]
        );

        // UMKM user
        User::firstOrCreate(
            ['email' => 'umkm@vinix.test'],
            [
                'name' => 'UMKM Demo',
                'password' => $passwordHash,
                'role' => 'umkm',
            ]
        );
    }
}
