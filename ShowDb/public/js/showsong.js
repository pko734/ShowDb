$('#deletebtn').on('click', function(){
    if( confirm("Do you want to delete this item?") ) {
	$('#deleteform').submit();
    }
});

$('.notedeletebutton').on('click', function() {
    $('#deletenoteform').attr('action', $('#deletenoteform').attr('action') + $(this).attr('data-note-id'));
    $('#deletenoteform').submit();
    $('.notedeletebutton').attr('disabled', true);
});

datbutton = false;

$(document).ready(function() {
    $('#noteaddbutton').click(function() {
	$('#notetable tbody').append('<tr><td><textarea data-provide="markdown" name="notes[]" value="" class="form-control" type="text" placeholder="Note"></textarea></td></tr>');
	$("textarea").markdown();
	if(!datbutton) {
	    $('#notetable').append( '<button id="addbutton" type="submit" class="btn btn-primary">Add Notes</button>');
	    datbutton = true;
	}

    });
});
