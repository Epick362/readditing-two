
var subredditApp = angular.module('readditingApp', [
		'ui.bootstrap', 
		'channelCtrl', 
		'channelService', 
		'ngSanitize', 
		'infinite-scroll',
		'angularMoment',
		'angulartics', 
		'angulartics.google.analytics'
	], function($interpolateProvider, $analyticsProvider, $locationProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');

    $locationProvider.html5Mode(true);

	$analyticsProvider.virtualPageviews(false);
}).run(['$location', '$rootElement', function ($location, $rootElement) {
    $rootElement.off('click');
}]);