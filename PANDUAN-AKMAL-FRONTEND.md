# Panduan Frontend — Bagian Akmal

Proyek: Booking PS (PBP) — Laravel + MongoDB Atlas + Tailwind CSS v4
Branch kerja: **frontend-landing**
Dokumen ini peta kerjanya Akmal: file mana yang dia pegang, kode ditaruh di mana,
dan file mana yang bukan bagiannya. Diperbarui terakhir 23 Nov 2026.

---

## 1. File yang dipegang Akmal (silakan diedit)

### Halaman (Blade) — `resources/views/`
| File | Isi |
|---|---|
| `landing.blade.php` | **Halaman utama yang aktif** — katalog unit PS. Ini yang dibuka route `/`. |
| `layouts/app.blade.php` | Kerangka semua halaman: navbar, footer. Edit di sini = berubah di semua halaman. |
| `auth/login.blade.php` | Halaman login |
| `auth/register.blade.php` | Halaman daftar |
| `dashboard/pengguna.blade.php` | Dashboard peran pengguna |
| `dashboard/pegawai.blade.php` | Dashboard peran pegawai |
| `dashboard/admin.blade.php` | Dashboard peran admin |

### Gaya & script
| File | Isi |
|---|---|
| `resources/css/app.css` | Pintu masuk Tailwind v4 + CSS kustom. Semua styling mulai dari sini. |
| `resources/js/app.js` | JavaScript kustom. |

### Gambar & aset statis — `public/`
| Folder | Isi |
|---|---|
| `public/images/rooms/` | Foto room/unit PS |
| `public/images/games/` | Foto/cover daftar game |

Panggil gambar dari Blade pakai helper `asset()`, contoh:
`{{ asset('images/rooms/ps5-vip.jpg') }}`

## 2. Bukan bagiannya (jangan diubah)

- `app/` — backend (Afriansyah & Lala)
- `routes/`, `config/`, `database/` — backend & database (Abiyyu)
- `.env` — sudah diatur (koneksi database dll.), jangan diutak-atik
- `welcome.blade.php` — halaman bawaan Laravel, **tidak dipakai** proyek ini.
  Abaikan saja (boleh dihapus, tidak ngaruh apa-apa).

## 3. Data di halaman utama — jangan ubah nama variabelnya

`landing.blade.php` menerima variabel `$units` dari HomeController.
Tiap unit punya field: `name`, `type`, `price_per_hour`, `status`, `description`.
Loop-nya sudah ada — tugas frontend adalah mempercantik tampilannya,
bukan mengubah cara datanya diambil.

## 4. Cara menjalankan

```
php artisan serve
```
Lalu buka http://127.0.0.1:8000

Selama mengedit tampilan, pilih salah satu:
- `npm run dev` — Vite mode pantau: aset ke-rebuild otomatis tiap file disimpan. **Terminal ini harus tetap jalan.**
- `npm run build` — build sekali jadi. Ulangi tiap selesai mengedit CSS/JS.

Kalau muncul error **"Vite manifest not found"** artinya aset belum di-build:
jalankan `npm install` (sekali saja) lalu `npm run build`.

## 5. Akun demo buat tes tampilan per peran

| Peran | Email | Password |
|---|---|---|
| Pengguna | user@gmail.com | user12345 |
| Pegawai | pegawai@gmail.com | pegawai123 |
| Admin | admin@gmail.com | admin123 |

## 6. Alur Git

```
git checkout frontend-landing
git pull                       (ambil perubahan terbaru sebelum mulai kerja)
... kerjakan frontend ...
git add .
git commit -m "Frontend: <ringkasan perubahan>"
git push origin frontend-landing
```
Push dilakukan dari terminal masing-masing (tidak bisa diwakilkan).

## 7. Yang dinilai dari sisi frontend

- **Desain (0,25)** — tampilan rapi & konsisten antar halaman
- **Responsif (0,4)** — enak dibuka di HP maupun desktop

Jadi selain bagus di layar besar, cek juga tampilan HP-nya
(Chrome DevTools → ikon HP, atau kecilkan jendela browser).
