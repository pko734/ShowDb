<?php

namespace ShowDb\Http\Controllers;

use Illuminate\Http\Request;
use ShowDb\ShowNote;
use ShowDb\SongNote;
use ShowDb\SetlistItemNote;
use ShowDb\Audit;
use ShowDb\User;

class AdminController extends Controller
{
    public function __construct() {
        $this->middleware('admin');
    }

    /**
     *  Display admin interface.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
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

    public function audit() {
        $audit = Audit::with('user')
               ->orderBy('created_at', 'desc')
               ->paginate(15);
        return view('admin.audit')
            ->withAudits($audit);

    }

    public function users() {
        $users = User::orderBy('id', 'asc')->paginate(15);
        return view('admin/users')
            ->withUsers($users);
    }
}
