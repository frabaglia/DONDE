'use strict';

/**
 * @ngdoc function
 * @name houstonDiversityMap:controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the houstonDiversityMap
 */
angular.module('dondeDataVizApp').controller('placeCtrl',
  function(moment, NgMap, $interval, $routeParams, $scope, $timeout, $document, $http, $translate, $cookies) {

    // Change language of this module
    var lang = $cookies.get('lang');
    if (lang) {
      $translate.use(lang);
    };

    $scope.nameCountry = $routeParams.pais;
    $scope.nameProvince = $routeParams.provincia;
    $scope.nameParty = $routeParams.partido;
    $scope.nameCity = $routeParams.ciudad;
    $scope.serviceCode = $routeParams.code;

    $scope.places = [];
    $http.get('pais/' + $scope.nameCountry + '/provincia/' + $scope.nameProvince + '/partido/' + $scope.nameParty + '/ciudad/' + $scope.nameCity + '/servicio/' + $scope.serviceCode)
      .success(function(places) {
        $scope.places = places.lugares;
        console.log($scope.cPlaces = places.cantidad);
      });

  });
