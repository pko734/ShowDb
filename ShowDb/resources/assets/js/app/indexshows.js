$(document).ready(function() {
    var datbutton = false;
    var date_type = $('#addbutton').attr('data-show-date') ? "text" : "hidden";

    $('#addbutton').click(function() {
	$('#showtable tbody').append('<tr><td><input name="dates[]" class="form-control" type="' + date_type + '" placeholder="YYYY-MM-DD" value="' + $('#user-add-show-form').attr('data-default-date') + '"></td><td></td><td><input name="venues[]" value="" class="form-control" type="text" placeholder="Venue - City, State"></td></tr>');

	if(!datbutton) {
	    $('#showtable').append('<button id="addbutton" type="submit" class="btn btn-primary">Submit</button>');
	    if($('#showtable').attr('data-display-creator-notice') == '1') {
		$('#showtable').after('<div>Please note: Fantasy shows that you create can be seen by any logged in user of this site, and will show your username as well.</div>');
	    }
	    datbutton = true;
	}

	$('html, body').scrollTop( $(document).height() );
    });

    $('.add-show-link').on('click', function(e) {
	e.preventDefault();
	$('#user-add-show-form').attr('action', '/users/shows/' + $(this).attr('data-show-id'));
	$('#user-add-show-form').submit();
	return false;
    });

    $('.remove-show-link').on('click', function(e) {
	e.preventDefault();
	$('#user-remove-show-form').attr('action', '/users/shows/' + $(this).attr('data-show-id'));
	$('#user-remove-show-form').submit();
	return false;
    });
});
