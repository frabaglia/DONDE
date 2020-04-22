'use strict';

/**
 * @ngdoc function
 * @name houstonDiversityMap:controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the houstonDiversityMap
 */
angular.module('dondeDataVizApp').controller('HomeCtrl',
  function(moment, NgMap, $interval, $scope, $timeout, $document, $http, $translate, $cookies) {

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
    $scope.showDetail = function(i, p) {
      $scope.currentMarker = p;
      for (var i = 0; i < $scope.ciudades.length; i++) {
        if ($scope.ciudades[i].id === p.idCiudad) {
          p.nombre_ciudad = $scope.ciudades[i].nombre_ciudad;
          p.nombre_partido = $scope.ciudades[i].nombre_partido;
          p.nombre_provincia = $scope.ciudades[i].nombre_provincia;
          p.nombre_pais = $scope.ciudades[i].nombre_pais;
          break;
        }
      }
      var anchor = document.querySelector('#top');
      smoothScroll.animateScroll(anchor);
    }

    $http.get('api/v1/places/all/autocomplete').then(function(d) {
      $scope.ciudades = d.data;
    });
    $http.get('api/v2/countries/ranking').then(function(d) {
      $scope.ranking = d.data;
    });



    $scope.data = [];
    var getStats = function() {
      var onPageFinished = function() {
        console.log($scope.data[0]);
      };
      var getNextPage = function(url) {
        $http.get(url)
          .then(function(d) {
            $scope.data = $scope.data.concat(d.data.data);
            if (d.data.next_page_url) {
              getNextPage(d.data.next_page_url);
            } else {
              onPageFinished();
            }
          });
      };

      getNextPage('api/v2/places/getall');

    };

    getStats();


  });
