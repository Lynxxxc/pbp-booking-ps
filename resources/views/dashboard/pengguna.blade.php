@extends('layouts.app')

@section('title', 'Dashboard Saya')

@section('content')
    <section class="mx-auto max-w-7xl px-4 py-10">

        {{-- ============ HEADER ============ --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.35em] text-pink-300">Save Point PlayStation</p>
                <h1 class="mt-1 text-3xl font-extrabold text-white">Dashboard Saya</h1>
                <p class="mt-1 text-sm text-slate-400">
                    Halo, {{ $user->name }}. Kamu masuk sebagai pengguna.
                </p>
            </div>

            <a href="{{ route('home') }}#paket"
               class="rounded-xl bg-gradient-to-r from-pink-500 to-pink-600 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-pink-600/30 transition hover:from-pink-400 hover:to-pink-500">
                Pesan Unit Sekarang
            </a>
        </div>

        {{-- ============ KARTU ============ --}}
        <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <div class="rounded-2xl border border-pink-300/15 bg-white/[0.04] p-6 backdrop-blur">
                <p class="text-sm text-slate-400">Poin Loyalty</p>
                <p class="mt-2 text-4xl font-extrabold text-pink-300">{{ number_format($user->poin ?? 0) }}</p>
                <p class="mt-1 text-xs text-slate-500">Kumpulkan poin dari setiap penyewaan</p>
            </div>

            <div class="rounded-2xl border border-pink-300/15 bg-white/[0.04] p-6 backdrop-blur">
                <p class="text-sm text-slate-400">Akun</p>
                <p class="mt-2 truncate font-semibold text-slate-100">{{ $user->email }}</p>
                <p class="mt-1 text-xs text-slate-500">Email terdaftar</p>
            </div>

            <div class="rounded-2xl border border-pink-300/15 bg-white/[0.04] p-6 backdrop-blur">
                <p class="text-sm text-slate-400">Booking Saya</p>
                <p class="mt-2 text-4xl font-extrabold text-pink-300">{{ number_format($jumlahBooking ?? 0) }}</p>
                <p class="mt-1 text-xs text-slate-500">Total booking yang pernah kamu buat</p>
                <a href="{{ route('booking.saya') }}" class="mt-3 inline-block text-sm font-semibold text-pink-300 hover:underline">Lihat riwayat booking →</a>
            </div>
        </div>

        {{-- ============ BOOKING TERBARU ============ --}}
        @php
            $statusStyle = [
                'pending'   => 'border-amber-400/40 bg-amber-400/10 text-amber-300',
                'confirmed' => 'border-sky-400/40 bg-sky-400/10 text-sky-300',
                'active'    => 'border-pink-400/40 bg-pink-400/10 text-pink-300',
                'done'      => 'border-emerald-400/40 bg-emerald-400/10 text-emerald-300',
                'cancelled' => 'border-red-400/40 bg-red-400/10 text-red-300',
            ];
            $statusLabel = [
                'pending'   => 'Menunggu Konfirmasi',
                'confirmed' => 'Dikonfirmasi',
                'active'    => 'Sedang Main',
                'done'      => 'Selesai',
                'cancelled' => 'Dibatalkan',
            ];
        @endphp
        <div class="mt-8 rounded-2xl border border-pink-300/15 bg-white/[0.04] backdrop-blur">
            <div class="flex items-center justify-between border-b border-pink-300/10 px-5 py-4">
                <h2 class="text-lg font-bold text-white">Booking Terbaru</h2>
                <a href="{{ route('booking.saya') }}" class="text-sm font-semibold text-pink-300 hover:underline">Lihat semua →</a>
            </div>
            <ul class="divide-y divide-pink-300/10">
                @forelse ($bookings ?? [] as $b)
                    @php $unitB = ($units ?? collect())->get((string) $b->ps_unit_id); @endphp
                    <li class="flex flex-wrap items-center justify-between gap-3 px-5 py-3.5">
                        <div>
                            <p class="font-semibold text-slate-100">{{ $unitB->name ?? 'Unit' }}</p>
                            <p class="text-xs text-slate-500">
                                {{ $b->start_time->translatedFormat('d M Y') }} &middot; {{ $b->start_time->format('H:i') }}–{{ $b->end_time->format('H:i') }}
                                &middot; Rp {{ number_format($b->total_price, 0, ',', '.') }}
                            </p>
                        </div>
                        <span class="inline-flex rounded-full border px-2.5 py-1 text-xs font-semibold {{ $statusStyle[$b->status] ?? 'border-slate-600 text-slate-300' }}">
                            {{ $statusLabel[$b->status] ?? ucfirst($b->status) }}
                        </span>
                    </li>
                @empty
                    <li class="px-5 py-10 text-center text-sm text-slate-500">
                        Belum ada booking. <a href="{{ route('home') }}#paket" class="font-semibold text-pink-300 hover:underline">Pesan unit sekarang →</a>
                    </li>
                @endforelse
            </ul>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    // AFRIAN_AUTO_REFRESH: halaman dimuat ulang otomatis tiap 5 detik (hanya saat tab terlihat)
    setInterval(function () {
        if (!document.hidden) { location.reload(); }
    }, 5000);
</script>
@endpush
