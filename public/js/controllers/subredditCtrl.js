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
	        	$('.panel-text a').each(function(index, obj){
				    //you can use this to access the current item
				    $(this).attr('target', '_blank');
				    $(this).append(' <i class="fa fa-share-square-o"></i>');

				    console.log(index);
				});
	        }
	    };
	});