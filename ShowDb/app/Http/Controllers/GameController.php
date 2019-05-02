<?php

namespace ShowDb\Http\Controllers;

use Illuminate\Http\Request;

class GameController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $request) {
        return view('game.index')
            ->withUser($request->user());
    }
}
