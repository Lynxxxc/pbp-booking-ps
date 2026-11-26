@extends('layouts.app')

@section('title', 'Booking Walk-in')

@section('content')
<section class="mx-auto max-w-2xl px-4 py-12">
    <a href="{{ route('pegawai.booking') }}"
       class="mb-6 inline-flex items-center gap-2 text-sm text-white/75 transition hover:text-pink-300">
        <span>←</span> Kembali ke Kelola Booking
    </a>

    <div class="rounded-3xl border border-pink-300/15 bg-[#1b0812]/80 p-8 shadow-2xl shadow-black/60 backdrop-blur-xl">
        <h1 class="font-display text-3xl font-bold uppercase tracking-wide text-pink-300">Booking Walk-in</h1>
        <p class="mt-1 text-sm text-white/70">Untuk pelanggan yang datang langsung ke tempat. Booking walk-in langsung berstatus terkonfirmasi.</p>

        @if ($errors->any())
            <div class="mt-5 rounded-xl border border-red-500/40 bg-red-500/10 px-4 py-3 text-sm text-red-300">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('pegawai.walkin.store') }}" class="mt-6 space-y-4" data-loading="MEMBUAT BOOKING...">
            @csrf

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="nama" class="block text-sm font-semibold text-white">Nama Pelanggan</label>
                    <input id="nama" name="nama" type="text" required value="{{ old('nama') }}" placeholder="Nama penyewa"
                           class="mt-2 w-full rounded-xl border border-white/10 bg-[#26121c] px-4 py-3 text-sm text-white placeholder-white/35 transition focus:border-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-400/25">
                </div>
                <div>
                    <label for="no_hp" class="block text-sm font-semibold text-white">Nomor HP</label>
                    <input id="no_hp" name="no_hp" type="text" required value="{{ old('no_hp') }}" placeholder="08xxxxxxxxxx"
                           class="mt-2 w-full rounded-xl border border-white/10 bg-[#26121c] px-4 py-3 text-sm text-white placeholder-white/35 transition focus:border-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-400/25">
                </div>
            </div>

            <div>
                <label for="ps_unit_id" class="block text-sm font-semibold text-white">Unit</label>
                <select id="ps_unit_id" name="ps_unit_id" required
                        class="mt-2 w-full rounded-xl border border-white/10 bg-[#26121c] px-4 py-3 text-sm text-white transition focus:border-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-400/25">
                    @foreach ($units as $u)
                        <option value="{{ $u->_id }}" @selected(old('ps_unit_id') === (string) $u->_id)>
                            {{ $u->name }} — Rp {{ number_format($u->price_per_hour, 0, ',', '.') }}/jam
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="tanggal" class="block text-sm font-semibold text-white">Tanggal Main</label>
                    <input id="tanggal" name="tanggal" type="date" required
                           value="{{ old('tanggal', now()->format('Y-m-d')) }}"
                           min="{{ now()->format('Y-m-d') }}"
                           class="mt-2 w-full rounded-xl border border-white/10 bg-[#26121c] px-4 py-3 text-sm text-white transition focus:border-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-400/25">
                </div>
                <div>
                    <label for="jam_mulai" class="block text-sm font-semibold text-white">Jam Mulai</label>
                    <input id="jam_mulai" name="jam_mulai" type="time" required
                           value="{{ old('jam_mulai', now()->format('H:i')) }}"
                           class="mt-2 w-full rounded-xl border border-white/10 bg-[#26121c] px-4 py-3 text-sm text-white transition focus:border-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-400/25">
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="durasi" class="block text-sm font-semibold text-white">Durasi</label>
                    <select id="durasi" name="durasi" required
                            class="mt-2 w-full rounded-xl border border-white/10 bg-[#26121c] px-4 py-3 text-sm text-white transition focus:border-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-400/25">
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" @selected((int) old('durasi', 1) === $i)>{{ $i }} jam</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label for="metode" class="block text-sm font-semibold text-white">Metode Pembayaran</label>
                    <select id="metode" name="metode" required
                            class="mt-2 w-full rounded-xl border border-white/10 bg-[#26121c] px-4 py-3 text-sm text-white transition focus:border-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-400/25">
                        <option value="cash" @selected(old('metode') === 'cash')>Tunai di tempat</option>
                        <option value="qris" @selected(old('metode') === 'qris')>QRIS</option>
                        <option value="e-wallet" @selected(old('metode') === 'e-wallet')>E-Wallet</option>
                    </select>
                </div>
            </div>

            <button type="submit"
                    class="flex w-full items-center justify-center gap-2.5 rounded-xl bg-gradient-to-r from-[#ff2d87] to-[#e11d6a] px-5 py-3.5 text-base font-bold text-white shadow-[0_0_25px_rgba(255,45,135,0.45)] transition hover:-translate-y-0.5 hover:brightness-110 active:scale-[0.99]">
                Buat Booking Walk-in
            </button>
        </form>
    </div>
</section>
@endsection
