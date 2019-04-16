<?php

namespace ShowDb\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Redirect;
use Auth;
use ShowDb\TriviaQuestion;

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
        $questions = TriviaQuestion::orderBy('updated_at', 'desc')
            ->paginate(100);

        return view('admin.trivia.index')
            ->withUser($request->user())
            ->withQuestions($questions);
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
        if($request->user()->admin) {
            $trivia->published = 1;
        } else {
            $trivia->published = 0;
        }
        $trivia->user_id = $request->user()->id;
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
    public function edit($id)
    {
        $trivia = TriviaQuestion::where('id', '=', $id)
            ->first();

        if(is_null($trivia)) {
            Session::flash('flash_error','Question not found');
            return redirect(dirname(url()->current()));
        }

        return view('admin.trivia.edit')
            ->withTrivia($trivia);
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
        if($request->user()->admin) {
            $trivia->published = 1;
        } else {
            $trivia->published = 0;
        }
        $trivia->user_id = $request->user()->id;
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
