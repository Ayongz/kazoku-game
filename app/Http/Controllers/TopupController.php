<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\TopupRequest;

class TopupController extends Controller
{
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
                'package' => 'required|in:random_box_20,treasure_40,random_box_40,treasure_80',
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

        // Calculate total approved topup amount per user (sum actual cost)
        $totals = [];
        $scoreboard = [];
        foreach ($grouped as $userId => $reqs) {
            $approved = $reqs->where('status', 'success');
            $totalAmount = 0;
            foreach ($approved as $req) {
                if ($req->package === 'random_box_20' || $req->package === 'treasure_40') {
                    $totalAmount += 50000;
                } elseif ($req->package === 'random_box_40' || $req->package === 'treasure_80') {
                    $totalAmount += 100000;
                }
            }
            $totals[$userId] = $totalAmount;
            $approvedCount = $approved->count();
            if ($approvedCount > 0) {
                $scoreboard[] = [
                    'user' => $reqs->first()->user,
                    'total' => $totalAmount,
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
            if ($pending->package === 'random_box_20') {
                $user->randombox += 20;
                $shieldHours = 6;
                $topupAmount = 50000;
            } elseif ($pending->package === 'treasure_40') {
                $user->treasure += 40;
                $shieldHours = 6;
                $topupAmount = 50000;
            } elseif ($pending->package === 'random_box_40') {
                $user->randombox += 40;
                $shieldHours = 12;
                $topupAmount = 100000;
            } elseif ($pending->package === 'treasure_80') {
                $user->treasure += 80;
                $shieldHours = 12;
                $topupAmount = 100000;
            }
            // Add shield (stack if already has shield)
            $now = now();
            if ($user->shield_expires_at && $user->shield_expires_at > $now) {
                $user->shield_expires_at = $user->shield_expires_at->addHours($shieldHours);
            } else {
                $user->shield_expires_at = $now->addHours($shieldHours);
            }
            // Add topup amount to money_earned
            $user->money_earned += $topupAmount;
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
