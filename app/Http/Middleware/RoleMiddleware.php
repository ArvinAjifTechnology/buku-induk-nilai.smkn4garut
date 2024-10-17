<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
       // Ambil user yang sedang login
       $user = auth()->user();

       // Periksa apakah user memiliki salah satu dari peran yang diizinkan
       if ($user && in_array($user->role, $roles)) {
           return $next($request);
       }

       auth()->logout();
       // Jika tidak memiliki peran yang sesuai, redirect atau tampilkan pesan error
       return redirect('/login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}
