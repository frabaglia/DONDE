dondev2App.controller('formController', function(NgMap, autocompleteService, vcRecaptchaService, placesFactory, $scope, $rootScope, $http, $interpolate, $location, $translate) {

  $rootScope.main = true;
  $scope.invalid = true;
  $scope.place = {};
  $scope.spinerflag = false;

  $scope.onDragEnd = function(e) {

    $scope.place.latitude = e.latLng.lat();
    $scope.place.longitude = e.latLng.lng()
  };
  $scope.isChecked = function(d) {
    if (d === 1 || d === true) {
      return true;
    } else {
      return false;
    }
  }

  try {

    if (typeof localStorage.lang !== "undefined") {

      $http.get('changelang/' + localStorage.lang)
      .success(
        function(response) {

          $translate.use(localStorage.getItem("lang"));
        },
        function(response) {
          Materialize.toast('Intenta nuevamente mas tarde.', 5000);
        });
    } else {
      var userLang = navigator.language || navigator.userLanguage; // es-AR
      var userLang = userLang.split('-')[0]; // es
      localStorage.setItem("lang", userLang);
      $translate.use(userLang);
    }

  } catch (err) {
    if (typeof(err) !== "undefined") {
      localStorage.setItem("lang", "es");
    }
  }

  var onLocationFound = function(position) {

    $scope.$apply(function() {
      $scope.waitingLocation = false;
      $scope.position = position;
      var lat = position.coords.latitude;
      var lon = position.coords.longitude;
      $scope.place.latitude = lat;
      $scope.place.longitude = lon;

      $scope.place.position = [lat, lon];

      $scope.positions = [];
      $scope.positions.push($scope.place);
      $scope.center = [lat, lon];

      $scope.loading = false;
      var map = NgMap.initMap('mapEditor');
      map.panTo(new google.maps.LatLng(lat, lon));

    });

  }
  var onLocationError = function() {
    Materialize.toast('Lo sentimos no hemos podido ubicar tu localización.', 5000);
  }
  $scope.lookupLocation = function() {

    if (navigator.geolocation) {
      $scope.waitingLocation = true;
      navigator.geolocation.getCurrentPosition(onLocationFound, onLocationError);
    } else {
      ga('send', 'event', 'geolalizacion', 'localizacioNoFunciona', "");
      alert("no location found");
    }
  };

  function isValidAttr(attr){
    return !(typeof attr === "undefined" || attr === null || 0 === attr.length);
  }

  function invalidForm() {
    var flag = (
      (!$scope.aceptaTerminos) ||
      (!isValidLocation()) ||
      (!$scope.place.establecimiento || 0 === $scope.place.establecimiento.length));
    if (!flag) {
      return !isValidServices();
    } else return true;
  }

  function isValidServices(){
    if(( $scope.place.condones || $scope.place.ile || $scope.place.prueba ||
      $scope.place.mac      || $scope.place.ssr || $scope.place.dc      )
      &&
      ( !($scope.place.condones && !isValidAttr($scope.place.servicetype_condones)) &&
        !($scope.place.ile      && !isValidAttr($scope.place.servicetype_ile))      &&   
        !($scope.place.prueba   && !isValidAttr($scope.place.servicetype_prueba))   &&
        !($scope.place.mac      && !isValidAttr($scope.place.servicetype_mac))      &&
        !($scope.place.ssr      && !isValidAttr($scope.place.servicetype_ssr))      &&
        !($scope.place.dc       && !isValidAttr($scope.place.servicetype_dc))        )
      )
      return true;
    else
      return false;
  }

  function isValidLocation() {
    var valid = true;
    if((typeof $scope.place.idPais      === "undefined")  ||
      (typeof $scope.place.idProvincia  === "undefined")  ||
      (typeof $scope.place.idPartido    === "undefined")  ||
      (typeof $scope.place.idCiudad     === "undefined")  )
      valid = false;
    if(isValidAutocomplete())
      valid = true;
    return valid;
  }

  $scope.formChange = function() {
    if (invalidForm()) {
      $scope.invalid = true;
    } else {
      $scope.invalid = false;
    }
  };

  function processServices() {
    if ($scope.place.condones) {
      $scope.place.responsable_distrib = $scope.place.responsable || '';
      $scope.place.horario_distrib = $scope.place.horario || '';
      $scope.place.mail_distrib = $scope.place.mail || '';
      $scope.place.tel_distrib = $scope.place.telefono || '';
      $scope.place.web_distrib = $scope.place.web || '';
    } else {
      $scope.place.condones = false;
    }

    if ($scope.place.prueba) {
      $scope.place.responsable_testeo = $scope.place.responsable || '';
      $scope.place.horario_testeo = $scope.place.horario || '';
      $scope.place.mail_testeo = $scope.place.mail || '';
      $scope.place.tel_testeo = $scope.place.telefono || '';
      $scope.place.web_testeo = $scope.place.web || '';
    } else {
      $scope.place.prueba = false;
    }

    if ($scope.place.infectologia) {
      $scope.place.responsable_infectologia = $scope.place.responsable || '';
      $scope.place.horario_infectologia = $scope.place.horario || '';
      $scope.place.mail_infectologia = $scope.place.mail || '';
      $scope.place.tel_infectologia = $scope.place.telefono || '';
      $scope.place.web_infectologia = $scope.place.web || '';
    } else {
      $scope.place.infectologia = false;
    }

    if ($scope.place.vacunatorio) {
      $scope.place.responsable_vac = $scope.place.responsable || '';
      $scope.place.horario_vac = $scope.place.horario || '';
      $scope.place.mail_vac = $scope.place.mail || '';
      $scope.place.tel_vac = $scope.place.telefono || '';
      $scope.place.web_vac = $scope.place.web || '';
    } else {
      $scope.place.vacunatorio = false;
    }


    if ($scope.place.mac) {
      $scope.place.responsable_mac = $scope.place.responsable || '';
      $scope.place.horario_mac = $scope.place.horario || '';
      $scope.place.mail_mac = $scope.place.mail || '';
      $scope.place.tel_mac = $scope.place.telefono || '';
      $scope.place.web_mac = $scope.place.web || '';
    } else {
      $scope.place.mac = false;
    }

    if ($scope.place.ile) {
      $scope.place.responsable_ile = $scope.place.responsable || '';
      $scope.place.horario_ile = $scope.place.horario || '';
      $scope.place.mail_ile = $scope.place.mail || '';
      $scope.place.tel_ile = $scope.place.telefono || '';
      $scope.place.web_ile = $scope.place.web || '';
    } else {
      $scope.place.ile = false;
    }

    if ($scope.place.ssr) {
      $scope.place.responsable_ssr = $scope.place.responsable || '';
      $scope.place.horario_ssr = $scope.place.horario || '';
      $scope.place.mail_ssr = $scope.place.mail || '';
      $scope.place.tel_ssr = $scope.place.telefono || '';
      $scope.place.web_ssr = $scope.place.web || '';
    } else {
      $scope.place.ssr = false;
    }

    if ($scope.place.dc) {
      $scope.place.responsable_dc = $scope.place.responsable || '';
      $scope.place.horario_dc = $scope.place.horario || '';
      $scope.place.mail_dc = $scope.place.mail || '';
      $scope.place.tel_dc = $scope.place.telefono || '';
      $scope.place.web_dc = $scope.place.web || '';
    } else {
      $scope.place.dc = false;
    }

  }

  placesFactory.getCountries(function(countries) {
    $scope.countries = countries;
  })

  $scope.showProvince = function() {
    $scope.provinceOn = true;
    placesFactory.getProvincesForCountry($scope.place.idPais, function(data) {
      $scope.provinces = data;
    });
  }

  $scope.showPartido = function() {
    $scope.partidoOn = true;
    placesFactory.getPartidosForProvince($scope.place.idProvincia, function(data) {
      $scope.partidos = data;
    });
  }

  $scope.loadCity = function() {
    $scope.showCity = true;
    placesFactory.getCitiesForPartidos({
      id: $scope.place.idPartido
    }, function(data) {
      $scope.cities = data;
    })
  };

  autocompleteService.initAutocomplete(checkAutocomplete);
  $scope.outputAutocomplete = "";

  function checkAutocomplete(){
    $scope.autocompleteForm = autocompleteService.fillInCity();
    var valid = isValidAutocomplete();
    if(valid){
      var str = commaParsing($scope.autocompleteForm);
      $scope.outputAutocomplete = str;
      $scope.$apply();
    }
  };

  $scope.cancelNewCity = function(){
    $scope.outputAutocomplete = "";
    $scope.inputAutocomplete = "";
    $scope.autocompleteForm = [];
  }

  function isValidAutocomplete(){
    var valid = true;
    if(!$scope.autocompleteForm || $scope.autocompleteForm.length === 0) return false;
    for (var i = 0; i < $scope.autocompleteForm.length; i++) {
      var component = $scope.autocompleteForm[i];
      if(component == "")
        valid = false;
    }
    return valid;
  }

  function commaParsing(array){
    var str = "";
    for (var i = 0; i < array.length; i++) {
      var component = array[i];
      if(component != ""){
        if(i == 0)
          str = str + component;
        else
          str =  str  + ", " + component;
      }
    }
    return str;
  }

  function placeAutocompleteParsing(){
    if(!isValidAutocomplete()) return;
    $scope.place.nombre_ciudad    = $scope.autocompleteForm[0];
    $scope.place.nombre_partido   = $scope.autocompleteForm[1];
    $scope.place.nombre_provincia = $scope.autocompleteForm[2];
    $scope.place.nombre_pais      = $scope.autocompleteForm[3];
    $scope.place.newCityAdded = true;
  }

  $scope.clicky = function() {
    $scope.formChange();
    if($scope.invalid){
      if($rootScope.selectedLanguage == "es")
        Materialize.toast("Completa el formulario", 5000);
      else
        Materialize.toast("Complete the form", 5000);
      return;
    }
    placeAutocompleteParsing();

    $scope.invalid = true;
    $scope.spinerflag = true;

    processServices();
    var data = $scope.place;

    $http.post('api/v1/places', data)
    .then(
      function(response) {
        $scope.spinerflag = false;
        if (response.data.length === 0) {
          Materialize.toast('Su peticion a sido enviada!', 5000);
          $("button").remove();
          $("input").val("");
          document.location.href = $location.path();
        } else {
          for (var propertyName in response.data) {
            Materialize.toast(response.data[propertyName], 10000);
          }
          $scope.spinerflag = false;
          $scope.formChange();
        }

      },
      function(response) {
        Materialize.toast('Intenta nuevamente mas tarde.', 5000);
        $scope.invalid = false;
        $scope.spinerflag = false;
      });
  };

  $rootScope.changeLanguage = function() {

    localStorage.setItem("lang", $rootScope.selectedLanguage);
    localStorage.setItem("selectedByUser", true);
    $translate.use($rootScope.selectedLanguage);
    // $cookies.put('lang', $rootScope.selectedLanguage);
    $http.get('changelang/' + $rootScope.selectedLanguage)
    .then(
      function(response) {

        if (response.statusText == 'OK') {

        } else {
          Materialize.toast('Intenta nuevamente mas tarde.', 5000);
        }
      },
      function(response) {
        Materialize.toast('Intenta nuevamente mas tarde.', 5000);
      });

    return;
  }
});
