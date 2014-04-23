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
});