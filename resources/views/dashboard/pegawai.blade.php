@extends('layouts.app')

@section('title', 'Dashboard Pegawai')

@section('content')
    <section class="mx-auto max-w-6xl px-4 py-12">
        <h1 class="text-2xl font-bold">Dashboard Pegawai</h1>
        <p class="mt-1 text-sm text-slate-400">Panel operasional harian: jadwal booking, check-in/check-out, dan pembayaran di tempat.</p>

        <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <div class="rounded-2xl border border-slate-800 bg-slate-900 p-6">
                <p class="text-sm text-slate-400">Unit PS terdaftar di database</p>
                <p class="mt-2 text-3xl font-bold text-violet-300">{{ $jumlahUnit }}</p>
            </div>
            <div class="rounded-2xl border border-slate-800 bg-slate-900 p-6">
                <p class="text-sm text-slate-400">Total booking tercatat</p>
                <p class="mt-2 text-3xl font-bold text-violet-300">{{ $jumlahBooking }}</p>
                <p class="mt-1 text-sm text-slate-500">Daftar booking per hari tampil di sini setelah fitur booking selesai dibangun.</p>
            </div>
            <div class="rounded-2xl border border-slate-800 bg-slate-900 p-6">
                <p class="text-sm text-slate-400">Booking walk-in</p>
                <p class="mt-2 text-slate-300">Pegawai dapat membuatkan booking untuk pelanggan yang datang langsung, dari menu booking (menyusul).</p>
            </div>
        </div>
    </section>
@endsection
