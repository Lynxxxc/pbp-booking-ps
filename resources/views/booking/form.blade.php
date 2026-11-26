@extends('layouts.app')

@section('title', 'Booking ' . $unit->name)

@section('content')
<section class="mx-auto max-w-2xl px-4 py-12">
    <a href="{{ route('home') }}#paket" data-goto
       class="mb-6 inline-flex items-center gap-2 text-sm text-white/75 transition hover:text-pink-300">
        <span>←</span> Kembali ke Katalog
    </a>

    <div class="rounded-3xl border border-pink-300/15 bg-[#1b0812]/80 p-8 shadow-2xl shadow-black/60 backdrop-blur-xl">
        <div class="flex flex-wrap items-start justify-between gap-3">
            <div>
                <h1 class="font-display text-3xl font-bold uppercase tracking-wide text-pink-300">{{ $unit->name }}</h1>
                <p class="mt-1 text-sm text-white/70">{{ $unit->type }} &middot; {{ $unit->description }}</p>
            </div>
            <div class="text-right">
                <p class="text-2xl font-extrabold text-white">Rp {{ number_format($unit->price_per_hour, 0, ',', '.') }}</p>
                <p class="text-xs text-white/50">per jam</p>
            </div>
        </div>

        @if ($errors->any())
            <div class="mt-5 rounded-xl border border-red-500/40 bg-red-500/10 px-4 py-3 text-sm text-red-300">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('booking.store', $unit) }}" class="mt-6 space-y-4" data-loading="MEMBUAT BOOKING...">
            @csrf

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

            <div>
                <label for="durasi" class="block text-sm font-semibold text-white">Durasi</label>
                <select id="durasi" name="durasi" required
                        class="mt-2 w-full rounded-xl border border-white/10 bg-[#26121c] px-4 py-3 text-sm text-white transition focus:border-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-400/25">
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" @selected((int) old('durasi', 2) === $i)>{{ $i }} jam</option>
                    @endfor
                </select>
            </div>

            <div>
                <label for="phone" class="block text-sm font-semibold text-white">Nomor HP / WhatsApp <span class="font-normal text-white/45">(opsional)</span></label>
                <input id="phone" name="phone" type="tel"
                       value="{{ old('phone', auth()->user()->phone ?? '') }}"
                       placeholder="Contoh: 0812xxxxxxx"
                       class="mt-2 w-full rounded-xl border border-white/10 bg-[#26121c] px-4 py-3 text-sm text-white transition focus:border-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-400/25">
                <p class="mt-1 text-xs text-white/45">Untuk pemberitahuan status booking. Nomor ini tersimpan di profilmu untuk booking berikutnya.</p>
            </div>

            <div>
                <label for="metode" class="block text-sm font-semibold text-white">Metode Pembayaran</label>
                <select id="metode" name="metode" required
                        class="mt-2 w-full rounded-xl border border-white/10 bg-[#26121c] px-4 py-3 text-sm text-white transition focus:border-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-400/25">
                    <option value="cash" @selected(old('metode') === 'cash')>Tunai di tempat</option>
                    <option value="qris" @selected(old('metode') === 'qris')>QRIS</option>
                    <option value="e-wallet" @selected(old('metode') === 'e-wallet')>E-Wallet</option>
                </select>
                <p class="mt-1 text-xs text-white/45">Pembayaran dicatat sebagai menunggu; pegawai menandai lunas setelah kamu membayar.</p>
            </div>

            <div class="flex items-center justify-between rounded-xl border border-pink-300/15 bg-white/[0.04] px-4 py-3">
                <span class="text-sm text-white/70">Total bayar</span>
                <span id="total" class="text-xl font-extrabold text-pink-300">Rp {{ number_format($unit->price_per_hour * 2, 0, ',', '.') }}</span>
            </div>

            <button type="submit"
                    class="flex w-full items-center justify-center gap-2.5 rounded-xl bg-gradient-to-r from-[#ff2d87] to-[#e11d6a] px-5 py-3.5 text-base font-bold text-white shadow-[0_0_25px_rgba(255,45,135,0.45)] transition hover:-translate-y-0.5 hover:brightness-110 active:scale-[0.99]">
                Buat Booking
            </button>
        </form>
    </div>
</section>
@endsection

@push('scripts')
<script>
    (function () {
        const harga = {{ (int) $unit->price_per_hour }};
        const durasi = document.getElementById('durasi');
        const total = document.getElementById('total');
        const update = () => {
            const rp = harga * parseInt(durasi.value || '0', 10);
            total.textContent = 'Rp ' + rp.toLocaleString('id-ID');
        };
        durasi.addEventListener('change', update);
        update();
    })();
</script>
@endpush
