dondev2App.controller('locationNewController',
  function($timeout, copyService, placesFactory, NgMap, $scope, $rootScope, $routeParams, $location, $http) {

    $rootScope.navBar = $routeParams.servicio;

    $scope.service = copyService.getFor($routeParams.servicio);

    $rootScope.places = [];
    $rootScope.centerMarkers = [];

    var queryNavBar;

    $scope.getNow = function(postdata) {

      switch ($scope.navBar) {

        case "Vacunatorios":
        queryNavBar = "Vacunatorio";
        break;

        case "infectologia":
        queryNavBar = "infectologia";
        break;

      }

      $scope.addComa = function(data){
        return data + ', ';
      }


      // Go to list the places
      var next = postdata.originalObject.idPais +"-" + postdata.originalObject.nombre_pais;
      next += "/" + postdata.originalObject.idProvincia +"-" + postdata.originalObject.nombre_provincia;
      if(postdata.originalObject.nombre_ciudad){
        next += "/" + postdata.originalObject.idPartido +"-" + postdata.originalObject.nombre_partido;
        next += "/" + postdata.originalObject.id +"-" + postdata.originalObject.nombre_ciudad;
      }
      else{
        next += "/" + postdata.originalObject.id +"-" + postdata.originalObject.nombre_partido;
      }
      next += "/" + $scope.navBar;
      next += "/listado";

      $location.path(next);

      }



  });
