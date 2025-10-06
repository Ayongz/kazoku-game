<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatusController extends Controller
{
    /**
     * Display the player status page
     */
    public function index()
    {
        $user = Auth::user();
        
        return view('game.status', [
            'user' => $user
        ]);
    }
}