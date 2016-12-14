$(document).ready(function() {
    $('#addbutton').click(function() {
	$('#songtable tbody').append('<tr><td><input name="songs[]" value="" class="form-control" type="text" placeholder="Song Title"></td><td></td></tr>');

	$('html, body').scrollTop( $(document).height() );
    });
});
