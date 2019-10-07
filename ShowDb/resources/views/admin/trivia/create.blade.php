@extends('layouts.master')
@section('title')
Add Trivia Question
@endsection
@section('content')
<div class="container">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-body">
	<form method="POST" action="{{ dirname(Request::url()) }}" autocomplete="off" enctype="multipart/form-data">
          {{ csrf_field() }}
	  <div class="form-group">
	    <label for="trivia_question">Trivia Question</label>
	    <input value=""
		   autocomplete="off"
		   name="question"
		   type="text"
		   class="form-control"
		   id="trivia_question">
	  </div>
	  <div class="form-group">
	    <label for="trivia_question_group">Group Name</label>
	    <select class="form-control" name="groupname">
	      <option value="newgroup">Create a new group</option>
	      @foreach($groups as $group)
	      <option value="{{ $group }}" @if($currentGroup == $group) SELECTED @endif >{{ $group }}</option>
	      @endforeach
	    </select>
	    <input value=""
		   name="newgroupname"
		   type="text"
		   class="form-control"
		   placeholder="If creating a new group, put the name here">
	  </div>
	  <div class="form-group">
	    <label class="radio-inline" for="trivia_published_yes">
	      <input value="1"
		     name="published"
		     autocomplete="off"
		     type="radio"		    
 	             id="trivia_published_yes">Published
	    </label>
	    <label class="radio-inline" for="trivia_published_no">
	      <input value="0"
		     name="published"
		     autocomplete="off"
		     type="radio"
		     checked
	             id="trivia_published_no">Unpublished
	    </label>
	  </div>
	  @if($user->admin && isset($songs))
	  <div class="form-group">
	    <label for="song_snip">Include Song Snip</label>
	    <select id="song_snip" name="song_snip" class="form-control" onChange="javascript:$('#audio_player').attr('src', $(this[this.selectedIndex]).attr('data-audioUrl')); document.getElementById('audio').load();">
	      <option data-audioUrl="" value="">Choose a song snippet if applicable</option>
	      @foreach($songs as $song)
	      <option data-audioUrl="{{ $song->snipUrl }}" value="{{ $song->id }}">{{ $song->title }}</option>
	      @endforeach
	    </select>
	    <audio id="audio" controls>
	      <source id="audio_player" src="" type="audio/mpeg">
		Your browser doesn't support the audio tag
	    </audio>	  

	  </div>	  
	  @endif
	  @if($user->admin)
	  <div class="form-group">
	    <label for="fupload">Include Image (if applicable) - Use square dimensions to avoid image distortion</label>
	    <input id="fupload" class="form-control" name="image" type="file">
	  </div>
	  @endif
	  <div class="form-group">
	    <label for="trivia_choice1">Choice 1</label>
	    <input value=""
		   name="choice1"
		   autocomplete="off"
		   type="text"
		   class="form-control"
		   id="trivia_choice1">
	  </div>
	  <div class="form-group">
	    <label for="trivia_choice2">Choice 2</label>
	    <input value=""
		   name="choice2"
		   autocomplete="off"
		   type="text"
		   class="form-control"
		   id="trivia_choice2">
	  </div>
	  <div class="form-group">
	    <label for="trivia_choice3">Choice 3</label>
	    <input value=""
		   name="choice3"
		   autocomplete="off"
		   type="text"
		   class="form-control"
		   id="trivia_choice3">
	  </div>
	  <div class="form-group">
	    <label for="trivia_choice4">Choice 4</label>
	    <input value=""
		   name="choice4"
		   autocomplete="off"
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
