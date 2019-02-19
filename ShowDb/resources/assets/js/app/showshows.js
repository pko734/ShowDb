$(document).ready(function() {
    $('.video_link').attr('data-youtube', function() { return getVideoId(this.href).id }); 

    $('#delete-show-btn').on('click', function() {
//	$("#mi-modal").modal('show');
	console.log('test');
	bootbox.confirm('Are you sure you want to delete this show?', function(result) {
	    if(result) {
		    $('#delete-show-form').submit();
	    }
	});

    });

    $('.delete-show-note-btn').on('click', function() {
	$('#delete-show-note-form').attr('action', $('#delete-show-note-form').attr('action') + $(this).attr('data-note-id'));
	$('#delete-show-note-form').submit();
	$('.delete-show-note-btn').attr('disabled', true);
    });

    $('#show-note-form .post-description').on('click', function(e) {
	if(!$(e.target).hasClass('edit-show-note-btn') && !$(e.target).hasClass('glyphicon-edit')) {
	    return;
	}

	var content = $($(this).children('.note-content')[0]);
	content.addClass('hide');

	$($(this).children('.stats')[0]).append( '<button id="save-note-btn" type="submit" class="btn btn-primary">Save Note</button>');
	$('.edit-show-note-btn').attr('disabled', true);

	content.after('<textarea id="show-note-edit-textarea" name="note">' + content.html() + '</textarea>');
	$("textarea").trumbowyg({

	    btns: [['bold', 'italic'], ['link'],['base64'], ['removeformat']],
	    autogrow: true
	});

	var that = this;
	$('#save-note-btn').on('click', function() {
	    var note_id = $(that).attr('data-note-id');
	    $('#edit-show-note-form').attr('action', $('#edit-show-note-form').attr('action') + note_id);
	    $('#edit-show-note-form').children('input[name=note]').val($('#show-note-edit-textarea').trumbowyg('html'));
	    $('#edit-show-note-form').submit();
	    $('#save-note-btn').attr('disabled', true);
	});

    });

    if(('#add-show-note-btn').length) {
	var add_check = {
	    init: function() {
		setTimeout(add_check.check, 2000);
	    },
	    check: function() {
		if($('#add-show-note-btn').isOnScreen()) {
		    $('#add-show-note-btn').tooltip('show')
		} else {
		    setTimeout(add_check.check, 2000);
		}
	    }
	}
	add_check.init();
    }

    var datbutton = false;
    $('#add-show-note-btn').click(function() {
	$('#notetable tbody').append('<tr><td><textarea name="notes[]" class="form-control" type="text" placeholder="Note"></textarea></td></tr>');

	$("textarea").trumbowyg({

	    btns: [['bold', 'italic'], ['link'],['base64']],
	    autogrow: true
	});

	if(!datbutton) {
	    $('#notetable').append( '<button id="addbutton" type="submit" class="btn btn-primary">Add Notes</button>');
	    datbutton = true;
	    window.scrollTo(0,$('#addbutton').offset().top - $(window).height()/2);

	}

    });

    $('.edit-video-btn').on('click', function() {
	var that = this;

	bootbox.prompt('Enter Video URL', function(result) {
	    if(result) {
		$('#videoinput').val(result);
		$('#add-video-form').attr('action',
					  '/setlistitems/' +
					  $(that).attr('data-item-id') +
					  '/video');
		$('#add-video-form').submit();
	    }
	});
    });

    $('.photo-add-btn').on('click', function() {
	var that = this;
	var uploadHtml = "<div>" +
	    "<p>When you contribute images to this site, you retain any copyright you have in the content, but you grant us permission to use it to provide our service, including reproducing and displaying your content to the public on our site.</p>" + 
	    "<p>If the content you contribute is not owned by you, you represent and warrant that it is either in the public domain or available under a Creative Commons license, or that you are authorized to use it by the rights holder or by law.</p>" +
	    "<p>Finally, we require that you grant permission for The Avett Brothers to use it in any way they see fit.</p>" + 
            "<form data-focus='false' data-toggle='validator' id='photo-add-form' method='POST' action='" + window.Laravel.showId + "/upload' accept-charset='UTF-8' enctype='multipart/form-data'>" +
	    "<div class='form-group'>" + 
	    "<div class='checkbox'>" +	
	    "<label><input name='tos' type='checkbox' checked value='1' required>I have read and agree the above terms.</label>" + 
	    "</div>" + 
	    "</div>" + 
	    "<div class='form-group'>" + 
	    "<div class='checkbox'>" +	
	    "<label><input name='certify' type='checkbox' value='1' checked required>I certify that this photo is from following show:<br/>" + window.Laravel.showDetail + "</label>" + 
	    "</div>" + 
	    "</div>" + 
	    "<div class='form-group'>" + 
	    "<label for='name'>Photo Credit</label>" + 
	    "<input type='text' class='form-control' id='name' name='photo_credit' value='" + window.Laravel.username + "'>" + 
	    "</div>" + 
	    "<div class='form-group'>" + 
	    "<label for='name'>Photo Caption</label>" + 
	    "<input type='text' class='form-control' id='name' name='photo_caption' placeholder='Optional'>" + 	    
	    "</div>" + 
	    "<div class='form-group'>" + 
	    "<input name='_token' type='hidden' value='" + window.Laravel.csrfToken + "'>" + 
            "<div class='row'>" + 
            "<div class='col-md-6'>" + 
	    "<input id='fupload' class='form-control' name='image[]' type='file' required multiple>" + 
            "</div>" +
            "<div class='col-md-6'>" + 
            "</div>" +
            "</div>" +
            "</div>" +
            "</form>" +
	    "<br />" +
	    "<span style='margin-left:5px !important;' id='fileList'></span>" +
	    "</div><div class='clearfix'></div>";
	console.log('hi');
	bootbox.dialog({
	    message: uploadHtml,
	    title: "Image Upload",
	    closeButton: true,
	    buttons: {
		success: {
		    label: "Upload",
		    className: "btn-default",
		    callback: function () {
			window.photo_add_form_valid = true;
			$('#photo-add-form').validator().on('submit', function (e) {
			    window.photo_add_form_valid = !e.isDefaultPrevented();
			});
			$('#photo-add-form').submit();
			return window.photo_add_form_valid;
		    }
		}
	    }
	}).init(function() {
	    $('#photo-add-form').validator('update');
	});


	var fileList = document.getElementById("fupload");
	fileList.addEventListener("change", function (e) {
	    var list = "";
	    for (var i = 0; i < this.files.length; i++) {
		list += "<div class='col-xs-12 file-list'>" + this.files[i].name + "</div>"
	    }
	    
	    $("#fileList").html(list);
	}, false);
    });
    

    $('.delete-video-btn').on('click', function() {
	var that = this;

	bootbox.confirm('Delete this video?', function(result) {
	    if(result) {
		$('#delete-video-form').attr('action',
					     '/setlistitems/' +
					     $(that).attr('data-item-id') +
					     '/video/' +
					     $(that).attr('data-video-id'));
		$('#delete-video-form').submit();
	    }
	});
    });

    $('.blueimp-gallery > .delete').on('click', function(e) {
        var photo_id = $(this).attr('data-photo-id');
        $('#delete-photo-form').attr('action', $('#delete-photo-form').attr('action') + photo_id);
        $('#delete-photo-form').submit();
    });

    $('.blueimp-gallery > .approve').on('click', function(e) {
        var photo_id = $(this).attr('data-photo-id');
        $('#approve-photo-form').attr('action', $('#approve-photo-form').attr('action') + photo_id);
        $('#approve-photo-form').submit();
    });

    $('#blueimp-gallery').on('open', function(e) {
	$('#blueimp-gallery').data('gallery').options.continuous = false;
	$('#blueimp-gallery').data('gallery').options.fullScreen = false;
    });

    $('#blueimp-gallery').on('slide', function(e, index, slide) {
	var photo_id = $($('#blueimp-gallery').data('gallery').list[index]).data('photo-id');

	$('.blueimp-gallery > .delete').hide();
	if($($('#blueimp-gallery').data('gallery').list[index]).data('deletable') == '1') {
	    $('.blueimp-gallery > .delete').show();
	    $('.blueimp-gallery > .delete').off('click');
	    $('.blueimp-gallery > .delete').on('click', function(e) {
		bootbox.confirm('Delete this photo?', function(result) {
		    if(result) {
			$('#delete-photo-form').attr('action', $('#delete-photo-form').attr('action') + photo_id);
			$('#delete-photo-form').submit();
		    }
		});
	    });
	}

	$('.blueimp-gallery > .approve').hide();	
	if($($('#blueimp-gallery').data('gallery').list[index]).data('approvable') == '1') {
	    $('.blueimp-gallery > .approve').show();
	    $('.blueimp-gallery > .approve').off('click');
	    $('.blueimp-gallery > .approve').on('click', function(e) {
		bootbox.confirm('Approve this photo?', function(result) {
		    if(result) {
			$('#approve-photo-form').attr('action', $('#approve-photo-form').attr('action') + photo_id);
    			$('#approve-photo-form').submit();
		    }
		});
	    });
	}
    });
});
