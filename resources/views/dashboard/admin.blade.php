@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <section class="mx-auto max-w-6xl px-4 py-12">
        <h1 class="text-2xl font-bold">Dashboard Admin</h1>
        <p class="mt-1 text-sm text-slate-400">Ringkasan data yang tersimpan di database bersama (MongoDB Atlas).</p>

        <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <div class="rounded-2xl border border-slate-800 bg-slate-900 p-6">
                <p class="text-sm text-slate-400">Unit PS terdaftar</p>
                <p class="mt-2 text-3xl font-bold text-violet-300">{{ $jumlahUnit }}</p>
            </div>
            <div class="rounded-2xl border border-slate-800 bg-slate-900 p-6">
                <p class="text-sm text-slate-400">Akun pengguna</p>
                <p class="mt-2 text-3xl font-bold text-violet-300">{{ $jumlahPengguna }}</p>
            </div>
            <div class="rounded-2xl border border-slate-800 bg-slate-900 p-6">
                <p class="text-sm text-slate-400">Akun pegawai</p>
                <p class="mt-2 text-3xl font-bold text-violet-300">{{ $jumlahPegawai }}</p>
            </div>
            <div class="rounded-2xl border border-slate-800 bg-slate-900 p-6">
                <p class="text-sm text-slate-400">Total booking tercatat</p>
                <p class="mt-2 text-3xl font-bold text-violet-300">{{ $jumlahBooking }}</p>
            </div>
            <div class="rounded-2xl border border-slate-800 bg-slate-900 p-6">
                <p class="text-sm text-slate-400">Total pembayaran tercatat</p>
                <p class="mt-2 text-3xl font-bold text-violet-300">{{ $jumlahPembayaran }}</p>
            </div>
        </div>

        <p class="mt-8 text-sm text-slate-500">Kelola unit, akun pegawai, laporan pendapatan, dan konten landing menyusul di panel ini.</p>
    </section>
@endsection
