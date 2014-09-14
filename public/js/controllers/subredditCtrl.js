angular.module('subredditCtrl', [])

	.config(function($sceProvider) {
	  // Completely disable SCE.  For demonstration purposes only!
	  // Do not use in new projects.
	  $sceProvider.enabled(false);
	})

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

		$scope.save = function(thing, type, dir) {
			var url = 'api/save/'+ type +'_' + thing.id;

			if(dir === 1) {
				var method = 'POST';
				thing.saved = true;
			}else{
				var method = 'DELETE';
				thing.saved = false;
			}

			$http({method: method, url: url})
			.success(function() {
				alert('ok');
			})
			.error(function() {
				alert('Error while upvoting.');
			});	
		};

		$scope.comments = function(post) {
			var modalInstance = $modal.open({
				templateUrl: 'comments.html',
				controller: 'commentsController',
				resolve: {
					post: function() {
						return post;
					},
					save: function() {
						return $scope.save;
					}
				},
				size: 'lg'
			});
		};
	})

	.controller('commentsController', function($scope, $modalInstance, post, save, Reddit) {
		$scope.post = post;
		$scope.save = save;
		$scope.reddit = new Reddit($scope.post.subreddit, $scope.post.id);

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