/* This stuff is shared across the site */

var ASD = ASD || {};

ASD.imageRotators = {
  init: function(){
    $('[data-bg-images]').each(function(){
      var self = $(this);
      var data = self.attr('data-bg-images');
      data = data.replace(/,\s*$/, "");
      var arr = data.split(',');
      var rand = Math.floor(Math.random() * (arr.length))
      $('<div class="bg-slider"/>').css({'background-image': 'url(' + arr[rand] + ')','display':'none'}).appendTo($(this)).fadeIn('slow');
      self.find('.loading').fadeOut('slow');
    })
  }
};

$(document).ready(function(){
  ASD.imageRotators.init();
});