@extends('layouts.app')

@section('title', 'Login - Save Point PlayStation')

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
                Masuk untuk mulai menyewa PS4 &amp; PS5
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
              action="{{ Route::has('login.guest') ? route('login.guest') : url('/login/guest') }}"
              class="mt-6"
              data-loading="MASUK SEBAGAI TAMU...">
            @csrf
            <button type="submit"
                    class="flex w-full items-center justify-center gap-2.5 rounded-xl bg-gradient-to-r from-[#ff2d87] to-[#e11d6a] px-5 py-3.5 text-base font-bold text-white shadow-[0_0_25px_rgba(255,45,135,0.45)] transition hover:-translate-y-0.5 hover:brightness-110 active:scale-[0.99]">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Masuk sebagai Tamu
            </button>
        </form>

        <div class="my-6 flex items-center gap-3 text-xs text-white/45">
            <span class="h-px flex-1 bg-white/10"></span>
            <span>atau login dengan akun</span>
            <span class="h-px flex-1 bg-white/10"></span>
        </div>

        <form method="POST"
              action="{{ Route::has('login') ? route('login') : url('/login') }}"
              class="space-y-4"
              data-loading="MEMVERIFIKASI AKUN...">
            @csrf

            <div>
                <label for="email" class="block text-sm font-semibold text-white">Email</label>
                <input id="email"
                       name="email"
                       type="email"
                       value="{{ old('email') }}"
                       required
                       autofocus
                       autocomplete="email"
                       placeholder="Contoh: email@gmail.com"
                       class="mt-2 w-full rounded-xl border border-white/10 bg-[#26121c] px-4 py-3 text-sm text-white placeholder-white/35 transition focus:border-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-400/25">
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-white">Password</label>
                <div class="relative mt-2">
                    <input id="password"
                           name="password"
                           type="password"
                           required
                           autocomplete="current-password"
                           placeholder="Masukkan password"
                           class="w-full rounded-xl border border-white/10 bg-[#26121c] py-3 pl-4 pr-16 text-sm text-white placeholder-white/35 transition focus:border-pink-400 focus:outline-none focus:ring-2 focus:ring-pink-400/25">
                    <button type="button"
                            id="toggle-password"
                            class="absolute inset-y-0 right-4 text-xs font-semibold text-pink-300 transition hover:text-pink-200">
                        Lihat
                    </button>
                </div>
            </div>

            <button type="submit"
                    class="mt-2 w-full rounded-xl border border-pink-400/50 bg-[#1c0a13] px-5 py-3.5 text-base font-bold text-white transition hover:border-pink-300 hover:bg-pink-500/10 active:scale-[0.99]">
                Login
            </button>
        </form>

        @if (Route::has('register'))
            <p class="mt-4 text-center text-xs text-white/60">
                Belum punya akun?
                <a href="{{ route('register') }}" data-goto class="font-semibold text-pink-300 hover:underline">
                    Daftar di sini
                </a>
            </p>
        @endif

        <p class="mt-4 text-center text-xs text-white/45">
            Akun tamu bersifat sementara &amp; bisa diupgrade kapan saja.
        </p>
    </div>
</section>
@endsection

@push('scripts')
<script>
    (function () {
        const pass = document.getElementById('password');
        const toggle = document.getElementById('toggle-password');
        if (pass && toggle) {
            toggle.addEventListener('click', () => {
                const isHidden = pass.type === 'password';
                pass.type = isHidden ? 'text' : 'password';
                toggle.textContent = isHidden ? 'Sembunyi' : 'Lihat';
            });
        }

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