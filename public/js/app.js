
var subredditApp = angular.module('subredditApp', [
		'ui.bootstrap', 
		'subredditCtrl', 
		'subredditService', 
		'ngSanitize', 
		'infinite-scroll', 
		'angular-kudos', 
		'angularMoment',
		'ngHtmlCompile'
	], function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});