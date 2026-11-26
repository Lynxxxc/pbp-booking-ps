@extends('layouts.app')

@section('title', 'Kelola Booking')

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
            'pending'   => 'Menunggu',
            'confirmed' => 'Dikonfirmasi',
            'active'    => 'Sedang Main',
            'done'      => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ];
    @endphp

    <section class="mx-auto max-w-7xl px-4 py-10">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.35em] text-pink-300">Save Point PlayStation</p>
                <h1 class="mt-1 text-3xl font-extrabold text-white">Kelola Booking</h1>
                <p class="mt-1 text-sm text-slate-400">Konfirmasi, check-in, dan selesaikan penyewaan dari sini.</p>
            </div>
            <a href="{{ route('pegawai.walkin') }}"
               class="rounded-xl bg-gradient-to-r from-pink-500 to-pink-600 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-pink-600/30 transition hover:from-pink-400 hover:to-pink-500">
                + Booking Walk-in
            </a>
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

        <div class="mt-8 overflow-x-auto rounded-2xl border border-pink-300/15 bg-white/[0.04] backdrop-blur">
            <table class="w-full min-w-[860px] text-left text-sm">
                <thead class="text-xs uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-5 py-3 font-semibold">Penyewa</th>
                        <th class="px-5 py-3 font-semibold">Unit</th>
                        <th class="px-5 py-3 font-semibold">Jadwal</th>
                        <th class="px-5 py-3 font-semibold">Total</th>
                        <th class="px-5 py-3 font-semibold">Pembayaran</th>
                        <th class="px-5 py-3 font-semibold">Status</th>
                        <th class="px-5 py-3 text-right font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-pink-300/10">
                    @forelse ($bookings as $b)
                        @php
                            $penyewa = $users->get((string) $b->user_id);
                            $unit = $units->get((string) $b->ps_unit_id);
                            $pay = $payments->get((string) $b->_id);
                            $durasi = $b->start_time->diffInHours($b->end_time);
                        @endphp
                        <tr class="transition hover:bg-pink-300/5">
                            <td class="px-5 py-3.5">
                                <p class="font-semibold text-slate-100">{{ $penyewa->name ?? 'Pengguna' }}</p>
                                <p class="text-xs text-slate-500">{{ $penyewa->email ?? '' }}</p>
                            </td>
                            <td class="px-5 py-3.5 text-slate-300">{{ $unit->name ?? 'Unit' }}</td>
                            <td class="px-5 py-3.5 text-slate-300">
                                {{ $b->start_time->translatedFormat('d M Y') }}
                                <span class="block text-xs text-slate-500">{{ $b->start_time->format('H:i') }}–{{ $b->end_time->format('H:i') }} ({{ $durasi }} jam)</span>
                            </td>
                            <td class="px-5 py-3.5 font-semibold text-slate-100">Rp {{ number_format($b->total_price, 0, ',', '.') }}</td>
                            <td class="px-5 py-3.5 text-slate-300">
                                @if ($pay)
                                    {{ strtoupper($pay->method) }}
                                    <span class="block text-xs {{ $pay->status === 'paid' ? 'text-emerald-300' : 'text-amber-300' }}">{{ $pay->status === 'paid' ? 'Lunas' : 'Belum dibayar' }}</span>
                                @else
                                    <span class="text-slate-500">—</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="inline-flex rounded-full border px-2.5 py-1 text-xs font-semibold {{ $statusStyle[$b->status] ?? 'border-slate-600 text-slate-300' }}">
                                    {{ $statusLabel[$b->status] ?? ucfirst($b->status) }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5">
                                <div class="flex justify-end gap-2">
                                    @if ($b->status === 'pending')
                                        <form method="POST" action="{{ route('pegawai.booking.konfirmasi', $b) }}" data-confirm="Konfirmasi booking ini? Email pemberitahuan akan dikirim ke penyewa.">
                                            @csrf
                                            <button type="submit" class="rounded-lg bg-sky-500 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-sky-400">Konfirmasi</button>
                                        </form>
                                    @elseif ($b->status === 'confirmed')
                                        <form method="POST" action="{{ route('pegawai.booking.checkin', $b) }}"
                                              data-confirm="Check-in penyewa ini? Unit ditandai sedang dipakai.">
                                            @csrf
                                            <button type="submit" class="rounded-lg bg-pink-500 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-pink-400">Check-in</button>
                                        </form>
                                    @elseif ($b->status === 'active')
                                        <form method="POST" action="{{ route('pegawai.booking.selesai', $b) }}"
                                              data-confirm="Selesaikan penyewaan ini? Unit kembali tersedia dan poin diberikan.">
                                            @csrf
                                            <button type="submit" class="rounded-lg bg-emerald-500 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-emerald-400">Selesai</button>
                                        </form>
                                    @else
                                        <span class="text-xs text-slate-500">—</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center text-slate-500">
                                <p class="text-3xl">🎮</p>
                                <p class="mt-2">Belum ada booking masuk.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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
