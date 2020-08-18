dondev2App.controller('cityMapController2',
  function(placesFactory, NgMap, copyService, $scope, $rootScope, $routeParams, $location, $http,$translate) {

    $rootScope.selectedLanguage = $routeParams.lang;
    $translate.use($routeParams.lang);

    var id = $routeParams.id;
    var urlShow = "api/v1/panel/places/" + id;

    $scope.voteLimit = 5;
    $rootScope.navigating = true;

    $scope.showCurrent = function(i, p) {
      $scope.currentMarker = p;
    }
    $scope.closeCurrent = function() {
      $scope.currentMarker = undefined;
    }

    $http({
      method: "GET",
      url: urlShow
    }).then(function mySucces(response) {
      var place = response.data[0];

      $rootScope.main = false;
      $rootScope.geo = false;
      $scope.province = place.nombre_provincia;
      $scope.provinceId = place.idProvincia;
      $scope.city = place.nombre_partido;
      $scope.cityId = place.idPartido;
      $scope.ciudadId = place.idCiudad;
      $rootScope.ciudad = place.nombre_ciudad;
      $scope.country = place.nombre_pais;
      $scope.countryId = place.idPais;

      $rootScope.places = place;

      var item = place;
      var urlComments = "api/v2/evaluacion/comentarios/" + id;
      item.comments = [];
      $http.get(urlComments)
      .then(function(response) {
        item.comments = response.data;
        item.comments.forEach(function(comment) {
          comment.que_busca = comment.que_busca.split(',');
        });
      });

      $rootScope.centerMarkers = [];
      $rootScope.centerMarkers.push(place);
      setTimeout(function() {
        $rootScope.currentMarker = $scope.currentMarker = place;
        $scope.$apply();
      }, 300);

      var urlRate = "api/v2/evaluacion/promedio/" + id;
      $http.get(urlRate)
      .then(function(response) {
        item.rate = response.data;
        item.faceList = [{
          id: '1',
          image: '1',
          imageDefault: '1',
          imageBacon: '1active'
        },
        {
          id: '2',
          image: '2',
          imageDefault: '2',
          imageBacon: '2active'
        },
        {
          id: '3',
          image: '3',
          imageDefault: '3',
          imageBacon: '3active'
        },
        {
          id: '4',
          image: '4',
          imageDefault: '4',
          imageBacon: '4active'
        },
        {
          id: '5',
          image: '5',
          imageDefault: '5',
          imageBacon: '5active'
        }
        ];


        var pos = -1;
        for (var i = 0; i < item.faceList.length; i++) {
          item.faceList[i].image = item.faceList[i].imageDefault;
          if (item.faceList[i].id == item.rate) pos = i;
        }
        //si tiene votos cambio el color
        if (pos != -1)
          item.faceList[pos].image = item.faceList[pos].imageBacon;
      });

      gtag('event','ver_centro', {
        'event_category': $rootScope.currentMarker.establecimiento,
        'event_label': $rootScope.currentMarker.nombre_pais + ' - ' + $rootScope.currentMarker.nombre_ciudad,
      });
    });
  });