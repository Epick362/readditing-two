angular.module('subredditCtrl', [])

	.config(function($sceProvider) {
	  // Completely disable SCE.  For demonstration purposes only!
	  // Do not use in new projects.
	  $sceProvider.enabled(false);
	})

	// inject the Comment service into our controller
	.controller('subredditController', function($scope, $attrs, $http, $modal, Reddit) {
		$scope.reddit = new Reddit($attrs.subreddit);

		$scope.subscribed = $attrs.subscribed;

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
			}else{
				var method = 'DELETE';
			}

			$http({method: method, url: url})
			.success(function() {
				if(dir === 1) {
					thing.saved = true;
				}else{
					thing.saved = false;
				}
			})
			.error(function() {
				alert('Error while saving.');
			});	
		};

		$scope.subscribe = function(dir) {
			var url = 'api/subscribe/'+ $attrs.subreddit;

			if(dir === 1) {
				var method = 'POST';
			}else{
				var method = 'DELETE';
			}

			$http({method: method, url: url})
			.success(function() {
				if(dir === 1) {
					$scope.subscribed = true;
				}else{
					$scope.subscribed = false;
				}
			})
			.error(function() {
				alert('Error while subscribing.');
			});	
		}

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