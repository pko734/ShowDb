$(document).ready(function() {
    datbutton = false;
    console.log('asdf');
    $('#albumaddbutton').click(function() {
	$('#albumtable tbody').append('<tr><td></td><td><input name="dates[]" value="" class="form-control" type="text" placeholder="YYYY-MM-DD"></td><td></td><td><input name="titles[]" value="" class="form-control" type="text" placeholder="Album Title"></td></tr>');

	if(!datbutton) {
	    $('#albumtable').append( '<button id="addbutton" type="submit" class="btn btn-primary">Submit</button>');
	    datbutton = true;
	}

	$('html, body').scrollTop( $(document).height() );
    });
});
