$(document).ready(function() {
    datbutton = false;

    $('#addbutton').click(function() {
	$('#showtable tbody').append('<tr><td><input name="dates[]" value="" class="form-control" type="text" placeholder="YYYY-MM-DD"></td><td></td><td><input name="venues[]" value="" class="form-control" type="text" placeholder="Venue - City, State"></td></tr>');

	if(!datbutton) {
	    $('#showtable').append( '<button id="addbutton" type="submit" class="btn btn-primary">Submit</button>');
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
