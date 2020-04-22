dondev2App.controller('partyListController',
  function(placesFactory, copyService, NgMap, $scope, $rootScope, $routeParams, $location, $http) {

    $rootScope.navBar = $routeParams.servicio;
    $scope.checkbox = false;
    $scope.loading = true;
    $rootScope.main = false;
    $rootScope.geo = false;
    $scope.legal = true;
    $scope.events = "rateReal";

    try {
      try {
        $scope.ciudad = $routeParams.ciudad.split('-')[1];
        $scope.ciudadId = $routeParams.ciudad.split('-')[0];
      } catch (e) {

      }

      $scope.city = $routeParams.partido.split('-')[1];
      $scope.cityId = $routeParams.partido.split('-')[0];

      $scope.partido = $routeParams.partido.split('-')[1];
      $scope.partidoId = $routeParams.partido.split('-')[0];

      // THIS INFO IS JUST FOR USER INFO PURPOSES
      $scope.placeName = $scope.ciudad || $scope.partido;

      $scope.province = $routeParams.provincia.split('-')[1];
      $scope.provinceId = $routeParams.provincia.split('-')[0];

      $scope.country = $routeParams.pais.split('-')[1];
      $scope.countryId = $routeParams.pais.split('-')[0];
    } catch (e) {
    } finally {
      // THIS INFO IS JUST FOR USER INFO PURPOSES
      $scope.placeName = $scope.ciudad || $scope.partido;
    }

    $scope.service = copyService.getFor($routeParams.servicio);
    $rootScope.navBar = $scope.service;

    var search = {

      partido: $scope.cityId,
      provincia: $scope.provinceId,
      pais: $scope.countryId,
      service: $routeParams.servicio.toLowerCase(),

    };
    search[$routeParams.servicio.toLowerCase()] = true;

    var eventName = 'ver_listado_partidos';
    gtag('event',eventName, {
      'event_category': $routeParams.servicio,
      'event_label':  $scope.country + ' - ' +   $scope.ciudad,
    });


    placesFactory.getPlacesByParty(search, function(data) {

      $rootScope.places = $scope.places = data;
      $scope.cantidad = $scope.places.length;

      //Actualizar el mapa en la posición del primer elemento
      $rootScope.moveMapTo = {latitude: data[0].latitude, longitude: data[0].longitude};
      $rootScope.currentZoom = {'rand': Math.random(), 'zoom': 'location'};

      if ($scope.country != null && $scope.country.length > 0) {

        $scope.countryImageTag = $scope.country.toLowerCase();
        $scope.countryImageTag = $scope.countryImageTag.trim();
        $scope.countryImageTag = $scope.countryImageTag.replace(/ +/g, "");
        $scope.countryImageTag = removeAccents($scope.countryImageTag);

        if ($scope.service.code == 'ile') {
          if ($scope.countryImageTag == 'antiguaandbarbuda' ||
            $scope.countryImageTag == 'aruba' ||
            $scope.countryImageTag == 'curacao' ||
            $scope.countryImageTag == 'dominica' ||
            $scope.countryImageTag == 'jamaica' ||
            $scope.countryImageTag == 'honduras' ||
            $scope.countryImageTag == 'grenada' ||
            $scope.countryImageTag == 'suriname' ||
            $scope.countryImageTag == 'saintvincent' ||
            $scope.countryImageTag == 'paraguay' ||
            $scope.countryImageTag == 'panama' ||
            $scope.countryImageTag == 'republicadominicana' ||
            $scope.countryImageTag == 'trinidadandtobago') {

            $scope.legal = false;

        }
      } else {
        $scope.legal = true;
      }

      $scope.ileTag = "ile_" + $scope.countryImageTag;
      $scope.countryTextTag = "countryText_" + $scope.countryImageTag;

    } else if (typeof $rootScope.places[0] != 'undefined' && $rootScope.places[0].idPais != undefined) {
        //busco el tag para ILE por país
        var url = "api/v2/getiletag/" + $rootScope.places[0].idPais;
        $http.get(url)
        .then(function(response) {
          $scope.ileTag = "ile_" + response.data[0].nombre_pais;
          $scope.countryTextTag = "countryText_" + response.data[0].nombre_pais;

        });
      }

      $scope.loading = false;

    })

    $scope.nextShowUp = function(item) {

      $scope.ciudad = item.nombre_ciudad;

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
        item.comments.forEach(function(comment) {
          comment.que_busca = comment.que_busca.split(',');
        });
      });

      $rootScope.currentMarker = item;
      $rootScope.centerMarkers.push($rootScope.currentMarker);

      $rootScope.moveMapTo = {latitude: item.latitude, longitude: item.longitude};
      $rootScope.currentZoom = {'rand': Math.random(), 'zoom': 'place'};

      $location.path('/' + $scope.country + '/' +
        $scope.province + '/' +
        $scope.city + '/' +
        $scope.ciudad + '/' +
        $routeParams.servicio + '/mapa');

    };

    $scope.$watchCollection('checkbox', function(newValue, oldValue) {
      $scope.checkbox = newValue;
      if ($scope.checkbox) {
        var c = 0;
        for (var i = $scope.places.length - 1; i >= 0; i--) {
          if ($scope.places[i].es_rapido == 1) {
            c++;
          }
        }
        $scope.cantidad = c;
      } else {
        $scope.cantidad = $scope.places.length;
      }

    });

    $scope.onChange = function() {

    }

    $scope.esFriendly = function() {
      return function(item) {
        if ($scope.onlyFriendly == 1) {

          if (item.friendly_dc == 1 || item.friendly_ssr == 1 || item.friendly_ile == 1 || item.friendly_mac == 1 || item.friendly_prueba == 1 || item.friendly_condones == 1) {
            return item;
          }
        } else {

          return item;
        }
      }
    }

    $scope.tieneServicioFriendly = function(item) {
      if (item.friendly_dc == 1 || item.friendly_ssr == 1 || item.friendly_ile == 1 || item.friendly_mac == 1 || item.friendly_prueba == 1 || item.friendly_condones == 1) {

        return true;
      } else {

        return false;
      }
    }

    $scope.esRapido = function() {
      return function(item) {
        if ($scope.checkbox == true) {
          if (item.es_rapido == 1) {
            return item;
          }
        }
        if ($scope.checkbox == false) {
          return item;
        }
      }
    };

    $scope.zendeskTriggerNotes = "El usuario se encontraba buscando información de " + $scope.service.label;
  });
