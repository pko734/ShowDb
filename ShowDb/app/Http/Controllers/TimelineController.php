<?php

namespace ShowDb\Http\Controllers;

use Illuminate\Http\Request;

class TimelineController extends Controller
{
    public function index(Request $request) {
        return view('timeline.index')
            ->withUser($request->user());
    }
}
