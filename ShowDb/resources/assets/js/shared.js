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

ASD.animateAlerts = function(){
  $('#asd-messages-box .alert').each(function(){
    var _alert = $(this);
    var _type = 'success';
    var _message = '';
    if (_alert.hasClass('alert-success')){
      _type = 'success';
    }else if (_alert.hasClass('alert-danger')){
      _type = 'danger';
    }else if (_alert.hasClass('alert-warning')){
      _type = 'warning';
    }else if (_alert.hasClass('alert-info')){
      _type = 'info';
    }
    _alert.find('strong').remove();
    _message = _alert.html();
    ASD.alert({type:_type,message:_message});
    _alert.remove();
  })
};

/* ======================================== */
/*                 alert                    */
/* ======================================== */
/* Todo: Better errors */
ASD.alert = function(args){
  var output = '';
  var icon = '';
  var $output;
  var mAlerts = $('#modal-alerts');
  if (!mAlerts.length){
    $('body').append('<div id="modal-alerts"></div>');
  }
  mAlerts = $('#modal-alerts');

  args.type = args.type || 'warning';
  args.message = args.message || '';
  args.time = args.time || 10000;
  switch(args.type){
    case 'warning':
      icon = '<i class="glyphicon glyphicon-warning-sign"></i>';
      break;
    case 'info':
      icon = '<i class="glyphicon glyphicon-info-sign"></i>';
      break;
    case 'danger':
      icon = '<i class="glyphicon glyphicon-remove"></i>';
      break;
    case 'success':
      icon = '<i class="glyphicon glyphicon-ok"></i>';
      break;
  }
  output += '<div class="alert-modal" style="display:none;">';
  output += '<div class="alert alert-'+args.type+'">';
  //output += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
  output += '<div class="alert-left">';
  output += icon;
  output += '</div>';
  output += '<div class="alert-right">';
  if (args.type == 'danger'){
    args.type = 'error';
  }
  output += '<p><strong>'+args.type+': </strong>'+args.message+'</p>';
  output += '</div>';
  output += '</div>';
  output += '</div>';


  $output = $(output).fadeIn('fast',function(){
    var me = $(this);
    setTimeout(function(){
      me.slideUp('fast',function(){
	$(this).remove();
      });
    },args.time);
  });

  mAlerts.append($output);
}


$(document).ready(function(){
  ASD.imageRotators.init();
  ASD.animateAlerts();
});
