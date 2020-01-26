$(document).ready(function() {
    datbutton = false;
    $('#merchaddbutton').click(function() {
	if(!datbutton) {
	    $('#merchtable tbody').prepend('<tr><td colspan="2"><table><tbody><tr><td><input id="fupload" name="image" class="form-control" type="file" required=""></td><td><input maxlength="4" size="4" name="year" value="" class="form-control" type="text" placeholder="Year"></td><td><input name="description" value="" class="form-control" type="text" placeholder="description"></td><td><button id="addbutton" type="submit" class="btn btn-primary">Submit</button></td></tr></tbody></table></td></tr>');
	    datbutton = true;
	}
    });

    $('.delete-merch-btn').on('click', function() {
	var that = this;

	bootbox.confirm('Delete this merch?', function(result) {
	    if(result) {
			$('#delete-merch-form').attr('action',
						     '/merch/' +
						     $(that).attr('data-merch-id'));
			$('#delete-merch-form').submit();
	    }
	});
    });

	$('#year_selector').on('change', function() {
		var val = $(this).val();
		if (val) {
			window.location = '/merch/posters?selector=year&year=' + val;
		}
	});
	$('#artist_selector').on('change', function() {
		var val = $(this).val();
		if (val) {
			window.location = '/merch/posters?selector=artist&artist_id=' + val;
		}
	});
});
