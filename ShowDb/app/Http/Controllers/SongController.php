<?php

namespace ShowDb\Http\Controllers;

use Illuminate\Http\Request;
use ShowDb\Song;
Use Session;

class SongController extends Controller
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
            'o' => 'in:title,setlist_items_count',
            'q' => 'string',
        ]);
        $q = $request->get('q');
        $o = $request->get('o') ?: 'title';
        $songs = Song::withCount('setlistItems')
               ->where( 'title', 'LIKE', '%' . $q . '%' )
               ->orderBy($o)
               ->orderBy('title')
               ->paginate(15)
               ->setPath( '' );
        $pagination = $songs->appends( [
            'q' => $q,
            'o' => $o,
        ]);

        return view('song.index')
            ->withSongs($songs)
            ->withQuery($q)
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

        foreach( $request->songs as $title ) {
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $user = $request->user();
        $song = Song::find($id);

        if(is_null($song)) {
            Session::flash('message','Book not found');
            return redirect('/songs');
        }

        return view('song.show')
            ->withSong($song)
            ->withUser($user);    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $song = Song::find($id);

        if(is_null($song)) {
            Session::flash('message','Book not found');
            return redirect('/songs');
        }

        return view('song.edit')->withSong($song);
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
            'title' => 'required|between:1,255',
        ]);

        $song = Song::find($id);
        $song->title = $request->title;
        $song->save();

        Session::flash('flash_message', 'Changes saved');
        return redirect('/songs');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Song::find($id)->delete();
        Session::flash('flash_message', 'Song Deleted');
        return redirect('/songs');    }
}
