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

		$scope.comments = function(post) {
			var modalInstance = $modal.open({
				templateUrl: 'comments.html',
				controller: 'commentsController',
				resolve: {
					post: function() {
						return post;
					}
				},
				size: 'lg'
			});
		};
	})

	.controller('commentsController', function($scope, $modalInstance, post, Reddit) {
		$scope.post = post;
		$scope.reddit = new Reddit($scope.post.subreddit, $scope.post.id);

		$scope.cancel = function () {
			$modalInstance.dismiss('cancel');
		};
	})

	.directive('ngBindHtmlUnsafe', ['$sce', function($sce){
	    return {
	        scope: {
	            ngBindHtmlUnsafe: '=',
	        },
	        template: "<div ng-bind-html='trustedHtml'></div>",
	        link: function($scope, iElm, iAttrs, controller) {
	            $scope.updateView = function() {
	                $scope.trustedHtml = $sce.trustAsHtml($scope.ngBindHtmlUnsafe);
	            }

	            $scope.$watch('ngBindHtmlUnsafe', function(newVal, oldVal) {
	                $scope.updateView(newVal);
	            });
	        }
	    };
	}])

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