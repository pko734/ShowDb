/** ADMIN **/
$(document).ready(function() {
    //deletes
    $('#show-note-column .notedeletebutton').on('click', function() {
	var that = this;

	$('#show-note-delete-form').attr('action',
					 '/shows/' +
					 $(that).attr('data-parent-id') +
					 '/notes/' +
					 $(that).attr('data-note-id'));

	$('#show-note-delete-form').submit();
    });

    $('#song-note-column .notedeletebutton').on('click', function() {
	var that = this;

	$('#song-note-delete-form').attr('action',
					 '/songs/' +
					 $(that).attr('data-parent-id') +
					 '/notes/' +
					 $(that).attr('data-note-id'));

	$('#song-note-delete-form').submit();
    });

    $('#album-note-column .notedeletebutton').on('click', function() {
	var that = this;

	$('#album-note-delete-form').attr('action',
					 '/albums/' +
					 $(that).attr('data-parent-id') +
					 '/notes/' +
					 $(that).attr('data-note-id'));

	$('#album-note-delete-form').submit();
    });

    $('#video-note-column .notedeletebutton').on('click', function() {
	var that = this;

	$('#video-note-delete-form').attr('action',
					  '/setlistitems/' +
					  $(that).attr('data-parent-id') +
					  '/video/' +
					  $(that).attr('data-note-id'));

	$('#video-note-delete-form').submit();

    });

    // edits
    $('#show-note-column .post-description').on('click', function(e) {
	var that = this;
	if(!$(e.target).hasClass('noteeditbutton') && !$(e.target).hasClass('glyphicon-edit')) {
	    return;
	}
	console.log('asdf');
	var content = $($(this).children('.note-content')[0]);
	content.addClass('hide');

	$($(this).children('.stats')[0]).append( '<button id="save-note-btn" type="submit" class="btn btn-primary">Save Note</button>');
	$('.noteeditbutton').attr('disabled', true);

	content.after('<textarea id="show-note-edit-textarea" name="note">' + content.html() + '</textarea>');
	$("textarea").trumbowyg({

	    btns: [['bold', 'italic'], ['link'],['base64']],
	    autogrow: true
	});

	$('#save-note-btn').on('click', function() {
	    var show_id = $(that).attr('data-parent-id');
	    var note_id = $(that).attr('data-note-id');
	    $('#show-note-edit-form').attr('action',
					   '/shows/' +
					   show_id +
					   '/notes/' +
					   note_id);
	    $('#show-note-edit-form').children('input[name=note]').val($('#show-note-edit-textarea').trumbowyg('html'));
	    $('#show-note-edit-form').submit();
	    $('#save-note-btn').attr('disabled', true);
	});

    });

    $('#song-note-column .post-description').on('click', function(e) {
	var that = this;
	if(!$(e.target).hasClass('noteeditbutton') && !$(e.target).hasClass('glyphicon-edit')) {
	    return;
	}
	console.log('asdf');
	var content = $($(this).children('.note-content')[0]);
	content.addClass('hide');

	$($(this).children('.stats')[0]).append( '<button id="save-note-btn" type="submit" class="btn btn-primary">Save Note</button>');
	$('.noteeditbutton').attr('disabled', true);

	content.after('<textarea id="song-note-edit-textarea" name="note">' + content.html() + '</textarea>');
	$("textarea").trumbowyg({

	    btns: [['bold', 'italic'], ['link'],['base64']],
	    autogrow: true
	});

	$('#save-note-btn').on('click', function() {
	    var song_id = $(that).attr('data-parent-id');
	    var note_id = $(that).attr('data-note-id');
	    $('#song-note-edit-form').attr('action',
					   '/songs/' +
					   song_id +
					   '/notes/' +
					   note_id);
	    $('#song-note-edit-form').children('input[name=note]').val($('#song-note-edit-textarea').trumbowyg('html'));
	    $('#song-note-edit-form').submit();
	    $('#save-note-btn').attr('disabled', true);
	});

    });

    $('#album-note-column .post-description').on('click', function(e) {
	var that = this;
	if(!$(e.target).hasClass('noteeditbutton') && !$(e.target).hasClass('glyphicon-edit')) {
	    return;
	}
	console.log('asdf');
	var content = $($(this).children('.note-content')[0]);
	content.addClass('hide');

	$($(this).children('.stats')[0]).append( '<button id="save-note-btn" type="submit" class="btn btn-primary">Save Note</button>');
	$('.noteeditbutton').attr('disabled', true);

	content.after('<textarea id="album-note-edit-textarea" name="note">' + content.html() + '</textarea>');
	$("textarea").trumbowyg({

	    btns: [['bold', 'italic'], ['link'],['base64']],
	    autogrow: true
	});

	$('#save-note-btn').on('click', function() {
	    var album_id = $(that).attr('data-parent-id');
	    var note_id = $(that).attr('data-note-id');
	    $('#album-note-edit-form').attr('action',
					   '/albums/' +
					   album_id +
					   '/notes/' +
					   note_id);
	    $('#album-note-edit-form').children('input[name=note]').val($('#album-note-edit-textarea').trumbowyg('html'));
	    $('#album-note-edit-form').submit();
	    $('#save-note-btn').attr('disabled', true);
	});

    });


    // approves
    $('#show-note-column .noteapprovebutton').on('click', function() {
	var that = this;

	$('#show-note-approve-form').attr('action',
					  '/shows/' +
					  $(that).attr('data-parent-id') +
					  '/notes/' +
					  $(that).attr('data-note-id'));

	$('#show-note-approve-form').submit();
    });

    $('#song-note-column .noteapprovebutton').on('click', function() {
	var that = this;

	$('#song-note-approve-form').attr('action',
					  '/songs/' +
					  $(that).attr('data-parent-id') +
					  '/notes/' +
					  $(that).attr('data-note-id'));

	$('#song-note-approve-form').submit();
    });

    $('#album-note-column .noteapprovebutton').on('click', function() {
	var that = this;

	$('#album-note-approve-form').attr('action',
					  '/albums/' +
					  $(that).attr('data-parent-id') +
					  '/notes/' +
					  $(that).attr('data-note-id'));

	$('#album-note-approve-form').submit();
    });


    $('#video-note-column .noteapprovebutton').on('click', function() {
	var that = this;

	$('#video-note-approve-form').attr('action',
					   '/setlistitems/' +
					   $(that).attr('data-parent-id') +
					   '/video/' +
					   $(that).attr('data-note-id'));

	$('#video-note-approve-form').submit();

    });

});
