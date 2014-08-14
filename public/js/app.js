
var subredditApp = angular.module('subredditApp', ['subredditCtrl', 'subredditService', 'ngSanitize'], function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});