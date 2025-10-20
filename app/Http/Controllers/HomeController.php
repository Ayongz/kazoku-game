<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\GameSetting;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard with leaderboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $currentUser = Auth::user();
        
        // Get top 10 players ordered by money_earned (highest to lowest)
        $topPlayers = User::orderBy('money_earned', 'desc')
                         ->take(10)
                         ->get();

        // Get current user's rank
        $userRank = User::where('money_earned', '>', $currentUser->money_earned)->count() + 1;
        
        // Get total number of players
        $totalPlayers = User::count();
        
        // Get game statistics
        $gameSettings = GameSetting::first();
        $globalPrizePool = $gameSettings ? $gameSettings->global_prize_pool : 0;
        
        // Calculate total money in circulation
        $totalMoneyInGame = User::sum('money_earned');
        
        // Calculate total random boxes in circulation
        $totalRandomBoxes = User::sum('randombox');
        
        // Calculate total treasures in circulation
        $totalTreasures = User::sum('treasure');
        
        // Calculate average player level
        $averageLevel = User::avg('level') ?: 1;
        
        // Get highest level player
        $highestLevelPlayer = User::orderBy('level', 'desc')->first();
        
        // Get player with most random boxes
        $topRandomBoxPlayer = User::orderBy('randombox', 'desc')->first();
        
        // Get player with highest treasure rarity
        $topTreasureRarityPlayer = User::orderBy('treasure_rarity_level', 'desc')->first();
        
        return view('home', [
            'currentUser' => $currentUser,
            'topPlayers' => $topPlayers,
            'userRank' => $userRank,
            'totalPlayers' => $totalPlayers,
            'globalPrizePool' => $globalPrizePool,
            'totalMoneyInGame' => $totalMoneyInGame,
            'totalRandomBoxes' => $totalRandomBoxes,
            'totalTreasures' => $totalTreasures,
            'averageLevel' => $averageLevel,
            'highestLevelPlayer' => $highestLevelPlayer,
            'topRandomBoxPlayer' => $topRandomBoxPlayer,
            'topTreasureRarityPlayer' => $topTreasureRarityPlayer,
        ]);
    }

    /**
     * Mark welcome overlay as shown for current session
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function markWelcomeShown(Request $request)
    {
        // Mark welcome overlay as shown in the session
        session(['welcome_shown' => true]);
        
        return response()->json([
            'success' => true,
            'message' => 'Welcome overlay marked as shown'
        ]);
    }
}
