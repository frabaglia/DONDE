dondev2App.config(function($interpolateProvider, $locationProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
  })

  .controller('usersController', function($scope, $rootScope, $http, $interpolate, $window) {

    console.log('usersController loaded');

    $scope.loadingPrev = true;
    $scope.loadingPost = true;
    $scope.countries = {};
    $scope.userId = $window.localStorage.getItem('idUser_countries');
    $scope.list = $window.localStorage.getItem('userCountries');
    $scope.list =  $scope.list.split(',').map(function(item) {
        return parseInt(item, 10);
    })
    console.log($scope.userId);
    console.log(JSON.stringify($scope.list));

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
        console.log(response);
        $scope.countries = response;
        $scope.loadingPrev = false;
        $scope.loadingPost = false;
      });

    $scope.toggle = function(country, list) {
      console.log("toogle");
      var idx = $scope.list.indexOf(country.id);
      if (idx > -1) {
        $scope.list.splice(idx, 1);
      } else {
        $scope.list.push(country.id);
      }
      console.log("list");
      console.log($scope.list);
    };

    $scope.exists = function(country, list) {

      return $scope.list.indexOf(country.id) > -1;
    };

    $scope.saveUserCountries = function() {
      console.log("list ");
      console.log($scope.list);
      $http.post('../api/v2/usercountries/'+$scope.userId, $scope.list)
        .then(
          function(response) {
            Materialize.toast("Exito", 3000);
          },
          function(response) {
            Materialize.toast("Problema al ejecutar la acción, inténtelo nuevamente más tarde", 5000);
          }
        );
    }



  });
