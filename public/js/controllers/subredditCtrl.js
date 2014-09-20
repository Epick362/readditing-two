angular.module('subredditCtrl', [])

	// inject the Comment service into our controller
	.controller('subredditController', function($scope, $attrs, $http, $modal, Reddit) {
		$scope.reddit = new Reddit($attrs.subreddit);
		$scope.subscribed = $attrs.subscribed;

		var base_url = 'http://107.170.53.44/';

		$scope.vote = function(thing, type, dir) {
			var url = base_url + 'api/vote/'+ type +'_' + thing.id;

			if(dir === 1) {
				var method = 'POST';
			}else{
				var method = 'DELETE';
			}

			$http({method: method, url: url})
			.success(function() {
				if(dir === 1) {
					thing.liked = true;
				}else{
					thing.liked = false;
				}
			})
			.error(function() {
				alert('Error while upvoting.');
			});
		};

		$scope.save = function(thing, type, dir) {
			var url = base_url + 'api/save/'+ type +'_' + thing.id;

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
			var url = base_url + 'api/subscribe/'+ $attrs.subreddit;

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
					},
					vote: function() {
						return $scope.vote;
					},
					reply: function() {
						return $scope.reply;
					}
				},
				size: 'lg'
			});
		};

		$scope.reply = function(thing, type) {
			var url = base_url + 'api/comment';

			$http({
				method: 'POST', 
				url: url,
				data: {
					text: thing.reply,
					thing: type + '_' + thing.id
				}
			})
			.success(function() {
				thing.replied = true;
				alert('Ok. -Rammus');
			})
			.error(function() {
				alert('Error while posting.');
			});
		};
	})

	.controller('commentsController', function($scope, $modalInstance, post, save, vote, reply, Reddit) {
		$scope.post = post;
		$scope.save = save;
		$scope.vote = vote;
		$scope.reply = reply;
		$scope.reddit = new Reddit($scope.post.subreddit, $scope.post.id);

		$scope.cancel = function () {
			$modalInstance.dismiss('cancel');
		};
	})

	.directive('replyForm', function($compile){
	    return {
	    	restrict: 'A',
	        link: function(scope, element, attrs) {
	            element.bind('click', function(e) {
	                e.stopPropagation();
	                
	                element.closest('.media-body').find('.replyForm:first').html($compile('<form ng-submit="reply(comment, \'t1\')"><div class="form-group" style="margin:10px 0 0 30px"><textarea class="form-control" ng-model="comment.reply" rows="3"></textarea><button style="margin-top:10px" class="btn btn-primary">Send</button></div></form>')(scope));
	            });
	        }
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