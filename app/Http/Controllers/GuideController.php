<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuideController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the game guide page.
     */
    public function index()
    {
        return view('game.guide');
    }
}