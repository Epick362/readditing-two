
var subredditApp = angular.module('subredditApp', ['subredditCtrl', 'subredditService', 'ngSanitize', 'infinite-scroll'], function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});