@extends('layouts.app')

@section('title', 'Dashboard Saya')

@section('content')
    <section class="mx-auto max-w-6xl px-4 py-12">
        <h1 class="text-2xl font-bold">Halo, {{ $user->name }}</h1>
        <p class="mt-1 text-sm text-slate-400">Kamu masuk sebagai pengguna.</p>

        <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <div class="rounded-2xl border border-slate-800 bg-slate-900 p-6">
                <p class="text-sm text-slate-400">Poin loyalty</p>
                <p class="mt-2 text-3xl font-bold text-violet-300">{{ $user->poin ?? 0 }}</p>
            </div>
            <div class="rounded-2xl border border-slate-800 bg-slate-900 p-6">
                <p class="text-sm text-slate-400">Booking saya</p>
                <p class="mt-2 text-slate-300">Fitur booking sedang dibangun. Nanti riwayat bookingmu tampil di sini.</p>
                <a href="{{ route('home') }}#katalog" class="mt-3 inline-block text-sm font-medium text-violet-300 hover:underline">Lihat katalog unit</a>
            </div>
            <div class="rounded-2xl border border-slate-800 bg-slate-900 p-6">
                <p class="text-sm text-slate-400">Akun</p>
                <p class="mt-2 text-slate-300">{{ $user->email }}</p>
            </div>
        </div>
    </section>
@endsection
