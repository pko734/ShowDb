$(document).ready(function() {
    datbutton = false;
    $('#merchaddbutton').click(function() {
	if(!datbutton) {
	    $('#add-merch-form').append('<input id="fupload" name="image" class="form-control" type="file" required=""><input maxlength="4" size="4" name="year" value="" class="form-control" type="text" placeholder="Year"><input name="description" value="" class="form-control" type="text" placeholder="description"><button id="addbutton" type="submit" class="btn btn-primary">Submit</button>');
	    datbutton = true;
	}
    });

	$('.merch-claimer').on('click', function(e) {
		e.preventDefault();
		$('#' + $(this).attr('data-target')).toggleClass('hidden');
		return false;
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

    $('.claim-mine').on('click', function(e) {
		e.preventDefault();
		var that = this;
		if($(this).attr('data-merch-status') == '0') {
			$('#user-add-merch-form').attr('action', '/user/merch/' + $(this).attr('data-merch-id'));
			$('#user-merch-claim-mode').attr('value', 'has');
			$('#' + 'claim-mine-' + $(this).attr('data-merch-id')).attr('class', 'far fa-check-square');
			$('#' + 'claim-want-' + $(this).attr('data-merch-id')).attr('class', 'far fa-square');
			$('#' + 'claim-want-' + $(this).attr('data-merch-id')).parent().attr('data-merch-status', '0');
			$('#thumbnail-' + $(that).attr('data-merch-id')).addClass('got-it');
			$('#thumbnail-' + $(that).attr('data-merch-id')).removeClass('want-it');
			$(this).attr('data-merch-status', '1');
			$.ajax({
				url: $('#user-add-merch-form').attr('action'),
				method: 'post',
				data: $('#user-add-merch-form').serialize(),
				success: function(r) {
				}
			});
			//$('#user-add-merch-form').submit();
		} else {
			$('#user-remove-merch-form').attr('action', '/user/merch/' + $(this).attr('data-merch-id'));
			$('#user-merch-claim-mode').attr('value', 'has');
			$(that).find('i').attr('class', 'far fa-square');
			$('#thumbnail-' + $(that).attr('data-merch-id')).removeClass('got-it');
			$(this).attr('data-merch-status', '0');
			$.ajax({
				url: $('#user-remove-merch-form').attr('action'),
				method: 'post',
				data: $('#user-remove-merch-form').serialize(),
				success: function(r) {
				}
			});
			//$('#user-remove-merch-form').submit();
		}
		return false;
	});

    $('.claim-want').on('click', function(e) {
		e.preventDefault();
		var that = this;
		if($(this).attr('data-merch-status') == '0') {
			$('#user-add-merch-form').attr('action', '/user/merch/' + $(this).attr('data-merch-id'));
			$('#user-merch-claim-mode').attr('value', 'want');
			$('#' + 'claim-want-' + $(this).attr('data-merch-id')).attr('class', 'far fa-check-square');
			$('#' + 'claim-mine-' + $(this).attr('data-merch-id')).attr('class', 'far fa-square');
			$('#' + 'claim-mine-' + $(this).attr('data-merch-id')).parent().attr('data-merch-status', '0');
			$('#thumbnail-' + $(that).attr('data-merch-id')).addClass('want-it');
			$('#thumbnail-' + $(that).attr('data-merch-id')).removeClass('got-it');
			$(this).attr('data-merch-status', '1');
			$.ajax({
				url: $('#user-add-merch-form').attr('action'),
				method: 'post',
				data: $('#user-add-merch-form').serialize(),
				success: function(r) {
				}
			});
			//$('#user-add-merch-form').submit();
		} else {
			$('#user-remove-merch-form').attr('action', '/user/merch/' + $(this).attr('data-merch-id'));
			$('#user-merch-claim-mode').attr('value', 'want');
			$(that).find('i').attr('class', 'far fa-square');
			$('#thumbnail-' + $(that).attr('data-merch-id')).removeClass('want-it');
			$(this).attr('data-merch-status', '0');
			$.ajax({
				url: $('#user-remove-merch-form').attr('action'),
				method: 'post',
				data: $('#user-remove-merch-form').serialize(),
				success: function(r) {
				}
			});
			//$('#user-remove-merch-form').submit();
		}
		return false;
	});

});
