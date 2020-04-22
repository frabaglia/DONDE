'use strict';

/**
 * @ngdoc function
 * @name houstonDiversityMap:controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the houstonDiversityMap
 */
angular.module('dondeDataVizApp').controller('countryCtrl',
  function(moment, NgMap, $interval, $routeParams, $scope, $timeout, $document, $http, $translate, $cookies) {

    // Change language of this module
    var lang = $cookies.get('lang');
    if (lang) {
      $translate.use(lang);
    }

    $scope.nameCountry = $routeParams.pais.split('-')[1];
    $scope.idCountry = $routeParams.pais.split('-')[0];

    gtag('event','pais', {
      'nombre_pais':   $scope.nameCountry
    });    

    $scope.provinces = [];
    $scope.url = 'pais' +
      $http.get('pais/' + $scope.idCountry + '/province')
      .success(function(provinces) {
        $scope.provinces = provinces;
      });

  });
