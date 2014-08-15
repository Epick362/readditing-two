angular.module('subredditCtrl', [])

	// inject the Comment service into our controller
	.controller('subredditController', function($scope, $attrs, $sce, $http, Subreddit) {
		// loading variable to show the spinning loading icon
		$scope.loading = true;

		// get all the comments first and bind it to the $scope.comments object
		// use the function we created in our service
		// GET ALL COMMENTS ====================================================
		console.log($attrs.subreddit);

		Subreddit.get($attrs.subreddit)
			.success(function(data) {
				for (var i = data.length - 1; i >= 0; i--) {
					data[i].content = $sce.trustAsHtml(data[i].content);
				};
				$scope.posts = data;
				$scope.loading = false;
			});
	})

	.directive('showMore', function($document){
	    return {
	        restrict: 'A',
	        link: function(scope, element, attrs) {
	            element.bind('click', function(e) {
	                e.stopPropagation();

	                element.find('.showmore-container').remove();
	                element.find('.panel-text').removeClass('panel-text-short');
	            });
	        }
	    };
	});