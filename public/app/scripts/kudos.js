/*
 * angular-kudos-directive v0.1.0
 * (c) 2013 Olajide Ogundipe Jr http://olaji.de
 * License: MIT
 */

angular.module('angular-kudos', [])
    
    
    .directive('ogKudos', function(){
    var kudosHTML = 
        "<figure ng-mouseenter='start()' ng-mouseleave='end()' ng-click='reset()' class='kudo kudoable'>" +
            "<a class='kudobject'>" +
                "<div class='opening'><div class='circle'>&nbsp;</div></div>" +
            "</a>" +
            "<a class='count'>" +
                "<span class='num' ng-show='kudoCountValue' >{{getKudoCount()}}</span>" +
                "<span class='txt'>Upvotes</span>" +
           " </a>" +
        "</figure>"
    return{
        restrict: 'A',
        template: kudosHTML,
        replace: true,
        scope:{ogKudosCount:'@ogKudosCount',
               ogKudosId:'@ogKudosId',
               ogKudosDone:'&ogKudosDone',
               ogKudosUndone:'&ogKudosUndone',
               ogKudosComplete:'@ogKudosComplete'},

        controller: ['$scope','$element','$timeout',
        function($scope, $element, $timeout) {
            $scope.kudod = function() {
                return $element.hasClass('complete');
            };

            $scope.kudoCountValue = function() {
                if ($scope.ogKudosCount){
                    return true;
                }else{
                    return false;
                }
            };
            
            $scope.start = function() {
                if(!$scope.kudod()){
                    $element.addClass('active');
                    $scope.timer = $timeout($scope.complete, 700);
                    return $scope.timer;
                }
            };

            $scope.end = function() {
                $scope.stopKudo = true;
                if(!$scope.kudod()){
                    $element.removeClass('active');
                   return $timeout.cancel($scope.timer);
        
                }
            };    
            
            $scope.getKudoCount = function(){
                if($scope.ogKudosComplete) {
                    $element.addClass('complete');
                };
                return $scope.ogKudosCount;
            }

            $scope.complete = function(){
                $scope.end();
                $element.addClass('complete');
                if($scope.ogKudosDone){
                    return $scope.ogKudosDone();
                }
            };  

            $scope.reset = function() {
                if($scope.kudod && $scope.ogKudosUndone) {
                     $element.removeClass('complete');
                    return $scope.ogKudosUndone();
                }
            };

            }]
        };
    })

    
   
    