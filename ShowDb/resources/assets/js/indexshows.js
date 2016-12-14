datbutton = false;

$(document).ready(function() {
    $('#addbutton').click(function() {
	$('#showtable tbody').append('<tr><td><input name="dates[]" value="" class="form-control" type="text" placeholder="YYYY-MM-DD"></td><td></td><td><input name="venues[]" value="" class="form-control" type="text" placeholder="Venue - City, State"></td></tr>');

	if(!datbutton) {
	    $('#showtable').append( '<button id="addbutton" type="submit" class="btn btn-primary">Submit</button>');
	    datbutton = true;
	}

	$('html, body').scrollTop( $(document).height() );
    });
});
