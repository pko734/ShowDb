$(document).ready(function() {
    $("#slide_text").trumbowyg({
        //btns: [['bold', 'italic'], ['link'],['base64']],
        autogrow: true
    });

    $('#delete-slide-btn').on('click', function() {
        bootbox.confirm('Are you sure you want to delete this slide?', function(result) {
            if(result) {
                $('#delete-timeline-form').submit();
            }
        });
    });
    
});
