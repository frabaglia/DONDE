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

      //Map dimensions (in pixels)
      var width =  $('body').width();
      var height = $('body').height();

      var datasets = [];
        datasets['HC']={
          source: 'HARRIS_COUNTY_VOTING_PRECINCTS.json',
          center: [-95.7148853, 29.8336768],
          toHighlight: [587,588],
          scale : {
            mobile: (height * 370.5)/14,
            desktop: 30000
          },
          translate : {
            mobile:[80, height / 4],
            desktop :[100, height /2.45]
          }
        }
        datasets['FBC']= {
          source: 'FORT_BEND_COUNTY_VOTING_PRECINCTS.json',
          center: [-96.0374028,29.5251683],
          toHighlight: [3098,4020],
          scale : {
            mobile: (height * 600.5)/14,
            desktop: 44000
          },
          translate : {
            mobile:[0, height / 3],
            desktop :[25, height /2.6]
          }
        };


      var dataset  = datasets[$scope.currentitem.toUpperCase()];
      if (!dataset){
        return;
      }
      var topoJSON = "datasets/output/"+ dataset.source;

      var raw = [];
      var scaleTop = 100;

       var smallScreenProjection = d3.geo.mercator()
          .center(dataset.center)
          .scale(dataset.scale.mobile)
          .translate(dataset.translate.mobile);

     var projection = smallScreenProjection;

       if ($(window).width() >= 980) {
              projection = d3.geo.mercator()
                          .center(dataset.center)
                          .scale(dataset.scale.desktop)
                          .translate(dataset.translate.desktop);

          }




      var map ;
      //Generate paths based on projection
          var path = d3.geo.path()
              .projection(projection);

          //Create an SVG
          var svg = d3.select(".map")
              .append("svg")
              // .attr('class', activeMap)
              .attr("width", width)
              .attr("height", height/1.25);
          // $('div.map svg.' + activeMap).show();
          var border = svg.append("g").attr("class", "border");
          //Group for the map features
          var features = svg.append("g")
              .attr("class", "features");


      var shouldHighlight = function(d){
        var toHighlight = false;
                    for (var j = 0; j < dataset.toHighlight.length; j++) {
                      if (dataset.toHighlight[j] ===  parseInt(d.properties.PRECINCT)){
                        toHighlight= true;
                        break;
                      }
                    };
                    return toHighlight;
      }
      d3.json(topoJSON, function(error, geodata) {

              //Create a path for each map feature in the data
              map = features.selectAll("path")
                  .data(geodata.features);
                  // .data(topojson.feature(geodata, geodata.features).features);
              //
              //generate features from TopoJSON

              map.enter()
                  .append("path")
                  // .attr("class", function(d) {
                  //     return 'n-' + d.properties.CC_JP_PCT;
                  // })
                  .attr('class', function(d, i) {
                        var mainClass = ''
                        if (shouldHighlight(d)){
                          mainClass = ' highlight';
                        }
                        var whoWon = 'trump';
                        if (d.properties.CLINTON >= d.properties.TRUMP)
                        {
                          whoWon = 'clinton';
                        }
                        d.whoWon = whoWon;

                        mainClass += ' ' + whoWon;

                        d.diversityScale = diversityScale(parseFloat(d.properties.DIV_INDEX));

                        mainClass += ' d-' + d.diversityScale;

                        return mainClass + ' n-' + d.properties.OBJECTID;
                    })
                    .attr('opacity', function(d, i) {

                        var item = d.properties.PCT_TRUMP;
                        if (d.properties.CLINTON >= d.properties.TRUMP)
                        {
                          item = d.properties.PCT_CLITO;
                        }
                        d.opacityScale =opacityScale(parseFloat(item*100));


                        return d.opacityScale;

                    })
                  .attr("d", path)
                  .on("click", function(d){
                    $scope.$apply(function(){
                       $scope.$emit('updateCurrentItem',d.properties);
                    });
                    d3.selectAll('.map path.active').remove();
                    $('.map path').show();
                    var newActive = d3.select('path.n-' + d.properties.OBJECTID);
                    var active = clone_d3_selection(newActive, 2);
                    active.attr('opacity', d.opacityScale /0.1);
                    active.attr('class', function() {
                        var mainClass = '';
                        mainClass += ' ' + d.whoWon;
                        return mainClass + ' cloned active ' + 'o_';
                    });
                    $('path.n-' + d.properties.OBJECTID).hide();
                  });


                 $scope.$apply(function(){
                    $scope.$emit('mapReady');
                  });
          });






















        },
        template: '<div class="map"></div>'
    };

});
