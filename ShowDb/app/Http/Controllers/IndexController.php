<?php

namespace ShowDb\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        if (\Auth::user()) {
            return view('redirect')->withTo('stats/'.\Auth::user()->username);
            
            return redirect('stats/'.\Auth::user()->username);
        } else {
            return view('redirect')->withTo('login');
            
            return redirect('register');
        }        
    }

    public function privacy()
    {
        return view('privacy');
    }

    public function about()
    {
        return view('about');
    }
}
