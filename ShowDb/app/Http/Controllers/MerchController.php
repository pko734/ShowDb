<?php

namespace ShowDb\Http\Controllers;

use Illuminate\Http\Request;
use ShowDb\Merch;
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $merch->dimensions = '';
        $merch->notes = '';
        $merch->group = 'The Avett Brothers';
        $merch->name = '';
        $merch->artist = '';
        $merch->category = $request->category;

        $filenamewithextension = $request->file('image')->getClientOriginalName();
        $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
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
        return redirect('merch/' . $merch->category)->with('success', "Merch uploaded successfully.");
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

            return redirect('/stickers');
        }

        return view('merch.edit')->withMerch($merch);
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
        $merch->artist = $request->artist;
        $merch->save();

        Session::flash('flash_message', 'Merch updated');

        return redirect('/merch/' . $merch->category);
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
        $merch->delete();
        Session::flash('flash_message', 'Merch deleted');
        return redirect('/merch/' . $category);
    }
}
