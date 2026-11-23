@extends('layouts.app')

@section('title', 'RentalPS')

@section('content')
    <section class="mx-auto max-w-6xl px-4 py-16 text-center">
        <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl">Booking PlayStation <span class="text-violet-400">per Jam</span></h1>
        <p class="mx-auto mt-4 max-w-2xl text-slate-400">Pilih room, tentukan tanggal dan jam, datang dan main. Tanpa antre, tanpa ribet — semua tercatat di sistem.</p>
        <div class="mt-8 flex justify-center gap-3">
            <a href="#katalog" class="rounded-xl bg-violet-600 px-6 py-3 font-semibold text-white hover:bg-violet-500">Lihat Unit</a>
            @guest
                <a href="{{ route('register') }}" class="rounded-xl border border-slate-700 px-6 py-3 font-semibold text-slate-200 hover:bg-slate-800">Daftar Akun</a>
            @endguest
        </div>
    </section>

    <section id="katalog" class="mx-auto max-w-6xl px-4 pb-16">
        <h2 class="text-2xl font-bold">Katalog Unit PS</h2>
        <p class="mt-1 text-sm text-slate-400">Harga per jam, mengikuti daftar unit yang tersimpan di database.</p>

        @if ($units->isEmpty())
            <div class="mt-6 rounded-2xl border border-dashed border-slate-700 p-8 text-center text-slate-400">
                Data unit belum tersedia. Katalog akan terisi setelah data unit PS diisi ke database.
            </div>
        @else
            <div class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($units as $unit)
                    <article class="rounded-2xl border border-slate-800 bg-slate-900 p-6">
                        <div class="flex items-start justify-between gap-3">
                            <h3 class="text-lg font-semibold">{{ $unit->name }}</h3>
                            @if ($unit->status === 'available')
                                <span class="rounded-full bg-emerald-500/15 px-2.5 py-1 text-xs font-medium text-emerald-300">Tersedia</span>
                            @else
                                <span class="rounded-full bg-rose-500/15 px-2.5 py-1 text-xs font-medium text-rose-300">{{ $unit->status }}</span>
                            @endif
                        </div>
                        <p class="mt-1 text-sm text-slate-400">{{ $unit->type }}</p>
                        @if ($unit->description)
                            <p class="mt-1 text-sm text-slate-400">{{ $unit->description }}</p>
                        @endif
                        <p class="mt-4 text-xl font-bold text-violet-300">Rp{{ number_format($unit->price_per_hour, 0, ',', '.') }}<span class="text-sm font-normal text-slate-400">/jam</span></p>
                    </article>
                @endforeach
            </div>
        @endif
    </section>

    <section class="border-t border-slate-800 bg-slate-900/50">
        <div class="mx-auto max-w-6xl px-4 py-14">
            <h2 class="text-2xl font-bold">Cara Booking</h2>
            <ol class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <li class="rounded-2xl border border-slate-800 bg-slate-900 p-5"><span class="font-bold text-violet-400">1.</span> Daftar akun atau masuk.</li>
                <li class="rounded-2xl border border-slate-800 bg-slate-900 p-5"><span class="font-bold text-violet-400">2.</span> Pilih unit, tanggal, jam mulai, dan durasi.</li>
                <li class="rounded-2xl border border-slate-800 bg-slate-900 p-5"><span class="font-bold text-violet-400">3.</span> Sistem mengecek ketersediaan dan mencatat booking.</li>
                <li class="rounded-2xl border border-slate-800 bg-slate-900 p-5"><span class="font-bold text-violet-400">4.</span> Datang, check-in ke pegawai, dan main.</li>
            </ol>
        </div>
    </section>
@endsection
