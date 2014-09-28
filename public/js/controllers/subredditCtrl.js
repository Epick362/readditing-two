angular.module('subredditCtrl', [])

	// inject the Comment service into our controller
	.controller('subredditController', function($scope, $attrs, $http, $modal, $window, Reddit) {
		if($attrs.subreddit) {
			$scope.reddit = new Reddit($attrs.subreddit);
			$scope.subscribed = $attrs.subscribed;
		}else{
			$scope.reddit = new Reddit(false, $attrs.profile);
		}
		$scope.user = $attrs.user;

		var base_url = 'http://preview.readditing.com/';

		$scope.submit = function(post, kind) {
			if($attrs.user == false) {
				$window.location.href = base_url + 'login';
				return;
			}

			var url = base_url + 'api/submit';

			post['kind'] = kind;

			$http({
				method: 'POST', 
				url: url,
				data: post
			})
			.success(function(data) {
				$window.location.href = base_url + 'r/'+post.sr+'/comments/'+data['json']['data']['id'];
			})
			.error(function() {
				alert('Error while posting.');
			});	
		};

		$scope.jumpTo = function() {
			$window.location.href = base_url + 'r/' + $scope.sr;
		};

		$scope.vote = function(thing, type, dir) {
			if($attrs.user == false) {
				$window.location.href = base_url + 'login';
				return;
			}

			var url = base_url + 'api/vote/'+ type +'_' + thing.id;

			if(dir === 1) {
				var method = 'POST';
			}else{
				var method = 'DELETE';
			}

			$http({method: method, url: url})
			.success(function() {
				if(dir === 1) {
					thing.likes = true;
					thing.score ++;
				}else{
					thing.likes = false;
					thing.score --;
				}
			})
			.error(function() {
				alert('Error while upvoting.');
			});
		};

		$scope.save = function(thing, type, dir) {
			if($attrs.user == false) {
				$window.location.href = base_url + 'login';
				return;
			}

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
			if($attrs.user == false) {
				$window.location.href = base_url + 'login';
				return;
			}

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
			if($attrs.user == false) {
				$window.location.href = base_url + 'login';
				return;
			}

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

				if(type !== 't3') {		
					var reply = {
						author: $scope.user,
						score: 1,
						body: thing.reply,
						likes: true,
						saved: false,
						replies: false
					};

					if(typeof thing.replies !== 'object') {
						thing.replies = [];
					}

					thing.replies.push(reply);
				}
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

	                if(attrs['replyForm'] === 'post') {
	                	element.closest('.modal-dialog').find('.media-list').prepend($compile('<li ng-show="!post.replied" class="media"><div class="media-body"><form ng-submit="reply(post, \'t3\')"><div class="form-group"><textarea class="form-control" ng-model="post.reply" rows="3"></textarea><button style="margin-top:10px" class="btn btn-primary">Send</button></div></form></div></li>')(scope));
	                }else{
	                	element.closest('.media-body').find('.replyForm:first').html($compile('<form ng-show="!comment.replied" ng-submit="reply(comment, \'t1\')"><div class="form-group" style="margin:10px 0 0 30px"><textarea class="form-control" ng-model="comment.reply" rows="3"></textarea><button style="margin-top:10px" class="btn btn-primary">Send</button></div></form>')(scope));
	                }
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