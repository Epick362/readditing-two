
var subredditApp = angular.module('readditingApp', [
		'ui.bootstrap', 
		'subredditCtrl', 
		'subredditService', 
		'ngSanitize', 
		'infinite-scroll', 
		'angular-kudos', 
		'angularMoment'
	], function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});