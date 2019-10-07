<?php

namespace ShowDb\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Redirect;
use Auth;
use ShowDb\TriviaQuestion;
use ShowDb\Song;
use \Storage;

class AdminTriviaController extends Controller
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
        $group = $request->groupname ?? 'game1';
        $questions = TriviaQuestion::orderBy('updated_at', 'desc')
                   ->where('groupname', '=', $group)
                   ->paginate(100);

        $groups = TriviaQuestion::select('groupname')->distinct()->pluck('groupname');

        return view('admin.trivia.index')
            ->withUser($request->user())
            ->withGroups($groups)
            ->withCurrentGroup($group)
            ->withQuestions($questions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $songs = Song::whereNotNull('snipUrl')->orderBy('title')->get();
        $groups = TriviaQuestion::select('groupname')->distinct()->pluck('groupname');
        return view('admin.trivia.create')
            ->withCurrentGroup($request->groupname)
            ->withUser($request->user())
            ->withGroups($groups)
            ->withSongs($songs);
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
            'question' => 'required',
            'choice1' => 'required',
            'choice2' => 'required',
            'choice3' => 'required',
            'correct' => 'required|in:1,2,3,4',
        ]);

        if($request->newgroupname) {
            $groupname = $request->newgroupname;
        } else {
            $groupname = $request->groupname;
            if($groupname == "newgroup") {
                Session::flash('flash_error','Must choose an existing group or add a new one');
                return redirect(dirname(url()->current()));
            }
        }

        $trivia = new TriviaQuestion();
        $trivia->question = $request->question;
        $trivia->choice1 = $request->choice1;
        $trivia->choice2 = $request->choice2;
        $trivia->choice3 = $request->choice3;
        $trivia->choice4 = $request->choice4;
        $trivia->correct = $request->correct;
        $trivia->groupname = $groupname;
        $trivia->published = $request->published;
        $trivia->user_id = $request->user()->id;

        if($request->song_snip) {
            $trivia->audioUrl = Song::find($request->song_snip)->snipUrl;
        }
        if($request->image) {
            $image = $request->image;
            $imageName = $image->store("/images/trivia", 's3');
            $trivia->imageUrl = storage::disk('s3')->url($imageName);
        }

        $trivia->save();
        Session::flash('flash_message', 'Question Added');
        return redirect(url()->current());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Redirect("/admin/trivia/$id/edit");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $songs = Song::whereNotNull('snipUrl')->orderBy('title')->get();
        $trivia = TriviaQuestion::where('id', '=', $id)
            ->first();

        if(is_null($trivia)) {
            Session::flash('flash_error','Question not found');
            return redirect(dirname(url()->current()));
        }
        $groups = TriviaQuestion::select('groupname')->distinct()->pluck('groupname');

        return view('admin.trivia.edit')
            ->withTrivia($trivia)
            ->withUser($request->user())
            ->withGroups($groups)
            ->withSongs($songs);
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
            'question' => 'required',
            'choice1' => 'required',
            'choice2' => 'required',
            'choice3' => 'required',
            'correct' => 'required|in:1,2,3,4'
        ]);

        $trivia = TriviaQuestion::find($id);
        $trivia->question = $request->question;
        $trivia->choice1 = $request->choice1;
        $trivia->choice2 = $request->choice2;
        $trivia->choice3 = $request->choice3;
        $trivia->choice4 = $request->choice4;
        $trivia->correct = $request->correct;
        $trivia->published = $request->published;
        #$trivia->user_id = $request->user()->id;
        if($request->image) {
            $image = $request->image;
            var_export($image);
            $imageName = $image->store("/images/trivia", 's3');
            $trivia->imageUrl = storage::disk('s3')->url($imageName);
        }
        $trivia->save();
        Session::flash('flash_message', 'Question Edited');
        return redirect('/admin/trivia');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TriviaQuestion::where('id', '=', $id)
            ->first()
            ->delete();
        Session::flash('flash_message', 'Question Deleted');
        return redirect('/admin/trivia');
    }
}
