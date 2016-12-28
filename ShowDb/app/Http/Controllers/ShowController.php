<?php

namespace ShowDb\Http\Controllers;

use Illuminate\Http\Request;
use ShowDb\Show;
use ShowDb\SetlistItem;
use ShowDb\Song;
use ShowDb\ShowNote;
use ShowDb\SetlistItemNote;
use Session;
use Redirect;
use Auth;
use Carbon\Carbon;

class ShowController extends Controller
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
            'storeVideo',
            'updateNote',
            'updateVideo',
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
            'o' => 'in:date-asc,date-desc,setlist_items_count-asc,setlist_items_count-desc',
            'q' => 'string|min:3',
        ]);

        $q = $request->get('q');
        $o = $request->get('o') ?: 'date-desc';
        $sort_order = explode('-', $o);
        $search = Show::withCount('setlistItems');
        foreach(preg_split('/\s+/', trim($q)) as $p) {
            $search = $search
                    ->where(function($q1) use ($p) {
                        $q1->where( 'date',   'LIKE', "%{$p}%" )
                            ->orWhere('venue', 'LIKE', "%{$p}%")
                            ->orWhereHas('notes', function($query) use ($p) {
                                $query->where('note', 'LIKE', "%{$p}%");
                            });
                    });

        }
        $search = $search->orderBy($sort_order[0], $sort_order[1])
               ->orderBy('date', 'desc')
               ->paginate(15)
               ->setPath( '' )
                ->appends( [
                    'q' => $request->get('q'),
                    'o' => $request->get('o'),
                ]);

        $setlist_order = 'setlist_items_count-asc';
        if( $o === $setlist_order ) {
            $setlist_order = 'setlist_items_count-desc';
        }

        $date_order = 'date-asc';
        if( $o === $date_order ) {
            $date_order = 'date-desc';
        }

        return view('show.index')
            ->withShows($search)
            ->withQuery($q)
            ->withSetlistItemOrder($setlist_order)
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
        return redirect('/shows');
    }

    /**
     * Store a show note.
     * @param integer                    $show_id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeNote($show_id, Request $request) {
        $this->validate($request, [
            'notes.*' => 'string|between:5,2000000',
        ]);

        $cnt = 0;
        foreach( $request->notes as $note ) {
            if( trim($note) === '') {
                continue;
            }
            $shownote = new ShowNote();
            $shownote->note = $note;
            $shownote->show_id = $show_id;
            $shownote->creator_id = $request->user()->id;
            $shownote->user_id = $request->user()->id;
            $shownote->type = 'public';
            $shownote->published = 0;
            $shownote->order = 0; // not yet utilized
            $shownote->save();
            $cnt++;
        }

        if($cnt) {
            Session::flash('flash_message', 'Show Note(s) added');
        } else {
            Session::flash('flash_error', 'Show Note(s) were empty');
        }
        return Redirect::back();

    }

    /**
     * Update a show note.
     *
     * @param integer                    $show_id
     * @param integer                    $note_id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateNote($show_id, $note_id, Request $request) {
        $this->validate($request, [
            'note'      => 'string|between:5,2000000',
            'published' => 'boolean'
        ]);

        $note = ShowNote::findOrFail($note_id);
        if( $note->show->id != $show_id ) {
            Session::flash('flash_error', "Show/Note mismatch");
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
        Session::flash('flash_message', 'Show Note Edited');
        return Redirect::back();
    }

    /**
     * Store a setlist item video link.
     *
     * @param  integer                   $setlist_item_id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeVideo($setlist_item_id, Request $request) {
        $this->validate($request, [
            'video_url' => 'active_url',
        ]);

        $note = new SetlistItemNote();
        $note->note = $request->video_url;
        $note->setlist_item_id = $setlist_item_id;
        $note->user_id = $request->user()->id;
        $note->published = 0;
        $note->creator_id = $request->user()->id;
        $note->order = 1;
        $note->save();
        Session::flash('flash_message', 'Video saved');
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
            'venues.*' => 'required|string|between:10,255',
        ]);

        if(count($request->venues) !== count($request->dates) ) {
            Session::flash('flash_error', 'Data size mismatch :(');
            return redirect('/shows');
        }

        $show_count = count($request->dates);
        for( $i=0; $i < $show_count; $i++ ) {
            try {
                $date = (new Carbon($request->dates[$i]))->toDateString();
            } catch(\Exception $e) {
                Session::flash('flash_error', 'Failed to parse date: ' . $request->dates[$i]);
                return Redirect::back();
            }
            $show = new Show();
            $show->date  = $date;
            $show->venue = $request->venues[$i];
            $show->published = 0;
            $show->save();
        }

        Session::flash('flash_message', 'Changes saved');
        return redirect('/shows');
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
        $show = Show::find($id);

        if(is_null($show)) {
            Session::flash('flash_error','Show not found');
            return redirect('/songs');
        }

        return view('show.show')
            ->withShow($show)
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
        $show = Show::find($id);

        if(is_null($show)) {
            Session::flash('flash_error','Show not found');
            return redirect('/show');
        }

        return view('show.edit')->withShow($show);
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
            'venue'   => 'required|string|between:10,255',
            'songs.*' => 'exists:songs,title',
        ]);

        try {
            $date = (new Carbon($request->date))->toDateString();
        } catch(\Exception $e) {
            Session::flash('flash_error', 'Failed to parse date: ' . $request->date);
            return Redirect::back();
        }

        $show = Show::find($id);
        $show->venue = $request->input('venue');
        $show->date  = $date;

        $items = $show->setlistItems->sortBy('order');

        $i = 1;
        $safe = [];

        // algorithm:
        // * loop over request songs array
        // * Look for the song in the existing Show setlist
        // * If found, update the item play order (if needed)
        // * If not found, add the new item with correct play order
        // * Keep track of which items are "good"
        // * Delete any left over (removed) setlist items.
        if(is_array($request->songs)) {
            foreach($request->songs as $song_title) {
                if( trim($song_title) === '' ) {
                    continue;
                }

                $my_item = $items->filter(function($item) use($song_title) {
                    return $item->song->title === $song_title;
                })->first();

                if( $my_item === null ) {
                    // Add new item!
                    $item = new SetlistItem();
                    $item->show_id = $id;
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
        $show->save();

        Session::flash('flash_message', 'Changes saved');
        return redirect('/shows');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer                   $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Show::find($id)->delete();
        Session::flash('flash_message', 'Show Deleted');
        return redirect('/shows');

    }

    /**
     * Delete a show note.
     *
     * @param integer                    $note_id
     * @param integer                    $show_id
     * @return \Illuminate\Http\Response
     */
    public function destroyNote($show_id, $note_id) {
        $note = ShowNote::findOrFail($note_id);
        if( $note->show->id != $show_id ) {
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
     * Approve a setlist item video.
     *
     * @param integer                    $item_id
     * @param integer                    $note_id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function approveVideo($item_id, $note_id, Request $request) {
        $this->validate($request, [
            'published' => 'required:boolean'
        ]);
        $note = SetlistItemNote::findOrFail($note_id);
        if( $note->setlistItem->id != $item_id ) {
            Session::flash('flash_error', "Video/Note mismatch");
            return Redirect::back();
        }

        $note->published = $request->published;
        $note->save();

        Session::flash('flash_message', 'Video Approved');
        return Redirect::back();
    }

    /**
     * Delete a setlist item video.
     *
     * @param integer                    $item_id
     * @param integer                    $note_id
     * @return \Illuminate\Http\Response
     */
    public function destroyVideo($item_id, $note_id) {
        $note = SetlistItemNote::findOrFail($note_id);
        if( $note->setlistItem->id != $item_id ) {
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
        Session::flash('flash_message', 'Video Deleted');
        return Redirect::back();
    }
}
