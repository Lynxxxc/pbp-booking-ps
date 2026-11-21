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

Lalu isi variabel `DB_URI` di file `.env` dengan connection string MongoDB Atlas milik kelompok. Connection string dibagikan lewat grup kelompok, **bukan** lewat repo ini — file `.env` tidak pernah di-commit.

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
