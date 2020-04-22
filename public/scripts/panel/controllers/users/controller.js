dondev2App.config(function($interpolateProvider, $locationProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
  })

  .controller('usersController', function($scope, $rootScope, $http, $interpolate, $window) {

    $scope.loadingPrev = true;
    $scope.loadingPost = true;
    $scope.countries = {};
    $scope.userId = $window.localStorage.getItem('idUser_countries');
    $scope.list = $window.localStorage.getItem('userCountries');
    $scope.list = $scope.list.split(',').map(function(item) {
      return parseInt(item, 10);
    })

    $scope.selected = [];
    $scope.newUser = {
      roll: "",
      name: "",
      email: "",
      password: "",
      password_confirmation: ""
    };

    $http.get('../api/v1/countries/all')
      .success(function(response) {
        $scope.countries = response;
        $scope.loadingPrev = false;
        $scope.loadingPost = false;
      });

    $scope.toggle = function(country, list) {
      var idx = $scope.list.indexOf(country.id);
      if (idx > -1) {
        $scope.list.splice(idx, 1);
      } else {
        $scope.list.push(country.id);
      }
    };

    $scope.exists = function(country, list) {

      return $scope.list.indexOf(country.id) > -1;
    };

    $scope.saveUserCountries = function() {
      $http.post('../api/v2/usercountries/' + $scope.userId, $scope.list)
        .then(
          function(response) {
            Materialize.toast("Exito")
          },
          function(response) {
            Materialize.toast("Problema al ejecutar la acción, inténtelo nuevamente más tarde", 5000)
          }
        );
    }
  });
