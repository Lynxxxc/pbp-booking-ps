<?php

namespace App\Http\Controllers;

use App\Mail\BookingDikonfirmasi;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\PsUnit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PegawaiBookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::orderByDesc('start_time')->limit(100)->get();

        $users = User::all()->keyBy(fn ($u) => (string) $u->_id);
        $units = PsUnit::all()->keyBy(fn ($u) => (string) $u->_id);
        $payments = Payment::whereIn('booking_id', $bookings->map(fn ($b) => (string) $b->_id)->all())
            ->get()
            ->keyBy('booking_id');

        return view('pegawai.booking', compact('bookings', 'users', 'units', 'payments'));
    }

    public function konfirmasi(Booking $booking)
    {
        if ($booking->status !== 'pending') {
            return back()->withErrors(['booking' => 'Hanya booking berstatus menunggu yang bisa dikonfirmasi.']);
        }

        $booking->update(['status' => 'confirmed']);

        // Pemberitahuan otomatis ke email penyewa bahwa bookingnya sudah
        // dikonfirmasi. Akun internal (.local: tamu & walk-in) dilewati, dan
        // kegagalan pengiriman tidak boleh menggagalkan konfirmasi itu sendiri.
        $terkirim = false;
        $penyewa = User::whereIn('_id', Booking::bentukId($booking->user_id))->first();
        if ($penyewa && $penyewa->email && ! Str::endsWith($penyewa->email, '.local')) {
            try {
                Mail::to($penyewa->email)->send(new BookingDikonfirmasi($booking, $penyewa));
                $terkirim = true;
            } catch (\Throwable $e) {
                Log::warning('Email konfirmasi booking gagal terkirim: ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Booking dikonfirmasi.' . ($terkirim ? ' Email pemberitahuan terkirim ke penyewa.' : ''));
    }

    public function checkin(Booking $booking)
    {
        if ($booking->status !== 'confirmed') {
            return back()->withErrors(['booking' => 'Booking harus dikonfirmasi dulu sebelum check-in.']);
        }

        $booking->update(['status' => 'active']);
        PsUnit::whereIn('_id', Booking::bentukId($booking->ps_unit_id))
            ->update(['status' => 'used']);

        return back()->with('success', 'Check-in berhasil. Unit ditandai sedang dipakai.');
    }

    public function selesai(Booking $booking)
    {
        if ($booking->status !== 'active') {
            return back()->withErrors(['booking' => 'Hanya booking yang sedang berjalan yang bisa diselesaikan.']);
        }

        $booking->update(['status' => 'done']);
        PsUnit::whereIn('_id', Booking::bentukId($booking->ps_unit_id))
            ->update(['status' => 'available']);

        // Poin loyalty: 1 poin per Rp10.000 dari total booking, diberikan sekali
        // saat penyewaan selesai.
        $poin = intdiv((int) $booking->total_price, 10000);
        if ($poin > 0) {
            $user = User::whereIn('_id', Booking::bentukId($booking->user_id))->first();
            if ($user) {
                $user->increment('poin', $poin);
            }
        }

        return back()->with('success', 'Penyewaan selesai. Unit kembali tersedia' . ($poin > 0 ? ", penyewa mendapat {$poin} poin." : '.'));
    }

    public function walkinForm()
    {
        $units = PsUnit::orderBy('price_per_hour')->get();

        return view('pegawai.walkin', compact('units'));
    }

    public function walkinStore(Request $request)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'no_hp' => ['required', 'string', 'max:20'],
            'ps_unit_id' => ['required', 'string'],
            'tanggal' => ['required', 'date'],
            'jam_mulai' => ['required', 'date_format:H:i'],
            'durasi' => ['required', 'integer', 'min:1', 'max:12'],
            'metode' => ['required', 'in:cash,qris,e-wallet'],
        ]);

        $unit = PsUnit::whereIn('_id', Booking::bentukId($data['ps_unit_id']))->first();
        if (! $unit) {
            return back()->withInput()->withErrors(['ps_unit_id' => 'Unit tidak ditemukan.']);
        }

        $start = Carbon::parse($data['tanggal'] . ' ' . $data['jam_mulai']);
        $end = $start->copy()->addHours((int) $data['durasi']);

        if ($start->lt(now()->subMinutes(15))) {
            return back()->withInput()
                ->withErrors(['jam_mulai' => 'Waktu mulai sudah lewat. Pilih waktu lain.']);
        }

        if (Booking::adaBentrok($unit->_id, $start, $end)) {
            return back()->withInput()
                ->withErrors(['jam_mulai' => 'Unit ini sudah dibooking di jam tersebut. Coba jam atau unit lain.']);
        }

        // Pelanggan walk-in dicatat sebagai akun pengguna berdasarkan nomor HP,
        // supaya riwayat & poinnya tetap terlacak.
        $email = 'walkin-' . preg_replace('/\D/', '', $data['no_hp']) . '@afrianjmk48.local';
        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $data['nama'],
                'phone' => $data['no_hp'],
                'password' => Str::random(32),
                'role' => 'pengguna',
                'poin' => 0,
            ]
        );
        if (empty($user->phone)) {
            $user->update(['phone' => $data['no_hp']]);
        }

        $total = (int) $unit->price_per_hour * (int) $data['durasi'];

        $booking = Booking::create([
            'user_id' => (string) $user->_id,
            'ps_unit_id' => (string) $unit->_id,
            'start_time' => $start,
            'end_time' => $end,
            'total_price' => $total,
            'status' => 'confirmed',
        ]);

        Payment::create([
            'booking_id' => (string) $booking->_id,
            'amount' => $total,
            'method' => $data['metode'],
            'status' => 'pending',
        ]);

        return redirect()->route('pegawai.booking')
            ->with('success', 'Booking walk-in untuk ' . $data['nama'] . ' dibuat (langsung terkonfirmasi). Total: Rp ' . number_format($total, 0, ',', '.'));
    }
}
