'use strict';

/**
 * @ngdoc function
 * @name houstonDiversityMap:controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the houstonDiversityMap
 */
angular.module('dondeDataVizApp').controller('serviceCtrl',
  function(moment, NgMap, $interval, $routeParams, $scope, $timeout, $document, $http, $translate, $cookies) {

    // Change language of this module
    var lang = $cookies.get('lang');
    if (lang) {
      $translate.use(lang);
    }

    $scope.services = [{
        icon: "iconos-new_preservativos-3.png",
        title: "condones_name",
        code: "condones",
        content: "condones_content"
      },
      {
        icon: "iconos-new_analisis-3.png",
        title: "prueba_name",
        code: "prueba",
        content: "prueba_content"
      },
      {
        icon: "iconos-new_vacunacion-3.png",
        title: "ssr_name",
        code: "ssr",
        content: "ssr_content"
      },
      {
        icon: "iconos-new_atencion-3.png",
        title: "dc_name",
        code: "dc",
        content: "dc_content"
      },
      {
        icon: "iconos-new_sssr-3.png",
        title: "mac_name",
        code: "mac",
        content: "mac_content"
      },
      {
        icon: "iconos-new_ile-3.png",
        title: "ile_name",
        code: "ile",
        content: "ile_content"
      }
    ];

    $scope.nameCountry = $routeParams.pais.split('-')[1];
    $scope.idCountry = $routeParams.pais.split('-')[0];
    $scope.nameProvince = $routeParams.provincia.split('-')[1];
    $scope.idProvince = $routeParams.provincia.split('-')[0];
    $scope.nameParty = $routeParams.partido.split('-')[1];
    $scope.idParty = $routeParams.partido.split('-')[0];
    $scope.nameCity = $routeParams.ciudad.split('-')[1];
    $scope.idCity = $routeParams.ciudad.split('-')[0];



  });
