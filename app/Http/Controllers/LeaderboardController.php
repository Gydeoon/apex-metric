<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

class LeaderboardController extends Controller
{
    public function index(): View
    {
        // Ambil peringkat top 50 user berdasarkan total poin tertinggi secara instan
        $leaderboard = User::orderBy('total_pts', 'desc')->take(50)->get();
        return view('leaderboard', compact('leaderboard'));
    }
}