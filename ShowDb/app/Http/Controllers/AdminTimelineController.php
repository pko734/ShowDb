<?php

namespace ShowDb\Http\Controllers;

use Illuminate\Http\Request;

use Session;
use Redirect;
use Auth;
use Carbon\Carbon;
use ShowDb\TimelineSlide;

class AdminTimelineController extends Controller
{
    public function __construct() {
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $slides = TimelineSlide::orderBy('start_date', 'asc')
            ->orderBy('start_time', 'asc')
            ->paginate(15);

        return view('admin.timeline.index')
            ->withUser($request->user())
            ->withSlides($slides);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('admin.timeline.create')
            ->withUser($request->user());
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
                                   'headline' => 'required',
                                   'type' => 'required',
                                   'start_date' => 'required'
        ]);

        if( $request->start_date ) {
            try {
                $start_date = (new Carbon($request->start_date))->toDateString();
            } catch(\Exception $e) {
                Session::flash('flash_error', 'Failed to parse date: ' . $request->start_date);
                return Redirect::back();
            }
        }
        if( $request->end_date ) {
            try {
                $end_date = (new Carbon($request->end_date))->toDateString();
            } catch(\Exception $e) {
                Session::flash('flash_error', 'Failed to parse date: ' . $request->end_date);
                return Redirect::back();
            }
        }

        $slide = new TimelineSlide();
        $slide->type = ($request->type === 'normal') ? null : $request->type;
        $slide->start_date = $start_date ?? null;
        $slide->end_date = $end_date ?? null;
        $slide->display_date = $request->display_date ?? null;
        $slide->text_headline = $request->headline;
        $slide->text_text = $request->text ?? null;
        $slide->media_url = $request->media_url ?? null;
        $slide->media_caption = $request->media_caption ?? null;
        $slide->media_credit = $request->media_credit ?? null;
        $slide->media_thumbnail_url = $request->media_thumbnail_url ?? null;
        $slide->creator_id = $request->user()->id;
        $slide->background = $request->background ?? null;
        $slide->published = true;
        $slide->save();

        Session::flash('flash_message', 'Changes saved');
        return redirect(url()->current());        
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
        $slide = TimelineSlide::find($id);

        if(is_null($slide)) {
            Session::flash('message','Slide not found');
            return redirect('/admin/timeline');
        }

        return view('admin.timeline.show')
            ->withSlide($slide)
            ->withUser($user);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $slide = TimelineSlide::where('id', '=', $id)
            ->first();

        if(is_null($slide)) {
            Session::flash('flash_error','Slide not found');
            return redirect(dirname(url()->current()));
        }

        return view('admin.timeline.edit')
            ->withSlide($slide);
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
        $this->validate($request, [
                                   'headline' => 'required',
                                   'type' => 'required',
                                   'start_date' => 'required'
        ]);

        if( $request->start_date ) {
            try {
                $start_date = (new Carbon($request->start_date))->toDateString();
            } catch(\Exception $e) {
                Session::flash('flash_error', 'Failed to parse date: ' . $request->start_date);
                return Redirect::back();
            }
        }
        if( $request->end_date ) {
            try {
                $end_date = (new Carbon($request->end_date))->toDateString();
            } catch(\Exception $e) {
                Session::flash('flash_error', 'Failed to parse date: ' . $request->end_date);
                return Redirect::back();
            }
        }
        #        var_export($id); exit;
        \DB::connection()->enableQueryLog();
        $slide = TimelineSlide::find($id);
        $slide->type = ($request->type === 'normal') ? null : $request->type;
        $slide->start_date = $start_date ?? null;
        $slide->display_date = $request->display_date ?? null;
        $slide->end_date = $end_date ?? null;
        $slide->text_headline = $request->headline;
        $slide->text_text = $request->text ?? null;
        $slide->media_url = $request->media_url ?? null;
        $slide->media_caption = $request->media_caption ?? null;
        $slide->media_credit = $request->media_credit ?? null;
        $slide->media_thumbnail_url = $request->media_thumbnail_url ?? null;
        $slide->background = $request->background ?? null;
        $slide->published = true;
        $slide->save();

        Session::flash('flash_message', 'Changes saved');
        return redirect(url()->current());
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TimelineSlide::where('id', '=', $id)
            ->first()
            ->delete();
        Session::flash('flash_message', 'Slide Deleted');
        return redirect(dirname(url()->current()));

    }
}
