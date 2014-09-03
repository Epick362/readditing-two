$(function() {
	//
	//	 Show more text on very long posts
	//
	$('.btn-showmore').on('click', function() {
		$(this).hide();
		var post = $(this).closest('.panel-body');
		var text = post.find('.panel-text');
		$(text).removeClass('panel-text-short');
		return false;
	});

	//
	//	 Load comments from reddit
	//
	$('.btn-showcomments').on('click', function() {
		var modal = $(this).closest('.panel').find('.modal');
		var modal_body = $(modal).find('.modal-body');
		$(modal).modal();
		$(modal_body).html('<div class="loading"><div class="ball"></div><div class="ball1"></div></div>');
		return false;
	});

	//
	//	 Save this post to reddit
	//
	$('.btn-postAction').on('click', function() {
		var action = $(this).data('action');
		var postID = $(this).closest('.panel').data('post');

		if(typeof postID !== "undefined") {
			switch(action) {
				case 'report':
				break;
				case 'hide':
				break;
				case 'save':
				break;
			}
			// do AJAX
			console.log(action+" postID: "+postID);
		}else{
			console.log('Post has no ID data.');
		}
		return false;
	});
});
