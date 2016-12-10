<?php

namespace ShowDb\Http\Controllers;

use Illuminate\Http\Request;
use ShowDb\Show;
use ShowDb\SetlistItem;
use ShowDb\Song;
use Session;

class ShowController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->except(['show','index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->validate($request, [
            'o' => 'in:date,setlist_items_count',
            'd' => 'in:asc,desc',
            'q' => 'string',
        ]);

        $q = $request->get('q');
        $o = $request->get('o') ?: 'date';
        $d = $request->get('d') ?: 'desc';

        $shows = Show::withCount('setlistItems')
               ->where( 'date', 'LIKE', "%{$q}%" )
               ->orWhere('venue', 'LIKE', "%{$q}%")
               ->orderBy($o, $d)
               ->orderBy('date', 'desc')
               ->paginate(15)
               ->setPath( '' );
        $pagination = $shows->appends( [
            'q' => $request->get('q'),
            'o' => $request->get('o'),
        ]);

        return view('show.index')
            ->withShows($shows)
            ->withQuery($q)
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
            $show->published = 1;
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
}
