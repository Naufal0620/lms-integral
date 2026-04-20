<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    /**
     * Display the leaderboard.
     */
    public function index()
    {
        // Get top 20 students by XP, excluding admins
        $topUsers = User::where('role', '!=', 'admin')
            ->orderBy('xp', 'desc')
            ->limit(20)
            ->get();

        // Find current user's rank
        $userRank = User::where('role', '!=', 'admin')
            ->where('xp', '>', auth()->user()->xp)
            ->count() + 1;

        return view('leaderboard.index', [
            'topUsers' => $topUsers,
            'userRank' => $userRank,
        ]);
    }
}
