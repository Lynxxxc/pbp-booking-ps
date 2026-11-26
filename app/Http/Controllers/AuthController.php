<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100'],
            'phone' => ['nullable', 'string', 'max:20', 'regex:/^[0-9+\-\s]+$/'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (User::where('email', $data['email'])->exists()) {
            return back()
                ->withInput()
                ->withErrors(['email' => 'Email sudah terdaftar.']);
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'password' => $data['password'],
            'role' => 'pengguna',
            'poin' => 0,
        ]);

        Auth::login($user);

        return redirect()->route('dashboard.pengguna');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($data, $request->boolean('remember'))) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Email atau password salah.']);
        }

        $request->session()->regenerate();

        return redirect()->intended($this->dashboardUrl(Auth::user()));
    }

    public function guestLogin(Request $request)
    {
        $user = User::firstOrCreate(
            ['email' => 'tamu@afrianjmk48.local'],
            [
                'name' => 'Tamu',
                'password' => Str::random(32),
                'role' => 'pengguna',
                'poin' => 0,
            ]
        );

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route('dashboard.pengguna');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    private function dashboardUrl(User $user): string
    {
        return match ($user->role) {
            'admin' => route('dashboard.admin'),
            'pegawai' => route('dashboard.pegawai'),
            default => route('dashboard.pengguna'),
        };
    }
}
