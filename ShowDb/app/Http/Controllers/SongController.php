<?php

namespace ShowDb\Http\Controllers;

use Auth;
use DB;
use Illuminate\Http\Request;
use Redirect;
use Session;
use ShowDb\Show;
use ShowDb\Song;
use ShowDb\SongNote;
use Storage;

class SongController extends Controller
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->middleware('admin')->only([
            'create',
            'store',
            'edit',
            'update',
            'destroy',
            'updateNote',
        ]);
        $this->middleware('auth')->only([
            'destroyNote',
            'storeNote',
        ]);
    }

    private function _getSongPlaysByYear($song_id)
    {
        $plays_by_year = DB::select(DB::raw(
            "SELECT SUBSTRING(date,1,4) AS year, COUNT(si.id) AS song_count
             FROM shows sh
             JOIN setlist_items si ON si.show_id = sh.id
             WHERE sh.user_id IS NULL
             AND (si.song_id = {$song_id} OR si.interlude_song_id = {$song_id})
             GROUP BY year
             ORDER BY year ASC"
        ));

        $graph_data = [['Year', 'Plays', (object) ['role' => 'style']]];
        $last_year = 0;
        foreach ($plays_by_year as $info) {
            while ($last_year > 0 && $last_year < $info->year - 1) {
                $graph_data[] = [++$last_year, 0, '#377bb5'];
            }
            $graph_data[] = [$info->year, $info->song_count, '#377bb5'];
            $last_year = $info->year;
        }

        return $graph_data;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->validate($request, [
            'o' => 'in:title-asc,title-desc,setlist_items_count-asc,setlist_items_count-desc',
            'q' => 'string|min:3',
        ]);
        $q = $request->get('q');
        $o = $request->get('o') ?: 'setlist_items_count-desc';
        $p = $request->get('page');
        $sort_order = explode('-', $o);

        $songs = \Cache::get("songs-index-$q-$o-$p");
        if ($songs === null) {
            $songs = Song::select(\DB::raw('*, (select count(*) from setlist_items si, shows s where s.id = si.show_id and (si.song_id = songs.id OR si.interlude_song_id = songs.id) and s.user_id is null) as setlist_items_count'))
                   ->withCount('notes');
            if($q != "") {
              $songs = $songs->where('title', 'LIKE', '%'.$q.'%')
                             ->orWhere('lyrics', 'LIKE', '%'.$q.'%');
            }
            $songs = $songs->orderBy($sort_order[0], $sort_order[1])
            ->orderBy('title')
            ->paginate(15)
            ->setPath('');

            \Cache::put("songs-index-$q-$o-$p", $songs, 60 * 24);
        }
        $pagination = $songs->appends([
            'q' => $q,
            'o' => $o,
        ]);

        $setlist_order = 'setlist_items_count-asc';
        if ($o === $setlist_order) {
            $setlist_order = 'setlist_items_count-desc';
        }

        $title_order = 'title-asc';
        if ($o === $title_order) {
            $title_order = 'title-desc';
        }

        return view('song.index')
            ->withSongs($songs)
            ->withQuery($q)
            ->withSetlistItemOrder($setlist_order)
            ->withTitleOrder($title_order)
            ->withUser($request->user());
    }

    /**
     * Redirect user to correct show listing for a given song.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function findPlays(Request $request)
    {
        $this->validate($request, [
            'title' => 'exists:songs',
            'username' => 'exists:users',
        ]);

        $song_id = Song::where('title', '=', $request->title)->first()->id;
        $prefix = '';
        if ($request->username) {
            $prefix = '/stats/'.$request->username;
        }

        return redirect($prefix.'/songs/'.$song_id.'/plays');
    }

    /**
     * Display the shows where a given song was played.
     *
     * @param int                    $song_id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function showPlays($song_id, Request $request)
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
        })->whereNull('user_id')
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
            ->withUser($request->user());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // handled on the index page!
        return $this->redirect('songs.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'songs.*' => 'required|unique:songs,title|max:255',
        ]);

        foreach ($request->songs as $title) {
            $song = new Song();
            $song->title = $title;
            $song->creator_id = $request->user()->id;
            $song->save();
        }
        Session::flash('flash_message', 'Changes saved');

        return redirect('/songs');
    }

    /**
     * Display the specified resource.
     *
     * @param  int                      $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $user = $request->user();
        $song = Song::find($id);

        if (is_null($song)) {
            Session::flash('message', 'Song not found');

            return redirect('/songs');
        }

        $videos = [];
        $videos = $song->setlistItemNotes()->get();

        return view('song.show')
            ->withSong($song)
            ->withUser($user)
            ->withVideos($videos)
            ->withSongStats($this->_getSongPlaysByYear($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $song = Song::find($id);

        if (is_null($song)) {
            Session::flash('message', 'Book not found');

            return redirect('/songs');
        }

        return view('song.edit')->withSong($song);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int                   $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate
        $this->validate($request, [
            'title' => 'required|between:1,255',
        ]);

        $song = Song::find($id);
        if ($request->snip) {
            $snip = $request->snip;
            $snipName = $snip->storeAs('/audio', "{$snip->hashName()}.mp3", 's3');
            $song->snipUrl = storage::disk('s3')->url($snipName);
        }

        $song->title = $request->title;
        $song->spotify_link = $request->spotify_link ?? null;
        $song->lyrics = $request->lyrics ?? null;
        $song->save();

        Session::flash('flash_message', 'Changes saved');

        return redirect('/songs/'.$song->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Song::find($id)->delete();
        Session::flash('flash_message', 'Song Deleted');

        return redirect('/songs');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int                  $song_id
     * @param  int                  $note_id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateNote($song_id, $note_id, Request $request)
    {
        $this->validate($request, [
            'note' => 'string|between:5,2000000',
            'published' => 'boolean',
        ]);
        $note = SongNote::findOrFail($note_id);
        if ($note->song->id != $song_id) {
            Session::flash('flash_message', 'Song/Note mismatch');

            return Redirect::back();
        }

        if ($request->has('published')) {
            $note->published = $request->published;
        } else {
            $note->published = 0;
        }

        if ($request->has('note')) {
            $note->note = $request->note;
        }

        $note->save();

        Session::flash('flash_message', 'Song Note Edited');

        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function storeNote($id, Request $request)
    {
        $this->validate($request, [
            'notes.*' => 'string|between:5,2000000',
        ]);

        $cnt = 0;
        foreach ($request->notes as $note) {
            if (trim($note) === '') {
                continue;
            }
            $songnote = new SongNote();
            $songnote->note = $note;
            $songnote->song_id = $id;
            $songnote->creator_id = $request->user()->id;
            $songnote->user_id = $request->user()->id;
            $songnote->type = 'public';
            $songnote->published = 0;
            $songnote->order = 0;
            $songnote->save();
            $cnt++;
        }

        if ($cnt) {
            Session::flash('flash_message', 'Song Note(s) added');
        } else {
            Session::flash('flash_message', 'Song Note(s) were empty');
        }

        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $song_id
     * @param  int $note_id
     * @return \Illuminate\Http\Response
     */
    public function destroyNote($song_id, $note_id)
    {
        $note = SongNote::findOrFail($note_id);
        if ($note->song->id != $song_id) {
            Session::flash('flash_message', 'boo');

            return Redirect::back();
        }

        if (! Auth::user()->admin) {
            if ($note->user_id != Auth::user()->id) {
                Session::flash('flash_message', 'Sorry, you can only delete notes you have created');

                return Redirect::back();
            }
        }

        $note->delete();
        Session::flash('flash_message', 'Note Deleted');

        return Redirect::back();
    }
}
