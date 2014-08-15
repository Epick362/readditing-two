angular.module('subredditService', [])

	.factory('Subreddit', function($http) {

		return {
			// get all the comments
			get : function(subreddit) {
				return $http.get('/api/r/'+ subreddit +'?formatted=1');
			}
		}

	});