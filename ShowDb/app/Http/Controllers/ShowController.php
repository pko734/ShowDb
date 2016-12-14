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

class ShowController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->only([
            'create',
            'store',
            'edit',
            'update',
            'destroy',
            'storeVideo',
            'approveNote',
            'approveVideo',
        ]);
        $this->middleware('auth')->only([
            'destroyNote',
            'storeNote',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
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
        $shows = Show::withCount('setlistItems')
               ->where( 'date',   'LIKE', "%{$q}%" )
               ->orWhere('venue', 'LIKE', "%{$q}%")
               ->orWhereHas('notes', function($query) use ($q) {
                   $query->where('note', 'LIKE', "%{$q}%");
               })
               ->orderBy($sort_order[0], $sort_order[1])
               ->orderBy('date', 'desc')
               ->paginate(15)
               ->setPath( '' );
        $pagination = $shows->appends( [
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
            ->withShows($shows)
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
        $this->redirect('/');
    }

    public function storeNote($show_id, Request $request) {
        $this->validate($request, [
            'notes.*' => 'string|between:5,255',
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
            $shownote->order = 0;
            $shownote->save();
            $cnt++;
        }

        if($cnt) {
            Session::flash('flash_message', 'Show Note(s) added');
        } else {
            Session::flash('flash_message', 'Show Note(s) were empty');
        }
        return Redirect::back();

    }

    public function approveNote($show_id, $note_id, Request $request) {
        $this->validate($request, [
            'published' => 'required:boolean'
        ]);

        $note = ShowNote::findOrFail($note_id);
        if( $note->show->id != $show_id ) {
            Session::flash('flash_message', "Show/Note mismatch");
            return Redirect::back();
        }

        $note->published = $request->published;
        $note->save();
        Session::flash('flash_message', 'Show Note Approved');
        return Redirect::back();
    }

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
            'dates.*'  => 'required|date_format:"Y-m-d"',
            'venues.*' => 'required|string|between:10,255',
        ]);

        if(count($request->venues) !== count($request->dates) ) {
            Session::flash('flash_message', 'Data size mismatch :(');
            return redirect('/shows');
        }

        $show_count = count($request->dates);
        for( $i=0; $i < $show_count; $i++ ) {
            $show = new Show();
            $show->date  = $request->dates[$i];
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
            Session::flash('message','Book not found');
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
            Session::flash('message','Book not found');
            return redirect('/songs');
        }

        return view('show.edit')->withShow($show);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        # Validate
        $this->validate($request, [
            'date'    => 'required|date_format:"Y-m-d"',
            'venue'   => 'required|string|between:10,255',
            'songs.*' => 'exists:songs,title',
        ]);

        $show = Show::find($id);
        $show->venue = $request->input('venue');
        $show->date  = $request->input('date');

        $items = $show->setlistItems->sortBy('order');

        $i = 1;
        $safe = [];
        foreach($request->songs as $song_title) {
            if( trim($song_title) === '' ) {
                continue;
            }
            $my_item = $items->filter(function($item) use($song_title) {
                return $item->song->title === $song_title;
            })->first();

            if( $my_item === null ) {
                echo $song_title;
                $item = new SetlistItem();
                $item->show_id = $id;
                $item->song_id = Song::where('title', '=', $song_title)->first()->id;
                $item->order   = $i;
                $item->creator_id = $request->user()->id;
                $item->save();
            } else {
                if( $my_item->order != $i ) {
                    $my_item->order = $i;
                    $my_item->save();
                }
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
        $show->save();

        Session::flash('flash_message', 'Changes saved');
        return redirect('/shows');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Show::find($id)->delete();
        Session::flash('flash_message', 'Show Deleted');
        return redirect('/shows');

    }

    public function destroyNote($show_id, $note_id) {
        $note = ShowNote::findOrFail($note_id);
        if( $note->show->id != $show_id ) {
            Session::flash('flash_message', "boo");
            return Redirect::back();
        }

        if( !Auth::user()->admin ) {
            if( $note->user_id != Auth::user()->id ) {
                Session::flash('flash_message', 'Sorry, you can only delete notes you have created');
                return Redirect::back();
            }
        }

        $note->delete();
        Session::flash('flash_message', 'Note Deleted');
        return Redirect::back();
    }

    public function approveVideo($item_id, $note_id, Request $request) {
        $this->validate($request, [
            'published' => 'required:boolean'
        ]);
        $note = SetlistItemNote::findOrFail($note_id);
        if( $note->setlistItem->id != $item_id ) {
            Session::flash('flash_message', "Video/Note mismatch");
            return Redirect::back();
        }

        $note->published = $request->published;
        $note->save();

        Session::flash('flash_message', 'Video Approved');
        return Redirect::back();
    }

    public function destroyVideo($item_id, $note_id) {
        $note = SetlistItemNote::findOrFail($note_id);
        if( $note->setlistItem->id != $item_id ) {
            Session::flash('flash_message', "Wrong item_id/note_id");
            return Redirect::back();
        }

        if( !Auth::user()->admin ) {
            if( $note->user_id != Auth::user()->id ) {
                Session::flash('flash_message', 'Sorry, you can only delete notes you have created');
                return Redirect::back();
            }
        }

        $note->delete();
        Session::flash('flash_message', 'Video Deleted');
        return Redirect::back();
    }
}
