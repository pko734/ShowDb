<?php

namespace ShowDb\Http\Controllers;

use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function welcome(Request $request) {
        return view('welcome');
    }
}
