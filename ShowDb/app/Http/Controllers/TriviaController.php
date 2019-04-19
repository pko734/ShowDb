<?php

namespace ShowDb\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Redirect;
use Auth;
use ShowDb\TriviaQuestion;

class TriviaController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return redirect('/trivia/create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('admin.trivia.create')
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
            'question' => 'required',
            'choice1' => 'required',
            'choice2' => 'required',
            'choice3' => 'required',
            'correct' => 'required|in:1,2,3,4'
        ]);

        $trivia = new TriviaQuestion();
        $trivia->question = $request->question;
        $trivia->choice1 = $request->choice1;
        $trivia->choice2 = $request->choice2;
        $trivia->choice3 = $request->choice3;
        $trivia->choice4 = $request->choice4;
        $trivia->correct = $request->correct;
        $trivia->published = 0;
        $trivia->user_id = $request->user()->id;
        $trivia->save();
        Session::flash('flash_message', 'Question added.  Thank you.  Add another!');
        return redirect('/trivia/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect('/trivia/create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return redirect('/trivia/create');
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
        return redirect('/trivia/create');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return redirect('/trivia/create');
    }
}
