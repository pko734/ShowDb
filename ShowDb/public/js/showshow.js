$('#deletebtn').on('click', function(){
    if( confirm("Do you want to delete this item?") ) {
	$('#deleteform').submit();
    }
});
