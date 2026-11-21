# pbp-booking-ps — Sistem Booking PlayStation

Website dinamis untuk booking PlayStation per jam, dibuat sebagai proyek akhir mata kuliah Pemrograman Berbasis Platform (PBP). Model layanannya mengikuti rental PS tipe lounge: pelanggan memilih room (Reguler, VIP, VVIP, Suite), menentukan tanggal dan jam, lalu sistem mencatat booking dan pembayarannya.

> Status: tahap awal. Kerangka Laravel dan koneksi database bersama sudah terverifikasi; fitur-fitur di bawah sedang dibangun bertahap.

## Fitur yang Direncanakan

- **Autentikasi** — register, login, logout dengan tiga peran: pengguna, pegawai, dan admin
- **Katalog room** — daftar room per tipe (Reguler PS4 Pro, Reguler PS5, VIP, VVIP, Suite), harga per jam, fasilitas, foto, dan detail room
- **Booking** — pilih room, tanggal, jam mulai, dan durasi; sistem mengecek ketersediaan sebelum booking tercatat
- **Pembayaran** — pencatatan pembayaran per booking (status lunas/belum)
- **Panel pegawai** — jadwal booking harian, check-in/check-out pelanggan, pencatatan pembayaran di tempat, status room
- **Panel admin** — kelola room, kelola akun pegawai, semua booking dan pembayaran, laporan
- **Loyalty point** (opsional) — poin untuk pelanggan yang dapat ditukar pada booking berikutnya

## Teknologi

- Laravel (PHP)
- MongoDB Atlas sebagai database bersama kelompok (paket `mongodb/laravel-mongodb`)
- Bootstrap untuk tampilan

## Cara Menjalankan (Lokal)

Prasyarat: PHP 8.3.36 dengan ekstensi `mongodb` aktif (di Laragon, versi PHP lain belum tentu punya ekstensi ini), Composer, dan akses ke database kelompok.

```bash
git clone https://github.com/Lynxxxc/pbp-booking-ps.git
cd pbp-booking-ps
composer install
copy .env.example .env
php artisan key:generate
php artisan serve
```

## Menghubungkan Database (MongoDB Atlas)

Database yang dipakai adalah MongoDB Atlas (cluster M0 gratis) dan dipakai bersama oleh kelompok. Laravel menyambung memakai paket `mongodb/laravel-mongodb` dan satu connection string di file `.env`.

1. Pastikan ekstensi `mongodb` aktif di PHP yang dipakai — di Laragon proyek ini, yang terbukti punya adalah PHP 8.3.36. Cek dengan `php -m`, harus ada baris `mongodb`.
2. Pasang paketnya (sekali per proyek): `composer require mongodb/laravel-mongodb`
3. Koneksi `mongodb` di `config/database.php` membaca `'dsn' => env('DB_URI')` dan `'database' => env('DB_DATABASE', 'akademik')`.
4. Isi file `.env`:

```
DB_CONNECTION=mongodb
DB_URI=mongodb+srv://<username>:<password>@cluster0.v6ixbdn.mongodb.net/...
```

Connection string lengkap diambil dari Atlas (Database → Connect → Drivers) atau dari grup kelompok. Nama variabelnya **wajib `DB_URI`** — kalau tertulis `DB_URL`, Laravel tidak membacanya dan muncul error "requires dsn or host key" (bug yang kami alami dan perbaiki pada 21 November 2026).

5. Bersihkan cache konfigurasi: `php artisan config:clear`
6. Tes koneksi lewat `php artisan tinker`:

```php
$client = new MongoDB\Client(env('DB_URI'));
$client->selectDatabase('admin')->command(['ping' => 1]);
```

Hasil yang benar: `ok => 1`.

7. Cek visual: buka MongoDB Compass dengan connection string yang sama — database `akademik` harus terlihat.

Error yang umum:

- "requires dsn or host key" → `DB_URI` kosong atau salah nama variabel.
- "bad auth" → username/password tidak cocok dengan Database User di Atlas.
- Ekstensi tidak ditemukan → PHP yang dipakai bukan 8.3.36.

## Struktur Database

Koleksi MongoDB:

- `users` — akun pengguna, pegawai, dan admin
- `room` — tipe room, harga per jam, fasilitas
- `booking` — pemesanan room oleh pengguna
- `pembayaran` — catatan pembayaran per booking

## Screenshot

_(menyusul setelah tampilan utama selesai dibangun)_

## Catatan Keamanan

- File `.env` dan backup-nya masuk `.gitignore` dan tidak di-commit ke repo ini.
- Password pengguna disimpan dalam bentuk hash oleh Laravel.
