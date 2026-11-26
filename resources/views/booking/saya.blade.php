@extends('layouts.app')

@section('title', 'Booking Saya')

@section('content')
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

    <section class="mx-auto max-w-7xl px-4 py-10">
        <p class="text-xs font-semibold uppercase tracking-[0.35em] text-pink-300">Save Point PlayStation</p>
        <h1 class="mt-1 text-3xl font-extrabold text-white">Booking Saya</h1>
        <p class="mt-1 text-sm text-slate-400">Riwayat dan status booking milikmu.</p>

        @if (session('success'))
            <div class="mt-6 rounded-xl border border-emerald-400/40 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-300">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="mt-6 rounded-xl border border-red-500/40 bg-red-500/10 px-4 py-3 text-sm text-red-300">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="mt-8 space-y-4">
            @forelse ($bookings as $b)
                @php
                    $unit = $units->get((string) $b->ps_unit_id);
                    $pay = $payments->get((string) $b->_id);
                    $durasi = $b->start_time->diffInHours($b->end_time);
                @endphp
                <div class="flex flex-col gap-4 rounded-2xl border border-pink-300/15 bg-white/[0.04] p-5 backdrop-blur md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-lg font-bold text-white">{{ $unit->name ?? 'Unit' }}</p>
                        <p class="mt-0.5 text-sm text-slate-400">
                            {{ $b->start_time->translatedFormat('l, d M Y') }} &middot;
                            {{ $b->start_time->format('H:i') }}–{{ $b->end_time->format('H:i') }} ({{ $durasi }} jam)
                        </p>
                        <p class="mt-1 text-sm text-slate-300">
                            Total <span class="font-bold text-pink-300">Rp {{ number_format($b->total_price, 0, ',', '.') }}</span>
                            @if ($pay)
                                &middot; {{ strtoupper($pay->method) }} — {{ $pay->status === 'paid' ? 'Lunas' : 'Belum dibayar' }}
                            @endif
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="inline-flex rounded-full border px-3 py-1 text-xs font-semibold {{ $statusStyle[$b->status] ?? 'border-slate-600 text-slate-300' }}">
                            {{ $statusLabel[$b->status] ?? ucfirst($b->status) }}
                        </span>
                        @if (in_array($b->status, ['pending', 'confirmed'], true) && $b->start_time->gt(now()))
                            <form method="POST" action="{{ route('booking.batal', $b) }}"
                                  data-confirm="Batalkan booking ini?">
                                @csrf
                                <button type="submit" class="rounded-lg border border-red-400/40 px-3 py-1.5 text-xs font-semibold text-red-300 transition hover:bg-red-400/10">
                                    Batalkan
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="rounded-2xl border border-pink-300/15 bg-white/[0.04] px-5 py-12 text-center text-slate-500 backdrop-blur">
                    <p class="text-3xl">🎮</p>
                    <p class="mt-2">Kamu belum punya booking.</p>
                    <a href="{{ route('home') }}#paket" data-goto class="mt-4 inline-block rounded-xl bg-gradient-to-r from-pink-500 to-pink-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-pink-600/30 transition hover:from-pink-400 hover:to-pink-500">
                        Lihat Katalog Unit
                    </a>
                </div>
            @endforelse
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
