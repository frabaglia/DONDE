'use strict';

angular.module('dondeDataVizApp')
.directive('mapChart', function() {
    return {
        restrict: 'E',
        replace:true,
        scope: {
          container: '=container',
          config: '=config',
          currentitem: '=currentitem',
          county:'=county',
        },
        controller: function($scope, $http) {
    
        var opacityScale = d3.scale.quantile()
          .domain([0, 25, 50, 80, 100])
          .range([0.2, 0.5, 0.6, 0.7, 0.8]);

        var diversityScale = d3.scale.quantile()
          .domain([0, 0.25, 0.5, 0.75, 0.9])
          .range([0, 25, 50, 80, 100]);

        d3.xml("images/maparg.svg")
              .mimeType("image/svg+xml")
              .get(function(error, xml) {
              $('.map').append(xml.documentElement);
                    

                         d3.selectAll('path.st1')
                             .on('click', function(){
                                  var k = d3.select(this).attr("id");
                                  var key = k.trim().split(' ').join('_');
                                  var anchor = document.querySelector( '#detail' );
                                  smoothScroll.animateScroll( anchor );
                                  $scope.$apply(function(){

                                    $scope.$emit('moveMap',k);
                                    
                                  }); 
                                 

                                   d3.selectAll('svg path.st1')
                                         .attr("class", "st1 active");
                                   d3.select('path#' + k)
                                       .attr("class", "st1 ` highlight");
                                 });

                       





                            
               });  

        }, 
        template: '<div class="map"></div>'
    };

});