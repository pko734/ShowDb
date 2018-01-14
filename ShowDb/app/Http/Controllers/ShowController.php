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

class ShowController extends AbstractShowController
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
            'storeItemNote',
            'updateItemNote',
	    'deleteImagePost',
	    'approveImage',
        ]);
        $this->middleware('auth')->only([
            'storeNote',
            'destroyNote',
	    'uploadImagePost',
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
        $this->showbase = Show::whereNull('user_id');
        return parent::index($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return parent::create();
    }

    /**
     * Store a show note.
     * @param integer                    $show_id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeNote($show_id, Request $request)
    {
        return parent::storeNote($show_id, $request);
    }

    public function uploadImagePost($id, Request $request) {
        $this->showbase = Show::whereNull('user_id');
        return parent::uploadImagePost($id, $request);
    }

    public function deleteImagePost($id, $photo_id, Request $request) {
        $this->showbase = Show::whereNull('user_id');
        return parent::deleteImagePost($id, $photo_id, $request);
    }

    /**
     * Update a show note.
     *
     * @param integer                    $show_id
     * @param integer                    $note_id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateNote($show_id, $note_id, Request $request)
    {
        return parent::updateNote($show_id, $note_id, $request);
    }

    /**
     * Store a setlist item item-note link.
     *
     * @param  integer                   $setlist_item_id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeItemNote($setlist_item_id, Request $request)
    {
        return parent::storeItemNote($setlist_item_id, $request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return parent::store($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $this->showbase = Show::whereNull('user_id');
        $this->note_tooltip = 'What made this show special?';

        return parent::show($id, $request);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $this->showbase = Show::whereNull('user_id');
        return parent::edit($id, $request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  integer                   $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $this->showbase = Show::whereNull('user_id');
        return parent::update($id, $request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer                   $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $this->showbase = Show::whereNull('user_id');
        return parent::destroy($id, $request);
    }

    /**
     * Delete a show note.
     *
     * @param integer                    $note_id
     * @param integer                    $show_id
     * @return \Illuminate\Http\Response
     */
    public function destroyNote($show_id, $note_id, Request $request) {
        return parent::destroyNote($show_id, $note_id, $request);
    }

    /**
     * Approve a setlist item item-note.
     *
     * @param integer                    $item_id
     * @param integer                    $note_id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function approveItemNote($item_id, $note_id, Request $request) {
        return parent::approveItemNote($item_id, $note_id, $request);
    }

    /**
     * Delete a setlist item item-note.
     *
     * @param integer                    $item_id
     * @param integer                    $note_id
     * @return \Illuminate\Http\Response
     */
    public function destroyItemNote($item_id, $note_id, Request $request) {
        return parent::destroyItemNote($item_id, $note_id, $request);
    }
}
