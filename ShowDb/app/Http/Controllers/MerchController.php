<?php

namespace ShowDb\Http\Controllers;

use Illuminate\Http\Request;
use ShowDb\Merch;
use ShowDb\Artist;
use ShowDb\Show;
use Image;
use Session;
use Illuminate\Http\UploadedFile;

class MerchController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->only([
            'create',
            'store',
            'edit',
            'update',
            'destroy',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function stickers()
    {
        $merch = Merch::orderBy('year')->where('category', '=', 'stickers')->paginate(200);
        return view('merch.index')
            ->withMerch($merch)
            ->withCategory('stickers')
            ->withHeading('Official Band Stickers')
            ->withSubheader('Looking for fan-made stickers?  Check out <a href="https://www.avettmail.com">avettmail.com</a>')
            ->withUser(\Auth::user());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function patches()
    {
        $merch = Merch::orderBy('year')->where('category', '=', 'patches')->paginate(200);
        return view('merch.index')
            ->withMerch($merch)
            ->withCategory('patches')
            ->withHeading('Official Band Patches')
            ->withSubheader('')
            ->withUser(\Auth::user());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function skateDecks()
    {
        $merch = Merch::orderBy('year')->where('category', '=', 'skatedecks')->paginate(200);
        return view('merch.index')
            ->withMerch($merch)
            ->withCategory('skatedecks')
            ->withHeading('Official Skate Decks')
            ->withSubheader('')
            ->withUser(\Auth::user());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function hats()
    {
        $merch = Merch::orderBy('year')->where('category', '=', 'hats')->paginate(200);
        return view('merch.index')
            ->withMerch($merch)
            ->withCategory('hats')
            ->withHeading('Official Band Hats')
            ->withSubheader('')
            ->withUser(\Auth::user());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function bandanas()
    {
        $merch = Merch::orderBy('year')->where('category', '=', 'bandanas')->paginate(200);
        return view('merch.index')
            ->withMerch($merch)
            ->withCategory('bandanas')
            ->withHeading('Official Band Bandanas')
            ->withSubheader('')
            ->withUser(\Auth::user());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function beltBuckles()
    {
        $merch = Merch::orderBy('year')->where('category', '=', 'beltbuckles')->paginate(200);
        return view('merch.index')
            ->withMerch($merch)
            ->withCategory('beltbuckles')
            ->withHeading('Official Belt Buckles')
            ->withSubheader('')
            ->withUser(\Auth::user());
    }

    public function posters(Request $request)
    {
        $year = $request->year ?? '';
        $artist_id = $request->artist_id ?? '';

        $selector = $request->selector ?? 'year';

        if($selector == 'year') {
            $merch = Merch::join('merch_show', 'merches.id', '=', 'merch_show.merch_id')
                ->join('shows', 'merch_show.show_id', '=', 'shows.id')
                ->with('shows')
                ->with('artists')
                ->where('category', '=', 'posters')
                ->where('year', '=', $year)
                ->orderBy('shows.date')
                ->select('merches.*')
                ->paginate(200);
        }
        $artist = null;
        if($selector == 'artist') {
            $merch = Merch::orderBy('artist')
                ->where('category', '=', 'posters')
                ->whereHas('artists', function ($query) use ($artist_id) {
                    $query->where('artist_id', '=', $artist_id);
                })
                ->orderBy('year')
                ->paginate(200);
            $artist = Artist::find($artist_id);
        }

        $all_years = Merch::distinct('year')
            ->orderBy('year')
            ->where('category', '=', 'posters')
            ->pluck('year');

        $all_artists = Artist::orderBy('name')->get();

        return view('merch.poster.index')
            ->withMerch($merch)
            ->withSelector($selector)
            ->withYear($year)
            ->withArtist($artist)
            ->withAllYears($all_years)
            ->withAllArtist($all_artists)
            ->withCategory('posters')
            ->withHeading('Show Posters')
            ->withSubheader('')
            ->withUser(\Auth::user());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $show = Show::find($request->show_id);
        $category = $request->category;
        $all_artists = Artist::orderBy('name')->get();
        $referer = $_SERVER['HTTP_REFERER'];

        return view('merch.create')
            ->withShow($show)
            ->withCategory($category)
            ->withAllArtist($all_artists)
            ->withReferer($referer);
    }

    /**
     * Create a thumbnail of specified size
     *
     * @param string $path path of thumbnail
     * @param int $width
     * @param int $height
     */
    public function createThumbnail($path, $width, $height = null)
    {
        $img = Image::make($path)->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save($path);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $merch = new Merch();
        $merch->year = (int)$request->year;
        $merch->description = $request->description;
        $merch->dimensions = $request->dimensions ?? '';
        $merch->notes = $request->notes ?? '';
        $merch->group = 'The Avett Brothers';
        $merch->name = $request->name ?? '';
        $merch->artist = $request->artist ?? '';
        $merch->category = $request->category;

        $filenamewithextension = $request->file('image')->getClientOriginalName();
        $filename = urldecode(pathinfo($filenamewithextension, PATHINFO_FILENAME));
        $extension = $request->file('image')->getClientOriginalExtension();
        $filenametostore = $filename.'_'.time().'.'.$extension;
        $smallthumbnail = $filename.'_small_'.time().'.'.$extension;
        $mediumthumbnail = $filename.'_medium_'.time().'.'.$extension;
        $largethumbnail = $filename.'_large_'.time().'.'.$extension;

        //Upload File
        $request->file('image')->storeAs('public/merch', $filenametostore);
        $request->file('image')->storeAs('public/merch/thumbnail', $smallthumbnail);
        $request->file('image')->storeAs('public/merch/thumbnail', $mediumthumbnail);
        $request->file('image')->storeAs('public/merch/thumbnail', $largethumbnail);

        //create small thumbnail
        $smallthumbnailpath = public_path('storage/merch/thumbnail/'.$smallthumbnail);
        $this->createThumbnail($smallthumbnailpath, 150);

        //create medium thumbnail
        $mediumthumbnailpath = public_path('storage/merch/thumbnail/'.$mediumthumbnail);
        $this->createThumbnail($mediumthumbnailpath, 300);

        //create large thumbnail
        $largethumbnailpath = public_path('storage/merch/thumbnail/'.$largethumbnail);
        $this->createThumbnail($largethumbnailpath, 550);

        $merch->url = '/storage/merch/' . $filenametostore;
        $merch->thumbnail_url = '/storage/merch/thumbnail/' . $smallthumbnail;
        $merch->save();

        if($request->artist_id) {
            $merch->artists()->detach();
            $merch->artists()->attach($request->artist_id);
            $merch->artist = Artist::find($request->artist_id)->name;
        }

        if($request->show_id) {
            $merch->shows()->attach($request->show_id);
        }

        $merch->save();

        return redirect($request->referer ?? $_SERVER['HTTP_REFERER'])
            ->with('success', "Merch uploaded successfully.");
    }

    /**
     * Display the specified resource.
     *
     * @param  \ShowDb\Merch  $merch
     * @return \Illuminate\Http\Response
     */
    public function show(Merch $merch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \ShowDb\Merch  $merch
     * @return \Illuminate\Http\Response
     */
    public function edit(Merch $merch)
    {
        if (is_null($merch)) {
            Session::flash('flash_error', 'Merch not found');

            return redirect('/merch/stickers');
        }
        $all_artists = Artist::orderBy('name')->get();

        return view('merch.edit')
        ->withMerch($merch)
        ->withReferer(@$_SERVER['HTTP_REFERER'])
        ->withAllArtist($all_artists);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \ShowDb\Merch  $merch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Merch $merch)
    {
        $merch->name = $request->name;
        $merch->dimensions = $request->dimensions;
        $merch->description = $request->description;
        $merch->notes = $request->notes;
        if($merch->artist) {
            $merch->artist = $request->artist;
        }
        if($request->artist_id) {
            $merch->artists()->detach();
            $merch->artists()->attach($request->artist_id);
            $merch->artist = Artist::find($request->artist_id)->name;
        }
        $merch->save();

        Session::flash('flash_message', 'Merch updated');

        return redirect($request->referer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \ShowDb\Sticker  $sticker
     * @return \Illuminate\Http\Response
     */
    public function destroy(Merch $merch)
    {
        $category = $merch->category;
        $merch->artists()->detach();
        $merch->delete();
        Session::flash('flash_message', 'Merch deleted');
        return redirect($_SERVER['HTTP_REFERER']);
    }
}
