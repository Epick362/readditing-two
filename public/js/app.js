
var subredditApp = angular.module('readditingApp', [
		'ui.bootstrap', 
		'subredditCtrl', 
		'subredditService', 
		'ngSanitize', 
		'infinite-scroll', 
		'angular-kudos', 
		'angularMoment',
		'angulartics', 
		'angulartics.google.analytics'
	], function($interpolateProvider, $analyticsProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');

	$analyticsProvider.virtualPageviews(false);
});