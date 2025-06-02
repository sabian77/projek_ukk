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
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect('/login');
        }

        $userEmail = Auth::user()->email;

        // Cek email di kedua tabel sekaligus untuk optimasi
        $isGuru = Guru::where('email', $userEmail)->exists();
        $isSiswa = Siswa::where('email', $userEmail)->exists();

        // Prioritas: Guru dulu, baru Siswa
        if ($isGuru) {
            return redirect('/admin'); // Route Filament
        }

        if ($isSiswa) {
            return $next($request); // Lanjut ke halaman siswa
        }

        // Jika email tidak ditemukan di kedua tabel
        Auth::logout();
        return redirect('/login')->with('error', 'Email tidak terdaftar dalam sistem sebagai Guru atau Siswa.');
    }
}