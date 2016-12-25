<?php

namespace ShowDb\Http\Controllers;

use Illuminate\Http\Request;
use ShowDb\User;
use \DB;
use \Redirect;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use ShowDb\Show;
use Validator;
use Illuminate\Validation\Rule;
use Session;


class UserController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
        $this->middleware('username')->except(['settings','update']);
    }

    public function storeShow($show_id, Request $request ) {
        $request->user()->shows()->syncWithoutDetaching([$show_id]);
        return Redirect::back();
    }

    public function destroyShow($show_id, Request $request ) {
        $request->user()->shows()->detach($show_id);
        return Redirect::back();
    }

    private function _getMySongs($user) {
        return DB::select(DB::raw(
            "SELECT COUNT(title) AS setlist_items_count,
                    s.id,
                    s.title
             FROM songs s
             JOIN setlist_items si ON s.id = si.song_id
             JOIN show_user su     ON su.show_id = si.show_id
             WHERE su.user_id = {$user->id}
             GROUP BY s.title, s.id
             ORDER BY setlist_items_count DESC"));
    }

    private function _getMyTotalSongs($user) {
        return DB::select(DB::raw(
            "SELECT COUNT(title) AS total_count
             FROM songs s
             JOIN setlist_items si ON s.id = si.song_id
             JOIN show_user su     ON su.show_id = si.show_id
             WHERE su.user_id = {$user->id}"
        ))[0]->total_count;
    }

    private function _getMyShowsByYear($user) {
        return DB::select(DB::raw(
            "SELECT SUBSTRING(date,1,4) AS year, count(sh.id) AS show_count
             FROM shows sh
             JOIN show_user su ON sh.id = su.show_id
             WHERE su.user_id = {$user->id}
             GROUP BY year
             ORDER BY year desc"
        ));
    }

    private function _getMySongsByYear($user) {
        return DB::select(DB::raw(
            "SELECT SUBSTRING(date,1,4) AS year, count(si.id) AS song_count
             FROM shows sh
             JOIN show_user su ON sh.id = su.show_id
             JOIN setlist_items si ON si.show_id = su.show_id
             WHERE su.user_id = {$user->id}
             GROUP BY year
             ORDER BY year desc"
        ));
    }

    private function _getMyUniqueSongsByYear($user) {
        return DB::select(DB::raw(
            "SELECT SUBSTRING(date,1,4) AS year, COUNT(DISTINCT s.title) as unique_songs
             FROM shows sh
             JOIN show_user su ON sh.id = su.show_id
             JOIN setlist_items si ON si.show_id = su.show_id
             JOIN songs s on si.song_id = s.id
             WHERE su.user_id = {$user->id}
             GROUP BY year
             ORDER BY year desc"
        ));
    }

    private function _getAllSongs() {
        return DB::select(DB::raw(
            "SELECT COUNT(title) AS setlist_items_count,
                    s.id,
                    s.title
             FROM songs s
             JOIN setlist_items si ON s.id = si.song_id
             GROUP BY s.title, s.id
             ORDER BY setlist_items_count DESC"));
    }

    private function _getAllTotalSongs() {
        return DB::select(DB::raw(
            "SELECT COUNT(title) AS total_count
             FROM songs s
             JOIN setlist_items si ON s.id = si.song_id"
        ))[0]->total_count;
    }

    private function _getAllShowsByYear() {
        return DB::select(DB::raw(
            "SELECT SUBSTRING(date,1,4) AS year, count(sh.id) AS show_count
             FROM shows sh
             GROUP BY year
             ORDER BY year desc"
        ));
    }

    private function _getAllSongsByYear() {
        return DB::select(DB::raw(
            "SELECT SUBSTRING(date,1,4) AS year, count(si.id) AS song_count
             FROM shows sh
             JOIN setlist_items si ON si.show_id = sh.id
             GROUP BY year
             ORDER BY year desc"
        ));
    }

    private function _getAllUniqueSongsByYear() {
        return DB::select(DB::raw(
            "SELECT SUBSTRING(date,1,4) AS year, COUNT(DISTINCT s.title) as unique_songs
             FROM shows sh
             JOIN setlist_items si ON si.show_id = sh.id
             JOIN songs s on si.song_id = s.id
             GROUP BY year
             ORDER BY year desc"
        ));
    }

    public function index(Request $request) {
        return $this->_showUserStats($request->user());
    }

    public function userstats($username, Request $request) {
        $v = Validator::make(['username' => $username], [
            'username' => [
                'required',
                Rule::exists('users'),
            ],
        ]);

        if($v->fails()) {
            return Redirect::to('/')->withErrors($v);
        }
        return $this->_showUserStats(User::where('username', '=', $username)->first());
    }

    private function _showUserStats($user) {
        $songs = $this->_getMySongs($user);
        $total_songs = $this->_getMyTotalSongs($user);
        $shows_by_year = $this->_getMyShowsByYear($user);
        $songs_by_year = $this->_getMySongsByYear($user);
        $unique_songs_by_year = $this->_getMyUniqueSongsByYear($user);

        $yearly_data = [];
        $i = 0;
        foreach($shows_by_year as $info) {
            $song_count = 0;
            $unique_songs = 0;
            foreach($songs_by_year as $s) {
                if($s->year === $info->year) {
                    $song_count = $s->song_count;
                    break;
                }
            }
            foreach($unique_songs_by_year as $u) {
                if($u->year === $info->year) {
                    $unique_songs = $u->unique_songs;
                    break;
                }
            }
            $yearly_data[$info->year] = (object)[
                'shows' => $info->show_count,
                'songs' => $song_count,
                'unique_songs' => $unique_songs,
            ];
            $i++;
        }

        $user_id = $user->id;
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
                    ->orderBy('date', 'asc')
                    ->first();

        return view('user.index')
            ->withPastShows($user
                            ->shows()
                            ->whereRaw('UNIX_TIMESTAMP(date) < ?',
                                       \Carbon\Carbon::now()->timestamp)->get())
            ->withUpcomingShows($user
                                ->shows()
                                ->whereRaw('UNIX_TIMESTAMP(date) > ?',
                                           \Carbon\Carbon::now()->timestamp)->get())
            ->withUser($user)
            ->withTotalSongs($total_songs)
            ->withFirstShow($first_show)
            ->withLastShow($last_show)
            ->withNextShow($next_show)
            ->withYearlyData($yearly_data)
            ->withSongs($songs);
    }

    public function allstats(Request $request) {
        $songs = $this->_getAllSongs();
        $total_songs = $this->_getAllTotalSongs();
        $shows_by_year = $this->_getAllShowsByYear();
        $songs_by_year = $this->_getAllSongsByYear();
        $unique_songs_by_year = $this->_getAllUniqueSongsByYear();

        $yearly_data = [];
        $i = 0;
        foreach($shows_by_year as $info) {
            $song_count = 0;
            $unique_songs = 0;
            foreach($songs_by_year as $s) {
                if($s->year === $info->year) {
                    $song_count = $s->song_count;
                    break;
                }
            }
            foreach($unique_songs_by_year as $u) {
                if($u->year === $info->year) {
                    $unique_songs = $u->unique_songs;
                    break;
                }
            }
            $yearly_data[$info->year] = (object)[
                'shows' => $info->show_count,
                'songs' => $song_count,
                'unique_songs' => $unique_songs,
            ];
            $i++;
        }

        return view('user.allstats')
            ->withPastShows(Show::whereRaw('UNIX_TIMESTAMP(date) < ?',
                                           \Carbon\Carbon::now()->timestamp)->get())
            ->withUpcomingShows(Show::whereRaw('UNIX_TIMESTAMP(date) > ?',
                                               \Carbon\Carbon::now()->timestamp)->get())
            ->withUser($request->user())
            ->withTotalSongs($total_songs)
            ->withYearlyData($yearly_data)
            ->withSongs($songs);
    }


    public function shows($username, Request $request) {
        $this->validate($request, [
            'o' => 'in:date-asc,date-desc,setlist_items_count-asc,setlist_items_count-desc',
            'q' => 'string|min:3',
        ]);

        $v = Validator::make(['username' => $username], [
            'username' => [
                'required',
                Rule::exists('users'),
            ],
        ]);

        if($v->fails()) {
            return Redirect::to('/')->withErrors($v);
        }

        $user = User::where('username', '=', $username)->first();
        $q = $request->q;
        return view('user.shows')
            ->withShows($user
                        ->shows()
                        ->where( 'date',   'LIKE', "%{$q}%" )
                        ->withCount('setlistItems')
                        ->orderBy('date', 'desc')
                        ->paginate(15))
            ->withUser($user)
            ->withQ($q);

    }

    public function songs($username, Request $request) {
        $this->validate($request, [
            'o' => 'in:date-asc,date-desc,setlist_items_count-asc,setlist_items_count-desc',
            'q' => 'string|min:3',
        ]);
        $v = Validator::make(['username' => $username], [
            'username' => [
                'required',
                Rule::exists('users'),
            ],
        ]);

        if($v->fails()) {
            return Redirect::to('/')->withErrors($v);
        }
        $user = User::where('username', '=', $username)->first();
        $q = $request->q;

        $results = DB::select(DB::raw(
            "SELECT COUNT(title) AS setlist_items_count,
                    COUNT(*)     AS total_count,
                    s.id,
                    s.title
             FROM songs s
             JOIN setlist_items si ON s.id = si.song_id
             JOIN show_user su     ON su.show_id = si.show_id
             JOIN shows sh         ON si.show_id = sh.id
             WHERE su.user_id = {$user->id}
             AND sh.date LIKE '%{$q}%'
             GROUP BY s.title, s.id
             ORDER BY setlist_items_count DESC, title asc"));

        $page = $request->page ?: 1; // Get the ?page=1 from the url
        $perPage = 15; // Number of items per page
        $offset = ($page * $perPage) - $perPage;
        $songs = new Collection($results);
        $paginate = new LengthAwarePaginator(
            array_slice($songs->toArray(), $offset, $perPage, true),
            count($songs), // Total items
            $perPage, // Items per page
            $page, // Current page
            ['path' => $request->url(), 'query' => $request->query()]
        );
        return view('user.songs')
            ->withSongs($paginate)
            ->withUser($user)
            ->withQ($q);
    }

    public function settings(Request $request) {
        return view('user.settings')
            ->withUser($request->user());
    }

    public function update(Request $request) {
        $v = Validator::make($request->all(), [
            'username' => [
                'required',
                'string',
                'min:3',
                'max:20',
                'alphanum',
                Rule::unique('users')->ignore($request->user()->id),
            ],
        ]);
        if($v->fails()) {
            return Redirect::back()
                ->withErrors($v);
        }

        $request->user()->username = $request->username;
        $request->user()->save();
        Session::flash('flash_message', 'Username saved.  Thanks!');
        return redirect('/');
    }
}
