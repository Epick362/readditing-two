$(function() {
	$("figure.upvoteable").upvoteable();

	$("figure.upvote").bind("upvote:added", function(e) {
		var post = $(this).closest('.panel').data('post');
		 $.ajax({
			  type: 'POST',
			  url: 'http://readditing.com/ajax/vote',
			  data: {'fullname': 't3_'+post, 'dir': '1'},
			  success: function(data){
			  	//alert('upvoted!');
			  },
			  error: function() {
			  	//alert('error');
			  },
			  dataType: 'html'
		 });
	});

	$("figure.upvote").bind("upvote:removed", function(e) {
		var post = $(this).closest('.panel').data('post');
		 $.ajax({
			  type: 'POST',
			  url: 'http://readditing.com/ajax/vote',
			  data: {'fullname': 't3_'+post, 'dir': '0'},
			  success: function(data){
			  	//alert('upvote removed!');
			  },
			  error: function() {
			  	//alert('error');
			  },
			  dataType: 'html'
		 });
	});
});