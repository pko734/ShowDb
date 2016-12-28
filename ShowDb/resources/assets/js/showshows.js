$(document).ready(function() {

    $('#delete-show-btn').on('click', function() {
	bootbox.confirm('Are you sure you want to delete this show?', function(result) {
	    if(result) {
		$('#delete-show-form').submit();
	    }
	});

    });

    $('.delete-show-note-btn').on('click', function() {
	$('#delete-show-note-form').attr('action', $('#delete-show-note-form').attr('action') + $(this).attr('data-note-id'));
	$('#delete-show-note-form').submit();
	$('.delete-show-note-btn').attr('disabled', true);
    });

    $('#show-note-form .post-description').on('click', function(e) {
	if(!$(e.target).hasClass('edit-show-note-btn') && !$(e.target).hasClass('glyphicon-edit')) {
	    return;
	}

	var content = $($(this).children('.note-content')[0]);
	content.addClass('hide');

	$($(this).children('.stats')[0]).append( '<button id="save-note-btn" type="submit" class="btn btn-primary">Save Note</button>');
	$('.edit-show-note-btn').attr('disabled', true);

	content.after('<textarea id="show-note-edit-textarea" name="note">' + content.html() + '</textarea>');
	$("textarea").trumbowyg({

	    btns: [['bold', 'italic'], ['link'],['base64']],
	    autogrow: true
	});

	var that = this;
	$('#save-note-btn').on('click', function() {
	    var note_id = $(that).attr('data-note-id');
	    $('#edit-show-note-form').attr('action', $('#edit-show-note-form').attr('action') + note_id);
	    $('#edit-show-note-form').children('input[name=note]').val($('#show-note-edit-textarea').trumbowyg('html'));
	    $('#edit-show-note-form').submit();
	    $('#save-note-btn').attr('disabled', true);
	});

    });


    datbutton = false;
    $('#add-show-note-btn').click(function() {
	$('#notetable tbody').append('<tr><td><textarea name="notes[]" class="form-control" type="text" placeholder="Note"></textarea></td></tr>');

	$("textarea").trumbowyg({

	    btns: [['bold', 'italic'], ['link'],['base64']],
	    autogrow: true
	});

	if(!datbutton) {
	    $('#notetable').append( '<button id="addbutton" type="submit" class="btn btn-primary">Add Notes</button>');
	    datbutton = true;
	}

    });

    $('.edit-video-btn').on('click', function() {
	var that = this;

	bootbox.prompt('Enter Video URL', function(result) {
	    if(result) {
		$('#videoinput').val(result);
		$('#add-video-form').attr('action',
					  '/setlistitems/' +
					  $(that).attr('data-item-id') +
					  '/video');
		$('#add-video-form').submit();
	    }
	});
    });

    $('.delete-video-btn').on('click', function() {
	var that = this;

	bootbox.confirm('Delete this video?', function(result) {
	    if(result) {
		$('#delete-video-form').attr('action',
					     '/setlistitems/' +
					     $(that).attr('data-item-id') +
					     '/video/' +
					     $(that).attr('data-video-id'));
		$('#delete-video-form').submit();
	    }
	});
    });

    setTimeout(function() {
	$('#add-show-note-btn').tooltip('show')
    }, 2000 );

});
