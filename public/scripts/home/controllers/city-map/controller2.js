dondev2App.controller('cityMapController2',
  function(placesFactory, NgMap, copyService, $scope, $rootScope, $routeParams, $location, $http,$translate) {

    $rootScope.selectedLanguage = localStorage.lang;
    $translate.use($rootScope.selectedLanguage);

    var id = $routeParams.id;
    var urlShow = "api/v1/panel/places/" + id;

    $scope.voteLimit = 5;

    var urlComments = "api/v2/evaluacion/comentarios/" + id;
    $scope.comments = [];
    $http.get(urlComments)
    .then(function(response) {
      $scope.comments = response.data;
      $scope.comments.forEach(function(comment) {
        comment.que_busca = comment.que_busca.split(',');
      });
    });

    function correctWebLinks(place){
      var columns = ['web_distrib','web_dc','web_ile','web_infectologia','web_mac','web_testeo','web_ssr','web_vac'];
      var patt = new RegExp("^(http:\/\/|https:\/\/).+$");
      for (var i = 0; i < columns.length; i++) {
        if(place[columns[i]] && !patt.test(place[columns[i]])){
          place[columns[i]] = "http://" + place[columns[i]];
        }
      }
      return place;
    }

    $http({
      method: "GET",
      url: urlShow
    }).then(function mySucces(response) {
      place = response.data[0];

      place = correctWebLinks(place);
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

      setTimeout(function(){
        $('.mdi-hardware-keyboard-arrow-down').each(function(e) { $(this).click()});
      },200)

      $rootScope.places = place;
      $rootScope.currentMarker = place;
      $scope.currentMarker = place;

      $rootScope.moveMapTo = {
        latitude: parseFloat($rootScope.currentMarker.latitude),
        longitude: parseFloat($rootScope.currentMarker.longitude),
      };
      $rootScope.currentZoom = {'rand': Math.random(), 'zoom': 'location'};

      $rootScope.centerMarkers = [];
      $rootScope.centerMarkers.push($rootScope.currentMarker);

      gtag('event','ver_centro', {
        'event_category': $rootScope.currentMarker.establecimiento,
      }); 

    }); //del get


  });
