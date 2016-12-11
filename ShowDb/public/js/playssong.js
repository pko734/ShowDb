$(document).ready(function() {

    var songs = new Bloodhound({
	datumTokenizer: Bloodhound.tokenizers.whitespace,
	queryTokenizer: Bloodhound.tokenizers.whitespace,
	prefetch: '/data/songs'
    });


    $('.ac-song-title .typeahead').typeahead({
	highlight: true,
	cache: false
    }, {
	name: 'songs',
	source: songs,
    });

});
