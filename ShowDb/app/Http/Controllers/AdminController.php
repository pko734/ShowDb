<?php

namespace ShowDb\Http\Controllers;

use Illuminate\Http\Request;
use ShowDb\ShowNote;
use ShowDb\SongNote;
use ShowDb\SetlistItemNote;

class AdminController extends Controller
{
    public function __construct() {
        $this->middleware('admin');
    }

    public function index(Request $request) {
        $show_notes = ShowNote::orderBy('updated_at', 'desc')
                    ->where('published', '=', 0)
                    ->paginate(5);

        $song_notes = SongNote::orderBy('updated_at', 'desc')
                    ->where('published', '=', 0)
                    ->paginate(5);

        $videos = SetListItemNote::orderBy('updated_at', 'desc')
                ->where('published', '=', 0)
                ->paginate(5);

        return view('admin.index')
            ->withUser($request->user())
            ->withShowNotes($show_notes)
            ->withSongNotes($song_notes)
            ->withVideos($videos);


    }
}
