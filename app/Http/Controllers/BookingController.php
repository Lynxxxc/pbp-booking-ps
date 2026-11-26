<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\PsUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BookingController extends Controller
{
    public function create(PsUnit $unit)
    {
        return view('booking.form', ['unit' => $unit]);
    }

    public function store(Request $request, PsUnit $unit)
    {
        $data = $request->validate([
            'tanggal' => ['required', 'date'],
            'jam_mulai' => ['required', 'date_format:H:i'],
            'durasi' => ['required', 'integer', 'min:1', 'max:12'],
            'metode' => ['required', 'in:cash,qris,e-wallet'],
            'phone' => ['nullable', 'string', 'max:20', 'regex:/^[0-9+\-\s]+$/'],
        ]);

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

        // Nomor HP dari form disimpan ke profil penyewa, supaya booking
        // berikutnya tidak perlu mengisi lagi dan pegawai punya nomor
        // yang bisa dihubungi untuk booking ini.
        $phone = isset($data['phone']) ? trim($data['phone']) : '';
        if ($phone !== '' && $phone !== (string) (auth()->user()->phone ?? '')) {
            auth()->user()->update(['phone' => $phone]);
        }

        $total = (int) $unit->price_per_hour * (int) $data['durasi'];

        $booking = Booking::create([
            'user_id' => (string) auth()->id(),
            'ps_unit_id' => (string) $unit->_id,
            'start_time' => $start,
            'end_time' => $end,
            'total_price' => $total,
            'status' => 'pending',
        ]);

        Payment::create([
            'booking_id' => (string) $booking->_id,
            'amount' => $total,
            'method' => $data['metode'],
            'status' => 'pending',
        ]);

        return redirect()->route('booking.saya')
            ->with('success', 'Booking berhasil dibuat dan menunggu konfirmasi pegawai. Total: Rp ' . number_format($total, 0, ',', '.'));
    }

    public function saya()
    {
        $bookings = Booking::whereIn('user_id', Booking::bentukId(auth()->id()))
            ->orderByDesc('start_time')
            ->get();

        $units = PsUnit::all()->keyBy(fn ($u) => (string) $u->_id);
        $payments = Payment::whereIn('booking_id', $bookings->map(fn ($b) => (string) $b->_id)->all())
            ->get()
            ->keyBy('booking_id');

        return view('booking.saya', compact('bookings', 'units', 'payments'));
    }

    public function batal(Booking $booking)
    {
        if (! in_array((string) $booking->user_id, array_map('strval', Booking::bentukId(auth()->id())), true)) {
            abort(403);
        }

        if (! in_array($booking->status, ['pending', 'confirmed'], true)) {
            return back()->withErrors(['booking' => 'Booking ini sudah tidak bisa dibatalkan.']);
        }

        if ($booking->start_time->lt(now())) {
            return back()->withErrors(['booking' => 'Booking yang waktunya sudah lewat tidak bisa dibatalkan.']);
        }

        $booking->update(['status' => 'cancelled']);

        return back()->with('success', 'Booking berhasil dibatalkan.');
    }
}
