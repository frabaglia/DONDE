dondev2App.controller('cityMapController',
  function(placesFactory, NgMap, copyService, $scope, $rootScope, $routeParams, $location, $http) {
    //controlador para busqueda escrita
    $rootScope.$watch('currentMarker', function() {
      $scope.currentMarker = $rootScope.currentMarker;
    })


    $scope.voteLimit = 5;

    $rootScope.main = false;
    $rootScope.geo = false;

    if ($routeParams.ciudad) {
      $scope.ciudad = $routeParams.ciudad.split('-')[1];
      $scope.ciudadId = $routeParams.ciudad.split('-')[0];
    } else {
      $scope.ciudad = "";
    }

    $scope.city = $routeParams.partido.split('-')[1];
    $scope.cityId = $routeParams.partido.split('-')[0];

    $scope.province = $routeParams.provincia.split('-')[1];
    $scope.provinceId = $routeParams.provincia.split('-')[0];

    $scope.country = $routeParams.pais.split('-')[1];
    $scope.countryId = $routeParams.pais.split('-')[0];


    $scope.service = copyService.getFor($routeParams.servicio);

    $rootScope.navBar = $scope.service;

    var search = {

      ciudad: $scope.ciudadId,
      partido: $scope.cityId,
      provincia: $scope.provinceId,
      pais: $scope.countryId,
      service: $routeParams.servicio.toLowerCase(),

    };
    search[$routeParams.servicio.toLowerCase()] = true;

    $scope.addComment = function() {
      $scope.voteLimit++;
    }

    $scope.nextShowUp = function(item) {

      var urlCount = "api/v2/evaluacion/cantidad/" + item.placeId;
      $http.get(urlCount)
        .then(function(response) {
          item.votes = response.data;
        });

      // //aparte
      var urlRate = "api/v2/evaluacion/promedio/" + item.placeId;
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



      var urlComments = "api/v2/evaluacion/comentarios/" + item.placeId;
      item.comments = [];
      $http.get(urlComments)
        .then(function(response) {
          item.comments = response.data;

        });


      $rootScope.places = $scope.places;
      $scope.cantidad = $scope.places.length;

      $rootScope.currentMarker = item;
      $rootScope.centerMarkers = [];
      //tengo que mostrar arriba en el map si es dekstop.
      $rootScope.centerMarkers.push($rootScope.currentMarker);

      //con esto centro el mapa en el place correspondiente
      $location.path('/localizar' + '/' + $routeParams.servicio + '/mapa');

    }




    $scope.showCurrent = function(i, p) {

      $rootScope.navBar = p.establecimiento;
      $scope.currentMarker = p;

    }

    $scope.closeCurrent = function() {
      $scope.currentMarker = undefined;
    }



    if ($rootScope.places.length > 0 && $rootScope.currentMarker) {

      $rootScope.centerMarkers = [];
      //tengo que mostrar arriba en el map si es dekstop.
      $rootScope.centerMarkers.push($rootScope.currentMarker);

      $rootScope.moveMapTo = {
        latitude: parseFloat($rootScope.currentMarker.latitude),
        longitude: parseFloat($rootScope.currentMarker.longitude),
        zoom: 18,
        center: true,
      };
    } else {
      placesFactory.getAllFor(search, function(data) {
        $rootScope.places = $scope.places = data;
        $rootScope.currentMarker = $scope.currentMarker = $scope.places[0];

        $rootScope.moveMapTo = {
          latitude: $rootScope.currentMarker.latitude,
          longitude: $rootScope.currentMarker.longitude,
          zoom: 14,
          center: true,
        };
        $rootScope.centerMarkers = [];
        //tengo que mostrar arriba en el map si es dekstop.
        $rootScope.centerMarkers.push($rootScope.currentMarker);



      })
    }


    console.log($rootScope.currentMarker.establecimiento);
    console.log($rootScope.currentMarker.placeId);
    console.log($rootScope.currentMarker.nombre_pais);
    console.log($rootScope.currentMarker.nombre_ciudad);

    gtag('event', 'evaluando', { 
      'lugar': $rootScope.currentMarker.nombre_pais + ' - ' + $rootScope.currentMarker.nombre_ciudad, 
      'nombre_establecimiento': $rootScope.currentMarker.establecimiento,
      'id_establecimiento': $rootScope.currentMarker.placeId
    });     

  });
