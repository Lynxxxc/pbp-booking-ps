@extends('layouts.app')

@section('title', 'Daftar')

@section('content')
    <section class="mx-auto max-w-md px-4 py-16">
        <h1 class="text-2xl font-bold">Daftar Akun</h1>
        <p class="mt-1 text-sm text-slate-400">Akun baru otomatis berperan sebagai pengguna.</p>

        @if ($errors->any())
            <div class="mt-5 rounded-xl border border-red-500/40 bg-red-500/10 px-4 py-3 text-sm text-red-300">
                <ul class="list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-4">
            @csrf
            <div>
                <label for="name" class="text-sm font-medium text-slate-300">Nama</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                       class="mt-1 w-full rounded-xl border border-slate-700 bg-slate-900 px-4 py-2.5 text-slate-100 focus:border-violet-500 focus:outline-none">
            </div>
            <div>
                <label for="email" class="text-sm font-medium text-slate-300">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required
                       class="mt-1 w-full rounded-xl border border-slate-700 bg-slate-900 px-4 py-2.5 text-slate-100 focus:border-violet-500 focus:outline-none">
            </div>
            <div>
                <label for="password" class="text-sm font-medium text-slate-300">Password</label>
                <input id="password" name="password" type="password" required
                       class="mt-1 w-full rounded-xl border border-slate-700 bg-slate-900 px-4 py-2.5 text-slate-100 focus:border-violet-500 focus:outline-none">
                <p class="mt-1 text-xs text-slate-500">Minimal 8 karakter.</p>
            </div>
            <div>
                <label for="password_confirmation" class="text-sm font-medium text-slate-300">Ulangi Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required
                       class="mt-1 w-full rounded-xl border border-slate-700 bg-slate-900 px-4 py-2.5 text-slate-100 focus:border-violet-500 focus:outline-none">
            </div>
            <button type="submit" class="w-full rounded-xl bg-violet-600 px-4 py-2.5 font-semibold text-white hover:bg-violet-500">Daftar</button>
        </form>

        <p class="mt-5 text-sm text-slate-400">Sudah punya akun? <a href="{{ route('login') }}" class="text-violet-300 hover:underline">Masuk di sini</a></p>
    </section>
@endsection
