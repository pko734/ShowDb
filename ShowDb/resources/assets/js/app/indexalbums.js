$(document).ready(function() {
    datbutton = false;
    $('#albumaddbutton').click(function() {
	$('#albumtable tbody').prepend('<tr><td></td><td><input name="dates[]" value="" class="form-control" type="text" placeholder="YYYY-MM-DD"></td><td></td><td><input name="titles[]" value="" class="form-control" type="text" placeholder="Album Title"></td></tr>');

	if(!datbutton) {
	    $('#albumtable').prepend( '<button id="addbutton" type="submit" class="btn btn-primary">Submit</button>');
	    datbutton = true;
	}
    });
});
