'use strict';

angular.module('dondeDataVizApp')
.directive('votes', function() {
    return {
        restrict: 'E',
        replace: false,
        scope: {
          container: '=container',
          config: '=config',
          currentitem: '=currentitem'
        },
        controller: function($scope, $http) {
          

          $scope.votesChart = c3.generate({
                bindto: '#votesChart',
                x:'x',
                data: {
                    columns: [
                        ['clinton', 0],
                        ['trump', 0]
                    ],

                    type: 'bar',
                    keys: {
                      value: ['clinton','trump'],
                      x:'votes'
                    },
                    names: {
                      clinton: 'Clinton',
                      trump: 'Trump',
                    },
                    colors: {
                        clinton: '#1e88e5',
                        trump: '#e53935',
                        data3: '#1e88e5'
                    }

                },

                size: {
                  height: 200,
                },
                padding: {
                    top: 0,
                    right: 20,
                    bottom: 10,
                    left: 20,
                },
                bar: {
                    width: {
                        ratio: 0.5 // this makes bar width 50% of length between ticks
                    }
                    // or
                    //width: 100 // this makes bar width 100px
                },
                axis: {
                    rotated: true,
                    x: {
                        show:false,
                        type: 'category'
                    },
                    y: {
                      show:true,
                      min: 0,
                      max:100,
                      padding: 5,
                      tick:{
                        format:function(y){
                          return y+'%';
                        }
                      }
                  }
                }
            });

          $scope.$emit('votesChartReady',$scope.votesChart);
          
        }, 
        templateUrl: 'views/directives/votes.html'
    };

});