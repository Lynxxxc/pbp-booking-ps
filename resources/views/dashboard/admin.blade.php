@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    @php
        // Nilai default supaya halaman tidak error jika controller belum mengirim data
        $stats  = $stats  ?? ['total' => 0, 'pending' => 0, 'active' => 0, 'revenue' => 0];
        $orders = $orders ?? collect();
        $units  = $units  ?? collect();

        $statusStyle = [
            'pending'   => 'border-amber-400/40 bg-amber-400/10 text-amber-300',
            'confirmed' => 'border-sky-400/40 bg-sky-400/10 text-sky-300',
            'active'    => 'border-pink-400/40 bg-pink-400/10 text-pink-300',
            'done'      => 'border-emerald-400/40 bg-emerald-400/10 text-emerald-300',
            'cancelled' => 'border-red-400/40 bg-red-400/10 text-red-300',
        ];
        $statusLabel = [
            'pending'   => 'Menunggu',
            'confirmed' => 'Dikonfirmasi',
            'active'    => 'Disewa',
            'done'      => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ];
    @endphp

    <section class="mx-auto max-w-7xl px-4 py-10">

        {{-- ============ HEADER ============ --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.35em] text-pink-300">Afrian JMK48 PlayStation</p>
                <h1 class="mt-1 text-3xl font-extrabold text-white">Dashboard Admin</h1>
                <p class="mt-1 text-sm text-slate-400">
                    Halo, {{ auth()->user()->name ?? 'Admin' }}. Ringkasan penyewaan hari ini.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ url('/') }}" target="_blank"
                   class="rounded-xl border border-pink-300/40 px-4 py-2 text-sm font-semibold text-pink-200 transition hover:bg-pink-300/10">
                    Lihat Website
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="rounded-xl bg-gradient-to-r from-pink-500 to-pink-600 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-pink-600/30 transition hover:from-pink-400 hover:to-pink-500">
                        Keluar
                    </button>
                </form>
            </div>
        </div>

        {{-- ============ KARTU STATISTIK ============ --}}
        <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-2xl border border-pink-300/15 bg-white/[0.04] p-5 backdrop-blur">
                <p class="text-sm text-slate-400">Total Pesanan</p>
                <p class="mt-2 text-4xl font-extrabold text-pink-300">{{ number_format($stats['total']) }}</p>
                <p class="mt-1 text-xs text-slate-500">Semua waktu</p>
            </div>

            <div class="rounded-2xl border border-amber-400/20 bg-white/[0.04] p-5 backdrop-blur">
                <p class="text-sm text-slate-400">Menunggu Konfirmasi</p>
                <p class="mt-2 text-4xl font-extrabold text-amber-300">{{ number_format($stats['pending']) }}</p>
                <p class="mt-1 text-xs text-slate-500">Perlu ditindaklanjuti</p>
            </div>

            <div class="rounded-2xl border border-pink-300/15 bg-white/[0.04] p-5 backdrop-blur">
                <p class="text-sm text-slate-400">Sedang Disewa</p>
                <p class="mt-2 text-4xl font-extrabold text-pink-400">{{ number_format($stats['active']) }}</p>
                <p class="mt-1 text-xs text-slate-500">Unit di luar</p>
            </div>

            <div class="rounded-2xl border border-emerald-400/20 bg-white/[0.04] p-5 backdrop-blur">
                <p class="text-sm text-slate-400">Pendapatan Bulan Ini</p>
                <p class="mt-2 text-3xl font-extrabold text-emerald-300">Rp {{ number_format($stats['revenue'], 0, ',', '.') }}</p>
                <p class="mt-1 text-xs text-slate-500">Pesanan selesai</p>
            </div>
        </div>

        <div class="mt-8 grid gap-6 lg:grid-cols-3">

            {{-- ============ PESANAN TERBARU ============ --}}
            <div class="rounded-2xl border border-pink-300/15 bg-white/[0.04] backdrop-blur lg:col-span-2">
                <div class="flex items-center justify-between border-b border-pink-300/10 px-5 py-4">
                    <h2 class="text-lg font-bold text-white">Pesanan Terbaru</h2>
                    @if (Route::has('admin.orders.index'))
                        <a href="{{ route('admin.orders.index') }}" class="text-sm font-semibold text-pink-300 hover:underline">Lihat semua →</a>
                    @endif
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[640px] text-left text-sm">
                        <thead class="text-xs uppercase tracking-wider text-slate-500">
                            <tr>
                                <th class="px-5 py-3 font-semibold">Penyewa</th>
                                <th class="px-5 py-3 font-semibold">Unit</th>
                                <th class="px-5 py-3 font-semibold">Tanggal</th>
                                <th class="px-5 py-3 font-semibold">Status</th>
                                <th class="px-5 py-3 text-right font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-pink-300/10">
                            @forelse ($orders as $order)
                                <tr class="transition hover:bg-pink-300/5">
                                    <td class="px-5 py-3.5">
                                        <p class="font-semibold text-slate-100">{{ $order->nama }}</p>
                                        <p class="text-xs text-slate-500">{{ $order->wa }}</p>
                                    </td>
                                    <td class="px-5 py-3.5 text-slate-300">{{ $order->unit }}</td>
                                    <td class="px-5 py-3.5 text-slate-300">
                                        {{ \Illuminate\Support\Carbon::parse($order->tanggal)->translatedFormat('d M Y') }}
                                        <span class="block text-xs text-slate-500">{{ $order->paket }}</span>
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <span class="inline-flex rounded-full border px-2.5 py-1 text-xs font-semibold {{ $statusStyle[$order->status] ?? 'border-slate-600 text-slate-300' }}">
                                            {{ $statusLabel[$order->status] ?? ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3.5 text-right">
                                        <div class="flex justify-end gap-2">
                                            <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/\D/', '', $order->wa)) }}" target="_blank"
                                               class="rounded-lg border border-pink-300/30 px-3 py-1.5 text-xs font-semibold text-pink-200 transition hover:bg-pink-300/10">
                                                WhatsApp
                                            </a>
                                            @if (Route::has('admin.orders.show'))
                                                <a href="{{ route('admin.orders.show', $order) }}"
                                                   class="rounded-lg bg-pink-500 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-pink-400">
                                                    Detail
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-5 py-12 text-center text-slate-500">
                                        <p class="text-3xl">🎮</p>
                                        <p class="mt-2">Belum ada pesanan masuk.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ============ STATUS UNIT ============ --}}
            <div class="rounded-2xl border border-pink-300/15 bg-white/[0.04] backdrop-blur">
                <div class="flex items-center justify-between border-b border-pink-300/10 px-5 py-4">
                    <h2 class="text-lg font-bold text-white">Status Unit</h2>
                    @if (Route::has('admin.units.index'))
                        <a href="{{ route('admin.units.index') }}" class="text-sm font-semibold text-pink-300 hover:underline">Kelola →</a>
                    @endif
                </div>

                <ul class="divide-y divide-pink-300/10">
                    @forelse ($units as $unit)
                        @php $available = ($unit->status ?? 'available') === 'available'; @endphp
                        <li class="flex items-center justify-between gap-3 px-5 py-3">
                            <div class="flex items-center gap-3">
                                <span class="h-3 w-3 rounded-full ring-1 ring-white/20"
                                      style="background: {{ $unit->warna ?? '#ff2d87' }}"></span>
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

        {{-- ============ AKSI CEPAT ============ --}}
        <div class="mt-8 grid gap-4 sm:grid-cols-3">
            @foreach ([
                ['route' => 'admin.orders.index', 'icon' => '📋', 'title' => 'Kelola Pesanan',  'desc' => 'Konfirmasi & update status'],
                ['route' => 'admin.units.index',  'icon' => '🎮', 'title' => 'Kelola Unit',     'desc' => 'Tambah & atur ketersediaan'],
                ['route' => 'admin.users.index',  'icon' => '👥', 'title' => 'Kelola Pengguna', 'desc' => 'Akun admin & pelanggan'],
            ] as $menu)
                @if (Route::has($menu['route']))
                    <a href="{{ route($menu['route']) }}"
                       class="group flex items-center gap-4 rounded-2xl border border-pink-300/15 bg-white/[0.04] p-5 transition hover:-translate-y-0.5 hover:border-pink-400/50 hover:bg-pink-500/10">
                        <span class="text-3xl">{{ $menu['icon'] }}</span>
                        <span>
                            <span class="block font-bold text-white group-hover:text-pink-200">{{ $menu['title'] }}</span>
                            <span class="block text-xs text-slate-400">{{ $menu['desc'] }}</span>
                        </span>
                    </a>
                @endif
            @endforeach
        </div>
    </section>
@endsection