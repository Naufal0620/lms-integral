<?php

namespace App\Services;

use App\Models\User;

class GamificationService
{
    /**
     * Add XP to user and check for level up.
     * Returns true if user leveled up.
     */
    public function addXp(User $user, int $amount): bool
    {
        $oldLevel = $user->level;
        $user->xp += $amount;
        
        // Basic level formula: Level = floor(sqrt(XP / 100)) + 1
        $newLevel = (int) floor(sqrt($user->xp / 100)) + 1;
        
        $levelUp = false;
        if ($newLevel > $oldLevel) {
            $user->level = $newLevel;
            $levelUp = true;
        }
        
        $user->save();
        return $levelUp;
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
