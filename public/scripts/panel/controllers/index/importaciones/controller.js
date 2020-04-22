dondev2App.config(function($interpolateProvider, $locationProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
  })

  .controller('tagsImportacionController', function(NgMap, placesFactory, $filter, $scope, $timeout, $rootScope, $http, $interpolate, $location, $route) {
      $scope.tagsImportaciones;
      $scope.loading = true;

      $scope.disableExportButtonLink = function(placesCount, tagId){
        if (placesCount <= 0) $( "#exportbutton_" + tagId ).addClass( "disabled" );
        return placesCount > 0 ? "panel/tagsimportaciones/"+ tagId : "#";
      }

      $http.get('api/v1/places/tagsimportaciones')
        .success(function(response) {
          $scope.tagsImportaciones = response;
          $scope.loading = false;
        });

      $('#demoModal').closeModal();
      $scope.closeModal = function(place) {
      $('#demoModal').closeModal();
      $scope.current = {};
    };

  });
