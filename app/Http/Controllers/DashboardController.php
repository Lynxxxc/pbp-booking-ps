<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\PsUnit;
use App\Models\User;

class DashboardController extends Controller
{
    public function pengguna()
    {
        $user = auth()->user();

        $bookings = Booking::whereIn('user_id', Booking::bentukId($user->_id))
            ->orderByDesc('start_time')
            ->limit(5)
            ->get();

        $units = PsUnit::all()->keyBy(fn ($u) => (string) $u->_id);

        return view('dashboard.pengguna', [
            'user' => $user,
            'bookings' => $bookings,
            'units' => $units,
            'jumlahBooking' => Booking::whereIn('user_id', Booking::bentukId($user->_id))->count(),
        ]);
    }

    public function pegawai()
    {
        $units = PsUnit::orderBy('price_per_hour')->get();

        return view('dashboard.pegawai', [
            'jumlahUnit' => $units->count(),
            'jumlahBooking' => Booking::count(),
            'stats' => [
                // Model antar/ambil (pengantaran unit ke rumah) tidak dipakai di
                // rental ini — penyewaan berlangsung di tempat, jadi dua angka
                // ini memang 0. Operasional booking ada di halaman Kelola Booking.
                'antar' => 0,
                'ambil' => 0,
                'pending' => Booking::where('status', 'pending')->count(),
                'tersedia' => $units->where('status', 'available')->count(),
            ],
            'deliveries' => collect(),
            'returns' => collect(),
            'units' => $units->map(fn ($u) => (object) [
                'nama' => $u->name,
                'status' => $u->status,
                'warna' => $this->warnaUnit($u),
            ]),
        ]);
    }

    public function admin()
    {
        $units = PsUnit::orderBy('price_per_hour')->get();
        $usersById = User::all()->keyBy(fn ($u) => (string) $u->_id);
        $unitsById = $units->keyBy(fn ($u) => (string) $u->_id);

        $orders = Booking::orderByDesc('start_time')->limit(8)->get()
            ->map(function ($b) use ($usersById, $unitsById) {
                $penyewa = $usersById->get((string) $b->user_id);
                $unit = $unitsById->get((string) $b->ps_unit_id);

                return (object) [
                    'nama' => $penyewa->name ?? 'Pengguna',
                    // Skema users tidak punya nomor WA; tombol WhatsApp di view
                    // hanya tampil bila field ini terisi.
                    'wa' => $penyewa->no_hp ?? '',
                    'unit' => $unit->name ?? 'Unit',
                    'tanggal' => $b->start_time,
                    'paket' => $b->start_time->diffInHours($b->end_time) . ' jam',
                    'status' => $b->status,
                ];
            });

        return view('dashboard.admin', [
            'jumlahUnit' => $units->count(),
            'jumlahPengguna' => User::where('role', 'pengguna')->count(),
            'jumlahPegawai' => User::where('role', 'pegawai')->count(),
            'jumlahBooking' => Booking::count(),
            'jumlahPembayaran' => Payment::count(),
            'stats' => [
                'total' => Booking::count(),
                'pending' => Booking::where('status', 'pending')->count(),
                'active' => Booking::where('status', 'active')->count(),
                'revenue' => (int) Booking::where('status', 'done')
                    ->where('start_time', '>=', now()->startOfMonth())
                    ->sum('total_price'),
            ],
            'orders' => $orders,
            'units' => $units->map(fn ($u) => (object) [
                'nama' => $u->name,
                'status' => $u->status,
                'warna' => $this->warnaUnit($u),
            ]),
        ]);
    }

    private function warnaUnit(PsUnit $unit): string
    {
        return match ($unit->type) {
            'PS5' => '#ff2d87',
            'PS4' => '#2d7dff',
            default => '#8b9bb3',
        };
    }
}
