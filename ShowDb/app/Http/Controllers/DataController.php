<?php

namespace ShowDb\Http\Controllers;

use Illuminate\Http\Request;
Use ShowDb\Song;

class DataController extends Controller
{
    /**
     * For use with typeahead inputs.
     */
    public function songs() {
        return Song::all()->pluck('title')->toJson();
    }
}
