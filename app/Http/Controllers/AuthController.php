<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

   public function login(Request $request)
{
    $credentials = $request->validate([
        'username' => 'required',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        $user = Auth::user();

        // cek role
        if (in_array($user->role, ['admin_putri', 'admin_putra'])) {
            return redirect()->intended('dashboard')
                ->with('success', 'Berhasil login!');
        } elseif ($user->role === 'santri') {
            // kalau status santri harus aktif
            if ($user->santri->status_santri !== 'aktif') {
                Auth::logout();
                return back()->with('error', 'Status akun Anda belum aktif, silakan hubungi admin.');
            }

            return redirect()->route('tagihan.pembayaran.santri.index')
                ->with('success', 'Berhasil login!');
        } else {
            Auth::logout();
            return back()->with('error', 'Role tidak dikenali.');
        }
    }

    return back()->with('error', 'Username atau password salah.');
}



    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('/');
    }
}

