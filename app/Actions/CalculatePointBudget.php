<?php

namespace App\Actions;

use App\Enums\BanditChoice;
use App\Models\LevelRange;

class CalculatePointBudget
{
    private const array QUEST_REWARDS = [
        // Act 1
        5 => 1,  // The Dweller of the Deep (Essence Crab)
        12 => 1, // The Marooned Mariner (Fairgraves)
        // Act 2
        17 => 1, // The Way Forward (Captain Arteri)
        18 => 1, // Through Sacred Ground (Crypt Golden Hand)
        // Act 3
        26 => 1, // Victario's Secrets (Three Busts)
        30 => 1, // Piety's Pets (Piety)
        // Act 4
        35 => 1, // An Indomitable Spirit (Free Deshret's Spirit)
        // Act 5
        41 => 1, // In Service to Science (Find Miasmeter)
        44 => 1, // Kitava's Torments (Collect Reliquary Parts)
        // Act 6
        46 => 1, // The Father of War (Tukohama)
        47 => 1, // The Cloven One (Abberath)
        48 => 1, // The Puppet Mistress (Ryslatha)
        // Act 7
        52 => 1, // The Master of a Million Faces (Ralakesh)
        53 => 1, // Queen of Despair (Gruthkul)
        54 => 1, // Kishara's Star (Found in causeway chest)
        // Act 8
        57 => 1, // Love Is Dead (Find ankh and kill Tolman)
        58 => 1, // The Gemling Legion (Gemling Legion)
        59 => 1, // Reflection of Terror (Yugul)
        // Act 9
        61 => 1, // Queen of the Sands (Shakari)
        63 => 1, // The Ruler of Highgate (Garukhan)
        // Act 10
        66 => 1, // Vilenta's Vengeance (Vilenta)
        68 => 2, // An End to Hunger (Kitava)
    ];

    // Deal with the Bandits — level at which the quest is usually completed
    private const int BANDIT_LEVEL = 19;

    /**
     * Handles calculation of allocatable points per level range based on player level and quest rewards.
     * @param LevelRange $range
     * @param BanditChoice $banditChoice
     * @return int
     */
    public function handle(LevelRange $range, BanditChoice $banditChoice): int
    {
        $basePoints = max(0, $range->level_max - max(1, $range->level_min - 1));

        $questPoints = collect(self::QUEST_REWARDS)
            ->filter(fn (int $points, int $level): bool => $level >= $range->level_min && $level <= $range->level_max)
            ->sum();

        $banditPoints = ($banditChoice === BanditChoice::KILL_ALL
            && self::BANDIT_LEVEL >= $range->level_min
            && self::BANDIT_LEVEL <= $range->level_max)
            ? 1
            : 0;

        return $basePoints + $questPoints + $banditPoints;
    }
}
