angular.module('subredditService', [])

	.factory('Subreddit', function($http) {

		return {
			// get all the comments
			get : function() {
				return $http.get('/api/r?formatted=1');
			}
		}

	});