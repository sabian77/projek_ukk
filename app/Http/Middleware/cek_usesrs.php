<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Siswa;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class cek_usesrs
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $UserEmail = Auth::user()->email;

            //cek ketersediaan email user di tanel siswa
            $siswa = Siswa::where('email', $UserEmail)->exists();

            if (!$siswa) {
                Auth::logout();//logout jika user tidak cocok
                return redirect('/login')->with('error', 'Email tidak cocok dengan data di tabel siswa');
            }
        }
        return $next($request);
    }
}