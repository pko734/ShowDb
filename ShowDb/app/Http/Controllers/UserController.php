<?php

namespace ShowDb\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Redirect;
use Session;
use ShowDb\Album;
use ShowDb\Badge;
use ShowDb\Show;
use ShowDb\Song;
use ShowDb\State;
use ShowDb\User;
use Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('username')->except(['settings', 'update']);
    }

    public function storeShow($show_id, Request $request)
    {
        $request->user()->shows()->syncWithoutDetaching([$show_id]);

        return Redirect::back();
    }

    public function destroyShow($show_id, Request $request)
    {
        $request->user()->shows()->detach($show_id);

        return Redirect::back();
    }

    public function storeMerch($merch_id, Request $request)
    {
        // only one mode per user/merch
        if($request->user()->merch()->wherePivot('mode', '!=', $request->mode)->exists()) {
            $request->user()->merch()->where('mode', '!=', $request->mode)->detach($merch_id);
        }

        // only attach if not already attached
        if(!$request->user()->merch()->wherePivot('mode', '=', $request->mode)->where('merch_id', '=', $merch_id)->exists()) {
            $request->user()->merch()->attach([$merch_id], ['mode' => $request->mode]);
        }

        return '1';
    }

    public function destroyMerch($merch_id, Request $request)
    {
        $request->user()->merch()->where('mode', '=', $request->mode)->detach($merch_id);

        return '1';
    }

    private function _getMySongs($user)
    {
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

    private function _getMyTotalSongs($user)
    {
        return DB::select(DB::raw(
            "SELECT COUNT(title) AS total_count
             FROM songs s
             JOIN setlist_items si ON s.id = si.song_id
             JOIN show_user su     ON su.show_id = si.show_id
             WHERE su.user_id = {$user->id}"
        ))[0]->total_count;
    }

    private function _getMyShowsByYear($user)
    {
        return DB::select(DB::raw(
            "SELECT SUBSTRING(date,1,4) AS year, count(sh.id) AS show_count
             FROM shows sh
             JOIN show_user su ON sh.id = su.show_id
             WHERE su.user_id = {$user->id}
             AND sh.user_id IS NULL
             GROUP BY year
             ORDER BY year asc"
        ));
    }

    private function _getMySongsByYear($user)
    {
        return DB::select(DB::raw(
            "SELECT SUBSTRING(date,1,4) AS year, count(si.id) AS song_count
             FROM shows sh
             JOIN show_user su ON sh.id = su.show_id
             JOIN setlist_items si ON si.show_id = su.show_id
             WHERE su.user_id = {$user->id}
             AND sh.user_id IS NULL
             GROUP BY year
             ORDER BY year asc"
        ));
    }

    private function _getMyUniqueSongsByYear($user)
    {
        return DB::select(DB::raw(
            "SELECT SUBSTRING(date,1,4) AS year, COUNT(DISTINCT s.title) as unique_songs
             FROM shows sh
             JOIN show_user su ON sh.id = su.show_id
             JOIN setlist_items si ON si.show_id = su.show_id
             JOIN songs s on si.song_id = s.id
             WHERE su.user_id = {$user->id}
             AND sh.user_id IS NULL
             GROUP BY year
             ORDER BY year asc"
        ));
    }

    private function _getAllSongs()
    {
        return DB::select(DB::raw(
            'SELECT COUNT(title) AS setlist_items_count,
                    s.id,
                    s.title
             FROM songs s
             JOIN setlist_items si ON s.id = si.song_id
             GROUP BY s.title, s.id
             ORDER BY setlist_items_count DESC'));
    }

    private function _getAllTotalSongs()
    {
        return DB::select(DB::raw(
            'SELECT COUNT(title) AS total_count
             FROM songs s
             JOIN setlist_items si ON s.id = si.song_id'
        ))[0]->total_count;
    }

    private function _getAllShowsByYear()
    {
        return DB::select(DB::raw(
            'SELECT SUBSTRING(date,1,4) AS year, count(sh.id) AS show_count
             FROM shows sh
             WHERE sh.user_id IS NULL
             GROUP BY year
             ORDER BY year asc'
        ));
    }

    private function _getAllSongsByYear()
    {
        return DB::select(DB::raw(
            'SELECT SUBSTRING(date,1,4) AS year, count(si.id) AS song_count
             FROM shows sh
             JOIN setlist_items si ON si.show_id = sh.id
             WHERE sh.user_id IS NULL
             GROUP BY year
             ORDER BY year asc'
        ));
    }

    private function _getAllUniqueSongsByYear()
    {
        return DB::select(DB::raw(
            'SELECT SUBSTRING(date,1,4) AS year, COUNT(DISTINCT s.title) as unique_songs
             FROM shows sh
             JOIN setlist_items si ON si.show_id = sh.id
             JOIN songs s on si.song_id = s.id
             WHERE sh.user_id IS NULL
             GROUP BY year
             ORDER BY year asc'
        ));
    }

    public function index(Request $request)
    {
        return $this->_showUserStats($request->user());
    }

    /**
     * Display the shows where a given song was played.
     *
     * @param int                    $song_id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function showPlays($username, $song_id, Request $request)
    {
        $this->validate($request, [
            'd' => 'in:asc,desc',
        ]);
        $song = Song::findOrFail($song_id);
        $o = $request->get('o') ?: 'date';
        $d = $request->get('d') ?: 'desc';

        $user = User::where('username', '=', $username)->first();

        $shows = Show::whereHas('setlistItems', function ($query) use ($song_id) {
            $query->where('song_id', '=', $song_id)
                ->orWhere('interlude_song_id', '=', $song_id);
        })->whereHas('users', function ($query) use ($user) {
            $query->where('user_id', '=', $user->id);
        })
               ->whereNull('user_id')
               ->withCount('setlistItems')
               ->withCount('notes')
               ->orderBy($o, $d)
               ->orderBy('date', 'desc')
               ->paginate(15)
               ->setPath('');

        $pagination = $shows->appends([
            'd' => $d,
        ]);

        return view('song.plays')
            ->withSong($song)
            ->withShows($shows)
            ->withOrderBy($o)
            ->withUserRestriction($request->user())
            ->withUser($request->user());
    }

    /**
     * Display the shows where a given song was played.
     *
     * @param int                    $song_id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function showPlaysAll($song_id, Request $request)
    {
        $this->validate($request, [
            'd' => 'in:asc,desc',
        ]);
        $song = Song::findOrFail($song_id);
        $o = $request->get('o') ?: 'date';
        $d = $request->get('d') ?: 'desc';

        $shows = Show::whereHas('setlistItems', function ($query) use ($song_id) {
            $query->where('song_id', '=', $song_id)
                ->orWhere('interlude_song_id', '=', $song_id);
        })
               ->whereNull('user_id')
               ->withCount('setlistItems')
               ->withCount('notes')
               ->orderBy($o, $d)
               ->orderBy('date', 'desc')
               ->paginate(15)
               ->setPath('');

        $pagination = $shows->appends([
            'd' => $d,
        ]);

        return view('song.plays')
            ->withSong($song)
            ->withShows($shows)
            ->withOrderBy($o)
            ->withUserRestriction((object) ['username' => 'all', 'id' => 0])
            ->withUser((object) ['username' => 'all', 'id' => 0]);
    }

    public function userstats($username, Request $request)
    {
        $v = Validator::make(['username' => $username], [
            'username' => [
                'required',
                Rule::exists('users'),
            ],
        ]);

        if ($v->fails()) {
            return Redirect::to('/')->withErrors($v);
        }

        return $this->_showUserStats(User::where('username', '=', $username)->first());
    }

    private function _calcYearlyGraphData($shows_by_year,
                                          $songs_by_year,
                                          $unique_songs_by_year,
                                          &$yearly_graph_data,
                                          &$max_shows,
                                          &$max_songs,
                                          &$max_unique)
    {
        foreach ($shows_by_year as $info) {
            $song_count = 0;
            $unique_songs = 0;
            foreach ($songs_by_year as $s) {
                if ($s->year === $info->year) {
                    $song_count = $s->song_count;
                    break;
                }
            }
            foreach ($unique_songs_by_year as $u) {
                if ($u->year === $info->year) {
                    $unique_songs = $u->unique_songs;
                    break;
                }
            }

            if ($info->show_count > 0) {
                $yearly_graph_data['shows'][] = [$info->year, $info->show_count, '#377bb5'];
            }
            if ($song_count > 0) {
                $yearly_graph_data['songs'][] = [$info->year, $song_count, '#377bb5'];
            }
            if ($unique_songs > 0) {
                $yearly_graph_data['unique_songs'][] = [$info->year, $unique_songs, '#377bb5'];
            }

            if ($max_shows < $info->show_count) {
                $max_shows = $info->show_count;
            }
            if ($max_songs < $song_count) {
                $max_songs = $song_count;
            }
            if ($max_unique < $unique_songs) {
                $max_unique = $unique_songs;
            }
        }
    }

    private function _getMyCovers($user)
    {
        return count(DB::select(DB::raw(
            "SELECT COUNT(title) AS setlist_items_count,
                    s.id,
                    s.title
             FROM songs s
             JOIN setlist_items si ON s.id = si.song_id
             JOIN show_user su     ON su.show_id = si.show_id
             JOIN shows sh         ON si.show_id = sh.id
             WHERE su.user_id = {$user->id}
             AND s.title LIKE '%cover)%'
             GROUP BY s.title, s.id
             ORDER BY setlist_items_count DESC, title asc")));
    }

    private function _showUserStats($user)
    {
        $songs = $this->_getMySongs($user);
        $total_songs = $this->_getMyTotalSongs($user);
        $shows_by_year = $this->_getMyShowsByYear($user);
        $songs_by_year = $this->_getMySongsByYear($user);
        $unique_songs_by_year = $this->_getMyUniqueSongsByYear($user);
        $covers = $this->_getMyCovers($user);

        $yearly_graph_data = [
            'shows'        => [['Year', 'Shows', (object) ['role' => 'style']]],
            'songs'        => [['Year', 'Songs', (object) ['role' => 'style']]],
            'unique_songs' => [['Year', 'Unique Songs', (object) ['role' => 'style']]],
        ];
        $max_shows = 0;
        $max_unique = 0;
        $max_songs = 0;
        $song_count = 0;
        $unique_songs = 0;

        $this->_calcYearlyGraphData($shows_by_year,
                                    $songs_by_year,
                                    $unique_songs_by_year,
                                    $yearly_graph_data,
                                    $max_shows,
                                    $max_songs,
                                    $max_unique);

        $state_graph_data = $this->_getStateGraphData($user);

        $user_id = $user->id;
        $first_show = Show::whereHas('users', function ($query) use ($user_id) {
            $query->where('user_id', '=', $user_id);
        })
                    ->whereNull('user_id')
                    ->whereRaw('UNIX_TIMESTAMP(date) < ?', \Carbon\Carbon::now()->timestamp)
                    ->orderBy('date', 'asc')
                    ->first();

        $last_show = Show::whereHas('users', function ($query) use ($user_id) {
            $query->where('user_id', '=', $user_id);
        })
                   ->whereNull('user_id')
                   ->whereRaw('UNIX_TIMESTAMP(date) < ?', \Carbon\Carbon::now()->timestamp)
                   ->orderBy('date', 'desc')
                   ->first();

        $next_show = Show::whereHas('users', function ($query) use ($user_id) {
            $query->where('user_id', '=', $user_id);
        })
                   ->whereNull('user_id')
                   ->whereRaw('UNIX_TIMESTAMP(date) > ?', \Carbon\Carbon::now()->timestamp)
                   ->orderBy('date', 'asc')
                   ->first();

        $album_info = DB::select(DB::raw(
            "SELECT al.id as album_id,
                    al.title,
                    COUNT(DISTINCT so.title) AS album_songs,
                    (
                        SELECT COUNT(DISTINCT song_id)
                        FROM album_items
                        WHERE album_items.album_id = al.id
                    ) as total
             FROM
             albums al, album_items ai, songs so, setlist_items si, shows sh, show_user su
             WHERE al.id = ai.album_id
             AND ai.song_id = so.id
             AND (so.id = si.song_id OR so.id = si.interlude_song_id)
             AND si.show_id = sh.id
             AND sh.id = su.show_id
             AND su.user_id = {$user_id}
             AND al.type = 'studio'
             GROUP BY al.id, al.title
             ORDER BY release_date asc"
        ));

        $albums = Album::orderBy('release_date')
                ->where('type', '=', 'studio')
                ->get();

        $past_shows = $user->shows()
                    ->whereNull('shows.user_id')
                    ->whereRaw('UNIX_TIMESTAMP(date) < ?',
                               \Carbon\Carbon::now()->timestamp)->get();

        $photos = $user->images()->get();

        $this->_generateBadges($user, $album_info, $total_songs, count($songs), count($past_shows), count($photos));

        if (\Auth::user()->id == $user->id) {
            $back_button = false;
        } else {
            $back_button = true;
        }

        return view('user.index')
            ->withPastShows($past_shows)
            ->withUpcomingShows($user
                                ->shows()
                                ->whereNull('shows.user_id')
                                ->whereRaw('UNIX_TIMESTAMP(date) > ?',
                                           \Carbon\Carbon::now()->timestamp)->get())
            ->withIncompleteSetlistShows($user
                                         ->shows()
                                         ->whereNull('shows.user_id')
                                         ->where('incomplete_setlist', '=', true)
                                         ->whereRaw('UNIX_TIMESTAMP(date) < ?',
                                                    \Carbon\Carbon::now()->timestamp)->get())

            ->withUser($user)
            ->withBadges($user->badges()->get())
            ->withAlbumInfo($album_info)
            ->withAlbums($albums)
            ->withTotalSongs($total_songs)
            ->withFirstShow($first_show)
            ->withLastShow($last_show)
            ->withNextShow($next_show)
            ->withYearlyGraphData($yearly_graph_data)
            ->withStateGraphData($state_graph_data)
            ->withMaxUnique($max_unique)
            ->withMaxSongs($max_songs)
            ->withMaxShows($max_shows)
            ->withSongs($songs)
            ->withCovers($covers)
            ->withPhotos($photos)
            ->withBackButton($back_button);
    }

    private function _generateBadges($user, $album_info, $songs, $unique, $shows, $photos)
    {
        $user->badges()->detach();

        // early adopter badge
        if (strtotime($user->created_at) < strtotime('2017-02-01')) {
            $user->badges()->attach(Badge::where('code', '=', 'EARLY')->first()->id);
        }

        // donor badge
        if ($user->donor) {
            $user->badges()->attach(Badge::where('code', '=', 'DONOR')->first()->id);
        }

        // notes
        $note_count1 = DB::select(DB::raw(
            "SELECT COUNT(*) as cnt
                 FROM show_notes sn
                 WHERE sn.user_id = {$user->id}"
        ));
        $note_count2 = DB::select(DB::raw(
            "SELECT COUNT(*) as cnt
                 FROM song_notes sn
                 WHERE sn.user_id = {$user->id}"
        ));

        if ($note_count1[0]->cnt + $note_count2[0]->cnt > 10) {
            $Badge = Badge::where('code', '=', 'NOTE')->first();
            if ($Badge) {
                $user->badges()->attach($Badge->id);
            }
        }

        // album badges
        $i = 1;
        foreach ($album_info as $al) {
            if (round(100 * ($al->album_songs / $al->total)) == 100) {
                $Badge = Badge::where('code', '=', "ALBUM{$al->album_id}")->first();
                if ($Badge) {
                    $user->badges()->attach($Badge->id);
                }
            }
            $i++;
        }

        // year club
        $first_show_date = $user->shows()->min('date');
        if ($first_show_date) {
            $Badge = Badge::where('code', '=', 'YEAR'.substr($first_show_date, 0, 4))->first();
            if ($Badge) {
                $user->badges()->attach($Badge->id);
            }
        }

        // songs
        $song_code = 0;
        if ($songs >= 500 && $songs <= 999) {
            $song_code = 500;
        }
        if ($songs >= 1000 && $songs <= 1499) {
            $song_code = 1000;
        }
        if ($songs >= 1500 && $songs <= 1999) {
            $song_code = 1500;
        }
        if ($songs >= 2000 && $songs <= 2999) {
            $song_code = 2000;
        }
        if ($songs >= 3000 && $songs <= 3999) {
            $song_code = 3000;
        }
        if ($songs >= 4000 && $songs <= 4999) {
            $song_code = 4000;
        }
        if ($songs > 5000) {
            $song_code = 5000;
        }
        if ($song_code) {
            $Badge = Badge::where('code', '=', 'SONGS'.$song_code)->first();
            if ($Badge) {
                $user->badges()->attach($Badge->id);
            }
        }

        // unique songs
        $unique_code = 0;
        if ($unique >= 100 && $unique <= 149) {
            $unique_code = 100;
        }
        if ($unique >= 150 && $unique <= 199) {
            $unique_code = 150;
        }
        if ($unique >= 200 && $unique <= 249) {
            $unique_code = 200;
        }
        if ($unique >= 250 && $unique <= 299) {
            $unique_code = 250;
        }
        if ($unique >= 300) {
            $unique_code = 300;
        }
        if ($unique_code) {
            $Badge = Badge::where('code', '=', 'UNIQUE'.$unique_code)->first();
            if ($Badge) {
                $user->badges()->attach($Badge->id);
            }
        }

        // shows
        $show_code = 0;
        if ($shows >= 10 && $shows <= 24) {
            $show_code = 10;
        }
        if ($shows >= 25 && $shows <= 49) {
            $show_code = 25;
        }
        if ($shows >= 50 && $shows <= 74) {
            $show_code = 50;
        }
        if ($shows >= 75 && $shows <= 99) {
            $show_code = 75;
        }
        if ($shows >= 100) {
            $show_code = 100;
        }
        if ($show_code) {
            $Badge = Badge::where('code', '=', 'SHOWS'.$show_code)->first();
            if ($Badge) {
                $user->badges()->attach($Badge->id);
            }
        }

        // photos
        $photo_code = 0;
        if ($photos >= 1 && $photos <= 4) {
            $photo_code = 1;
        }
        if ($photos >= 5 && $photos <= 9) {
            $photo_code = 5;
        }
        if ($photos >= 10 && $photos <= 19) {
            $photo_code = 10;
        }
        if ($photos >= 20 && $photos <= 29) {
            $photo_code = 20;
        }
        if ($photos >= 30 && $photos <= 39) {
            $photo_code = 30;
        }
        if ($photos >= 40 && $photos <= 49) {
            $photo_code = 40;
        }
        if ($photos >= 50) {
            $photo_code = 50;
        }
        if ($photo_code) {
            $Badge = Badge::where('code', '=', 'PHOTOS'.$photo_code)->first();
            if ($Badge) {
                $user->badges()->attach($Badge->id);
            }
        }

        // states
        $states = DB::table('states')
                ->join('shows', 'states.id', '=', 'shows.state_id')
                ->join('show_user', 'shows.id', '=', 'show_user.show_id')
                ->select('iso_3166_2 as code', 'country_code')
                ->distinct()
                ->where('show_user.user_id', '=', $user->id)
                ->whereRaw('UNIX_TIMESTAMP(shows.date) < ?', \Carbon\Carbon::now()->timestamp)
                ->orderBy('states.name')
                ->get();

        foreach ($states as $state) {
            $Badge = Badge::where('code', '=', 'STATE_'.$state->code.'_'.$state->country_code)->first();
            if ($Badge) {
                $user->badges()->attach($Badge->id);
            }
        }
    }

    private function _getStateGraphData($user = null)
    {
        $state_data = DB::table('states')
                    ->join('shows', 'states.id', '=', 'shows.state_id')
                    ->select('iso_3166_2 as code', 'country_code', 'name', DB::raw('COUNT(shows.id) as show_count'))
                    ->whereNull('shows.user_id')
                    ->whereRaw('UNIX_TIMESTAMP(shows.date) < ?', \Carbon\Carbon::now()->timestamp)
                    ->groupBy('code', 'country_code', 'name');

        if ($user !== null) {
            $state_data = $state_data->where('show_user.user_id', '=', $user->id)
                        ->join('show_user', 'shows.id', '=', 'show_user.show_id');
        }

        $state_data = $state_data->get();

        $results = [['State', 'Number of shows']];
        foreach ($state_data as $one_state) {
            $results[] = ["{$one_state->name}", $one_state->show_count];
        }

        return $results;
    }

    public function allstats(Request $request)
    {
        $songs = $this->_getAllSongs();
        $total_songs = $this->_getAllTotalSongs();
        $shows_by_year = $this->_getAllShowsByYear();
        $songs_by_year = $this->_getAllSongsByYear();
        $unique_songs_by_year = $this->_getAllUniqueSongsByYear();

        $yearly_graph_data = [
            'shows'        => [['Year', 'Shows', (object) ['role' => 'style']]],
            'songs'        => [['Year', 'Songs', (object) ['role' => 'style']]],
            'unique_songs' => [['Year', 'Unique Songs', (object) ['role' => 'style']]],
        ];
        $max_shows = 0;
        $max_unique = 0;
        $max_songs = 0;
        $song_count = 0;
        $unique_songs = 0;

        $this->_calcYearlyGraphData($shows_by_year,
                                    $songs_by_year,
                                    $unique_songs_by_year,
                                    $yearly_graph_data,
                                    $max_shows,
                                    $max_songs,
                                    $max_unique);

        $state_graph_data = $this->_getStateGraphData();

        $all_user_show_data = DB::table('show_user')
                            ->select(DB::raw('COUNT(show_id) as show_count'))
                            ->havingRaw('COUNT(show_id) < 300')
                            ->groupBy('user_id')->pluck('show_count')->toArray();

        array_unshift($all_user_show_data, 'People');
        $all_user_show_data = array_map(function ($x) {
            return [$x];
        }, $all_user_show_data);

        return view('user.allstats')
            ->withYearlyGraphData($yearly_graph_data)
            ->withStateGraphData($state_graph_data)
            ->withMaxShows($max_shows)
            ->withMaxSongs($max_songs)
            ->withMaxUnique($max_unique)
            ->withAllUserShowData($all_user_show_data)
            ->withPastShows(Show::whereRaw('UNIX_TIMESTAMP(date) < ?',
                                           \Carbon\Carbon::now()->timestamp)
                            ->whereNull('user_id')
                            ->get())
            ->withUpcomingShows(Show::whereRaw('UNIX_TIMESTAMP(date) > ?',
                                               \Carbon\Carbon::now()->timestamp)
                                ->whereNull('user_id')
                                ->get())
            ->withUser($request->user())
            ->withTotalSongs($total_songs)
            ->withSongs($songs);
    }

    public function timeline($username, Request $request)
    {
        $v = Validator::make(['username' => $username], [
            'username' => [
                'required',
                Rule::exists('users'),
            ],
        ]);

        if ($v->fails()) {
            return Redirect::to('/')->withErrors($v);
        }

        $user = User::where('username', '=', $username)->first();
        $shows = $user->shows()
               ->whereRaw('UNIX_TIMESTAMP(date) < ?', \Carbon\Carbon::now()->timestamp)
               ->orderBy('date')->get();

        $ta = ['title' => [], 'events' => []];
        if (count($user->images) > 0) {
            $title_image = $user->images->where('published', '=', '1')->random();
            $ta['title']['media']['url'] = $title_image->url;
            $ta['title']['media']['caption'] = $title_image->caption;
            $ta['title']['media']['credit'] = $title_image->photo_credit;
        }
        $ta['title']['text']['headline'] = "{$username}'s Avett Journey";
        $ta['title']['text']['text'] = count($shows).
                                     ' shows over '.
                                     $shows->pluck('date')->map(function ($date) {
                                         return substr($date, 0, 4);
                                     })->unique()->count().' years';

        foreach ($shows as $show) {
            $event = [];
            $stamp = strtotime($show->date);
            $event['start_date']['month'] = date('m', $stamp);
            $event['start_date']['day'] = date('d', $stamp);
            $event['start_date']['year'] = date('Y', $stamp);
            $event['text']['headline'] = $show->venue;

            $my_images = $show->images->where('user_id', '=', $user->id)->where('published', '=', '1');
            $all_images = $show->images->where('published', '=', '1');
            if (count($my_images) > 0) {
                $event['background'] = ['url' => $my_images->random()->url];
            } elseif (count($all_images) > 0) {
                $event['background'] = ['url' => $all_images->random()->url];
            }

            $videos = $show->setlistItemsNotes->where('published', '=', '1');
            if (count($videos) > 0) {
                $event['media']['url'] = $videos->random()->note;
                $event['media']['caption'] = 'One of '.count($videos).' videos from this day';
            }

            if (! isset($event['media'])) {
                if (count($my_images) > 1) {
                    $event['media']['url'] = $my_images->random()->url;
                    $event['media']['caption'] = $my_images->random()->caption;
                    $event['media']['credit'] = $my_images->random()->photo_credit;
                }
            }
            if (! isset($event['media'])) {
                if (count($all_images) > 1) {
                    $event['media']['url'] = $all_images->random()->url;
                    $event['media']['caption'] = $all_images->random()->caption;
                    $event['media']['credit'] = $all_images->random()->photo_credit;
                }
            }

            $text_text = '';

            $text_text .= '<hr><div class="setlist_open"><a href="#">Setlist</a></div><div style="display: none;" class="setlist">';
            $saw_encore = false;
            $no_songs = true;
            foreach ($show->setlistItems->sortBy('order') as $item) {
                if ($saw_encore === false && $item->encore) {
                    $text_text .= '<br/>';
                    $saw_encore = true;
                }
                $text_text .= "{$item->order}. {$item->song->title}<br/>";
                $no_songs = false;
            }
            if ($no_songs) {
                $text_text .= 'Setlist empty<br/>';
            }
            $text_text .= '</div>';
            if ($show->incomplete_setlist) {
                $text_text .= '<div>This setlist is incomplete  If you can help complete it let us know!</div>';
            }

            if (! @$event['background'] || ! @$event['media']) {
                $extra_text = '<br/>Help improve this page by adding photos from this show';
            } else {
                $extra_text = '';
            }

            $text_text .=
               "<hr><a href=\"/shows/{$show->id}\">View this show in the database <span class=\"fas fa-external-link-alt\"></span></a>{$extra_text}";

            $event['text']['text'] = $text_text;
            $ta['events'][] = $event;
        }

        return view('user.timeline')
            ->withUser($request->user())
            ->withTimeline($ta);
    }

    public function shows($username, Request $request)
    {
        $this->validate($request, [
            'o' => 'in:date-asc,date-desc,setlist_items_count-asc,setlist_items_count-desc',
            'q' => 'string|min:3',
            'i' => 'boolean',
        ]);

        $v = Validator::make(['username' => $username], [
            'username' => [
                'required',
                Rule::exists('users'),
            ],
        ]);

        if ($v->fails()) {
            return Redirect::to('/')->withErrors($v);
        }

        $user = User::where('username', '=', $username)->first();
        $q = $request->q;
        $shows = $user->shows()
               ->where('date', 'LIKE', "%{$q}%")
               ->withCount('setlistItems')
               ->withCount('notes');

        if ($request->get('i') == '1') {
            $shows = $shows->where('incomplete_setlist', '=', true);
        }

        $shows = $shows->orderBy('date', 'desc')
               ->paginate(15)
               ->setPath('')
               ->appends([
                   'q' => $request->get('q'),
                   'o' => $request->get('o'),
                   'i' => $request->get('i'),
               ]);

        return view('user.shows')
            ->withShows($shows)
            ->withUser($user)
            ->withDisplayComplete(true)
            ->withQ($q);
    }

    public function albums($username, Request $request)
    {
        $this->validate($request, [
            'id' => 'exists:albums',
        ]);
        $album_id = $request->id;
        $user = User::where('username', '=', $username)->first();

        $albums = Album::orderBy('release_date')->get();

        $songs = Song::whereHas('albumItems', function ($query) use ($album_id) {
            $query->where('album_id', '=', $album_id);
        })->get();

        $song_counts = [];
        foreach ($songs as $song) {
            $count = DB::select(DB::raw(
                "SELECT COUNT(*) AS setlist_items_count
                 FROM setlist_items si
                 JOIN show_user su ON su.show_id = si.show_id
                 WHERE su.user_id = {$user->id}
                 AND (si.song_id = {$song->id} OR si.interlude_song_id = {$song->id})"
            ));
            $song_counts[$song->id] = $count[0]->{'setlist_items_count'};
        }

        return view('user.albums')
            ->withAlbumId($album_id)
            ->withSongs($songs)
            ->withSongCounts($song_counts)
            ->withUser($user)
            ->withAlbums($albums);
    }

    public function songs($username, Request $request)
    {
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

        if ($v->fails()) {
            return Redirect::to('/')->withErrors($v);
        }
        $user = User::where('username', '=', $username)->first();
        $q = $request->q;

        if ($q == 'covers') {
            $q = 'cover)';
        }

        $results = DB::select(DB::raw(
            "SELECT COUNT(title) AS setlist_items_count,
                    COUNT(*)     AS total_count,
                    (SELECT count(*) FROM song_notes WHERE song_notes.song_id = s.id) AS notes_count,
                    s.id,
                    s.title
             FROM songs s
             JOIN setlist_items si ON s.id = si.song_id
             JOIN show_user su     ON su.show_id = si.show_id
             JOIN shows sh         ON si.show_id = sh.id
             WHERE su.user_id = {$user->id}
             AND (sh.date LIKE '%{$q}%' OR s.title LIKE '%{$q}%')
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

        if ($q == 'cover)') {
            $q = 'covers';
        }

        return view('user.songs')
            ->withSongs($paginate)
            ->withUser($user)
            ->withQ($q);
    }

    public function songsAll(Request $request)
    {
        $this->validate($request, [
            'o' => 'in:date-asc,date-desc,setlist_items_count-asc,setlist_items_count-desc',
            'q' => 'string|min:3',
        ]);

        $q = $request->q;

        $results = DB::select(DB::raw(
            "SELECT COUNT(title) AS setlist_items_count,
                    COUNT(*)     AS total_count,
                    (SELECT count(*) FROM song_notes WHERE song_notes.song_id = s.id) AS notes_count,
                    s.id,
                    s.title
             FROM songs s
             JOIN setlist_items si ON s.id = si.song_id
             JOIN shows sh         ON si.show_id = sh.id
             WHERE sh.date LIKE '%{$q}%'
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
            ->withUser((object) ['username' => 'all'])
            ->withQ($q);
    }

    public function settings(Request $request)
    {
        //        var_export($request->user());
        return view('user.settings')
            ->withUser($request->user());
    }

    public function update(Request $request)
    {
        $v = Validator::make($request->all(), [
            'username' => [
                'required',
                'string',
                'min:3',
                'max:20',
                'alphanum',
                Rule::unique('users')->ignore($request->user()->id),
            ],
            'email' => ['required', Rule::unique('users')->ignore($request->user()->id)],
            'name' => ['required', 'min:3'],
            'share' => ['boolean'],
        ]);
        if ($v->fails()) {
            return Redirect::back()
                ->withErrors($v);
        }

        $request->user()->username = $request->username;
        $request->user()->email = $request->email;
        $request->user()->name = $request->name;
        if ($request->share == '0' || $request->share == '1') {
            $request->user()->share = $request->share;
        }
        $request->user()->save();
        Session::flash('flash_message', 'Username saved.  Thanks!');

        return redirect('/settings');
    }
}
