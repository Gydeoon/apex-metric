<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View { return view('auth.login'); }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors(['email' => 'Kredensial yang diberikan tidak cocok dengan catatan kami.']);
    }

    public function showRegister(): View { return view('auth.register'); }

    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_premium' => false // Bawaan pendaftaran awal adalah gratis/non-premium
        ]);

        Auth::login($user);
        return redirect()->route('dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    // Tombol simulasi bayar premium instan (Untuk kebutuhan Testing / Demo SaaS)
    public function activePremium(Request $request): RedirectResponse
    {
        $user = $request->user();
        $user->update(['is_premium' => !$user->is_premium]);
        return redirect()->back()->with('success', $user->is_premium ? 'Akun Anda berhasil ditingkatkan ke Premium!' : 'Akun Premium dinonaktifkan.');
    }
}