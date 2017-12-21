dondev2App.config(function($interpolateProvider, $locationProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
  })

  .controller('panelImporterController', function($scope, $rootScope, $http, $interpolate) {

    $scope.serverMode = "";
    $scope.disableCleardbModalButton = true;
    $scope.cleardDBClick = "";

    $scope.openCleardbModal = function() {
      $('#cleardbModal').openModal();
    };

    $scope.showDisabledMessageCleardbModal = function() {
      Materialize.toast('Botón inhabilitado para modo de servidor "PRODUCCION"', 5000);
    };
    $scope.closeCleardbModal = function() {
      $('#cleardbModal').closeModal();
    };

    $rootScope.cleardb = function() {
      $http.get('../api/v1panel/cleardb')
        .then(
          function(response) {
            if ((response.data.mode == 'production') || (response.data.mode == null)) {
              Materialize.toast('Proceso NO permitido para servidor en PRODUCCION ', 5000);
            } else {
              Materialize.toast('Exito', 10000);
            }
          },
          function(response) {
            Materialize.toast('Hemos cometido un error al procesar tu peticion, intenta nuevamente mas tarde.', 5000);

          });
      $('#cleardbModal').closeModal();
    };

    $http.get('../api/v1panel/getservermode')
      .then(
        function(response) {
          $scope.serverMode = response.data.mode

          if (($scope.serverMode != null) && ($scope.serverMode != 'production')) {
            $scope.disableCleardbModalButton = false;
            $scope.cleardDBClick = $scope.openCleardbModal;
          } else {
            $scope.disableCleardbModalButton = true;
            $("#openModalButton").addClass("disabled");
            $scope.cleardDBClick = $scope.showDisabledMessageCleardbModal;

          }
        });

  });
