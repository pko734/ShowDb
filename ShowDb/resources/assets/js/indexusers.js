$(document).ready(function() {
    $cb = new Clipboard('#usershare');
    $cb.on('success', function(e) {
	$('#usershare').attr('data-original-title', 'Copied!').tooltip('fixTitle').tooltip('show');
    });

    $('[data-toggle="tooltip"]').tooltip();
});
