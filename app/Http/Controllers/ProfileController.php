<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profile = null;

        if (in_array($user->role, ['adm', 'opr'])) {
            $profile = $user->pegawai;
        } elseif ($user->role === 'nsb') {
            $profile = $user->nasabah;
        }

        return view('profile.index', compact('user', 'profile'));
    }

    public function settings()
    {
        $user = Auth::user();
        $profile = null;

        if (in_array($user->role, ['adm', 'opr'])) {
            $profile = $user->pegawai;
        } elseif ($user->role === 'nsb') {
            $profile = $user->nasabah;
        }

        return view('profile.settings', compact('user', 'profile'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'nama'   => 'required|string|max:100',
            'no_hp'  => 'nullable|string|max:20',
            'email'  => 'nullable|email|max:100',
            'alamat' => 'nullable|string',
        ]);

        if (in_array($user->role, ['adm', 'opr']) && $user->pegawai) {
            $user->pegawai->update($validated);
            session(['nama' => $validated['nama']]);
        } elseif ($user->role === 'nsb' && $user->nasabah) {
            $user->nasabah->update($validated);
            session(['nama' => $validated['nama']]);
        }

        return redirect()->route('profile.index')
            ->with('toast_success', [
                'title'   => 'Profil Diperbarui',
                'message' => 'Data profil Anda berhasil disimpan.'
            ]);
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'password_lama' => ['required', function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    $fail('Password lama tidak sesuai.');
                }
            }],
            'password_baru' => ['required', 'confirmed', Password::min(6)],
        ], [
            'password_baru.confirmed' => 'Konfirmasi password baru tidak cocok.',
            'password_baru.min'       => 'Password baru minimal 6 karakter.',
        ]);

        $user->update(['password' => Hash::make($request->password_baru)]);

        return redirect()->route('profile.settings')
            ->with('toast_success', [
                'title'   => 'Password Diubah',
                'message' => 'Password akun Anda berhasil diperbarui.'
            ]);
    }
}
