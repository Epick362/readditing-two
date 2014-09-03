$(function() {
	$("figure.upvoteable").upvoteable();

	console.log('hei boi');

	$("figure.upvote").bind("upvote:added", function(e) {
		
	});

	$("figure.upvote").bind("upvote:removed", function(e) {
		
	});
});