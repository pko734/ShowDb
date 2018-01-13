$(document).ready(function() {
    $cb = new Clipboard('#usershare');
    $cb.on('success', function(e) {
	$('#usershare').attr('data-original-title', 'Copied to clipboard!').tooltip('fixTitle').tooltip('show');
    });

    $('[data-toggle="tooltip"]').tooltip();
});
