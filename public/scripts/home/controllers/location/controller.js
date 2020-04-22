dondev2App.controller('locationController',
  function($timeout, copyService, placesFactory, NgMap, $scope, $rootScope, $routeParams, $location, $http) {
    $rootScope.navBar = $routeParams.servicio;
    $scope.service = copyService.getFor($routeParams.servicio);

    $rootScope.returnTo = ""; //manipulate close buton.

     gtag('event','ver_servicio', {
          'event_category': $routeParams.servicio,
          'event_label':  $routeParams.servicio
         });
    
    $scope.searchOn = false;
    $rootScope.main = false;

    $rootScope.places = [];
    $rootScope.centerMarkers = [];
    $scope.countries = [];    

    placesFactory.getCountries(function(countries) {
      $scope.countries = countries;
    })

    $scope.getNow = function() {
      var next = $scope.selectedCountry.id + "-" + $scope.selectedCountry.nombre_pais;
      next += "/" + $scope.selectedProvince.id + "-" + $scope.selectedProvince.nombre_provincia;
      next += "/" + $scope.selectedCity.id + "-" + $scope.selectedCity.nombre_partido;
      next += "/" + $scope.navBar;
      next += "/listado";

      $location.path(next);
    }

    $scope.setReturn = function(value) {
      $rootScope.returnTo = value;
    }

    $scope.loadCity = function() {
      $scope.showCity = true;
      placesFactory.getCitiesForProvince($scope.selectedProvince, function(data) {
        $scope.cities = data;
        $rootScope.moveMapTo = $scope.selectedProvince.geo;
      })

    };
    $scope.showSearch = function() {
      $scope.searchOn = true;
      $rootScope.moveMapTo = $scope.selectedCity.geo;
    }

    $scope.showProvince = function() {

      $scope.provinceOn = true;
      $rootScope.moveMapTo = $scope.selectedCountry.geo;
      placesFactory.getProvincesForCountry($scope.selectedCountry.id, function(data) {
        $scope.provinces = data;
      });

    }

    $rootScope.serviceLabel = $scope.service.label;
    $rootScope.serviceCode = $scope.service.code;

    $scope.zendeskTriggerNotes = "El usuario se encontraba buscando información de " + $scope.service.label;
});
