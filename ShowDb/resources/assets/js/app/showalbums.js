$(document).ready(function() {

    $('#delete-album-btn').on('click', function() {
	bootbox.confirm('Are you sure you want to delete this album?', function(result) {
	    if(result) {
		$('#delete-album-form').submit();
	    }
	});

    });

    $('.delete-album-note-btn').on('click', function() {
	$('#delete-album-note-form').attr('action', $('#delete-album-note-form').attr('action') + $(this).attr('data-note-id'));
	$('#delete-album-note-form').submit();
	$('.delete-album-note-btn').attr('disabled', true);
    });

    $('#album-note-form .post-description').on('click', function(e) {
	if(!$(e.target).hasClass('edit-album-note-btn') && !$(e.target).hasClass('glyphicon-edit')) {
	    return;
	}

	var content = $($(this).children('.note-content')[0]);
	content.addClass('hide');

	$($(this).children('.stats')[0]).append( '<button id="save-note-btn" type="submit" class="btn btn-primary">Save Note</button>');
	$('.edit-album-note-btn').attr('disabled', true);

	content.after('<textarea id="album-note-edit-textarea" name="note">' + content.html() + '</textarea>');
	$("textarea").trumbowyg({

	    btns: [['bold', 'italic'], ['link'],['base64'], ['removeformat']],
	    autogrow: true
	});

	var that = this;
	$('#save-note-btn').on('click', function() {
	    var note_id = $(that).attr('data-note-id');
	    $('#edit-album-note-form').attr('action', $('#edit-album-note-form').attr('action') + note_id);
	    $('#edit-album-note-form').children('input[name=note]').val($('#album-note-edit-textarea').trumbowyg('html'));
	    $('#edit-album-note-form').submit();
	    $('#save-note-btn').attr('disabled', true);
	});

    });

/*    if(('#add-album-note-btn').length) {
	var add_check = {
	    init: function() {
		setTimeout(add_check.check, 2000);
	    },
	    check: function() {
		if($('#add-album-note-btn').isOnScreen()) {
		    $('#add-album-note-btn').tooltip('album')
		} else {
		    setTimeout(add_check.check, 2000);
		}
	    }
	}
	add_check.init();
    }
*/
    var datbutton = false;
    $('#add-album-note-btn').click(function() {
	$('#notetable tbody').append('<tr><td><textarea name="notes[]" class="form-control" type="text" placeholder="Note"></textarea></td></tr>');

	$("textarea").trumbowyg({

	    btns: [['bold', 'italic'], ['link'],['base64']],
	    autogrow: true
	});

	if(!datbutton) {
	    $('#notetable').append( '<button id="addbutton" type="submit" class="btn btn-primary">Add Notes</button>');
	    window.scrollTo(0,$('#addbutton').offset().top - $(window).height()/2);
	    datbutton = true;
	}

    });

    $('.edit-item-btn').on('click', function() {
	var that = this;

	bootbox.prompt('Enter Note', function(result) {
	    if(result) {
		$('#iteminput').val(result);
		$('#add-item-form').attr('action',
					  '/albumitems/' +
					  $(that).attr('data-item-id') +
					  '/note');
		$('#add-item-form').submit();
	    }
	});
    });

    $('.delete-item-btn').on('click', function() {
	var that = this;

	bootbox.confirm('Delete this note?', function(result) {
	    if(result) {
		$('#delete-item-form').attr('action',
					     '/albumitems/' +
					     $(that).attr('data-item-id') +
					     '/note/' +
					     $(that).attr('data-item-note-id'));
		$('#delete-item-form').submit();
	    }
	});
    });
});
