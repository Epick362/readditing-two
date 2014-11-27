	readditingApp.config(["$provide", function ($provide) {
        $provide.value("base_url", $("#ApiRoot").attr("href") + '/');
    }]);

	// inject the Comment service into our controller
	readditingApp.controller('channelController', function($scope, $attrs, $http, $modal, $window, Reddit, base_url) {
		if($attrs.channel) {
			$scope.reddit = new Reddit($attrs.channel, false, $attrs.sort);
			$scope.subscribed = $attrs.subscribed;
		}else{
			$scope.reddit = new Reddit(false, $attrs.profile);
		}
		$scope.user = $attrs.user;
		$scope.nsfw = $attrs.nsfw;

		$scope.setNSFW = function() {
			if(!$scope.nsfw) {
				var method = 'POST';
			}else{
				var method = 'DELETE';
			}

			var url = base_url + 'api/settings/nsfw';

			$scope.nsfw = !$scope.nsfw;

			$http({
				method: method, 
				url: url
			});
		}

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
				console.log('Error while posting.');
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

			thing.likes = !thing.likes;

			$http({method: method, url: url})
			.success(function() {
				if(dir === 1) {
					thing.score ++;
				}else{
					thing.score --;
				}
			})
			.error(function() {
				thing.likes = !thing.likes;
				console.log('Error while upvoting.');
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
			
			thing.saved = !thing.saved;

			$http({method: method, url: url})
			.error(function() {
				thing.saved = !thing.saved;
				console.log('Error while saving.');
			});	
		};

		$scope.subscribe = function(dir) {
			if($attrs.user == false) {
				$window.location.href = base_url + 'login';
				return;
			}

			if(!$attrs.multi) {
				var url = base_url + 'api/subscribe?channel='+ $attrs.channel;
			}else{
				var url = base_url + 'api/subscribe?multi='+ $attrs.multi;
			}

			if(dir === 1) {
				var method = 'POST';
			}else{
				var method = 'DELETE';
			}

			$scope.subscribed = !$scope.subscribed;

			$http({method: method, url: url})
			.error(function() {
				console.log('Error while subscribing.');
			});	
		}

		$scope.multi = function(multi, dir) {
			if($attrs.user == false) {
				$window.location.href = base_url + 'login';
				return;
			}

			var url = base_url + 'api/multi/'+ multi +'/'+ $attrs.channel;

			if(dir === 1) {
				var method = 'POST';
			}else{
				var method = 'DELETE';
			}

			$http({method: method, url: url})
			.error(function() {
				console.log('Error while adding.');
			});	
		}

		$scope.comments = function(post) {
			var modalInstance = $modal.open({
				templateUrl: 'comments_modal.html',
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
			.success(function(data) {
				thing.replied = true;

				var reply = data.json.data.things[0].data;

				var reply = {
					id: reply.id,
					author: reply.author,
					score: 1,
					create: reply.created,
					body: reply.body,
					likes: true,
					saved: false,
					replies: false
				};

				if(type !== 't3') {		
					if(typeof thing.replies !== 'object') {
						thing.replies = [];
					}

					thing.replies.push(reply);
				}

				alert('Reply sent!');

				thing.reply = '';
			})
			.error(function() {
				console.log('Error while posting.');
			});
		};
	});

	readditingApp.controller('commentsController', function($scope, $modalInstance, post, save, vote, reply, Reddit) {
		$scope.post = post;
		$scope.save = save;
		$scope.vote = vote;
		$scope.reply = reply;
		$scope.reddit = new Reddit($scope.post.subreddit, $scope.post.id);

		$scope.cancel = function () {
			$modalInstance.dismiss('cancel');
		};
	})

	readditingApp.directive('replyForm', function($compile){
	    return {
	    	restrict: 'A',
	        link: function(scope, element, attrs) {
	            element.bind('click', function(e) {
	                e.stopPropagation();

	                element.closest('.media-body').find('.replyForm:first').html($compile('<form ng-show="!comment.replied" ng-submit="reply(comment, \'t1\')"><div class="form-group" style="margin:10px 0 0 30px"><textarea class="form-control" placeholder="Contribute to discussion..." ng-model="comment.reply" rows="3"></textarea><button style="margin-top:10px" class="btn btn-primary btn-sm pull-right">Send</button></div></form>')(scope));
	            });
	        }
	    };
	});

	readditingApp.directive('showMore', function($document){
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