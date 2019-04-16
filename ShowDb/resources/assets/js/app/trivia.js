$(document).ready(function() {
    $('#delete-question-btn').on('click', function() {
        bootbox.confirm('Are you sure you want to delete this trivia question?', function(result) {
            if(result) {
                $('#delete-question-form').submit();
            }
        });
    });
    
});
