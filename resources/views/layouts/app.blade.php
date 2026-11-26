<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Save Point PlayStation')</title>

    <script>
        // Terapkan tema tersimpan sebelum halaman digambar (biar tidak kedip)
        try {
            var savedTheme = localStorage.getItem('afrian-jmk48-theme');
            if (savedTheme) document.documentElement.setAttribute('data-theme', savedTheme);
        } catch (e) {}
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Oswald:wght@500;600;700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { background: radial-gradient(ellipse at 50% 0%, var(--bg-glow, #3a0a22) 0%, #12040b 55%, #090208 100%); }
    </style>
</head>
<body class="flex min-h-screen flex-col overflow-x-hidden font-sans text-white antialiased">

    <div id="loader" class="fixed inset-0 z-[100] flex flex-col items-center justify-center bg-night transition-opacity duration-500">
        <div class="relative h-24 w-24">
            <div class="absolute inset-0 rounded-full border-4 border-pink-300/15"></div>
            <div class="absolute inset-0 animate-spin rounded-full border-4 border-transparent border-t-pink-400 border-r-pink-500"></div>
            <div class="absolute inset-0 flex items-center justify-center text-3xl animate-floaty">🎮</div>
        </div>
        <p id="loader-text" class="mt-6 font-display text-xl tracking-[0.3em] text-pink-200">MEMUAT...</p>
        <div class="mt-4 flex gap-2">
            <span class="h-3 w-3 rounded-full bg-pink-400 animate-bounceDot [animation-delay:-0.32s]"></span>
            <span class="h-3 w-3 rounded-full bg-pink-400 animate-bounceDot [animation-delay:-0.16s]"></span>
            <span class="h-3 w-3 rounded-full bg-pink-400 animate-bounceDot"></span>
        </div>
    </div>

    {{-- Popup konfirmasi kustom --}}
    <div id="confirm-modal" class="fixed inset-0 z-[110] hidden bg-black/70 opacity-0 backdrop-blur-sm transition-opacity duration-200">
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="w-full max-w-sm rounded-3xl border border-pink-300/25 bg-[#170b28] p-6 shadow-[0_0_60px_rgba(255,45,135,0.25)]">
                <p class="font-display text-lg font-bold tracking-wide text-pink-200">KONFIRMASI</p>
                <p id="confirm-text" class="mt-3 text-sm leading-relaxed text-white/80"></p>
                <div class="mt-6 flex gap-3">
                    <button id="confirm-no" type="button" class="flex-1 rounded-xl border border-white/20 px-4 py-2.5 text-sm font-semibold text-white/80 transition hover:bg-white/10">Batal</button>
                    <button id="confirm-yes" type="button" class="flex-1 rounded-xl bg-pink-500 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-pink-400">Ya, Lanjutkan</button>
                </div>
            </div>
        </div>
    </div>

    <div id="stars" class="pointer-events-none fixed inset-0 z-0"></div>

    <header class="relative z-20 border-b border-pink-300/10 bg-black/20 backdrop-blur">
        <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-3 px-4 py-4">
            <a href="{{ route('home') }}" data-goto class="leading-tight">
                <div class="font-display text-2xl font-bold uppercase tracking-wide text-pink-300">Save Point</div>
                <div class="text-[10px] font-semibold uppercase tracking-[0.45em] text-pink-100/90">PlayStation</div>
            </a>
            <nav class="flex items-center gap-3 text-sm">
                <a href="{{ route('home') }}" data-goto class="text-white/85 transition hover:text-pink-300">Beranda</a>
                @auth
                    @if (auth()->user()->role === 'admin')
                        <a href="{{ route('dashboard.admin') }}" class="text-white/85 transition hover:text-pink-300">Dashboard</a>
                        <a href="{{ route('pegawai.booking') }}" class="text-white/85 transition hover:text-pink-300">Kelola Booking</a>
                    @elseif (auth()->user()->role === 'pegawai')
                        <a href="{{ route('dashboard.pegawai') }}" class="text-white/85 transition hover:text-pink-300">Dashboard</a>
                        <a href="{{ route('pegawai.booking') }}" class="text-white/85 transition hover:text-pink-300">Kelola Booking</a>
                    @else
                        <a href="{{ route('dashboard.pengguna') }}" class="text-white/85 transition hover:text-pink-300">Dashboard</a>
                        <a href="{{ route('booking.saya') }}" class="text-white/85 transition hover:text-pink-300">Booking Saya</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" data-loading="SAMPAI JUMPA..." class="inline">
                        @csrf
                        <button type="submit" class="rounded-xl bg-gradient-to-r from-pink-500 to-pink-600 px-4 py-2 font-semibold text-white shadow-lg shadow-pink-600/30 transition hover:from-pink-400 hover:to-pink-500">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" data-goto class="text-white/85 transition hover:text-pink-300">Masuk</a>
                    <a href="{{ route('register') }}" data-goto class="rounded-xl bg-gradient-to-r from-pink-500 to-pink-600 px-4 py-2 font-semibold text-white shadow-lg shadow-pink-600/30 transition hover:from-pink-400 hover:to-pink-500">Daftar</a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="relative z-10 flex-1">
        @yield('content')
    </main>

    <footer class="relative z-10 border-t border-pink-300/10 py-6 text-center text-sm text-white/45">
        © 2026 Save Point PlayStation — Rental PS4 &amp; PS5 per jam.
    </footer>

    <script>
        // Bintang latar (sama seperti landing)
        (function () {
            const wrap = document.getElementById('stars');
            if (!wrap) return;
            for (let i = 0; i < 60; i++) {
                const s = document.createElement('span');
                const size = Math.random() * 3 + 1;
                s.className = 'absolute rounded-full bg-pink-300 animate-twinkle';
                s.style.cssText = `width:${size}px;height:${size}px;left:${Math.random()*100}%;top:${Math.random()*100}%;animation-delay:${Math.random()*3}s;animation-duration:${2 + Math.random()*3}s`;
                wrap.appendChild(s);
            }
        })();

        const loader = document.getElementById('loader');
        const loaderText = document.getElementById('loader-text');
        // Splash loader hanya tampil di kunjungan pertama per sesi; kunjungan
        // berikutnya (termasuk auto-refresh) langsung tampil tanpa loader.
        const splashSeen = sessionStorage.getItem('spp-splash') === '1';
        if (splashSeen) loader.classList.add('hidden');
        const hideLoader = () => {
            loader.classList.add('opacity-0', 'pointer-events-none');
            setTimeout(() => loader.classList.add('hidden'), 500);
        };
        const showLoader = (t = 'MEMUAT...') => {
            if (splashSeen) return;
            loaderText.textContent = t;
            loader.classList.remove('hidden');
            requestAnimationFrame(() => loader.classList.remove('opacity-0', 'pointer-events-none'));
        };
        window.showLoader = showLoader;
        const t0 = performance.now();
        window.addEventListener('load', () => {
            if (splashSeen) return;
            setTimeout(() => { hideLoader(); sessionStorage.setItem('spp-splash', '1'); }, Math.max(0, 700 - (performance.now() - t0)));
        });
        window.addEventListener('pageshow', (e) => { if (e.persisted) hideLoader(); });

        document.querySelectorAll('[data-goto]').forEach((a) => {
            a.addEventListener('click', (e) => {
                e.preventDefault();
                showLoader('MEMUAT...');
                setTimeout(() => (window.location.href = a.href), splashSeen ? 0 : 600);
            });
        });
        // Submit form: status proses tampil di tombolnya saja, bukan overlay layar penuh.
        document.querySelectorAll('form[data-loading]').forEach((f) => {
            f.addEventListener('submit', () => {
                if (f.hasAttribute('data-confirm') && f.dataset.confirmed !== '1') return;
                const btn = f.querySelector('button[type="submit"], input[type="submit"]');
                if (!btn || btn.disabled) return;
                btn.disabled = true;
                btn.innerHTML = '<span class="mr-2 inline-block h-3.5 w-3.5 animate-spin rounded-full border-2 border-white/40 border-t-white align-[-2px]"></span>' + (f.getAttribute('data-loading') || 'MEMUAT...');
            });
        });

        // Popup konfirmasi kustom untuk form ber-atribut data-confirm.
        const confirmModal = document.getElementById('confirm-modal');
        const confirmText = document.getElementById('confirm-text');
        let confirmTarget = null;
        const openConfirm = (msg) => {
            confirmText.textContent = msg;
            confirmModal.classList.remove('hidden');
            requestAnimationFrame(() => confirmModal.classList.remove('opacity-0'));
        };
        const closeConfirm = () => {
            confirmModal.classList.add('opacity-0');
            setTimeout(() => confirmModal.classList.add('hidden'), 200);
            confirmTarget = null;
        };
        document.querySelectorAll('form[data-confirm]').forEach((f) => {
            f.addEventListener('submit', (e) => {
                if (f.dataset.confirmed === '1') return;
                e.preventDefault();
                confirmTarget = f;
                openConfirm(f.getAttribute('data-confirm'));
            });
        });
        document.getElementById('confirm-yes').addEventListener('click', () => {
            if (!confirmTarget) return;
            const f = confirmTarget;
            f.dataset.confirmed = '1';
            closeConfirm();
            f.requestSubmit();
        });
        document.getElementById('confirm-no').addEventListener('click', closeConfirm);
        confirmModal.addEventListener('click', (e) => { if (e.target === confirmModal) closeConfirm(); });
    </script>
    @stack('scripts')
</body>
</html>
