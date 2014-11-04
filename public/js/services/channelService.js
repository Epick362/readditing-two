	readditingApp.factory('Reddit', function($http, $compile, $location) {
		var Reddit = function(subreddit, profile, sort) {
			this.subreddit = subreddit;
			this.profile = profile;
			this.sort = sort;
			this.posts = [];
			this.comments = [];
			this.busy = false;
			this.after = '';
			this.page = 1;
		};

		Reddit.prototype.nextProfilePage = function(category, after) {
			if (this.busy) return;
			this.busy = true;

			if(this.after === '') {
				this.after = after;
			}

			this.category = category;

			var url = '/api/u/'+this.profile+'/'+this.category+'?after='+this.after;

			$http({method: 'GET', url: url})
			.success(function(data) {
				var posts = data;
				var last = this.posts[this.posts.length - 1];

				for (var i = 0; i < posts.length; i++) {
					this.posts.push(posts[i]);
				}

				this.after = "t3_" + this.posts[this.posts.length - 1].id;

				if(typeof last != 'undefined') {
					var path = $location.path(); //Path without parameters, e.g. /search (without ?q=test)
					$location.url(path + '?after=t3_' + last.id);
				}

				this.busy = false;
				this.page++;
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

		Reddit.prototype.nextPage = function(after, sort) {
			if (this.busy) return;
			this.busy = true;

			if(this.after === '') {
				this.after = after;
			}

			if(this.subreddit) {
				var url = '/api/r/'+this.subreddit+'/'+this.sort+'?after='+this.after;
			}else{
				var url = '/api/r?after='+this.after;
			}

			$http({method: 'GET', url: url})
			.success(function(data) {
				var posts = data;
				var last = this.posts[this.posts.length - 1];

				for (var i = 0; i < posts.length; i++) {
					this.posts.push(posts[i]);
				}

				this.after = "t3_" + this.posts[this.posts.length - 1].id;

				if(typeof last != 'undefined') {
					var path = $location.path(); //Path without parameters, e.g. /search (without ?q=test)
					$location.url(path + '?after=t3_' + last.id);
				}

				this.busy = false;
				this.page++;
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

		Reddit.prototype.getComments = function(thing) {
			if (this.busy) return;
			this.busy = true;

			this.thing = thing;

			var url = '/api/r/'+this.subreddit+'/comments/'+this.thing+'?after='+this.after;

			$http({method: 'GET', url: url})
			.success(function(data) {
				var comments = data;

				for (var i = 0; i < comments.length; i++) {
					this.comments.push(comments[i]);
				}

				this.after = "t1_" + this.comments[this.comments.length - 1].id;
			}.bind(this))
			.error(function(data) {
				this.comments.push({
					'title': 'There was an error',
					'content': '<div class="alert alert-danger">Readditing has encountered a problem. Try refreshing the page.</div>',
					'source': ''
				});
			}.bind(this));			
		};

		return Reddit;
	});