@extends('layouts.app')

@section('title', 'Masuk')

@section('content')
    <section class="mx-auto max-w-md px-4 py-16">
        <h1 class="text-2xl font-bold">Masuk</h1>
        <p class="mt-1 text-sm text-slate-400">Gunakan akun yang sudah terdaftar.</p>

        @if ($errors->any())
            <div class="mt-5 rounded-xl border border-red-500/40 bg-red-500/10 px-4 py-3 text-sm text-red-300">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-4">
            @csrf
            <div>
                <label for="email" class="text-sm font-medium text-slate-300">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                       class="mt-1 w-full rounded-xl border border-slate-700 bg-slate-900 px-4 py-2.5 text-slate-100 focus:border-violet-500 focus:outline-none">
            </div>
            <div>
                <label for="password" class="text-sm font-medium text-slate-300">Password</label>
                <input id="password" name="password" type="password" required
                       class="mt-1 w-full rounded-xl border border-slate-700 bg-slate-900 px-4 py-2.5 text-slate-100 focus:border-violet-500 focus:outline-none">
            </div>
            <label class="flex items-center gap-2 text-sm text-slate-400">
                <input type="checkbox" name="remember" class="rounded border-slate-700 bg-slate-900">
                Ingat saya
            </label>
            <button type="submit" class="w-full rounded-xl bg-violet-600 px-4 py-2.5 font-semibold text-white hover:bg-violet-500">Masuk</button>
        </form>

        <p class="mt-5 text-sm text-slate-400">Belum punya akun? <a href="{{ route('register') }}" class="text-violet-300 hover:underline">Daftar di sini</a></p>
    </section>
@endsection
