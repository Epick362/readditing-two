
	var readditingApp = readditingApp || angular.module('readditingApp', [
			'ui.bootstrap', 
			'ngSanitize', 
			'infinite-scroll',
			'angularMoment',
			'angulartics', 
			'monospaced.elastic',
			'angulartics.google.analytics'
		], function($interpolateProvider, $analyticsProvider, $locationProvider) {
	    $interpolateProvider.startSymbol('<%');
	    $interpolateProvider.endSymbol('%>');

	    $locationProvider.html5Mode(true);

		$analyticsProvider.virtualPageviews(false);
	});

	readditingApp.run(['$location', '$rootElement', function ($location, $rootElement) {
	    $rootElement.off('click');
	}]);