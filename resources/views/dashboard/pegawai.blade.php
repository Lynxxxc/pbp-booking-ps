@extends('layouts.app')

@section('title', 'Dashboard Pegawai')

@section('content')
    @php
        $stats      = $stats      ?? ['antar' => 0, 'ambil' => 0, 'pending' => 0, 'tersedia' => 0];
        $deliveries = $deliveries ?? collect();
        $returns    = $returns    ?? collect();
        $units      = $units      ?? collect();

        $waLink  = fn ($no) => 'https://wa.me/' . preg_replace('/^0/', '62', preg_replace('/\D/', '', $no));
        $mapLink = fn ($alamat) => 'https://www.google.com/maps/search/?api=1&query=' . urlencode($alamat);
    @endphp

    <section class="mx-auto max-w-6xl px-4 py-10">

        {{-- HEADER --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.35em] text-pink-300">Save Point PlayStation</p>
                <h1 class="mt-1 text-3xl font-extrabold text-white">Dashboard Pegawai</h1>
                <p class="mt-1 text-sm text-slate-400">
                    Halo, {{ auth()->user()->name ?? 'Pegawai' }} &middot; {{ now()->translatedFormat('l, d F Y') }}
                </p>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="rounded-xl bg-gradient-to-r from-pink-500 to-pink-600 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-pink-600/30 transition hover:from-pink-400 hover:to-pink-500">
                    Keluar
                </button>
            </form>
        </div>

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

        {{-- RINGKASAN --}}
        <div class="mt-8 grid grid-cols-2 gap-4 lg:grid-cols-4">
            <div class="rounded-2xl border border-pink-300/15 bg-white/[0.04] p-5 backdrop-blur">
                <p class="text-sm text-slate-400">Antar Hari Ini</p>
                <p class="mt-2 text-4xl font-extrabold text-pink-300">{{ $stats['antar'] }}</p>
            </div>
            <div class="rounded-2xl border border-sky-400/20 bg-white/[0.04] p-5 backdrop-blur">
                <p class="text-sm text-slate-400">Ambil Hari Ini</p>
                <p class="mt-2 text-4xl font-extrabold text-sky-300">{{ $stats['ambil'] }}</p>
            </div>
            <div class="rounded-2xl border border-amber-400/20 bg-white/[0.04] p-5 backdrop-blur">
                <p class="text-sm text-slate-400">Belum Dikonfirmasi</p>
                <p class="mt-2 text-4xl font-extrabold text-amber-300">{{ $stats['pending'] }}</p>
            </div>
            <div class="rounded-2xl border border-emerald-400/20 bg-white/[0.04] p-5 backdrop-blur">
                <p class="text-sm text-slate-400">Unit Tersedia</p>
                <p class="mt-2 text-4xl font-extrabold text-emerald-300">{{ $stats['tersedia'] }}</p>
            </div>
        </div>

        <div class="mt-8 grid gap-6 lg:grid-cols-3">
            <div class="space-y-6 lg:col-span-2">

                {{-- JADWAL PENGANTARAN --}}
                <div class="rounded-2xl border border-pink-300/15 bg-white/[0.04] backdrop-blur">
                    <div class="flex items-center justify-between border-b border-pink-300/10 px-5 py-4">
                        <h2 class="text-lg font-bold text-white">🚚 Jadwal Pengantaran</h2>
                        <span class="rounded-full bg-pink-500/15 px-3 py-1 text-xs font-semibold text-pink-300">{{ $deliveries->count() }} tugas</span>
                    </div>

                    <ul class="divide-y divide-pink-300/10">
                        @forelse ($deliveries as $order)
                            <li class="p-5">
                                <div class="flex flex-wrap items-start justify-between gap-3">
                                    <div>
                                        <p class="text-lg font-bold text-white">{{ $order->nama }}</p>
                                        <p class="mt-0.5 text-sm text-pink-200">{{ $order->unit }} &middot; {{ $order->paket }}</p>
                                    </div>
                                    <span class="rounded-full border border-pink-400/40 bg-pink-400/10 px-3 py-1 text-sm font-bold text-pink-300">
                                        🕒 {{ \Illuminate\Support\Str::of($order->waktu)->substr(0, 5) }}
                                    </span>
                                </div>

                                <p class="mt-3 text-sm text-slate-300">
                                    📍 {{ $order->alamat }}, RT/RW {{ $order->rtrw }}, No. {{ $order->norumah }}
                                </p>
                                @if ($order->catatan)
                                    <p class="mt-1 text-xs text-slate-500">💬 {{ $order->catatan }}</p>
                                @endif

                                <div class="mt-4 flex flex-wrap gap-2">
                                    <a href="{{ $mapLink($order->alamat) }}" target="_blank" rel="noopener"
                                       class="rounded-lg border border-pink-300/30 px-3 py-2 text-xs font-semibold text-pink-200 transition hover:bg-pink-300/10">Buka Peta</a>
                                    <a href="{{ $waLink($order->wa) }}" target="_blank" rel="noopener"
                                       class="rounded-lg border border-pink-300/30 px-3 py-2 text-xs font-semibold text-pink-200 transition hover:bg-pink-300/10">WhatsApp Penyewa</a>
                                    <a href="{{ $waLink($order->wakeluarga) }}" target="_blank" rel="noopener"
                                       class="rounded-lg border border-pink-300/30 px-3 py-2 text-xs font-semibold text-pink-200 transition hover:bg-pink-300/10">WA Keluarga</a>

                                    @if (Route::has('pegawai.orders.deliver'))
                                        <form method="POST" action="{{ route('pegawai.orders.deliver', $order) }}"
                                              data-confirm="Tandai unit sudah diantar ke {{ e($order->nama) }}?">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    class="rounded-lg bg-pink-500 px-4 py-2 text-xs font-bold text-white shadow shadow-pink-600/30 transition hover:bg-pink-400 active:scale-95">
                                                ✔ Tandai Sudah Diantar
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </li>
                        @empty
                            <li class="px-5 py-12 text-center text-slate-500">
                                <p class="text-3xl">🎉</p>
                                <p class="mt-2">Tidak ada pengantaran hari ini.</p>
                            </li>
                        @endforelse
                    </ul>
                </div>

                {{-- PENGAMBILAN UNIT --}}
                <div class="rounded-2xl border border-pink-300/15 bg-white/[0.04] backdrop-blur">
                    <div class="flex items-center justify-between border-b border-pink-300/10 px-5 py-4">
                        <h2 class="text-lg font-bold text-white">📦 Pengambilan Unit</h2>
                        <span class="rounded-full bg-sky-500/15 px-3 py-1 text-xs font-semibold text-sky-300">{{ $returns->count() }} tugas</span>
                    </div>

                    <ul class="divide-y divide-pink-300/10">
                        @forelse ($returns as $order)
                            <li class="flex flex-wrap items-center justify-between gap-3 p-5">
                                <div>
                                    <p class="font-bold text-white">{{ $order->nama }}</p>
                                    <p class="text-sm text-slate-400">{{ $order->unit }} &middot; {{ $order->alamat }}</p>
                                </div>
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ $mapLink($order->alamat) }}" target="_blank" rel="noopener"
                                       class="rounded-lg border border-pink-300/30 px-3 py-2 text-xs font-semibold text-pink-200 transition hover:bg-pink-300/10">Buka Peta</a>
                                    @if (Route::has('pegawai.orders.return'))
                                        <form method="POST" action="{{ route('pegawai.orders.return', $order) }}"
                                              data-confirm="Tandai {{ e($order->unit) }} sudah dikembalikan?">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    class="rounded-lg bg-sky-500 px-4 py-2 text-xs font-bold text-white transition hover:bg-sky-400 active:scale-95">
                                                ✔ Tandai Sudah Kembali
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </li>
                        @empty
                            <li class="px-5 py-10 text-center text-sm text-slate-500">Tidak ada pengambilan hari ini.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            {{-- STATUS UNIT --}}
            <div class="h-fit rounded-2xl border border-pink-300/15 bg-white/[0.04] backdrop-blur">
                <div class="border-b border-pink-300/10 px-5 py-4">
                    <h2 class="text-lg font-bold text-white">🎮 Status Unit</h2>
                </div>

                <ul class="divide-y divide-pink-300/10">
                    @forelse ($units as $unit)
                        @php $available = ($unit->status ?? 'available') === 'available'; @endphp
                        <li class="flex items-center justify-between gap-3 px-5 py-3">
                            <div class="flex items-center gap-3">
                                <span class="h-3 w-3 rounded-full ring-1 ring-white/20" style="background: {{ $unit->warna ?? '#ff2d87' }}"></span>
                                <span class="text-sm font-medium text-slate-200">{{ $unit->nama }}</span>
                            </div>
                            <span class="rounded-full border px-2.5 py-0.5 text-xs font-semibold
                                {{ $available ? 'border-emerald-400/40 bg-emerald-400/10 text-emerald-300' : 'border-pink-400/40 bg-pink-400/10 text-pink-300' }}">
                                {{ $available ? 'Tersedia' : 'Disewa' }}
                            </span>
                        </li>
                    @empty
                        <li class="px-5 py-10 text-center text-sm text-slate-500">Belum ada data unit.</li>
                    @endforelse
                </ul>
            </div>
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
