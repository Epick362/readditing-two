angular.module('subredditCtrl', [])

	// inject the Comment service into our controller
	.controller('subredditController', function($scope, $attrs, $http, Reddit) {
		$scope.reddit = new Reddit($attrs.subreddit);
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
	})
	.directive('filterPost', function($document){
	    return {
	        restrict: 'A',
	        link: function(scope, element, attrs) {
	            element.find('a').attr('target', '_blank');

	            console.log('adssadasdasd');

	            console.log(element.find('a'));

	            element.find('.panel-text').remove();

	            element.find('a').append(' <i class="fa fa-share-square-o"></i>');
	        }
	    };
	});