dondev2App.controller('acercaController',
	function(placesFactory,NgMap, $scope,$rootScope, $routeParams, $location, $http){

		$scope.goToNext = function(next){
			document.getElementById(next).scrollIntoView()
		};
});
