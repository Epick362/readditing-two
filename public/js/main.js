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
		$.ajax({
			url: 'http://www.reddit.com/',
			crossDomain: true
		})
		.done(function(data) {
			$(modal_body).html('<pre>'+ data +'</pre>');
		})
		.fail(function(xhr, status, error) {
			$(modal_body).find('.modal-body').html('<div class="alert alert-danger">Sorry, there was a problem with your request.</div>');
			console.log(xhr)
		});
	});
});