$(function() {
	//
	//	 Show more text on very long posts
	//
	$('.btn-showmore').on('click', function() {
		$(this).hide();
		var post = $(this).closest('.panel-body');
		var text = post.find('.panel-text');
		$(text).removeClass('panel-text-short');
	});

	//
	//	 Load comments from reddit
	//
	$('.btn-showcomments').on('click', function() {
		var modal = $(this).closest('.panel').find('.modal');
		var modal_body = $(modal).find('.modal-body');
		$(modal).modal();
		
	});
});