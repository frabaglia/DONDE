'use strict';

angular.module('dondeDataVizApp')
  .directive('diverisity', function() {
    return {
      restrict: 'E',
      replace: false,
      scope: {
        container: '=container',
        config: '=config',
        currentitem: '=currentitem',
        diversitychart: '=diversitychart'
      },
      controller: function($scope, $http, $timeout) {
        $scope.diversitychart =
          c3.generate({
            bindto: '#diversityChart',
            data: {
              columns: [
                ['diversity', 0]
              ],
              names: {
                diversity: 'Diversity %',
              },
              type: 'gauge',
            },
            gauge: {},
            color: {
              pattern: ['#e0f2f1', '#80cbc4', '#26a69a', '#00897b', '#004d40'], // the three color levels for the percentage values.
              threshold: {
                values: [0, 25, 50, 80, 100]
              }
            },
            size: {
              height: 180
            }
          });
        $scope.$emit('diversityChartReady', $scope.diversitychart);

      },
      templateUrl: 'views/directives/diversity.html'
    };
  });
