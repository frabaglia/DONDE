dondev2App.controller('cityMapController',
  function(placesFactory, NgMap, copyService, $scope, $rootScope, $routeParams, $location, $http) {
    //controlador para busqueda escrita
    $rootScope.$watch('currentMarker', function() {
      $scope.currentMarker = $rootScope.currentMarker;
    })

    $rootScope.main = false;
    $rootScope.geo = false;

    $scope.service = copyService.getFor($routeParams.servicio);
    $rootScope.navBar = $scope.service;

    $scope.voteLimit = 5;

    $scope.addComment = function() {
      $scope.voteLimit++;
    }

    $scope.closeCurrent = function() {
      $scope.currentMarker = undefined;
    }

    gtag('event','ver_centro', {
      'event_category': $rootScope.currentMarker.establecimiento,
      'event_label': $scope.service.label
    });


    $scope.zendeskTriggerNotes = "El usuario se encontraba buscando información de " + $scope.service.label + ".\nCiudad: " + $scope.cityId + ".";
  });
