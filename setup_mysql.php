<?php

/**
 * Script untuk setup database MySQL
 * Jalankan: php setup_mysql.php
 */

echo "=== Setup Database MySQL ===\n\n";

// Baca file .env
$envFile = __DIR__ . '/.env';
if (!file_exists($envFile)) {
    echo "Error: File .env tidak ditemukan!\n";
    exit(1);
}

$envContent = file_get_contents($envFile);

// Tampilkan konfigurasi saat ini
echo "Konfigurasi Database Saat Ini:\n";
preg_match('/DB_CONNECTION=(.*)/', $envContent, $matches);
echo "DB_CONNECTION: " . ($matches[1] ?? 'tidak ditemukan') . "\n";

preg_match('/DB_HOST=(.*)/', $envContent, $matches);
echo "DB_HOST: " . ($matches[1] ?? 'tidak ditemukan') . "\n";

preg_match('/DB_DATABASE=(.*)/', $envContent, $matches);
echo "DB_DATABASE: " . ($matches[1] ?? 'tidak ditemukan') . "\n";

echo "\n";
echo "Untuk mengubah ke MySQL, edit file .env dan ubah:\n";
echo "DB_CONNECTION=sqlite  ->  DB_CONNECTION=mysql\n";
echo "DB_HOST=127.0.0.1\n";
echo "DB_PORT=3306\n";
echo "DB_DATABASE=nama_database_anda\n";
echo "DB_USERNAME=username_anda\n";
echo "DB_PASSWORD=password_anda\n";
echo "\n";
echo "Contoh konfigurasi:\n";
echo "DB_CONNECTION=mysql\n";
echo "DB_HOST=127.0.0.1\n";
echo "DB_PORT=3306\n";
echo "DB_DATABASE=vinix_micro_internship\n";
echo "DB_USERNAME=root\n";
echo "DB_PASSWORD=\n";
echo "\n";

