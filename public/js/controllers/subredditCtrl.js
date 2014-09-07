angular.module('subredditCtrl', [])

	// inject the Comment service into our controller
	.controller('subredditController', function($scope, $attrs, $http, Reddit) {
		$scope.reddit = new Reddit($attrs.subreddit);

		$scope.vote = function(id, dir) {
			var url = 'api/vote/' + id;

			console.log(url);

			$http({method: 'POST', url: url})
			.success(function(data) {
				console.log(data);
				alert('okay');
			})
			.error(function(data) {
				alert('error');
			});
		};
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