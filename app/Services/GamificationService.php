<?php

namespace App\Services;

use App\Models\User;

class GamificationService
{
    /**
     * Add XP to user and check for level up.
     */
    public function addXp(User $user, int $amount): void
    {
        $user->xp += $amount;
        
        // Basic level formula: Level = floor(sqrt(XP / 100)) + 1
        // Example: 100 XP = Lvl 2, 400 XP = Lvl 3, 900 XP = Lvl 4
        $newLevel = (int) floor(sqrt($user->xp / 100)) + 1;
        
        if ($newLevel > $user->level) {
            $user->level = $newLevel;
            // Optionally: dispatch level up event
        }
        
        $user->save();
    }

    /**
     * Add coins to user.
     */
    public function addCoins(User $user, int $amount): void
    {
        $user->coins += $amount;
        $user->save();
    }
}
