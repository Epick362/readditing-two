angular.module('subredditCtrl', [])

	// inject the Comment service into our controller
	.controller('subredditController', function($scope, $http, Subreddit) {
		// loading variable to show the spinning loading icon
		$scope.loading = true;

		// get all the comments first and bind it to the $scope.comments object
		// use the function we created in our service
		// GET ALL COMMENTS ====================================================
		Subreddit.get()
			.success(function(data) {
				$scope.posts = data;
				$scope.loading = false;
			});
	});