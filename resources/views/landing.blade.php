<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Afrian JMK48 PlayStation - Rental PS4 &amp; PS5</title>

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Oswald:wght@500;600;700&display=swap" rel="stylesheet" />

  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <style>
    body { background: radial-gradient(ellipse at 50% 0%, #3a0a22 0%, #12040b 55%, #090208 100%); }
  </style>
</head>

<body class="min-h-screen font-sans text-white antialiased overflow-x-hidden">

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

  <div id="stars" class="pointer-events-none fixed inset-0 -z-0"></div>

  <header class="relative z-20">
    <nav class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-4 px-6 py-6 md:flex-row">

      <a href="{{ route('home') }}" class="text-center leading-tight md:text-left">
        <div class="font-display text-3xl font-bold uppercase tracking-wide text-pink-300">Afrian JMK48</div>
        <div class="text-[11px] font-semibold uppercase tracking-[0.45em] text-pink-100/90">PlayStation</div>
      </a>

      <ul class="flex flex-wrap items-center justify-center gap-x-7 gap-y-2 text-base font-medium">
        <li><a href="{{ route('home') }}" class="text-pink-300">Beranda</a></li>
        <li><a href="#tentang" class="text-white/90 transition hover:text-pink-300">Tentang</a></li>
        <li><a href="#paket" class="text-white/90 transition hover:text-pink-300">Paket</a></li>
        <li><a href="#cara-sewa" class="text-white/90 transition hover:text-pink-300">Cara Sewa</a></li>
        <li><a href="#paket" class="font-bold text-pink-400 transition hover:text-pink-300">Pesan Sekarang</a></li>
        <li>
          @auth
            <a href="{{ route(auth()->user()->role === 'admin' ? 'dashboard.admin' : (auth()->user()->role === 'pegawai' ? 'dashboard.pegawai' : 'dashboard.pengguna')) }}" data-goto
               class="font-semibold text-pink-200 underline-offset-4 transition hover:text-pink-300 hover:underline">Dashboard</a>
          @else
            <a href="{{ route('login') }}" data-goto
               class="font-semibold text-pink-200 underline-offset-4 transition hover:text-pink-300 hover:underline">Login</a>
          @endauth
        </li>
      </ul>
    </nav>
  </header>

  <main id="beranda" class="relative z-10 mx-auto flex max-w-5xl flex-col items-center px-6 pb-24 pt-10 text-center">

    <span class="inline-flex items-center gap-2 rounded-full border border-pink-300/30 bg-white/5 px-6 py-2.5 text-lg font-medium text-pink-200 backdrop-blur">
      <span></span> #1 Rental PlayStation Terpercaya
    </span>

    <h1 class="mt-10 font-display text-6xl font-bold uppercase leading-none tracking-wide sm:text-8xl lg:text-9xl">
      <span class="text-white">Rental</span>
      <span class="text-pink-300">PS4</span>
      <span class="text-white">&amp;</span>
      <span class="text-pink-500 drop-shadow-[0_0_25px_rgba(255,45,135,.55)]">PS5</span>
    </h1>

    <p class="mt-10 max-w-3xl text-xl leading-relaxed text-white/70 sm:text-2xl">
      Nikmati pengalaman gaming terbaik tanpa harus membeli. Koleksi game lengkap, kondisi prima, harga bersahabat.
    </p>

    <div class="mt-12 flex flex-col gap-4 sm:flex-row">
      <a href="#paket"
         class="flex items-center justify-center gap-3 rounded-xl bg-pink-500 px-10 py-5 text-xl font-bold shadow-xl shadow-pink-600/40 transition hover:-translate-y-0.5 hover:bg-pink-400">
        <svg class="h-7 w-7" viewBox="0 0 24 24" fill="currentColor"><path d="M6 8a5 5 0 00-5 5v1a4 4 0 004 4c1.3 0 2-.7 2.8-1.5.5-.5 1-.5 1.7-.5h5c.7 0 1.2 0 1.7.5.8.8 1.5 1.5 2.8 1.5a4 4 0 004-4v-1a5 5 0 00-5-5H6zm1 3h1.5v1.5H10V14H8.5v1.5H7V14H5.5v-1.5H7V11zm8.5.5a1 1 0 110 2 1 1 0 010-2zm2.5 1.5a1 1 0 110 2 1 1 0 010-2z"/></svg>
        Pesan Sekarang
      </a>
      <a href="#paket"
         class="flex items-center justify-center gap-3 rounded-xl border-2 border-pink-300/70 px-10 py-5 text-xl font-bold text-pink-200 transition hover:-translate-y-0.5 hover:bg-pink-300/10">
        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor"><path d="M2 4a2 2 0 012-2h7.2a2 2 0 011.4.6l8.8 8.8a2 2 0 010 2.8l-6.6 6.6a2 2 0 01-2.8 0L3.2 12.2A2 2 0 012 10.8V4zm5 1.5a1.5 1.5 0 100 3 1.5 1.5 0 000-3z"/></svg>
        Lihat Paket
      </a>
    </div>

    <div class="mt-20 grid w-full max-w-3xl grid-cols-3 gap-6">
      <div>
        <div class="font-display text-6xl font-bold text-pink-300 sm:text-7xl">500</div>
        <div class="text-2xl text-white">+</div>
        <div class="mt-1 text-lg text-white/60">Pelanggan Puas</div>
      </div>
      <div>
        <div class="font-display text-6xl font-bold text-pink-300 sm:text-7xl">50</div>
        <div class="text-2xl text-white">+</div>
        <div class="mt-1 text-lg text-white/60">Game Tersedia</div>
      </div>
      <div>
        <div class="font-display text-6xl font-bold text-pink-300 sm:text-7xl">5</div>
        <div class="text-2xl text-white">★</div>
        <div class="mt-1 text-lg text-white/60">Rating</div>
      </div>
    </div>
  </main>

  <section id="tentang" class="relative z-10 mx-auto max-w-5xl px-6 py-16">
    <h2 class="text-center font-display text-4xl font-bold uppercase tracking-wide text-white sm:text-5xl">
      Tentang <span class="text-pink-400">Kami</span>
    </h2>
    <p class="mx-auto mt-6 max-w-3xl text-center text-lg leading-relaxed text-white/70">
      Afrian JMK48 PlayStation adalah layanan rental PlayStation per jam. Kamu bisa memainkan PS4 dan PS5
      tanpa harus membeli konsolnya — cukup pilih unit yang tersedia, tentukan jadwal, dan datang untuk bermain.
      Koleksi game lengkap, kondisi unit prima, dan harga bersahabat per jamnya.
    </p>
  </section>

  <section id="paket" class="relative z-10 mx-auto max-w-7xl px-6 py-16">
    <h2 class="text-center font-display text-4xl font-bold uppercase tracking-wide text-white sm:text-5xl">
      Pilih <span class="text-pink-400">Unit</span> Kamu
    </h2>
    <p class="mx-auto mt-4 max-w-2xl text-center text-white/60">
      Daftar unit di bawah ini tampil langsung dari data rental kami. Pilih unit yang tersedia, lalu pesan.
    </p>

    <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
      @forelse ($units as $unit)
        <div class="flex flex-col rounded-3xl border border-pink-300/15 bg-white/[0.04] p-6 shadow-2xl shadow-black/40 backdrop-blur-xl">
          <div class="flex items-center justify-between gap-2">
            <span class="rounded-full bg-pink-500/15 px-3 py-1 text-xs font-bold uppercase tracking-wider text-pink-300">{{ $unit->type }}</span>
            @if ($unit->status === 'available')
              <span class="rounded-full bg-emerald-500/15 px-3 py-1 text-xs font-bold text-emerald-300">Tersedia</span>
            @else
              <span class="rounded-full bg-rose-500/15 px-3 py-1 text-xs font-bold text-rose-300">Sedang Dipakai</span>
            @endif
          </div>

          <h3 class="mt-4 font-display text-2xl font-semibold uppercase tracking-wide text-white">{{ $unit->name }}</h3>
          <p class="mt-2 flex-1 text-sm leading-relaxed text-white/60">{{ $unit->description }}</p>

          <div class="mt-5 font-display text-3xl font-bold text-pink-300">
            Rp{{ number_format($unit->price_per_hour, 0, ',', '.') }}<span class="text-sm font-medium normal-case text-white/50">/jam</span>
          </div>

          @if ($unit->status === 'available')
            @guest
              <a href="{{ route('login') }}" data-goto
                 class="mt-5 flex w-full items-center justify-center rounded-xl bg-gradient-to-r from-[#ff2d87] to-[#e11d6a] px-5 py-3 font-bold text-white shadow-[0_0_25px_rgba(255,45,135,0.35)] transition hover:-translate-y-0.5 hover:brightness-110 active:scale-[0.99]">
                Pesan Unit Ini
              </a>
            @else
              <a href="{{ route(auth()->user()->role === 'admin' ? 'dashboard.admin' : (auth()->user()->role === 'pegawai' ? 'dashboard.pegawai' : 'dashboard.pengguna')) }}"
                 class="mt-5 flex w-full items-center justify-center rounded-xl bg-gradient-to-r from-[#ff2d87] to-[#e11d6a] px-5 py-3 font-bold text-white shadow-[0_0_25px_rgba(255,45,135,0.35)] transition hover:-translate-y-0.5 hover:brightness-110 active:scale-[0.99]">
                Pesan Unit Ini
              </a>
            @endguest
          @else
            <button type="button" disabled
                    class="mt-5 w-full cursor-not-allowed rounded-xl border border-white/10 bg-white/5 px-5 py-3 font-bold text-white/40">
              Tidak Tersedia
            </button>
          @endif
        </div>
      @empty
        <p class="col-span-full text-center text-white/60">Belum ada unit yang terdaftar saat ini.</p>
      @endforelse
    </div>
  </section>

  <section id="cara-sewa" class="relative z-10 mx-auto max-w-7xl px-6 py-16">
    <h2 class="text-center font-display text-4xl font-bold uppercase tracking-wide text-white sm:text-5xl">
      Cara <span class="text-pink-400">Sewa</span>
    </h2>

    <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
      <div class="rounded-3xl border border-pink-300/15 bg-white/[0.04] p-6 text-center backdrop-blur-xl">
        <div class="font-display text-5xl font-bold text-pink-500">1</div>
        <h3 class="mt-3 font-display text-xl font-semibold uppercase tracking-wide text-white">Pilih Unit</h3>
        <p class="mt-2 text-sm leading-relaxed text-white/60">Lihat katalog unit di atas, pilih PS4 atau PS5 yang statusnya tersedia.</p>
      </div>
      <div class="rounded-3xl border border-pink-300/15 bg-white/[0.04] p-6 text-center backdrop-blur-xl">
        <div class="font-display text-5xl font-bold text-pink-500">2</div>
        <h3 class="mt-3 font-display text-xl font-semibold uppercase tracking-wide text-white">Tentukan Jadwal</h3>
        <p class="mt-2 text-sm leading-relaxed text-white/60">Tentukan tanggal, jam mulai, dan durasi sewa sesuai kebutuhanmu.</p>
      </div>
      <div class="rounded-3xl border border-pink-300/15 bg-white/[0.04] p-6 text-center backdrop-blur-xl">
        <div class="font-display text-5xl font-bold text-pink-500">3</div>
        <h3 class="mt-3 font-display text-xl font-semibold uppercase tracking-wide text-white">Lakukan Pembayaran</h3>
        <p class="mt-2 text-sm leading-relaxed text-white/60">Bayar dengan tunai, QRIS, atau e-wallet sesuai total harga sewamu.</p>
      </div>
      <div class="rounded-3xl border border-pink-300/15 bg-white/[0.04] p-6 text-center backdrop-blur-xl">
        <div class="font-display text-5xl font-bold text-pink-500">4</div>
        <h3 class="mt-3 font-display text-xl font-semibold uppercase tracking-wide text-white">Datang &amp; Main</h3>
        <p class="mt-2 text-sm leading-relaxed text-white/60">Datang sesuai jadwal yang dipesan — unitmu sudah siap dimainkan.</p>
      </div>
    </div>
  </section>

  <footer class="relative z-10 border-t border-pink-300/10 py-8 text-center">
    <div class="font-display text-xl font-bold uppercase tracking-wide text-pink-300">Afrian JMK48</div>
    <div class="text-[10px] font-semibold uppercase tracking-[0.45em] text-pink-100/70">PlayStation</div>
    <p class="mt-3 text-sm text-white/40">© 2026 Afrian JMK48 PlayStation — Rental PS4 &amp; PS5 per jam.</p>
  </footer>

  <script>
    (function () {
      const wrap = document.getElementById('stars');
      for (let i = 0; i < 70; i++) {
        const s = document.createElement('span');
        const size = Math.random() * 3 + 1;
        s.className = 'absolute rounded-full bg-pink-300 animate-twinkle';
        s.style.cssText = `width:${size}px;height:${size}px;left:${Math.random()*100}%;top:${Math.random()*100}%;animation-delay:${Math.random()*3}s;animation-duration:${2 + Math.random()*3}s`;
        wrap.appendChild(s);
      }
    })();

    const loader = document.getElementById('loader');
    const loaderText = document.getElementById('loader-text');
    const hideLoader = () => {
      loader.classList.add('opacity-0', 'pointer-events-none');
      setTimeout(() => loader.classList.add('hidden'), 500);
    };
    const showLoader = (t = 'MEMUAT...') => {
      loaderText.textContent = t;
      loader.classList.remove('hidden');
      requestAnimationFrame(() => loader.classList.remove('opacity-0', 'pointer-events-none'));
    };
    window.showLoader = showLoader;
    const t0 = performance.now();
    window.addEventListener('load', () => {
      setTimeout(hideLoader, Math.max(0, 1200 - (performance.now() - t0)));
    });
    window.addEventListener('pageshow', (e) => { if (e.persisted) hideLoader(); });

    document.querySelectorAll('[data-goto]').forEach((a) => {
      a.addEventListener('click', (e) => {
        e.preventDefault();
        showLoader('MEMUAT...');
        setTimeout(() => (window.location.href = a.href), 600);
      });
    });
  </script>
</body>
</html>
