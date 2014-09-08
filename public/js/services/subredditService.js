angular.module('subredditService', [])

	.factory('Reddit', function($http, $sce) {
		var Reddit = function(subreddit) {
			this.subreddit = subreddit;
			this.posts = [];
			this.busy = false;
			this.after = '';
		};

		Reddit.prototype.nextPage = function() {
			if (this.busy) return;
			this.busy = true;

			if(this.subreddit) {
				var url = '/api/r/'+this.subreddit+'?after='+this.after;
			}else{
				var url = '/api/r?after='+this.after;
			}

			$http({method: 'GET', url: url})
			.success(function(data) {
				var posts = data;

				for (var i = 0; i < posts.length; i++) {
					posts[i].content = $sce.trustAsHtml(posts[i].content);
					console.log(posts[i].id+' liked: '+ posts[i].likes);
					this.posts.push(posts[i]);
				}


				this.after = "t3_" + this.posts[this.posts.length - 1].id;
				this.busy = false;
			}.bind(this))
			.error(function(data) {
				this.posts.push({
					'title': 'There was an error',
					'content': '<div class="alert alert-danger">Readditing has encountered a problem. Try refreshing the page.</div>',
					'source': ''
				});
				this.busy = false;
			}.bind(this));
		};

		return Reddit;
	});