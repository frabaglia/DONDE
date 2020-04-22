dondev2App.controller('mapController',
	function(placesFactory,NgMap, $scope,$rootScope, $timeout, $routeParams, $location, $http){

    //Constants
    var overviewZoom = 5;
    var locationZoom = 12;
    var placeZoom = 15;
    var initLocation = {latitude: -27.433133, longitude: -63.046042};

    //Shared variables
    $rootScope.moveMapTo = [];
    $rootScope.loadPlaces = [];
    $rootScope.currentZoom = [];

    //Private variables
    var markers = [];

    function initMap() {
      $rootScope.moveMapTo = initLocation;
      $rootScope.currentZoom = {'rand': Math.random(), 'zoom': 'overview'};
    }

    //Watch out when the map needs to be moved
    $rootScope.$watch('moveMapTo', function(coords){
      var pos = new google.maps.LatLng(coords.latitude, coords.longitude);
      if (window.map){
        window.map.setCenter(pos);
        window.map.panTo(pos);
      }
    });

    //Watch out when we need to adjust the zoom
    $rootScope.$watch('currentZoom', function(currentZoom){
      var zoom = currentZoom['zoom'];
      if (window.map){
        switch (zoom) {
          case "overview":
          window.map.setZoom(overviewZoom); break;
          case "location":
          window.map.setZoom(locationZoom); break;
          case "place":
          window.map.setZoom(placeZoom); break;
          default:
          window.map.setZoom(overviewZoom); break;
        }
      }
    });

    //Watch places. If changed, reset markers. Prefilter centers to avoid doubled markers on same geolocation
    $rootScope.$watch('places', function(){
      var places = $rootScope.places;
      var centers = $rootScope.centerMarkers;
      if(places){
        deleteMarkers();
        places = filterPlacesOverCenters(places,centers);
        for (var i = 0; i < places.length; i++) {
          var item = places[i];
          pushMarker(item,false);
        }
        if(centers){
          for (var i = 0; i < centers.length; i++) {
            var item = centers[i];
            pushMarker(item,true);
          }
        }
      }
    });

    // Watch out changes on center markers. Must delete a present place marker before
    $rootScope.$watch('currentMarker', function(){
      var centers = $rootScope.centerMarkers;
      if(centers){
        for (var i = 0; i < centers.length; i++) {
          var item = centers[i];
          deleteMarkerByID(item.placeId);
          pushMarker(item,true);
        }
      }
    });

    // Delete marker by ID
    function deleteMarkerByID(id){
      for (var i = 0; i < markers.length; i++) {
        if(markers[i]['ID'] == id){
          markers[i]['marker'].setMap(null);
          markers.splice(i,1);
          return i;
        }
      }
      return -1;
    }

    // Get rid of centers that are present on places, avoiding double markers
    function filterPlacesOverCenters(places, centers){
      if(centers){
        for (var j = 0; j < centers.length; j++) {
          for (var i = 0; i < places.length; i++) {
            if(centers[j].placeId == places[i].placeId){
              places.splice(i, 1);
            }
          }
        }
      }
      return places;
    }

    // Set markers on screen (or not)
    function setMapOnMarkers(map) {
      for (var i = 0; i < markers.length; i++) {
        markers[i]['marker'].setMap(map);
      }
    }

    // Refresh markers
    function deleteMarkers() {
      setMapOnMarkers(null);
      markers = [];
    }

    // Creates marker (check if it's selected or not), add to list, add 'click' listener, add to map
    function pushMarker(item,is_center = false){
      var marker = new google.maps.Marker({
        position: new google.maps.LatLng(item.latitude,item.longitude),
        icon: (is_center)?"images/place-on.png":"images/place-off.png"
      });
      markers.push({
        'marker': marker,
        'ID': item.placeId
      });
      markers[markers.length - 1]['marker'].addListener('click', showCurrent.bind(this, item));
      markers[markers.length - 1]['marker'].setMap(window.map);
    }

    $timeout(function(){
      initMap();
    },100);

    //Bind 'click' function on map
    function showCurrent (place){
      $rootScope.navBar = place.establecimiento;

      //Load comments
      var urlComments = "api/v2/evaluacion/comentarios/" + place.placeId;
      place.comments = [];
      $http.get(urlComments)
      .then(function(response) {
        place.comments = response.data;
        place.comments.forEach(function(comment) {
          comment.que_busca = comment.que_busca.split(',');
        });
      });

      //Actualizar markers seleccionados en el mapa
      $rootScope.currentMarker = place;
      $rootScope.centerMarkers.push($rootScope.currentMarker);

      //Actualizar mapa
      $rootScope.moveMapTo = {latitude: place.latitude, longitude: place.longitude};
      $rootScope.currentZoom = {'rand': Math.random(), 'zoom': 'place'};

      var path = $location.path();
      if (path.indexOf('listado') > -1){
        var newPath = path.replace('listado','mapa');
        $location.path(newPath);
      }
    }

  });
