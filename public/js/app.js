
var subredditApp = angular.module('subredditApp', [
		'ui.bootstrap', 
		'subredditCtrl', 
		'subredditService', 
		'ngSanitize', 
		'infinite-scroll', 
		'angular-kudos', 
		'angularMoment',
		'ngDialog'
	], function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});