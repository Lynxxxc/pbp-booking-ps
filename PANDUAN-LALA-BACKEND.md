# Panduan Backend — Bagian Lala

Proyek: Booking PS (PBP) — Laravel + MongoDB Atlas + Tailwind CSS v4
Branch kerja: **frontend-landing**
Dokumen ini peta kerjanya Lala: fitur yang dia pegang, kontrak datanya,
dan file mana yang bukan bagiannya. Dibuat 24 Nov 2026.

---

## 1. Bagianmu: dua fitur backend

1. **Pencatatan pembayaran** — pembayaran booking bisa dicatat dan statusnya
   diubah sampai lunas.
2. **Panel admin** — admin bisa mengelola unit PS dan akun pegawai dari web,
   tanpa buka database langsung.

Dua-duanya dinilai langsung: **fungsionalitas (0,3)** dan
**keamanan data (0,4)**. Anggota yang hanya mengerjakan dokumen tidak dinilai,
jadi dua fitur ini adalah pegangan nilaimu di proyek ini.

Logika booking-nya sendiri (bikin booking, cek bentrok jadwal, hitung total)
adalah bagian Afriansyah — fiturmu menempel di hasil kerjanya.

## 2. Sebelum mulai (setup di laptopmu)

- Ambil repo dengan **clone**, JANGAN download ZIP dari GitHub — file ZIP
  tidak berisi folder `.git`, jadi `git pull` tidak akan pernah jalan di sana:
  ```
  git clone -b frontend-landing https://github.com/Lynxxxc/pbp-booking-ps.git
  ```
- File `.env` tidak ada di GitHub. Minta file `.env` ke Afriansyah secara
  privat (isinya string koneksi database), simpan di folder proyek.
- `composer install` butuh ekstensi PHP **mongodb** versi 2.x. Cek dulu:
  ```
  php -m | findstr mongo
  ```
  Harus muncul `mongodb`. Kalau kosong, jangan lanjut dulu — kabari Afriansyah,
  ada resep pasang DLL-nya (kemarin Abiyyu & Akmal mentok persis di sini).
  Jangan pakai `--ignore-platform-req=ext-mongodb`, webnya tetap crash.
- Sekali saja: `npm install` lalu `npm run build`.
- Jalankan: `php artisan serve` → buka http://127.0.0.1:8000

## 3. Kontrak data (database `rental_ps`, skema Abiyyu)

Modelnya sudah dibuatkan Afriansyah di `app/Models/` — pakai yang ada,
jangan bikin koleksi/field baru tanpa koordinasi sama Abiyyu & Afriansyah.

| Koleksi | Field | Catatan |
|---|---|---|
| `ps_units` | name, type, price_per_hour, status, description | status: `available` = tersedia |
| `bookings` | user_id, ps_unit_id, start_time, end_time, total_price, status | status: `pending`, `confirmed` |
| `payments` | booking_id, amount, method, status, paid_at | method: `cash`, `qris`, `e-wallet`; status: `pending`, `paid` |
| `users` | name, email, password, role, poin | role: `pengguna`, `pegawai`, `admin` |

Di database sekarang sudah ada data contoh: 4 unit, 2 booking, 4 pembayaran —
cukup buat bahan tes fiturmu sebelum logika booking Afriansyah selesai.

## 4. Tugas 1 — Panel admin (khusus role `admin`)

- Daftar unit PS + **tambah / edit / hapus unit** (nama, tipe, harga per jam,
  status, deskripsi).
- **Kelola akun pegawai**: buat akun pegawai baru (password wajib di-hash,
  jangan pernah disimpan sebagai teks biasa).
- Semua route-nya wajib dibungkus middleware role admin — pengguna &
  pegawai tidak boleh bisa membuka URL-nya langsung.

Tempat kode:
- Controller baru di `app/Http/Controllers/` (mis. `AdminUnitController`,
  `AdminPegawaiController`)
- View baru di `resources/views/admin/`
- Route baru di `routes/web.php` (lihat aturan file bersama di bagian 7)

## 5. Tugas 2 — Pencatatan pembayaran (role `pegawai` & `admin`)

- Halaman daftar pembayaran: booking-nya siapa, unit apa, jumlah, metode,
  status.
- **Tandai lunas**: status `pending` → `paid`, dan `paid_at` diisi waktu
  pembayaran diterima.
- **Catat pembayaran di tempat**: untuk booking yang belum punya pembayaran,
  pegawai bisa membuat catatan pembayaran tunai di lokasi.

Tempat kode:
- Controller baru di `app/Http/Controllers/` (mis. `PaymentController`)
- View baru di `resources/views/payments/`
- Modelnya sudah ada: `app/Models/Payment.php` dan `app/Models/Booking.php`

## 6. Aturan keamanan (ini yang dinilai 0,4)

- Setiap route fiturmu dibungkus middleware `role` sesuai peran di atas.
- Password selalu `Hash::make(...)` — tidak ada password teks biasa.
- Jangan pernah commit file `.env`.
- Validasi input form (harga angka ≥ 0, email valid & unik, dsb.) —
  jangan percaya input mentah dari form.

## 7. Bukan bagianmu & aturan file bersama

- **Tampilan akhir** (landing, dashboard, mempercantik view): Akmal.
  View yang kamu buat cukup fungsional & sederhana pakai layout yang ada —
  nanti Akmal yang memoles.
- **Skema database**: Abiyyu. Butuh field/koleksi baru → koordinasi dulu.
- **AuthController & logika booking**: Afriansyah.
- `routes/web.php` itu **file bersama** semua backend: sebelum menambah
  route, kabari di grup, dan selalu `git pull` dulu sebelum mulai kerja
  supaya tidak tabrakan.

## 8. Akun demo buat tes

| Peran | Email | Password |
|---|---|---|
| Pengguna | user@gmail.com | user12345 |
| Pegawai | pegawai@gmail.com | pegawai123 |
| Admin | admin@gmail.com | admin123 |

## 9. Alur Git

```
git checkout frontend-landing
git pull                       (ambil perubahan terbaru sebelum mulai kerja)
... kerjakan bagianmu ...
git add .
git commit -m "Backend: <ringkasan perubahan>"
git push origin frontend-landing
```
Push dilakukan dari terminal masing-masing (tidak bisa diwakilkan).
Kalau push ditolak (403 / Permission denied), artinya kamu belum di-invite
sebagai collaborator — minta Afriansyah invite username GitHub-mu,
lalu Accept undangannya dulu.
