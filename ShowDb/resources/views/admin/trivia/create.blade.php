@extends('layouts.master')
@section('title')
Add Trivia Question
@endsection
@section('content')
<div class="container">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-body">
	<form method="POST" action="/admin/trivia">
          {{ csrf_field() }}
	  <div class="form-group">
	    <label for="trivia_question">Trivia Question</label>
	    <input value=""
		   name="question"
		   type="text"
		   class="form-control"
		   id="trivia_question">
	  </div>
	  <div class="form-group">
	    <label for="trivia_choice1">Choice 1</label>
	    <input value=""
		   name="choice1"
		   type="text"
		   class="form-control"
		   id="trivia_choice1">
	  </div>
	  <div class="form-group">
	    <label for="trivia_choice2">Choice 2</label>
	    <input value=""
		   name="choice2"
		   type="text"
		   class="form-control"
		   id="trivia_choice2">
	  </div>
	  <div class="form-group">
	    <label for="trivia_choice3">Choice 3</label>
	    <input value=""
		   name="choice3"
		   type="text"
		   class="form-control"
		   id="trivia_choice3">
	  </div>
	  <div class="form-group">
	    <label for="trivia_choice4">Choice 4</label>
	    <input value=""
		   name="choice4"
		   type="text"
		   class="form-control"
		   id="trivia_choice4">
	  </div>

	  <div class="form-group">
	    <label for="trivia_correct">Correct Answer</label>
            <select name="correct" class="form-control">
	      <option value="0">Choose Correct Answer</option>
              <option value="1">Choice 1</option>
              <option value="2">Choice 2</option>
              <option value="3">Choice 3</option>
              <option value="4">Choice 4</option>
            </select>
	  </div>

	  <button type="submit" class="pull-left btn btn-primary">Add Trivia Question</button>&nbsp;
	</form>
      </div>
    </div>
  </div>
</div>

@endsection
