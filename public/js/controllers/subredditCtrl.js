angular.module('subredditCtrl', [])

	// inject the Comment service into our controller
	.controller('subredditController', function($scope, $attrs, $http, $modal, Reddit) {
		$scope.reddit = new Reddit($attrs.subreddit);

		$scope.vote = function(id, dir) {
			var url = 'api/vote/t3_' + id;

			if(dir === 1) {
				var method = 'POST';
			}else{
				var method = 'DELETE';
			}

			$http({method: method, url: url})
			.error(function() {
				alert('Error while upvoting.');
			});
		};

		$scope.comments = function(id) {
			var modalInstance = $modal.open({
				templateUrl: 'comments.html',
				controller: 'commentsController',
				resolve: {
					id: id
				}
			});
		};
	})

	.controller('commentsController', function($scope, $modalInstance, id) {

		$scope.id = id;

		console.log($scope.id);

		$scope.cancel = function () {
			$modalInstance.dismiss('cancel');
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