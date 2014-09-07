
var subredditApp = angular.module('subredditApp', ['subredditCtrl', 'subredditService', 'ngSanitize', 'infinite-scroll', 'angular-kudos'], function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});