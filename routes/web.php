<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PegawaiBookingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

Route::middleware(['auth', 'role:pengguna'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'pengguna'])->name('dashboard.pengguna');
    Route::get('/booking/{unit}', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking/{unit}', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking-saya', [BookingController::class, 'saya'])->name('booking.saya');
    Route::post('/booking/{booking}/batal', [BookingController::class, 'batal'])->name('booking.batal');
});

Route::middleware(['auth', 'role:pegawai,admin'])->group(function () {
    Route::get('/pegawai', [DashboardController::class, 'pegawai'])->name('dashboard.pegawai');
    Route::get('/pegawai/booking', [PegawaiBookingController::class, 'index'])->name('pegawai.booking');
    Route::post('/pegawai/booking/{booking}/konfirmasi', [PegawaiBookingController::class, 'konfirmasi'])->name('pegawai.booking.konfirmasi');
    Route::post('/pegawai/booking/{booking}/checkin', [PegawaiBookingController::class, 'checkin'])->name('pegawai.booking.checkin');
    Route::post('/pegawai/booking/{booking}/selesai', [PegawaiBookingController::class, 'selesai'])->name('pegawai.booking.selesai');
    Route::get('/pegawai/walkin', [PegawaiBookingController::class, 'walkinForm'])->name('pegawai.walkin');
    Route::post('/pegawai/walkin', [PegawaiBookingController::class, 'walkinStore'])->name('pegawai.walkin.store');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
});
