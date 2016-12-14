$(document).ready(function() {

$('#delete-song-btn').on('click', function() {
    bootbox.confirm('Are you sure you wanted to delete this song?', function(result) {
	if(result) {
	    $('#delete-song-form').submit();
	}
    });
});

$('.delete-song-note-btn').on('click', function() {
    $('#delete-song-note-form').attr('action', $('#delete-song-note-form').attr('action') + $(this).attr('data-note-id'));
    $('#delete-song-note-form').submit();
    $('.delete-song-note-btn').attr('disabled', true);
});

$(document).ready(function() {
    var datbutton = false;
    $('#add-song-note-btn').click(function() {
	$('#notetable tbody').append('<tr><td><textarea name="notes[]" value="" class="form-control" type="text" placeholder="Note"></textarea></td></tr>');

	$("textarea").trumbowyg({
	    btns: [['bold', 'italic'], ['link'], ['insertImage']]
	});

	if(!datbutton) {
	    $('#notetable').append( '<button id="add-song-note-btn" type="submit" class="btn btn-primary">Add Notes</button>');
	    datbutton = true;
	}

    });
});

});
