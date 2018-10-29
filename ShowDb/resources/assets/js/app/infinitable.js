$(document).ready(function() {


    var page = 1;
    if ($(".infinitable")[0]) {
        $(window).scroll(function() {
            console.log($(window).scrollTop() + " " + $(window).height() + " " + $(document).height())
            if($(window).scrollTop() + $(window).height() >= $(document).height()) {
                page++;
                loadMoreData(page);
            }
        });
    }    
    
    function loadMoreData(page){
        $.ajax(
            {
                url: '?page=' + page,
                type: "get",
                beforeSend: function()
                {
                    $('.ajax-load').show();
                }
            })
            .done(function(data)
                  {
                      if(data.html == " "){
                          $('.ajax-load').html("No more records found");
                          return;
                      }
                      $('.ajax-load').hide();
                      $(".infinitable > tbody:last-child").append(data.html);
                  })
            .fail(function(jqXHR, ajaxOptions, thrownError)
                  {
                      alert('server not responding...');
                  });
    }
});
