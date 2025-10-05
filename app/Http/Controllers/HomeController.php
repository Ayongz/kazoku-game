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
        
        return view('home', [
            'currentUser' => $currentUser,
            'topPlayers' => $topPlayers,
            'userRank' => $userRank,
            'totalPlayers' => $totalPlayers,
            'globalPrizePool' => $globalPrizePool,
            'totalMoneyInGame' => $totalMoneyInGame,
        ]);
    }
}
