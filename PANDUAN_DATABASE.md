# Panduan Konfigurasi Database MySQL/MariaDB

## Status Saat Ini
Aplikasi saat ini menggunakan **SQLite** sebagai database default.

## Cara Mengubah ke MySQL/MariaDB

### 1. Edit File .env

Buka file `.env` di root project dan ubah konfigurasi database:

```env
# Ubah dari:
DB_CONNECTION=sqlite
DB_DATABASE=vinix

# Menjadi:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database_anda
DB_USERNAME=username_anda
DB_PASSWORD=password_anda
```

### 2. Contoh Konfigurasi

**Untuk MySQL/MariaDB Lokal:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=vinix_micro_internship
DB_USERNAME=root
DB_PASSWORD=
```

**Untuk MySQL/MariaDB Remote:**
```env
DB_CONNECTION=mysql
DB_HOST=your-server-ip
DB_PORT=3306
DB_DATABASE=vinix_micro_internship
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 3. Buat Database di MySQL

Jalankan di MySQL:
```sql
CREATE DATABASE vinix_micro_internship CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 4. Jalankan Migrasi

Setelah mengubah konfigurasi, jalankan:
```bash
php artisan config:clear
php artisan migrate
php artisan db:seed
```

### 5. Verifikasi Koneksi

Jalankan untuk memastikan koneksi berhasil:
```bash
php artisan db:show
```

## Catatan Penting

1. Pastikan MySQL/MariaDB sudah terinstall dan running
2. Pastikan database sudah dibuat sebelum menjalankan migrate
3. Backup data SQLite jika ada data penting sebelum migrasi
4. Setelah migrasi ke MySQL, file `database/database.sqlite` tidak akan digunakan lagi

