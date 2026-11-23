<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'RentalPS') — Booking PlayStation per Jam</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen flex flex-col">
    <header class="border-b border-slate-800 bg-slate-900/70">
        <div class="mx-auto max-w-6xl px-4 py-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-xl font-bold tracking-tight text-violet-400">RentalPS</a>
            <nav class="flex items-center gap-3 text-sm">
                <a href="{{ route('home') }}" class="text-slate-300 hover:text-white">Beranda</a>
                @auth
                    @if (auth()->user()->role === 'admin')
                        <a href="{{ route('dashboard.admin') }}" class="text-slate-300 hover:text-white">Dashboard Admin</a>
                    @elseif (auth()->user()->role === 'pegawai')
                        <a href="{{ route('dashboard.pegawai') }}" class="text-slate-300 hover:text-white">Dashboard Pegawai</a>
                    @else
                        <a href="{{ route('dashboard.pengguna') }}" class="text-slate-300 hover:text-white">Dashboard Saya</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="rounded-lg bg-slate-800 px-3 py-1.5 text-slate-200 hover:bg-slate-700">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-slate-300 hover:text-white">Masuk</a>
                    <a href="{{ route('register') }}" class="rounded-lg bg-violet-600 px-3 py-1.5 font-medium text-white hover:bg-violet-500">Daftar</a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="flex-1">
        @yield('content')
    </main>

    <footer class="border-t border-slate-800 py-6 text-center text-sm text-slate-500">
        RentalPS — proyek akhir Pemrograman Berbasis Platform. Nama rental masih sementara.
    </footer>
</body>
</html>
