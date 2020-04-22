'use strict';

/**
 * @ngdoc function
 * @name houstonDiversityMap:controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the houstonDiversityMap
 */
angular.module('dondeDataVizApp').controller('HomeCtrl',
  function(moment, NgMap, $interval, $scope,$rootScope, $timeout, $document, $http, $translate, $cookies) {

    $scope.serviceCode = 'resume';
    $rootScope.serviceCode = 'resume';
    // Change language of this module
    var lang = $cookies.get('lang');
    if (lang) {
      $translate.use(lang);
    }

    $scope.closeDetail = function() {
      $scope.currentMarker = undefined;
      var anchor = document.querySelector('#top');
      smoothScroll.animateScroll(anchor);
    }

    $scope.goToMap = function() {
      var anchor = document.querySelector('#mainMap');
      smoothScroll.animateScroll(anchor);
    }

    function correctWebLinks(place){
      var columns = ['web_distrib','web_dc','web_ile','web_infectologia','web_mac','web_testeo','web_ssr','web_vac'];
      var patt = new RegExp("^(http:\/\/|https:\/\/).+$");
      for (var i = 0; i < columns.length; i++) {
        if(place[columns[i]] && !patt.test(place[columns[i]])){
          place[columns[i]] = "http://" + place[columns[i]];
        }
      }
      return place;
    }

    $scope.showDetail = function(z, p) {
      $scope.currentMarker = p;
      for (var i = 0; i < $scope.ciudades.length; i++) {
        var c = $scope.ciudades[i];

        if (c.id === p.idCiudad) {
          p = correctWebLinks(p);
          p.nombre_ciudad = c.nombre_ciudad;
          p.nombre_partido = c.nombre_partido;
          p.nombre_provincia = c.nombre_provincia;
          p.nombre_pais = c.nombre_pais;
          p.serviceCode = 'resume';
          break;
        }
      }
      var anchor = document.querySelector('#top');
      smoothScroll.animateScroll(anchor);
    }

    $http.get('api/v1/cities/all/autocomplete').then(function(d) {
      $scope.ciudades = d.data;
    });
    $http.get('api/v2/countries/ranking').then(function(d) {
      $scope.ranking = d.data;
    });

    $scope.data = [];
    var preData = [];
    var getStats = function() {
      var onPageFinished = function() {
        for (var i = 0; i < preData.length; i++) {
          if (preData[i].aprobado){
            $scope.data.push(preData[i]);
          }
        }
      };
      var getNextPage = function(url) {
        $http.get(url)
          .then(function(d) {
            preData = preData.concat(d.data.data);
            if (d.data.next_page_url) {
              getNextPage(d.data.next_page_url);
            } else {
              onPageFinished();
            }
          });
      };

      getNextPage('api/v2/places/getApproved');

    };

    getStats();

  });
