dondev2App.controller('locateMapController',
  function(placesFactory,NgMap, $scope,$rootScope, $routeParams, $location, $http){

    $rootScope.geo = true;
    $scope.service = $routeParams.servicio;
    $rootScope.navBar = $scope.service;
    $scope.main = true;
    $rootScope.main = false;

    $scope.closeCurrent = function(){
      $scope.currentMarker = undefined;
    }

    $scope.zendeskTriggerNotes = "El usuario se encontraba buscando información de " + $scope.service + ".\n"+
    "Buscó utilizando su ubicación actual";

  });
