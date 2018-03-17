$(document).ready(function() {
    if(('#addbutton span').length) {
	$('#addbutton span').tooltip('show')
    }

    var songs = new Bloodhound({
	datumTokenizer: Bloodhound.tokenizers.whitespace,
	queryTokenizer: Bloodhound.tokenizers.whitespace,
	prefetch: '/data/songs'
    });

    $('#addbutton').click(function() {
	$('#addbutton span').tooltip('hide')
	$('#setlisttable tbody').append('<tr><td><span class="ac-song-title-new"><input name="songs[]" value="" class="form-control typeahead" type="text" placeholder="Song Title"></span></td></tr>');

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

    (function() {
	var songs = new Bloodhound({
	    datumTokenizer: Bloodhound.tokenizers.whitespace,
	    queryTokenizer: Bloodhound.tokenizers.whitespace,
	    prefetch: '/data/songs'
	});

	$('#setlisttable .ac-song-title .typeahead').typeahead({
	    highlight: true,
	    cache: false
	}, {
	    name: 'songs',
	    limit: 10,
	    source: songs
	})
     })();

    (function() {
	var states = new Bloodhound({
	    datumTokenizer: Bloodhound.tokenizers.whitespace,
	    queryTokenizer: Bloodhound.tokenizers.whitespace,
	    prefetch: '/data/states'
	});

	$('.ac-show-state .typeahead').typeahead({
	    highlight: true,
	    cache: false
	}, {
	    name: 'states',
	    limit: 10,
	    source: states
	})
     })();


});
