<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Batasi route berdasarkan peran user: pengguna, pegawai, admin.
     * Contoh pakai: ->middleware('role:pegawai,admin')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        if (! in_array($user->role, $roles, true)) {
            abort(403, 'Halaman ini tidak bisa diakses dengan peran akunmu.');
        }

        return $next($request);
    }
}
