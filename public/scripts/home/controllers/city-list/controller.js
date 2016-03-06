dondev2App.controller('cityListController', 
	function(placesFactory,NgMap, $scope,$rootScope, $routeParams, $location, $http){
	$rootScope.main = false;
		$rootScope.geo = false;
		$scope.province = $routeParams.provincia;
		$scope.city = $routeParams.ciudad;
		$scope.country = $routeParams.pais;
		$scope.service = $routeParams.servicio;
		$rootScope.navBar =$scope.service ;
		var search = {
			provincia_region: $routeParams.provincia,
			partido_comuna: $routeParams.ciudad,
			// pais: $routeParams.pais,
			// servicio: $routeParams.servicio
		}
	placesFactory.getAllFor(search, function(data){
		$rootScope.places = $scope.places = data;
	})

	$scope.nextShowUp =function(item){
		$rootScope.places = $scope.places;
	    $rootScope.currentMarker = item;
		$location.path('/'+ $scope.country  +'/' + search.provincia + '/' + search.barrio_localidad + '/' + $routeParams.servicio + '/mapa');

	}
});