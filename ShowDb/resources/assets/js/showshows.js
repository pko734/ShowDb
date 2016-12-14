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

    datbutton = false;
    $('#add-show-note-btn').click(function() {
	$('#notetable tbody').append('<tr><td><textarea name="notes[]" value="" class="form-control" type="text" placeholder="Note"></textarea></td></tr>');

	$("textarea").trumbowyg({
	    btns: [['bold', 'italic'], ['link'], ['insertImage']]
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

});
