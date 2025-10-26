<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\TopupRequest;

class TopupController extends Controller
{
    public static $PACKAGE_COST = 50000;

    public function index()
    {
        $pending = TopupRequest::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->latest()->first();
        return view('topup.index', compact('pending'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'package' => 'required|in:random_box,treasure',
            ]);
            TopupRequest::create([
                'user_id' => Auth::id(),
                'package' => $request->package,
                'status' => 'pending',
            ]);
            return redirect()->route('topup.index')->with('success', 'Top up request submitted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('topup.index')->with('error', 'Failed to submit top up request.');
        }
    }

    public function admin()
    {
        $this->authorizeAdmin();
        $requests = TopupRequest::with('user')->orderByDesc('created_at')->get();
        $grouped = $requests->groupBy('user_id');

        // Calculate total approved topup amount per user
        $totals = [];
        foreach ($grouped as $userId => $reqs) {
            $totals[$userId] = $reqs->where('status', 'success')->count() * self::$PACKAGE_COST;
        }

        // Scoreboard: all players who have already topup (approved at least once)
        $scoreboard = [];
        foreach ($grouped as $userId => $reqs) {
            $approvedCount = $reqs->where('status', 'success')->count();
            if ($approvedCount > 0) {
                $scoreboard[] = [
                    'user' => $reqs->first()->user,
                    'total' => $approvedCount * self::$PACKAGE_COST,
                    'count' => $approvedCount,
                ];
            }
        }
        // Sort scoreboard by total descending
        usort($scoreboard, function($a, $b) { return $b['total'] <=> $a['total']; });

        return view('topup.admin', compact('grouped', 'totals', 'scoreboard'));
    }

    // Admin approve specific request
    public function adminApprove($id)
    {
        $this->authorizeAdmin();
        $pending = TopupRequest::where('id', $id)->where('status', 'pending')->first();
        if ($pending) {
            $user = User::find($pending->user_id);
            if ($pending->package === 'random_box') {
                $user->randombox += 20;
            } else {
                $user->treasure += 40;
            }
            // Add 12 hours shield (stack if already has shield)
            $now = now();
            if ($user->shield_expires_at && $user->shield_expires_at > $now) {
                $user->shield_expires_at = $user->shield_expires_at->addHours(12);
            } else {
                $user->shield_expires_at = $now->addHours(12);
            }
            // Add 50,000 IDR to money_earned
            $user->money_earned += 50000;
            $user->save();
            $pending->status = 'success';
            $pending->save();
        }
        return redirect()->route('topup.admin');
    }

    // Admin reject specific request
    public function adminReject($id)
    {
        $this->authorizeAdmin();
        $pending = TopupRequest::where('id', $id)->where('status', 'pending')->first();
        if ($pending) {
            $pending->status = 'rejected';
            $pending->save();
        }
        return redirect()->route('topup.admin');
    }

    // Helper: only allow admin
    protected function authorizeAdmin()
    {
        if (!Auth::user() || !Auth::user()->is_admin) {
            abort(403, 'Unauthorized');
        }
    }
}
