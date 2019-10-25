<?php

namespace ShowDb\Http\Controllers;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Redirect;
use Session;
use ShowDb\SetlistItem;
use ShowDb\SetlistItemNote;
use ShowDb\Show;
use ShowDb\ShowNote;
use ShowDb\Song;

class FantasyShowController extends AbstractShowController
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->middleware('admin')->only([
            'updateNote',
            'storeItemNote',
            'updateItemNote',
        ]);
        $this->middleware('auth')->only([
            'index',
            'storeNote',
            'destroyNote',
            'create',
            'store',
            'show',
            'edit',
            'update',
            'destroy',
        ]);

        $this->display_complete = false;
        $this->notes_require_approval = false;
        $this->display_show_checkbox = false;
        $this->display_show_date = false;
        $this->display_show_creator = true;
        $this->display_search_examples = false;
        $this->display_creator_notice = 1;
        $this->venue_display = 'Description';
        $this->default_sort_column = 'created_at';
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->showbase = Show::whereNotNull('user_id');
        $this->default_date = date('Y-m-d');
        $this->user_can_add_show = true;
        $this->show_add_tooltip = 'Click here to add a fantasy show!';

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
     * @param int                    $show_id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeNote($show_id, Request $request)
    {
        return parent::storeNote($show_id, $request);
    }

    /**
     * Update a show note.
     *
     * @param int                    $show_id
     * @param int                    $note_id
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
     * @param  int                   $setlist_item_id
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
        $this->show_user_id = $request->user()->id;

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
        $this->showbase = Show::whereNotNull('user_id');
        $this->note_tooltip = 'Add any special notes here!';

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
        if ($request->user()->isAdmin()) {
            $this->showbase = Show::whereNotNull('user_id');
        } else {
            $this->showbase = Show::where('user_id', '=', $request->user()->id);
        }

        $this->setlist_item_add_tooltip = 'Click here to add songs!';

        return parent::edit($id, $request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int                   $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        if ($request->user()->isAdmin()) {
            $this->showbase = Show::whereNotNull('user_id');
        } else {
            $this->showbase = Show::where('user_id', '=', $request->user()->id);
        }

        return parent::update($id, $request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int                   $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        if ($request->user()->isAdmin()) {
            $this->showbase = Show::whereNotNull('user_id');
        } else {
            $this->showbase = Show::where('user_id', '=', $request->user()->id);
        }

        return parent::destroy($id, $request);
    }

    /**
     * Delete a show note.
     *
     * @param int                    $note_id
     * @param int                    $show_id
     * @return \Illuminate\Http\Response
     */
    public function destroyNote($show_id, $note_id, Request $request)
    {
        return parent::destroyNote($show_id, $note_id, $request);
    }

    /**
     * Approve a setlist item item-note.
     *
     * @param int                    $item_id
     * @param int                    $note_id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function approveItemNote($item_id, $note_id, Request $request)
    {
        return parent::approveItemNote($item_id, $note_id, $request);
    }

    /**
     * Delete a setlist item item-note.
     *
     * @param int                    $item_id
     * @param int                    $note_id
     * @return \Illuminate\Http\Response
     */
    public function destroyItemNote($item_id, $note_id, Request $request)
    {
        return parent::destroyItemNote($item_id, $note_id, $request);
    }
}
