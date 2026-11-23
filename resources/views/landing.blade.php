<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Laravel: <meta name="csrf-token" content="{{ csrf_token() }}"> -->
  <title>Afrian JMK48 PlayStation - Rental PS4 &amp; PS5</title>

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Oswald:wght@500;600;700&display=swap" rel="stylesheet" />

  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: { display: ['Oswald', 'sans-serif'], sans: ['Inter', 'sans-serif'] },
          colors: {
            pink: {
              50: '#fff1f7', 100: '#ffe4ef', 200: '#ffc9df', 300: '#ffa3c8',
              400: '#ff66a1', 500: '#ff2d87', 600: '#e11d6a', 700: '#be1257',
              800: '#9d1349', 900: '#831541', 950: '#2a0614'
            },
            night: '#12040b'
          },
          keyframes: {
            bounceDot: { '0%,80%,100%': { transform: 'scale(0.6)', opacity: '.5' }, '40%': { transform: 'scale(1)', opacity: '1' } },
            floaty: { '0%,100%': { transform: 'translateY(0)' }, '50%': { transform: 'translateY(-8px)' } },
            twinkle: { '0%,100%': { opacity: '.2' }, '50%': { opacity: '1' } }
          },
          animation: {
            bounceDot: 'bounceDot 1.2s infinite ease-in-out both',
            floaty: 'floaty 2.4s ease-in-out infinite',
            twinkle: 'twinkle 3s ease-in-out infinite'
          }
        }
      }
    }
  </script>
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

      <a href="#beranda" class="text-center leading-tight md:text-left">
        <div class="font-display text-3xl font-bold uppercase tracking-wide text-pink-300">Afrian JMK48</div>
        <div class="text-[11px] font-semibold uppercase tracking-[0.45em] text-pink-100/90">PlayStation</div>
      </a>

      <ul class="flex flex-wrap items-center justify-center gap-x-7 gap-y-2 text-base font-medium">
        <li><a href="#beranda" class="text-pink-300">Beranda</a></li>
        <li><a href="#tentang" class="text-white/90 transition hover:text-pink-300">Tentang</a></li>
        <li><a href="#paket" class="text-white/90 transition hover:text-pink-300">Paket</a></li>
        <li><a href="#cara-sewa" class="text-white/90 transition hover:text-pink-300">Cara Sewa</a></li>
        <li><a href="pemesanan.html" data-goto class="font-bold text-pink-400 transition hover:text-pink-300">Pesan Sekarang</a></li>
        <li>
          <a href="login.html" data-goto
             class="font-semibold text-pink-200 underline-offset-4 transition hover:text-pink-300 hover:underline">Login</a>
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
      <a href="pemesanan.html" data-goto
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

  <section id="tentang"></section>
  <section id="paket"></section>
  <section id="cara-sewa"></section>

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