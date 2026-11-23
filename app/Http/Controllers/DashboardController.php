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
        return view('dashboard.pengguna', [
            'user' => auth()->user(),
        ]);
    }

    public function pegawai()
    {
        return view('dashboard.pegawai', [
            'jumlahUnit' => PsUnit::count(),
            'jumlahBooking' => Booking::count(),
        ]);
    }

    public function admin()
    {
        return view('dashboard.admin', [
            'jumlahUnit' => PsUnit::count(),
            'jumlahPengguna' => User::where('role', 'pengguna')->count(),
            'jumlahPegawai' => User::where('role', 'pegawai')->count(),
            'jumlahBooking' => Booking::count(),
            'jumlahPembayaran' => Payment::count(),
        ]);
    }
}
