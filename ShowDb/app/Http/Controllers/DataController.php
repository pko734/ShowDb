<?php

namespace ShowDb\Http\Controllers;

use Illuminate\Http\Request;
use ShowDb\Song;
use ShowDb\State;


class DataController extends Controller
{
    /**
     * For use with typeahead inputs.
     */
    public function songs() {
        return Song::all()->pluck('title')->toJson();
    }

    /**
     * Available state information.
     */
     public function states() {
         return State::all()->pluck('name')->toJson();
     }
}
