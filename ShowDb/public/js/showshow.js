$('#deletebtn').on('click', function() {
    bootbox.confirm('Are you sure you want to delete this show?', function(result) {
	if(result) {
	    $('#deleteform').submit();
	}
    });

});

$('.notedeletebutton').on('click', function() {
    $('#deletenoteform').attr('action', $('#deletenoteform').attr('action') + $(this).attr('data-note-id'));
    $('#deletenoteform').submit();
    $('.notedeletebutton').attr('disabled', true);
});

datbutton = false;

$(document).ready(function() {
    $('#noteaddbutton').click(function() {
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
		$('#addvideoform').attr('action',
					'/setlistitems/' +
					$(that).attr('data-item-id') +
					'/video');
		$('#addvideoform').submit();
	    }
	});
    });

    $('.delete-video-btn').on('click', function() {
	var that = this;

	bootbox.confirm('Delete this video?', function(result) {
	    if(result) {
		$('#deletevideoform').attr('action',
					   '/setlistitems/' +
					   $(that).attr('data-item-id') +
					   '/video/' +
					   $(that).attr('data-video-id'));
		$('#deletevideoform').submit();
	    }
	});
    });


});
