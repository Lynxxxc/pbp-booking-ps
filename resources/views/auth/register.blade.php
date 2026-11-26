@extends('layouts.app')

@section('title', 'Daftar Akun - Save Point PlayStation')

@section('content')
<section class="mx-auto max-w-md px-4 py-12">
    <a href="{{ Route::has('landing') ? route('landing') : url('/') }}"
       data-goto
       class="mb-6 inline-flex items-center gap-2 text-sm text-white/75 transition hover:text-pink-300">
        <span>←</span> Kembali ke Beranda
    </a>

    <div class="rounded-3xl border border-pink-300/15 bg-[#1b0812]/80 p-8 shadow-2xl shadow-black/60 backdrop-blur-xl">
        <div class="text-center">
            <div class="font-display text-4xl font-bold uppercase tracking-wide text-pink-300">
                SAVE POINT
            </div>
            <div class="mt-0.5 text-[11px] font-semibold uppercase tracking-[0.45em] text-pink-100/85">
                PLAYSTATION
            </div>
            <p class="mt-4 text-sm text-white/75">
                Buat akun baru untuk mulai menyewa PS4 &amp; PS5
            </p>
        </div>

        @if (session('status'))
            <div class="mt-5 rounded-xl border border-pink-400/40 bg-pink-500/10 px-4 py-3 text-sm text-pink-200">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mt-5 rounded-xl border border-red-500/40 bg-red-500/10 px-4 py-3 text-sm text-red-300">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST"
              action="{{ Route::has('register') ? route('register') : url('/register') }}"
              class="mt-6 space-y-4"
              data-loading="MENDAFTARKAN AKUN...">
            @csrf

            <div>
                <label for="name" class="block text-sm font-semibold text-white">Nama Lengkap</label>
                <input id="name"
                       name="name"
                       type="text"
                       value="{{ old('name') }}"
                       required
                       autofocus
                       autocomplete="name"
                       placeholder="Masukkan nama lengkap"
                       class="mt-2 w-full rounded-xl border border-white/10 bg-[#26121c] px-4 py-3 text-sm text-white placeholder-white/35 transition focus:border-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-400/25">
            </div>

            <div>
                <label for="email" class="block text-sm font-semibold text-white">Email</label>
                <input id="email"
                       name="email"
                       type="email"
                       value="{{ old('email') }}"
                       required
                       autocomplete="email"
                       placeholder="Contoh: email@gmail.com"
                       class="mt-2 w-full rounded-xl border border-white/10 bg-[#26121c] px-4 py-3 text-sm text-white placeholder-white/35 transition focus:border-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-400/25">
            </div>

            <div>
                <label for="phone" class="block text-sm font-semibold text-white">Nomor HP / WhatsApp <span class="font-normal text-white/45">(opsional)</span></label>
                <input id="phone"
                       name="phone"
                       type="tel"
                       value="{{ old('phone') }}"
                       autocomplete="tel"
                       placeholder="Contoh: 0812xxxxxxx"
                       class="mt-2 w-full rounded-xl border border-white/10 bg-[#26121c] px-4 py-3 text-sm text-white placeholder-white/35 transition focus:border-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-400/25">
                <p class="mt-1 text-xs text-white/45">Dipakai untuk pemberitahuan status booking kamu.</p>
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-white">Password</label>
                <div class="relative mt-2">
                    <input id="password"
                           name="password"
                           type="password"
                           required
                           autocomplete="new-password"
                           placeholder="Minimal 8 karakter"
                           class="w-full rounded-xl border border-white/10 bg-[#26121c] py-3 pl-4 pr-16 text-sm text-white placeholder-white/35 transition focus:border-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-400/25">
                    <button type="button"
                            id="toggle-password"
                            class="absolute inset-y-0 right-4 text-xs font-semibold text-pink-300 transition hover:text-pink-200">
                        Lihat
                    </button>
                </div>
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-white">Konfirmasi Password</label>
                <div class="relative mt-2">
                    <input id="password_confirmation"
                           name="password_confirmation"
                           type="password"
                           required
                           autocomplete="new-password"
                           placeholder="Ulangi password"
                           class="w-full rounded-xl border border-white/10 bg-[#26121c] py-3 pl-4 pr-16 text-sm text-white placeholder-white/35 transition focus:border-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-400/25">
                    <button type="button"
                            id="toggle-password-confirm"
                            class="absolute inset-y-0 right-4 text-xs font-semibold text-pink-300 transition hover:text-pink-200">
                        Lihat
                    </button>
                </div>
            </div>

            <button type="submit"
                    class="mt-2 flex w-full items-center justify-center gap-2.5 rounded-xl bg-gradient-to-r from-[#ff2d87] to-[#e11d6a] px-5 py-3.5 text-base font-bold text-white shadow-[0_0_25px_rgba(255,45,135,0.45)] transition hover:-translate-y-0.5 hover:brightness-110 active:scale-[0.99]">
                Daftar Sekarang
            </button>
        </form>

        <p class="mt-6 text-center text-xs text-white/60">
            Sudah punya akun?
            <a href="{{ Route::has('login') ? route('login') : url('/login') }}"
               data-goto
               class="font-semibold text-pink-300 hover:underline">
                Masuk di sini
            </a>
        </p>
    </div>
</section>
@endsection

@push('scripts')
<script>
    (function () {
        const bindToggle = (inputId, buttonId) => {
            const input = document.getElementById(inputId);
            const btn = document.getElementById(buttonId);
            if (!input || !btn) return;
            btn.addEventListener('click', () => {
                const isHidden = input.type === 'password';
                input.type = isHidden ? 'text' : 'password';
                btn.textContent = isHidden ? 'Sembunyi' : 'Lihat';
            });
        };

        bindToggle('password', 'toggle-password');
        bindToggle('password_confirmation', 'toggle-password-confirm');

        document.querySelectorAll('[data-goto]').forEach((link) => {
            link.addEventListener('click', (e) => {
                if (typeof showLoader !== 'function') return;
                e.preventDefault();
                showLoader('MEMUAT...');
                setTimeout(() => {
                    window.location.href = link.href;
                }, 400);
            });
        });
    })();
</script>
@endpush