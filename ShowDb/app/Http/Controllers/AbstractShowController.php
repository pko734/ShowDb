<?php

namespace ShowDb\Http\Controllers;

use Illuminate\Http\Request;
use ShowDb\Show;
use ShowDb\SetlistItem;
use ShowDb\Song;
use ShowDb\ShowNote;
use ShowDb\SetlistItemNote;
use ShowDb\ShowImage;
use Session;
use Redirect;
use Auth;
use Carbon\Carbon;
use \Storage;

class AbstractShowController extends Controller
{

    protected $showbase = null;
    protected $show_user_id = null;
    protected $default_date = null;
    protected $note_tooltip = null;
    protected $setlist_item_add_tooltip = null;
    protected $user_can_add_show = false;
    protected $display_complete = true;
    protected $show_add_tooltip = null;
    protected $notes_require_approval = true;
    protected $display_show_checkbox = true;
    protected $display_show_creator = false;
    protected $display_show_date = true;
    protected $display_search_examples = true;
    protected $display_creator_notice = false;
    protected $venue_display = 'Venue';
    protected $default_sort_column = 'date';

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
            'i' => 'boolean',
        ]);

        $q = $request->get('q');

        $o = $request->get('o') ?: 'date-desc';
        $sort_order = explode('-', $o);
        $search = $this->showbase
                ->withCount('setlistItems')
                ->withCount('notes');
        foreach(preg_split('/\s+/', trim($q)) as $p) {
            $search = $search
                    ->where(function($q1) use ($p) {
                        $q1->where( 'date',   'LIKE', "%{$p}%" )
                            ->orWhere('venue', 'LIKE', "%{$p}%")
                            ->orWhereHas('creator', function($query) use ($p) {
                                $query->where('username', 'LIKE', "%{$p}%");
                            })
                            ->orWhereHas('notes', function($query) use ($p) {
                                $query->where('note', 'LIKE', "%{$p}%")
                                      ->where('note', 'NOT LIKE', '%<img src="data:%');
                            });
                    });

        }
        if($request->get('i') == '1') {
            $search = $search->where('incomplete_setlist', '=', true);
        }
        $search = $search->orderBy($sort_order[0], $sort_order[1])
               ->orderBy($this->default_sort_column, 'desc')
               ->paginate(15)
               ->setPath( '' )
                ->appends( [
                    'q' => $request->get('q'),
                    'o' => $request->get('o'),
                    'i' => $request->get('i'),
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
            ->withDefaultDate($this->default_date)
            ->withUserCanAddShow($this->user_can_add_show)
            ->withShowAddTooltip($this->show_add_tooltip)
            ->withDisplayComplete($this->display_complete)
            ->withDisplayShowCheckbox($this->display_show_checkbox)
            ->withDisplayShowCreator($this->display_show_creator)
            ->withDisplayShowDate($this->display_show_date)
            ->withDisplaySearchExamples($this->display_search_examples)
            ->withDisplayCreatorNotice($this->display_creator_notice)
            ->withVenueDisplay($this->venue_display)
            ->withUser($request->user());
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
            if($this->notes_require_approval) {
                $shownote->published = 0;
            } else {
                $shownote->published = 1;
            }
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
            'published' => 'boolean',
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
     * Store a setlist item item-note link.
     *
     * @param  integer                   $setlist_item_id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeItemNote($setlist_item_id, Request $request) {
        $this->validate($request, [
            'video_url' => 'active_url',
        ]);

        $note = new SetlistItemNote();
        $note->note = $request->video_url;
        $note->setlist_item_id = $setlist_item_id;
        $note->user_id = $request->user()->id;

        if($this->notes_require_approval) {
            $note->published = 0;
        } else {
            $note->published = 1;
        }
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
            return redirect( url()->current() );
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
            $show->incomplete_setlist = 1;
            if( $this->show_user_id !== null ) {
                $show->user_id = $this->show_user_id;
            }
            $show->save();
        }

        Session::flash('flash_message', 'Changes saved');
        return redirect(url()->current());
    }

    /**
     * Delete an image.
     * @param integer                    $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deleteImagePost($id, $photo_id, Request $request) {
      $show = $this->showbase
	->where('id', '=', $id)
	->first();

      $photo = ShowImage::where('show_id', '=', $show->id)
	->where('id', '=', $photo_id)
	->first();

        if(is_null($show)) {
	  echo 'bye'; exit;
            Session::flash('flash_error','Show not found');
            return redirect(dirname(dirname(url()->current())));
        }

        if(is_null($photo)) {
	  echo 'hi'; exit;
            Session::flash('flash_error','Photo not found');
            return redirect(dirname(dirname(url()->current())));
        }

	Storage::disk('s3')->delete($photo->path);

        $photo->delete();
        Session::flash('flash_message', 'Image Deleted');
        return Redirect::back();
    }
    /**
     * Upload an image.
     * @param integer                    $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadImagePost($id, Request $request) {
      request()->validate([
	  'image'   => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:6144',
          'tos'     => 'accepted',
	  'certify' => 'accepted',
	]);

      $show = $this->showbase
	->where('id', '=', $id)
	->first();
      $imageName = $request->image->store("/images/{$show->date}/{$show->id}", 's3');

      $image = new ShowImage();
      $image->user_id = $request->user()->id;
      $image->show_id = $show->id;
      $image->caption = $request->photo_caption;
      $image->photo_credit = $request->photo_credit;
      $image->published = $request->user()->admin;
      $image->path = $imageName;
      $image->url = Storage::disk('s3')->url($imageName);
      $image->save();

      Session::flash('flash_message', 'Photo Submitted.  Thank you!');
      return back()
        ->withShowId($id)
	->with('image',$imageName);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $show = $this->showbase
              ->where('id', '=', $id)
              ->first();

	$images = ShowImage::where('show_id', '=', $show->id)->get();
        $user = $request->user();

        if(is_null($show)) {
            Session::flash('flash_error','Show not found');
            return redirect(dirname(url()->current()));
        }

        return view('show.show')
            ->withShow($show)
            ->withUser($user)
	    ->withImages($images)
            ->withNoteTooltip($this->note_tooltip)
            ->withDisplayComplete($this->display_complete)
            ->withVenueDisplay($this->venue_display)
            ->withDisplayShowDate($this->display_show_date);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $show = $this->showbase
              ->where('id', '=', $id)
              ->first();

        if(is_null($show)) {
            Session::flash('flash_error','Show not found');
            return redirect(dirname(url()->current()));
        }

        return view('show.edit')
            ->withShow($show)
            ->withSetlistItemAddTooltip($this->setlist_item_add_tooltip)
            ->withDisplayShowDate($this->display_show_date)
            ->withVenueDisplay($this->venue_display)
            ->withDisplayComplete($this->display_complete);
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
        # Validate
        $this->validate($request, [
            'date'    => 'required',
            'venue'   => 'required|string|between:10,255',
            'songs.*' => 'exists:songs,title',
            'interlude_song' => 'exists:songs,title',
            'complete' => 'boolean',
        ]);

        try {
            $date = (new Carbon($request->date))->toDateString();
        } catch(\Exception $e) {
            Session::flash('flash_error', 'Failed to parse date: ' . $request->date);
            return Redirect::back();
        }

        $show = $this->showbase
              ->where('id', '=', $id)
              ->first();
        $show->venue = $request->input('venue');
        $show->date  = $date;
        if(isset($request->complete)) {
            $show->incomplete_setlist = !$request->complete;
        } else {
            $show->incomplete_setlist = false;
        }

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
		    // handle interludes		    
		    if($my_item->song->title === 'Pretty Girl from Annapolis' && isset($request->interlude_song) && $request->interlude_song) {
 		      $my_item->interlude_song_id = 
		        Song::where('title', '=', $request->interlude_song)->first()->id;
		    } else {
		      $my_item->interlude_song_id = null;
		    }

                    // Update the item order
                    if($my_item->order != $i) {
                        $my_item->order = $i;
                    }
		    $my_item->save();

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
        return redirect(url()->current());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer                   $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $this->showbase
            ->where('id', '=', $id)
            ->first()
            ->delete();
        Session::flash('flash_message', 'Show Deleted');
        return redirect(dirname(url()->current()));

    }

    /**
     * Delete a show note.
     *
     * @param integer                    $note_id
     * @param integer                    $show_id
     * @return \Illuminate\Http\Response
     */
    public function destroyNote($show_id, $note_id, Request $request) {
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
     * Approve a photo.
     *
     * @param integer                    $show_id
     * @param integer                    $photo_id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function approvePhoto($show_id, $photo_id, Request $request) {
        $this->validate($request, [
            'published' => 'required:boolean'
        ]);
        $photo = ShowImage::findOrFail($photo_id);
        if( $photo->show->id != $show_id ) {
            Session::flash('flash_error', "Show/Photo mismatch");
            return Redirect::back();
        }

        $photo->published = $request->published;
        $photo->save();

        Session::flash('flash_message', 'Photo Approved');
        return Redirect::back();
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
     * Delete a setlist item item-note.
     *
     * @param integer                    $item_id
     * @param integer                    $note_id
     * @return \Illuminate\Http\Response
     */
    public function destroyItemNote($item_id, $note_id, Request $request) {
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
