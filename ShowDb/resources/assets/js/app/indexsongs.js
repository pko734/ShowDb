$(document).ready(function() {
    var datbutton = false;

    $('#addbutton').click(function() {
	$('#songtable tbody').prepend('<tr><td></td><td><input name="songs[]" value="" class="form-control" type="text" placeholder="Song Title"></td><td></td></tr>');

	if(!datbutton) {
	    $('#songtable').prepend('<button id="addbutton" type="submit" class="btn btn-primary">Submit</button>');
	    datbutton = true;
	}
    });
});
