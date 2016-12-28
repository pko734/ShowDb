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

    $('#song-note-form .post-description').on('click', function(e) {
	if(!$(e.target).hasClass('edit-song-note-btn') && !$(e.target).hasClass('glyphicon-edit')) {
	    return;
	}

	var content = $($(this).children('.note-content')[0]);
	content.addClass('hide');

	$($(this).children('.stats')[0]).append( '<button id="save-note-btn" type="submit" class="btn btn-primary">Save Note</button>');
	$('.edit-song-note-btn').attr('disabled', true);

	content.after('<textarea id="song-note-edit-textarea" name="note">' + content.html() + '</textarea>');
	$("textarea").trumbowyg({

	    btns: [['bold', 'italic'], ['link'],['base64']],
	    autogrow: true
	});

	var that = this;
	$('#save-note-btn').on('click', function() {
	    console.log('asdf');
	    var note_id = $(that).attr('data-note-id');
	    $('#edit-song-note-form').attr('action', $('#edit-song-note-form').attr('action') + note_id);
	    $('#edit-song-note-form').children('input[name=note]').val($('#song-note-edit-textarea').trumbowyg('html'));
	    $('#edit-song-note-form').submit();
	    $('#save-note-btn').attr('disabled', true);
	});

    });


    $(document).ready(function() {
	var datbutton = false;
	$('#add-song-note-btn').click(function() {
	    $('#notetable tbody').append('<tr><td><textarea name="notes[]" value="" class="form-control" type="text" placeholder="Note"></textarea></td></tr>');

	    $("textarea").trumbowyg({
		btns: [['bold', 'italic'], ['link'], ['base64']]
	    });

	    if(!datbutton) {
		$('#notetable').append( '<button id="add-song-note-btn" type="submit" class="btn btn-primary">Add Notes</button>');
		datbutton = true;
	    }

	});
    });

    setTimeout(function() {
	$('#add-song-note-btn').tooltip('show')
    }, 2000 );

});
