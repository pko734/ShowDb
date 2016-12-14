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

$('#video-note-column .notedeletebutton').on('click', function() {
    var that = this;

    $('#video-note-delete-form').attr('action',
				      '/setlistitems/' +
				      $(that).attr('data-parent-id') +
				      '/video/' +
				      $(that).attr('data-note-id'));

    $('#video-note-delete-form').submit();

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

$('#video-note-column .noteapprovebutton').on('click', function() {
    var that = this;

    $('#video-note-approve-form').attr('action',
				      '/setlistitems/' +
				      $(that).attr('data-parent-id') +
				      '/video/' +
				      $(that).attr('data-note-id'));

    $('#video-note-approve-form').submit();

});
