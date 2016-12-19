<?php

namespace ShowDb\Http\Controllers;

use Illuminate\Http\Request;
use ShowDb\User;
use \DB;
use \Redirect;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use ShowDb\Show;

class UserController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function storeShow($show_id, Request $request ) {
        $request->user()->shows()->attach($show_id);
        return Redirect::back();
    }

    public function destroyShow($show_id, Request $request ) {
        $request->user()->shows()->detach($show_id);
        return Redirect::back();
    }

    public function index(Request $request) {
        $total = 0;
        $songs = [];
        $i = 0;

        $results = DB::select(DB::raw(
            "SELECT COUNT(title) AS setlist_items_count,
                    s.id,
                    s.title
             FROM songs s
             JOIN setlist_items si ON s.id = si.song_id
             JOIN show_user su     ON su.show_id = si.show_id
             WHERE su.user_id = {$request->user()->id}
             GROUP BY s.title, s.id
             ORDER BY setlist_items_count DESC"));

        $total_count = DB::select(DB::raw(
            "SELECT COUNT(title) AS total_count
             FROM songs s
             JOIN setlist_items si ON s.id = si.song_id
             JOIN show_user su     ON su.show_id = si.show_id
             WHERE su.user_id = {$request->user()->id}"
        ))[0]->total_count;

        $user_id = $request->user()->id;
        $first_show = Show::whereHas('users', function($query) use($user_id) {
            $query->where('user_id', '=', $user_id);
        })
                    ->whereRaw('UNIX_TIMESTAMP(date) < ?', \Carbon\Carbon::now()->timestamp)
                    ->orderBy('date', 'asc')
                    ->first();
        $last_show = Show::whereHas('users', function($query) use($user_id) {
            $query->where('user_id', '=', $user_id);
        })
                   ->whereRaw('UNIX_TIMESTAMP(date) < ?', \Carbon\Carbon::now()->timestamp)
                    ->orderBy('date', 'desc')
                    ->first();

        $next_show = Show::whereHas('users', function($query) use($user_id) {
            $query->where('user_id', '=', $user_id);
        })
                   ->whereRaw('UNIX_TIMESTAMP(date) > ?', \Carbon\Carbon::now()->timestamp)
                    ->orderBy('date', 'desc')
                    ->first();

        return view('user.index')
            ->withShows($request
                        ->user()
                        ->shows()
                        ->withCount('setlistItems'))
            ->withUser($request->user())
            ->withTotalSongs($total_count)
            ->withFirstShow($first_show)
            ->withLastShow($last_show)
            ->withNextShow($next_show)
            ->withSongs($results);
    }

    public function shows(Request $request) {
        return view('user.shows')
            ->withShows($request
                        ->user()
                        ->shows()
                        ->withCount('setlistItems')
                        ->orderBy('date', 'desc')
                        ->paginate(15));

    }

    public function songs(Request $request) {
        $results = DB::select(DB::raw(
            "SELECT COUNT(title) AS setlist_items_count,
                    COUNT(*)     AS total_count,
                    s.id,
                    s.title
             FROM songs s
             JOIN setlist_items si ON s.id = si.song_id
             JOIN show_user su     ON su.show_id = si.show_id
             WHERE su.user_id = {$request->user()->id}
             GROUP BY s.title, s.id
             ORDER BY setlist_items_count DESC, title asc"));

        $page = $request->page ?: 1; // Get the ?page=1 from the url
        $perPage = 15; // Number of items per page
        $offset = ($page * $perPage) - $perPage;
        $songs = new Collection($results);
        $paginate = new LengthAwarePaginator(
            array_slice($songs->toArray(), $offset, $perPage, true), // Only grab the items we need
            count($songs), // Total items
            $perPage, // Items per page
            $page, // Current page
            ['path' => $request->url(), 'query' => $request->query()] // We need this so we can keep all old query parameters from the url
        );
        return view('user.songs')
            ->withSongs($paginate);
    }
}
