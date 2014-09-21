
var subredditApp = angular.module('subredditApp', [
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