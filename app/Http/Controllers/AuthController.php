<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $req)
    {
        $credentials = $req->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        if (!Auth::attempt($credentials, $req->filled('remember'))) {
            return back()
                ->withErrors(['login_gagal' => 'Username atau password salah.'])
                ->with('toast_error', [
                    'title' => 'Login Gagal',
                    'message' => 'Username atau password yang Anda masukkan salah.'
                ])
                ->onlyInput('username');
        }

        $req->session()->regenerate();
        $user = Auth::user();

        switch ($user->role) {
            case 'adm':
            case 'opr':
                $pegawai = $user->pegawai;
                session([
                    'nip' => $pegawai->nip ?? '-',
                    'nama' => $pegawai->nama ?? '-'
                ]);
                return redirect()
                    ->route('dashboard.index')
                    ->with('toast_success', [
                        'title' => 'Login Berhasil',
                        'message' => 'Selamat datang, ' . ($pegawai->nama ?? $user->username) . '!'
                    ]);

            case 'nsb':
                $nasabah = $user->nasabah
                    ->whereHas('rekening', fn($q) => $q->where('status', 1))
                    ->with('rekening')->first();
                if (!$nasabah) {
                    Auth::logout();
                    $req->session()->invalidate();
                    return redirect('/')
                        ->withErrors(['login_gagal' => 'Rekening Anda tidak aktif.'])
                        ->with('toast_error', [
                            'title' => 'Akses Ditolak',
                            'message' => 'Rekening Anda tidak aktif. Silakan hubungi admin.'
                        ]);
                }
                session([
                    'nin' => $nasabah->nin ?? '-',
                    'nama' => $nasabah->nama ?? '-'
                ]);
                return redirect()
                    ->route('dashboard.index')
                    ->with('toast_success', [
                        'title' => 'Login Berhasil',
                        'message' => 'Selamat datang, ' . ($nasabah->nama ?? $user->username) . '!'
                    ]);

            default:
                Auth::logout();
                $req->session()->invalidate();
                return redirect('/')
                    ->withErrors(['login_gagal' => 'Role pengguna tidak valid.'])
                    ->with('toast_error', [
                        'title' => 'Role Tidak Valid',
                        'message' => 'Role pengguna tidak terdaftar di sistem.'
                    ]);
        }
    }

    public function logout(Request $req)
    {
        Auth::logout();
        $req->session()->invalidate();
        $req->session()->regenerateToken();
        return redirect('/')->with('toast_success', [
            'title' => 'Logout Berhasil',
        ]);
    }
}
