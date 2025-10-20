<?php

namespace App\Services;

class ExperienceService
{
    /**
     * Calculate the experience required for a given level
     * Formula: EXP = 100 * level^1.5 (rounded to nearest 50)
     * 
     * @param int $level
     * @return int
     */
    public static function getExpRequiredForLevel(int $level): int
    {
        if ($level <= 1) {
            return 0;
        }
        
        // Base formula: 100 * level^1.5
        $baseExp = 100 * pow($level, 1.5);
        
        // Round to nearest 50 for cleaner numbers
        return (int) (round($baseExp / 50) * 50);
    }
    
    /**
     * Get cumulative experience required to reach a level
     * 
     * @param int $level
     * @return int
     */
    public static function getCumulativeExpForLevel(int $level): int
    {
        $totalExp = 0;
        
        for ($i = 2; $i <= $level; $i++) {
            $totalExp += self::getExpRequiredForLevel($i);
        }
        
        return $totalExp;
    }
    
    /**
     * Calculate what level a player should be based on their total experience
     * 
     * @param int $experience
     * @return int
     */
    public static function getLevelFromExperience(int $experience): int
    {
        if ($experience <= 0) {
            return 1;
        }
        
        $level = 1;
        $cumulativeExp = 0;
        
        while (true) {
            $nextLevelExp = self::getExpRequiredForLevel($level + 1);
            
            if ($cumulativeExp + $nextLevelExp > $experience) {
                break;
            }
            
            $cumulativeExp += $nextLevelExp;
            $level++;
        }
        
        return $level;
    }
    
    /**
     * Get experience gained from opening treasure
     * Formula: Random base EXP (10-13) + (level * 2) for scaling
     * 
     * @param int $playerLevel
     * @return int
     */
    public static function getExpFromTreasure(int $playerLevel): int
    {
        return rand(10, 13) + ($playerLevel * 2);
    }
    
    /**
     * Get experience needed for next level from current experience
     * 
     * @param int $currentExp
     * @param int $currentLevel
     * @return int
     */
    public static function getExpToNextLevel(int $currentExp, int $currentLevel): int
    {
        $nextLevelTotalExp = self::getCumulativeExpForLevel($currentLevel + 1);
        return max(0, $nextLevelTotalExp - $currentExp);
    }
    
    /**
     * Get experience progress towards next level as percentage
     * 
     * @param int $currentExp
     * @param int $currentLevel
     * @return float
     */
    public static function getExpProgressPercentage(int $currentExp, int $currentLevel): float
    {
        $currentLevelTotalExp = self::getCumulativeExpForLevel($currentLevel);
        $nextLevelTotalExp = self::getCumulativeExpForLevel($currentLevel + 1);
        
        if ($nextLevelTotalExp <= $currentLevelTotalExp) {
            return 100.0;
        }
        
        $progressInCurrentLevel = $currentExp - $currentLevelTotalExp;
        $expRequiredForCurrentLevel = $nextLevelTotalExp - $currentLevelTotalExp;
        
        return ($progressInCurrentLevel / $expRequiredForCurrentLevel) * 100;
    }
    
    /**
     * Check if player should level up and return new level
     * 
     * @param int $currentExp
     * @param int $currentLevel
     * @return array ['shouldLevelUp' => bool, 'newLevel' => int]
     */
    public static function checkLevelUp(int $currentExp, int $currentLevel): array
    {
        $calculatedLevel = self::getLevelFromExperience($currentExp);
        
        return [
            'shouldLevelUp' => $calculatedLevel > $currentLevel,
            'newLevel' => $calculatedLevel
        ];
    }
    
    /**
     * Get EXP table for reference (first 20 levels)
     * 
     * @return array
     */
    public static function getExpTable(int $maxLevel = 20): array
    {
        $table = [];
        
        for ($level = 1; $level <= $maxLevel; $level++) {
            $table[$level] = [
                'level' => $level,
                'exp_for_this_level' => self::getExpRequiredForLevel($level),
                'cumulative_exp' => self::getCumulativeExpForLevel($level),
                'exp_from_treasure' => self::getExpFromTreasure($level)
            ];
        }
        
        return $table;
    }
}