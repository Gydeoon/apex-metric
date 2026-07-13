<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ActivityController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; 
use App\Models\User;

// Halaman utama / Marketing Landing Page (Akses Publik)
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Halaman About & Visi Misi (Akses Publik)
Route::get('/about', function () {
    return view('about');
});

// Grup Route yang dilindungi oleh sistem Autentikasi (Harus Login)
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Halaman Dashboard Utama (Menampilkan Rank dan Form Log)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // ROUTE VIEW HALAMAN PEMBELIAN PREMIUM SAAS
    Route::get('/premium', function () {
        if (Auth::user()->is_premium) {
            return redirect()->route('dashboard')->with('success', 'Anda sudah aktif sebagai member Premium.');
        }
        return view('premium');
    })->name('premium.index');

    // Route Proses CRUD Aktivitas
    Route::post('/activities', [ActivityController::class, 'store'])->name('activities.store');
    Route::get('/activities/{activity}/edit', [ActivityController::class, 'edit'])->name('activities.edit');
    Route::put('/activities/{activity}', [ActivityController::class, 'update'])->name('activities.update');
    Route::delete('/activities/{activity}', [ActivityController::class, 'destroy'])->name('activities.destroy');

    // ROUTE SIMULASI PREMIUM TOGGLE INSTAN (Intelephense Clean)
    Route::post('/premium-simulate', function () {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $user->update(['is_premium' => !$user->is_premium]);
        return redirect()->route('dashboard')->with('success', $user->is_premium ? 'Akun berhasil ditingkatkan ke Premium.' : 'Akun Premium dinonaktifkan.');
    })->name('premium.simulate');

    // GLOBAL LEADERBOARD (DILINDUNGI PAYWALL KONDISIONAL - Intelephense Clean)
    Route::get('/leaderboard', function () {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user || !$user->is_premium) {
            return redirect()->route('dashboard')->withErrors(['premium_error' => 'Fitur ini eksklusif untuk member Premium.']);
        }
        
        $leaderboard = User::orderBy('total_pts', 'desc')->take(50)->get();
        return view('leaderboard', compact('leaderboard'));
    })->name('leaderboard');

    // VIEW DETAIL PROFIL ATLET LAIN (Eksklusif Premium)
    Route::get('/users/{user}', function (User $user) {
        /** @var \App\Models\User $currentUser */
        $currentUser = Auth::user();

        if (!$currentUser->is_premium) {
            return redirect()->route('dashboard')->withErrors(['premium_error' => 'Fitur mengintip profil atlet lain eksklusif untuk member Premium.']);
        }

        // Mengambil maksimal 15 aktivitas terbaru milik pengguna tersebut untuk dianalisis
        $activities = $user->activities()->latest()->take(15)->get();

        return view('user-profile', compact('user', 'activities'));
    })->name('users.profile');

    // Profile routes bawaan Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Memuat sistem autentikasi bawaan Laravel Breeze
require __DIR__.'/auth.php';