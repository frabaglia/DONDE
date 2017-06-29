dondev2App.controller('homeController',
	function($timeout,copyService, placesFactory,NgMap, $anchorScroll, $scope,$rootScope, $routeParams, $location, $http){

$scope.selectedLang = "";
$rootScope.selectedLang = "";

$scope.listaIdiomas = [
	{
	  id: 1,
	  label: 'en'
	}, 
	{
	  id: 2,
	  label: 'es'
	}, 
	{
	  id: 3,
	  label: 'br'
	}
];

$scope.selectedLangChange = function(data) {
	console.log(localStorage.getItem("lang"));

	try {
    	localStorage.setItem("lang", data);
    	$rootScope.selectedLang = data;
  	}
  	catch(err) {
      console.log('No soporta localstorage')
      if (typeof(err) !== "undefined") {
        localStorage.setItem("lang", "es");
      }
  	}

  	console.log(localStorage.getItem("lang"));
  	window.location.reload();
 }
  // $(document).ready(function(){
  //   $('.tooltipped').tooltip({delay: 0});
  // });

	$timeout(
		function() {
			$rootScope.moveMapTo = {
      latitude:-12.382928338487396,
      longitude:-79.27734375,
      zoom:3
    };
  },500);
		$rootScope.places = [];
	$rootScope.navigating = false;
	$scope.currentMarker = undefined;

	$rootScope.main = true;
	$rootScope.navBar = ""



	$scope.collapsibleElements = copyService.getAll();
	//console.log($scope.collapsibleElements);
});
