dondev2App.controller('locateListController',
  function(placesFactory, NgMap, $scope, $rootScope, $routeParams, $location, $http) {
    $rootScope.main = false;
    $scope.service = $routeParams.servicio;
    $rootScope.navBar = $scope.service;
    $scope.places = [];
    $scope.main = true;
    $rootScope.geo = true;
    $scope.loading = true;
    $scope.events = "distance";
    $scope.legal = true;
    //parseo a obj para obtener el servicio si no piden todo

    if (typeof $scope.service === "undefined" || $scope.service === null || $scope.service == "" || $scope.service == "friendly") {
      $scope.service = "friendly";
    } else {
      $scope.service = ($scope.service != "all") ? angular.fromJson($scope.service) : $scope.service;
    }

    //seteo a todos en false x las dudas
    $scope.checkbox = false;
    $rootScope.voteLimit = 5;
    $scope.voteLimit = 5;

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


    $scope.addComment = function() {
      $scope.voteLimit++;
    }

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

    var onLocationError = function(e) {
      $scope.$apply(function() {
        $location.path('/call/help');
      });
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
          item.rate = response.data[0];
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

          for (var i = item.comments.length - 1; i >= 0; i--) {
            item.comments[i].que_busca = item.comments[i].que_busca.split(',');
          }

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

    var onLocationFound = function(position) {
      $scope.$apply(function() {

        placesFactory.forLocation(position.coords, function(result) {

          var geoPais;

          var address = position.coords.latitude+','+position.coords.longitude

          var url = "https://maps.google.com.ar/maps/api/geocode/json?latlng="+address+"&key=AIzaSyBoXKGMHwhiMfdCqGsa6BPBuX43L-2Fwqs";

          $http.get(url)
          .then(function(response) {
            for (var i = 0; i <response.data.results.length; i++){
              if(response.data.results[i].types[0] === 'country'){
                console.log(response.data.results[i].address_components[0].long_name);
                geoPais = response.data.results[i].address_components[0].long_name;
              }
              
            }

            gtag('event', 'geo',{
              'latitud': position.coords.latitude,
              'longitud': position.coords.longitude 
            });

            gtag('event', 'geoPais',{
              'nombre_pais' : geoPais
            });            


          });

          for (var i = result.length - 1; i >= 0; i--) {
            if (typeof result[i].distance === "string")
              result[i].distance = Number(result[i].distance);
            var tmp = result[i].distance.toFixed();
            result[i].distance = tmp * Number(100);
          }

          var jsonObj = {
            code: "all"
          };

          try {
            jsonObj = JSON.parse($routeParams.servicio);

          } catch (e) {
            jsonObj = {
              code: $routeParams.servicio
            }
          }

          var resultTemp = [];

          if (jsonObj.code === "all") {
            resultTemp = result;
          } else {

            if (jsonObj.code == "condones") { //codigo =  condon
              for (var i = 0; i < result.length; i++) {
                if (result[i].condones == 1)
                  resultTemp.push(result[i]);
              }
            }
/*
            if (jsonObj.code == "vacunatorio") { //codigo =  vacunacion
              for (var i = 0; i < result.length; i++) {
                if (result[i].vacunatorio == 1)
                  resultTemp.push(result[i]);
              }
            }
*/
            if (jsonObj.code == "prueba") { //codigo =  prueba
              for (var i = 0; i < result.length; i++) {
                if (result[i].prueba == 1)
                  resultTemp.push(result[i]);
              }
            }
/*
            if (jsonObj.code == "infectologia") { //codigo =  infectologia
              for (var i = 0; i < result.length; i++) {
                if (result[i].infectologia == 1)
                  resultTemp.push(result[i]);
              }
            }
*/
            if (jsonObj.code == "mac") { //codigo =  mac
              for (var i = 0; i < result.length; i++) {
                if (result[i].mac == 1)
                  resultTemp.push(result[i]);
              }
            }

            if (jsonObj.code == "ile") { //codigo =  ile
              for (var i = 0; i < result.length; i++) {
                if (result[i].ile == 1)
                  resultTemp.push(result[i]);
              }
            }

            if (jsonObj.code == "dc") { //codigo =  dc
              for (var i = 0; i < result.length; i++) {
                if (result[i].dc == 1)
                  resultTemp.push(result[i]);
              }
            }

            if (jsonObj.code == "ssr") { //codigo =  ssr
              for (var i = 0; i < result.length; i++) {
                if (result[i].ssr == 1)
                  resultTemp.push(result[i]);
              }
            }

            if (jsonObj.code == "friendly") {
              for (var i = 0; i < result.length; i++) {
                if (result[i].friendly_ile == 1 || result[i].friendly_mac == 1 || result[i].friendly_ssr == 1 || result[i].friendly_dc == 1 || result[i].friendly_condones == 1 || result[i].friendly_prueba == 1)
                  resultTemp.push(result[i]);
              }
            }
          }

          $rootScope.places = $scope.places = $scope.closer = resultTemp;
          $scope.cantidad = $scope.places.length;
          $rootScope.currentPos = position.coords;
					if (typeof $rootScope.places[0] != 'undefined' && $rootScope.places[0].idPais != undefined){
						var url = "api/v2/getiletag/" + $rootScope.places[0].idPais;
						$http.get(url)
							.then(function(response) {
								$scope.countryImageTag = response.data[0].nombre_pais.toLowerCase();
                $scope.countryImageTag = $scope.countryImageTag.trim();
                $scope.countryImageTag = $scope.countryImageTag.replace(/ +/g, "");
                $scope.countryImageTag = removeAccents($scope.countryImageTag);

                if ($scope.service.code == 'ile'){
                 if($scope.countryImageTag == 'antiguaandbarbuda' || 
                  $scope.countryImageTag == 'aruba' || 
                  $scope.countryImageTag == 'curacao' || 
                  $scope.countryImageTag == 'dominica' || 
                  $scope.countryImageTag == 'jamaica' || 
                  $scope.countryImageTag == 'honduras' || 
                  $scope.countryImageTag == 'grenada' || 
                  $scope.countryImageTag == 'suriname' || 
                  $scope.countryImageTag == 'saintvincent'|| 
                  $scope.countryImageTag == 'paraguay'|| 
                  $scope.countryImageTag == 'panama' || 
                  $scope.countryImageTag == 'republicadominicana' || 
                  $scope.countryTextTag =='trinidadandtobago'){

                    $scope.legal = false;

                  }
                }
              else{
               $scope.legal = true;
               }

                $scope.ileTag = "ile_" + $scope.countryImageTag;
                $scope.countryTextTag = "countryText_" + $scope.countryImageTag;
							});
					}

          $scope.loading = false;
        });
      });
    };
    navigator.geolocation.getCurrentPosition(onLocationFound, onLocationError);
  });
