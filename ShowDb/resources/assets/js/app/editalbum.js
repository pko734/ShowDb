$(document).ready(function() {
    var songs = new Bloodhound({
	datumTokenizer: Bloodhound.tokenizers.whitespace,
	queryTokenizer: Bloodhound.tokenizers.whitespace,
	prefetch: '/data/songs'
    });

    $('#albumitemaddbutton').click(function() {
	$('#albumitemtable tbody').append('<tr><td><span class="ac-song-title-new"><input name="songs[]" value="" class="form-control typeahead" type="text" placeholder="Song Title"></span></td></tr>');

	$('.ac-song-title-new .typeahead').typeahead({
	    highlight: true,
	    cache: false
	}, {
	    name: 'songs',
	    source: songs,
	});

	$('.ac-song-title-new')
	    .removeClass('ac-song-title-new')
	    .addClass('ac-song-title');

	$('html, body').scrollTop( $(document).height() );
    });

    var songs = new Bloodhound({
	datumTokenizer: Bloodhound.tokenizers.whitespace,
	queryTokenizer: Bloodhound.tokenizers.whitespace,
	prefetch: '/data/songs'
    });

    // passing in `null` for the `options` arguments will result in the default
    // options being used
    $('#albumitemtable .ac-song-title .typeahead').typeahead({
	highlight: true,
	cache: false
    }, {
	name: 'songs',
	limit: 10,
	source: songs,
    });

});
