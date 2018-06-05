<?php

namespace ShowDb\Http\Controllers;

use Illuminate\Http\Request;

use ShowDb\Album;
use ShowDb\AlbumItem;
use ShowDb\Song;
use ShowDb\AlbumNote;
use ShowDb\AlbumItemNote;
use Session;
use Redirect;
use Auth;
use Carbon\Carbon;

class AlbumController extends Controller
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
            'updateNote',
            'destroy',
            'storeItemNote',
            'updateItemNote',
        ]);
        $this->middleware('auth')->only([
            'storeNote',
            'destroyNote',
        ]);
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
            'o' => 'in:release_date-asc,release_date-desc,album_items_count-asc,album_items_count-desc',
            'q' => 'string|min:3',
        ]);

        $q = $request->get('q');
        $o = $request->get('o') ?: 'release_date-desc';
        $sort_order = explode('-', $o);
        $search = Album::withCount('albumItems')
                ->withCount('notes');
        foreach(preg_split('/\s+/', trim($q)) as $p) {
            $search = $search
                    ->where(function($q1) use ($p) {
                        $q1->where( 'release_date',   'LIKE', "%{$p}%" )
                            ->orWhere('title', 'LIKE', "%{$p}%")
                            ->orWhereHas('albumItems', function($query) use ($p) {
                                $query->whereHas('song', function($query) use ($p) {
                                    $query->where('songs.title', 'LIKE', "%{$p}%");
                                });
                            })
                            ->orWhereHas('notes', function($query) use ($p) {
                                $query->where('note', 'LIKE', "%{$p}%")
                                      ->where('note', 'NOT LIKE', '%<img src="data:%');
                            });
                    });

        }
        $search = $search->orderBy($sort_order[0], $sort_order[1])
               ->orderBy('release_date', 'desc')
               ->paginate(15)
               ->setPath( '' )
                ->appends( [
                    'q' => $request->get('q'),
                    'o' => $request->get('o'),
                ]);

        $item_order = 'album_items_count-asc';
        if( $o === $item_order ) {
            $item_order = 'album_items_count-desc';
        }

        $date_order = 'release_date-asc';
        if( $o === $date_order ) {
            $date_order = 'release_date-desc';
        }

        return view('album.index')
            ->withAlbums($search)
            ->withQuery($q)
            ->withAlbumItemOrder($item_order)
            ->withDateOrder($date_order)
            ->withUser($request->user());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // handled by index!
        return redirect('/albums');
    }

    /**
     * Store a show note.
     * @param integer                    $show_id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeNote($album_id, Request $request) {
        $this->validate($request, [
            'notes.*' => 'string|between:5,2000000',
        ]);

        $cnt = 0;
        foreach( $request->notes as $note ) {
            if( trim($note) === '') {
                continue;
            }
            $albumnote = new AlbumNote();
            $albumnote->note = $note;
            $albumnote->album_id = $album_id;
            $albumnote->creator_id = $request->user()->id;
            $albumnote->type = 'public';
            $albumnote->published = 0;
            $albumnote->order = 0; // not yet utilized
            $albumnote->save();
            $cnt++;
        }

        if($cnt) {
            Session::flash('flash_message', 'Album Note(s) added');
        } else {
            Session::flash('flash_error', 'Album Note(s) were empty');
        }
        return Redirect::back();

    }

    /**
     * Update an album note.
     *
     * @param integer                    $show_id
     * @param integer                    $note_id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateNote($album_id, $note_id, Request $request) {
        $this->validate($request, [
            'note'      => 'string|between:5,2000000',
            'published' => 'boolean',
        ]);

        $note = AlbumNote::findOrFail($note_id);
        if( $note->album->id != $album_id ) {
            Session::flash('flash_error', "Album/Note mismatch");
            return Redirect::back();
        }

        if($request->has('published')) {
            $note->published = $request->published;
        } else {
            $note->published = 0;
        }

        if($request->has('note')) {
            $note->note = $request->note;
        }
        $note->save();
        Session::flash('flash_message', 'Album Note Edited');
        return Redirect::back();
    }

    /**
     * Store a setlist item video link.
     *
     * @param  integer                   $setlist_item_id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeItemNote($album_item_id, Request $request) {
        $this->validate($request, [
            'item_note' => 'required',
        ]);

        $note = new AlbumItemNote();
        $note->note = $request->item_note;
        $note->album_item_id = $album_item_id;
        $note->published = 0;
        $note->creator_id = $request->user()->id;
        $note->order = 1;
        $note->save();
        Session::flash('flash_message', 'Album Item Note saved');
        return Redirect::back();
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
            'dates.*'  => 'required',
            'titles.*' => 'required|string|between:3,255',
        ]);

        if(count($request->titles) !== count($request->dates) ) {
            Session::flash('flash_error', 'Data size mismatch :(');
            return redirect('/albums');
        }

        $album_count = count($request->dates);
        for( $i=0; $i < $album_count; $i++ ) {
            try {
                $date = (new Carbon($request->dates[$i]))->toDateString();
            } catch(\Exception $e) {
                Session::flash('flash_error', 'Failed to parse date: ' . $request->dates[$i]);
                return Redirect::back();
            }
            $album = new Album();
            $album->release_date  = $date;
            $album->title = $request->titles[$i];
            $album->asin  = '';
            $album->save();
        }

        Session::flash('flash_message', 'Album(s) Added');
        return redirect('/albums');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $user = $request->user();
        $album = Album::find($id);

        if(is_null($album)) {
            Session::flash('flash_error','Album not found');
            return redirect('/songs');
        }

        return view('album.show')
            ->withAlbum($album)
            ->withUser($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $album = Album::find($id);

        if(is_null($album)) {
            Session::flash('flash_error','Album not found');
            return redirect('/album');
        }

        return view('album.edit')->withAlbum($album);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  integer                   $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        # Validate
        $this->validate($request, [
            'date'    => 'required',
            'title'   => 'required|string|between:3,255',
            'songs.*' => 'exists:songs,title',
        ]);

        try {
            $date = (new Carbon($request->date))->toDateString();
        } catch(\Exception $e) {
            Session::flash('flash_error', 'Failed to parse date: ' . $request->date);
            return Redirect::back();
        }

        $album = Album::find($id);
        $album->title = $request->input('title');
        $album->release_date = $date;
        $album->description = $request->description ?? null;
        $album->spotify_link = $request->spotify_link ?? null;
        $album->type = $request->type ?? 'studio';
        $items = $album->albumItems->sortBy('order');

        $i = 1;
        $safe = [];

        // algorithm:
        // * loop over request songs array
        // * Look for the song in the existing Album setlist
        // * If found, update the item play order (if needed)
        // * If not found, add the new item with correct play order
        // * Keep track of which items are "good"
        // * Delete any left over (removed) setlist items.
        if(is_array($request->songs)) {

	    $tracker = [];
            foreach($request->songs as $song_title) {
                if( trim($song_title) === '' ) {
                    continue;
                }
		if( !isset($tracker[$song_title]) ) {
		    $tracker[$song_title] = 0;
		}
                $my_items = $items->filter(function($item) use($song_title) {
                    return $item->song->title === $song_title;
                });

		if( count($my_items) <= 1 ) {
		    $my_item = $my_items->first();
                } else {
		    $my_item = $my_items->get($tracker[$song_title]);
		    $tracker[$song_title] += 1;
		}

                if( $my_item === null ) {
                    // Add new item!
                    $item = new AlbumItem();
                    $item->album_id = $id;
                    $item->song_id = Song::where('title', '=', $song_title)->first()->id;
                    $item->order   = $i;
                    $item->creator_id = $request->user()->id;
                    $item->save();
                } else {
                    // Update the item order
                    if($my_item->order != $i) {
                        $my_item->order = $i;
                        $my_item->save();
                    }
                    // We don't want to delete the "safe" items.
                    $safe[] = $my_item->id;
                }
                $i++;
            }
            $to_delete = $items->filter(function($item) use($safe) {
                return !in_array($item->id, $safe);
            });

            foreach( $to_delete as $item ) {
                $item->delete();
            }
        }
        $album->save();

        Session::flash('flash_message', 'Changes saved');
        return redirect('/albums/' . $album->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer                   $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Album::find($id)->delete();
        Session::flash('flash_message', 'Album Deleted');
        return redirect('/albums');

    }

    /**
     * Delete a show note.
     *
     * @param integer                    $album_id
     * @param integer                    $note_id
     * @return \Illuminate\Http\Response
     */
    public function destroyNote($album_id, $note_id) {
        $note = AlbumNote::findOrFail($note_id);
        if( $note->album->id != $album_id ) {
            Session::flash('flash_error', "boo");
            return Redirect::back();
        }

        if( !Auth::user()->admin ) {
            if( $note->user_id != Auth::user()->id ) {
                Session::flash('flash_error', 'Sorry, you can only delete notes you have created');
                return Redirect::back();
            }
        }

        $note->delete();
        Session::flash('flash_message', 'Note Deleted');
        return Redirect::back();
    }


    /**
     * Approve a setlist item note.
     *
     * @param integer                    $item_id
     * @param integer                    $note_id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function approveItemNote($item_id, $note_id, Request $request) {
        $this->validate($request, [
            'published' => 'required:boolean'
        ]);
        $note = AlbumItemNote::findOrFail($note_id);
        if( $note->albumItem->id != $item_id ) {
            Session::flash('flash_error', "Album/Note mismatch");
            return Redirect::back();
        }

        $note->published = $request->published;
        $note->save();

        Session::flash('flash_message', 'Note Approved');
        return Redirect::back();
    }

    /**
     * Delete a setlist item note.
     *
     * @param integer                    $item_id
     * @param integer                    $note_id
     * @return \Illuminate\Http\Response
     */
    public function destroyItemNote($item_id, $note_id) {
        $note = AlbumItemNote::findOrFail($note_id);
        if( $note->albumItem->id != $item_id ) {
            Session::flash('flash_error', "Wrong item_id/note_id");
            return Redirect::back();
        }

        if( !Auth::user()->admin ) {
            if( $note->user_id != Auth::user()->id ) {
                Session::flash('flash_error', 'Sorry, you can only delete notes you have created');
                return Redirect::back();
            }
        }

        $note->delete();
        Session::flash('flash_message', 'Note Deleted');
        return Redirect::back();
    }
}
