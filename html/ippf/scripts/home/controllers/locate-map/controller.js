dondev2App.controller('locateMapController',
	function(placesFactory,NgMap, $scope,$rootScope, $routeParams, $location, $http){
  
  $rootScope.geo = true;
	$scope.service = $routeParams.servicio;
	$rootScope.navBar =$scope.service ;
	$rootScope.places = [];
	$scope.main = true;
  $rootScope.main = false;
	 var onLocationError = function(e){
        $scope.$apply(function(){
          $location.path('/call/help');
        });
    };

    $scope.addComment = function () {
       $scope.voteLimit ++;
    }

    var onLocationFound = function(position){
      $scope.$apply(function(){
        	placesFactory.forLocation(position.coords, function(result){
              //$rootScope.places = $scope.places = $scope.closer = result;
							//tener en cuenta esta linea comentada
              $scope.currentPos = position.coords;
                $rootScope.moveMapTo = {
                    latitude:position.coords.latitude,
                    longitude:position.coords.longitude,
                  };
            });
        });
    };

    $scope.showCurrent = function(i,p){
      $rootScope.navBar = p.establecimiento;
      $scope.currentMarker = p;
      $rootScope.centerMarkers = [];
      //tengo que mostrar arriba en el map si es dekstop.
      $rootScope.centerMarkers.push($rootScope.currentMarker);

    }
    $scope.closeCurrent = function(){
      $scope.currentMarker = undefined;
    }
    navigator.geolocation.getCurrentPosition(onLocationFound, onLocationError);
});
