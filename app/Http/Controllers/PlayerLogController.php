<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PlayerLog;

class PlayerLogController extends Controller
{
    /**
     * Display the player's activity logs
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Get filter parameters
        $actionType = $request->get('action_type');
        $perPage = $request->get('per_page', 25);
        
        // Build query
        $query = PlayerLog::forUser($user->id)
            ->orderBy('created_at', 'desc');
            
        // Apply action type filter if specified
        if ($actionType && $actionType !== 'all') {
            $query->where('action_type', $actionType);
        }
        
        // Paginate results
        $logs = $query->paginate($perPage)->withQueryString();
        
        // Get summary statistics
        $stats = $this->getPlayerStats($user->id);
        
        return view('game.logs', [
            'logs' => $logs,
            'stats' => $stats,
            'currentFilter' => $actionType ?? 'all',
            'user' => $user
        ]);
    }
    
    /**
     * Get player statistics from logs
     */
    private function getPlayerStats($userId): array
    {
        $allLogs = PlayerLog::forUser($userId)->get();
        
        return [
            'total_logs' => $allLogs->count(),
            'total_money_gained' => $allLogs->where('money_change', '>', 0)->sum('money_change'),
            'total_money_lost' => abs($allLogs->where('money_change', '<', 0)->sum('money_change')),
            'total_experience_gained' => $allLogs->sum('experience_gained'),
            'total_treasures_opened' => $allLogs->whereIn('action_type', ['treasure_open', 'rare_treasure_open'])->count(),
            'total_boxes_opened' => $allLogs->where('action_type', 'random_box_open')->count(),
            'total_gambling_sessions' => $allLogs->whereIn('action_type', ['gambling_dice', 'gambling_card', 'treasure_fusion'])->count(),
            'success_rate' => $allLogs->count() > 0 ? round(($allLogs->where('is_success', true)->count() / $allLogs->count()) * 100, 1) : 0,
            'action_breakdown' => $allLogs->groupBy('action_type')->map(function ($group) {
                return $group->count();
            })->toArray()
        ];
    }
    
    /**
     * Clear old logs (for maintenance)
     */
    public function clearOldLogs(Request $request)
    {
        $user = Auth::user();
        $daysToKeep = $request->get('days', 30);
        
        $deleted = PlayerLog::forUser($user->id)
            ->where('created_at', '<', now()->subDays($daysToKeep))
            ->delete();
            
        return response()->json([
            'success' => true,
            'message' => "Deleted {$deleted} old log entries (older than {$daysToKeep} days)",
            'deleted_count' => $deleted
        ]);
    }
}
