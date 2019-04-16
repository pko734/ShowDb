@extends('layouts.master')
@section('title')
{{ $trivia->question }}
@endsection
@section('content')
<div class="container">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-body">
	<form method="POST" action="{{ dirname(url()->current()) }}">
          {{ method_field('PUT') }}
          {{ csrf_field() }}
	  <div class="form-group">
	    <label for="trivia_question">Trivia Question</label>
	    <input value="{{ $trivia->question }}"
		   name="question"
		   type="text"
		   class="form-control"
		   id="trivia_question">
	  </div>
	  <div class="form-group">
	    <label for="trivia_choice1">Choice 1</label>
	    <input value="{{ $trivia->choice1 }}"
		   name="choice1"
		   type="text"
		   class="form-control"
		   id="trivia_choice1">
	  </div>
	  <div class="form-group">
	    <label for="trivia_choice2">Choice 2</label>
	    <input value="{{ $trivia->choice2 }}"
		   name="choice2"
		   type="text"
		   class="form-control"
		   id="trivia_choice2">
	  </div>
	  <div class="form-group">
	    <label for="trivia_choice3">Choice 3</label>
	    <input value="{{ $trivia->choice3 }}"
		   name="choice3"
		   type="text"
		   class="form-control"
		   id="trivia_choice3">
	  </div>
	  <div class="form-group">
	    <label for="trivia_choice4">Choice 4</label>
	    <input value="{{ $trivia->choice4 }}"
		   name="choice4"
		   type="text"
		   class="form-control"
		   id="trivia_choice4">
	  </div>

	  <div class="form-group">
	    <label for="trivia_correct">Correct Answer</label>
            <select name="correct" class="form-control">
	      <option value="0">Choose Correct Answer</option>
              <option value="1" @if($trivia->correct == "1") SELECTED  @endif>Choice 1</option>
              <option value="2" @if($trivia->correct == "2") SELECTED  @endif>Choice 2</option>
              <option value="3" @if($trivia->correct == "3") SELECTED  @endif>Choice 3</option>
              <option value="4" @if($trivia->correct == "4") SELECTED  @endif>Choice 4</option>
            </select>
	  </div>

	  <button type="submit" class="pull-left btn btn-primary">Save Trivia Question</button>&nbsp;
	  <button id="delete-question-btn" type="button" class="pull-right btn btn-danger">
	    <span class="glyphicon glyphicon-trash"></span>
	  </button>
	</form>
      </div>
    </div>
  </div>
</div>
<form id="delete-question-form" method="POST" action="/admin/trivia/{{ $trivia->id }}">
  {{ method_field('DELETE') }}
  {{ csrf_field() }}
</form>

@endsection
