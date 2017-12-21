
dondev2App.config(function($interpolateProvider, $locationProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
})
.filter('removeAccents',function() {

  // Create the return function
  // set the required parameter name to **number**
  return function(text) {
    return removeAccents(text);
  }
})
.filter('matchCity',function() {

  // Create the return function
  // set the required parameter name to **number**
  return function(text) {

    return removeAccents(text);
  }
})

.controller('panelIndexController', function(NgMap,copyService, placesFactory,$filter, $scope, $timeout, $rootScope, $http, $interpolate, $location, $route, $translate) {

   $http.get('api/v1/places/approved')
              .success(function(response) {

                  $scope.places = response;

          });

 $http.get('api/v2/evaluation/getall')
              .success(function(response) {

                  $rootScope.totalEvals = response.total;
                  $rootScope.evaluations = response.data;

          });                  

  $rootScope.exportEvalClick = "";

  var lang = localStorage.getItem("lang");
  $rootScope.selectedLanguage = localStorage.getItem("lang");

  if(lang == 'es'){
    $rootScope.details = 'Ver detalles';
    $rootScope.delete = 'Eliminar';
    $rootScope.edit = 'Editar';
    $rootScope.reject = 'Rechazar';
  }
  else{
    $rootScope.details = 'More details';
    $rootScope.delete = 'Delete';
    $rootScope.edit = 'Edit';
    $rootScope.reject = 'Reject';    
  }
  

    $rootScope.openExportEvalModal = function(){
      $('#exportEvalModal').openModal();
      };

    $rootScope.closeExportEvalModal = function(){
         $('#exportEvalModal').closeModal();
      };

  $rootScope.services = copyService.getAll();
  $rootScope.selectedServiceList = [];
        //$rootScope.services = [{"name":"Condones","shortname" : "Condones"},{"name":"Prueba VIH","shortname":"prueba"},{"name":"Vacunatorios","shortname":"Vacunatorios"},{"name":"Centros de Infectología","shortname":"CDI"},{"name":"Servicios de Salud Sexual y Repoductiva","shortname":"SSR"},{"name":"Interrupción Legal del Embarazo","shortname":"ILE"}];
          $rootScope.selectedServiceList = [0];
          $rootScope.toggle = function (shortname, list) {
            var idx = $rootScope.selectedServiceList.indexOf(shortname);
            if (idx > -1) {
              $rootScope.selectedServiceList.splice(idx, 1);
            }
            else {
              $rootScope.selectedServiceList.push(shortname);
            }
          };

          $rootScope.exists = function (shortname, list) {
            return $rootScope.selectedServiceList.indexOf(shortname) > -1;
          };


          $rootScope.isIndeterminate = function() {
              return ($rootScope.selectedServiceList.length !== 0 &&
                  $rootScope.selectedServiceList.length !== $rootScope.services.length);
            };

            $rootScope.isChecked = function() {
              return $rootScope.selectedServiceList.length === $rootScope.services.length;
            };

            $rootScope.toggleAll = function() {
              if ($rootScope.selectedServiceList.length === $rootScope.services.length) {
                $rootScope.selectedServiceList = [];
              } else if ($rootScope.selectedServiceList.length === 0 || $rootScope.selectedServiceList.length > 0) {
                $rootScope.selectedServiceList = $scope.services.slice(0);
              }
            };




    $rootScope.fire = function(){
    };


    var filterAccents = function(place){
      place.establecimiento = removeAccents(place.establecimiento);
      place.nombre_provincia = removeAccents(place.nombre_provincia);
      place.nombre_localidad = removeAccents(place.nombre_partido);
      place.calle = removeAccents(place.calle);
      return place;
    }

    $scope.filterLocalidad = "";
    $scope.searchExistence = "";
     $scope.data = {
      selectedIndex: 0,
      secondplaceed:  true,
      secondLabel:   "Item Two",
      bottom:        false
    };
    $scope.next = function() {
      $scope.data.selectedIndex = Math.min($scope.data.selectedIndex + 1, 2) ;
    };
    $scope.previous = function() {
      $scope.data.selectedIndex = Math.max($scope.data.selectedIndex - 1, 0);
    };

    $scope.loadingPrev = true;
    $scope.loadingPost = true;
    $scope.loadingDep = true;
    
    $scope.getFontSize = function(c){
      var size = 1;
      return {"font-size": size + "em"};
    }

    $rootScope.showInfo = $scope.showInfo = function(e,i){
      window.open("https://huesped.org.ar/donde/panel/places/" + i.placeId);
    }

  $rootScope.exportPreview = function (places) {

    var data = places;
    $http.post('panel/importer/front-export',
      data
      ,
      {
        headers: { 'Content-Type': 'application/force-download; charset=UTF-8'}
      }
      )
    .then(function (response) {

    }, function (response) {
    });

  };

$rootScope.disableExportEvaluationButton = function(){
  return ($rootScope.selectedServiceList <= 0);
}

  $rootScope.exportEvaluations = function(){
   $rootScope.loadingPost = true;
   var idPais;
   var idProvincia;
   var idPartido;
   if (typeof $rootScope.selectedCountry == "undefined") {
     idPais = null;
   }
   else idPais = $rootScope.selectedCountry.id;
   if (typeof $rootScope.selectedProvince == "undefined") {
     idProvincia = null;
   }
      else idProvincia = $rootScope.selectedProvince.id;
   if (typeof $rootScope.selectedCity === 'undefined'){
     idPartido = null;
   }
   else idPartido = $rootScope.selectedCity.id;

    var f = document.createElement("form");
    f.setAttribute('method',"post");
    f.setAttribute('action',"panel/importer/activePlacesEvaluationsExport");
    f.style.display = 'none';
    var i1 = document.createElement("input"); //input element, text
    i1.setAttribute('type',"hidden");
    i1.setAttribute('name',"idPais");
    i1.setAttribute('value', idPais);

    var i2 = document.createElement("input"); //input element, text
    i2.setAttribute('type',"hidden");
    i2.setAttribute('name',"idProvincia");
    i2.setAttribute('value', idProvincia);

    var i3 = document.createElement("input"); //input element, text
    i3.setAttribute('type',"hidden");
    i3.setAttribute('name',"idPartido");
    i3.setAttribute('value',idPartido);

    var i4 = document.createElement("input"); //input element, text
    i4.setAttribute('type',"hidden");
    i4.setAttribute('name',"selectedServiceList");
    i4.setAttribute('value',$rootScope.selectedServiceList);

    var s = document.createElement("input"); //input element, Submit button
    s.setAttribute('type',"submit");
    s.setAttribute('value',"Submit");
    s.setAttribute('display',"hidden");

    f.appendChild(i1);
    f.appendChild(i2);
    f.appendChild(i3);
    f.appendChild(i4);
    f.appendChild(s);

    document.getElementsByTagName('body')[0].appendChild(f);
    f.submit();
    $rootScope.loadingPost = false;
    document.removeChild(f);
  };

 $rootScope.exportEvaluationsEval = function(){

   $rootScope.loadingPost = true;
   var idPais;
   var idProvincia;
   var idPartido;
   var idCiudad;

   if (typeof $rootScope.selectedCountryEval == "undefined") {
     idPais = null;
   }
   else idPais = $rootScope.selectedCountryEval.id;

   if (typeof $rootScope.selectedProvinceEval == "undefined") {
     idProvincia = null;
   }
      else idProvincia = $rootScope.selectedProvinceEval.id;

   if (typeof $rootScope.selectedPartyEval === 'undefined'){
     idPartido = null;
   }
   else idPartido = $rootScope.selectedPartyEval.id;

   if (typeof $rootScope.selectedCityEval === 'undefined'){
     idCiudad = null;
   }
   else idCiudad = $rootScope.selectedCityEval.id;   

    var f = document.createElement("form");
    f.setAttribute('method',"post");
    f.setAttribute('action',"panel/importer/filteredEvaluations");
    f.style.display = 'none';
    var i1 = document.createElement("input"); //input element, text
    i1.setAttribute('type',"hidden");
    i1.setAttribute('name',"idPais");
    i1.setAttribute('value', idPais);

    var i2 = document.createElement("input"); //input element, text
    i2.setAttribute('type',"hidden");
    i2.setAttribute('name',"idProvincia");
    i2.setAttribute('value', idProvincia);

    var i3 = document.createElement("input"); //input element, text
    i3.setAttribute('type',"hidden");
    i3.setAttribute('name',"idPartido");
    i3.setAttribute('value',idPartido);

    var i4 = document.createElement("input"); //input element, text
    i4.setAttribute('type',"hidden");
    i4.setAttribute('name',"idCiudad");
    i4.setAttribute('value',idCiudad);

    var lang = document.createElement("input"); //input element, text
    lang.setAttribute('type',"hidden");
    lang.setAttribute('name',"lang");
    lang.setAttribute('value',$rootScope.selectedLanguage);

    var s = document.createElement("input"); //input element, Submit button
    s.setAttribute('type',"submit");
    s.setAttribute('value',"Submit");
    s.setAttribute('display',"hidden");

    f.appendChild(i1);
    f.appendChild(i2);
    f.appendChild(i3);
    f.appendChild(i4);
    f.appendChild(lang);    
    f.appendChild(s);

    document.getElementsByTagName('body')[0].appendChild(f);
    f.submit();
    $rootScope.loadingPost = false;
    document.getElementsByTagName('body')[0].removeChild(f);
  };

  var processPlaces = function(response){
    for (var i = 0; i < response.length; i++) {
                    response[i] = filterAccents(response[i]);

                  };
                  $rootScope.filteredplaces = $scope.filteredplaces = $scope.places = $rootScope.places = response;

                  $rootScope.loadingPost = false;
                  //TODO: Move to service
                  var count = _.countBy(response, function(l){
                    return l.nombre_partido + ", " + l.nombre_provincia } );
                  var mapped = _.map(count,function(n,k){return {
                    key: k,count:n, percentage:n*100/response.length};});
                  var ordered = _.sortBy(mapped,"count").reverse();
                  ordered = _.map(ordered,function(n,i){
                    n.position = i+1;
                    return n;
                  });

                  $rootScope.cityRanking = ordered;
                  NgMap.initMap('mapEditor');
                  $rootScope.filterAllplaces();
  }



   $rootScope.activePlacesExport = function(){

   $rootScope.loadingPost = true;

   var idPais;
   var idProvincia;
   var idPartido;
   var idCiudad;

   if (typeof $rootScope.selectedCountry == "undefined") {
     idPais = null;

   }
   else idPais = $rootScope.selectedCountry.id;
   if (typeof $rootScope.selectedProvince == "undefined") {
     idProvincia = null;

   }
      else idProvincia = $rootScope.selectedProvince.id;
   if (typeof $rootScope.selectedParty == 'undefined'){
     idPartido = null;

   }
   else idPartido = $rootScope.selectedParty.id;

      if (typeof $rootScope.selectedCity == 'undefined'){
     idCiudad = null;

   }
   else idCiudad = $rootScope.selectedCity.id;


    var data =  $.param({
      'idPais' : idPais,
      'idProvincia' : idProvincia,
      'idPartido' : idPartido,
      'idCiudad' : idCiudad
    });

    var f = document.createElement("form");
    f.setAttribute('method',"post");
    f.setAttribute('action',"panel/importer/activePlacesExport");
    f.style.display = 'none';
    var i1 = document.createElement("input"); //input element, text
    i1.setAttribute('type',"hidden");
    i1.setAttribute('name',"idPais");
    i1.setAttribute('value', idPais);

    var i2 = document.createElement("input"); //input element, text
    i2.setAttribute('type',"hidden");
    i2.setAttribute('name',"idProvincia");
    i2.setAttribute('value', idProvincia);

    var i3 = document.createElement("input"); //input element, text
    i3.setAttribute('type',"hidden");
    i3.setAttribute('name',"idPartido");
    i3.setAttribute('value',idPartido);

    var i4 = document.createElement("input"); //input element, text
    i4.setAttribute('type',"hidden");
    i4.setAttribute('name',"idCiudad");
    i4.setAttribute('value',idCiudad);


    var s = document.createElement("input"); //input element, Submit button
    s.setAttribute('type',"submit");
    s.setAttribute('value',"Submit");
    s.setAttribute('display',"hidden");

    f.appendChild(i1);
    f.appendChild(i2);
    f.appendChild(i3);
    f.appendChild(i4);
    f.appendChild(s);

    document.getElementsByTagName('body')[0].appendChild(f);
    f.submit();
    $rootScope.loadingPost = false;
    document.getElementsByTagName('body')[0].removeChild(f);
  };

  $rootScope.getNow = function(){

  if($rootScope.selectedCity){
   $rootScope.loadingPost = true;
      $http.get('api/v1/places/approved/' +   $rootScope.selectedCountry.id  + '/' +  $rootScope.selectedProvince.id + '/' + $rootScope.selectedParty.id + '/' +   $rootScope.selectedCity.id )
              .success(function(response) {
    $rootScope.optionMaster1 = true;
    $rootScope.optionMaster2 = false;

                  processPlaces(response);

          });
  }
  else{
    Materialize.toast("Debe seleccionar una ciudad" ,3000);
  }
}

$rootScope.getNowEval = function(){

  if($rootScope.selectedCityEval){

    $rootScope.loadingPost = true;

    $http.get('api/v2/evaluation/getall/' +   $rootScope.selectedCountryEval.id  + '/' +  $rootScope.selectedProvinceEval.id + '/' + $rootScope.selectedPartyEval.id + '/' +   $rootScope.selectedCityEval.id)
    .success(function(response) {
      $rootScope.evaluations = response;
      $rootScope.totalEvals = response.length;
      $rootScope.loadingPost = false;
    })
  }
  else{
    Materialize.toast("Debe seleccionar una ciudad" ,3000);
  }
}  


   $http.get('api/v2/panel/places/countersfilterbyuser')
              .success(function(response) {

                  $scope.counters = $rootScope.counters = response;

          });




$rootScope.searchQuery = "";
  $rootScope.searchNow = function(){
    $rootScope.optionMaster1 = false;
    $rootScope.optionMaster2 = true;

    if ($rootScope.searchQuery.length <=3){
      Materialize.toast("Por favor, ingresa mas de 3 letras para buscar" ,4000);
      return;
    }


    $rootScope.loadingPost = true;
      $http.get('api/v1/panel/places/searchfilterbyuser/' +  $rootScope.searchQuery)
              .success(function(response) {
                  processPlaces(response);

          });

  };

    $rootScope.loadCity = function() {

      var flag =$(".tabs li a").last().hasClass('active');

      // From Actives
      if(!flag){
        $rootScope.showCity = true;
        placesFactory.getCitiesForPartidos({
          id: $scope.selectedParty.id
        }, function(data) {
          $scope.cities = data;
          $rootScope.cities = data;
        })
      }
    // From Evaluations
    else{
      $rootScope.showCityEval = true;
      placesFactory.getCitiesForPartidos({
        id: $scope.selectedPartyEval.id
      }, function(data) {
        $scope.citiesEval = data;
        $rootScope.citiesEval = data;
      })      
    }
  }

  $scope.showSearch = function(){
    $scope.searchOn= true;
  }

  $rootScope.showProvince = function(){

    var flag =$(".tabs li a").last().hasClass('active');
    
    // From Actives 
    if(!flag){
      $rootScope.provinceOn= true;
      placesFactory.getProvincesForCountry($scope.selectedCountry.id,function(data){
       $rootScope.provinces = data;
     });
    }
    // From Evaluations
    else{
      $rootScope.provinceEvalOn= true;
      placesFactory.getProvincesForCountry($scope.selectedCountryEval.id,function(data){
       $rootScope.provincesEval = data;
     });
    }
  }

  $rootScope.showPartidos = function(){

  var flag =$(".tabs li a").last().hasClass('active');

  // From Actives
  if(!flag){
    $rootScope.partidoOn= true;
    placesFactory.getPartidosForProvince($scope.selectedProvince.id,function(data){
      $rootScope.parties = data;
    });      
  }
  // From Evaluations
  else{
    $rootScope.partidoEvalOn= true;
    placesFactory.getPartidosForProvince($scope.selectedProvinceEval.id,function(data){
      $rootScope.partiesEval = data;
    });      
  }
}

    var loadAllLists = function(){
          $scope.loadingPrev = true;
          $scope.loadingPost = false;
          $scope.loadingDep = true;

          $scope.loadingDashboard = true;

           $http.get('api/v1panelplaces/ranking')
              .success(function(data) {
                  for (var i = 0; i < data.length; i++) {
                    var d= data[i];
                    data[i].key = d.nombre_partido + " " + d.nombre_provincia + " , " + d.nombre_pais
                  };
                  $scope.ranking = data;
                  $scope.loadingDashboard = false;
              });

          $http.get('api/v1panelplaces/badgeofilterbyuser')
              .success(function(data) {
                  for (var i = 0; i < data.length; i++) {
                    var d= data[i];
                    data[i].key = d.nombre_partido + " " + d.nombre_provincia + " , " + d.nombre_pais
                  };
                  $scope.badGeo = data;
                  $scope.loadingDashboard = false;
              });

          $http.get('api/v1panelplaces/nongeofilterbyuser')
              .success(function(data) {
                  for (var i = 0; i < data.length; i++) {
                    var d= data[i];
                    data[i].key = d.nombre_partido + " " + d.nombre_provincia + " , " + d.nombre_pais
                  };
                  $scope.nonGeo = data;
                  $scope.loadingDashboard = false;
              });


          $http.get('api/v1panelplaces/pendingfilterbyuser')
              .success(function(response) {
                for (var i = 0; i < response.length; i++) {
                  console.debug(response[i]);
                   response[i]=filterAccents(response[i]);

                  };
                  $rootScope.penplaces = $scope.penplaces = response;
                  $scope.loadingPrev = false;
              });


            $http.get('api/v1/places/blocked')
              .success(function(response) {
                for (var i = 0; i < response.length; i++) {
                    response[i] = filterAccents(response[i]);

                  };
                  $rootScope.rejectedplaces = $scope.rejectedplaces = response;

                  $scope.loadingDep = false;
            });

            $http.get('api/v1/places/tagsimportaciones')
              .success(function(response) {
                $scope.tagsImportaciones = response;
                $scope.loading = false;
              });
    };

    loadAllLists();
    $rootScope.onlyBadGeo = true;
    $rootScope.onlyGoodGeo = true;
    $scope.filterAllPlaces = $rootScope.filterAllplaces = function(q){

        var result = [];
         var filterPlaces = [];
        var filterValues = {
            $:""
        };
        if ((typeof $rootScope.searchExistence != "undefined") && ($rootScope.searchExistence.length > 3)){
          filterValues = {
            $:$rootScope.searchExistence
          };
        }

        var preFilter =
          $filter('filter')($rootScope.places,filterValues);

        for (var i = 0; i < preFilter.length; i++) {
          var p = preFilter[i];
          if (!p.confidence && $rootScope.onlyBadGeo){
            result.push(p);

          }
          else if (p.confidence ===0.5 && $rootScope.onlyBadGeo){
            result.push(p);
          }
          else if (p.confidence > 0.5 && $rootScope.onlyGoodGeo){
            result.push(p);
          }
        }
         $rootScope.filteredplaces = $scope.filteredplaces = result;


    }


    $rootScope.blockNow= function(place){
      $rootScope.current = place;
       $('#demoModal').openModal();
    };

    $rootScope.removePlace = function(){

      var establec = $rootScope.current.establecimiento;
    $http.post('api/v1/panel/places/' + $rootScope.current.placeId + '/block')
      .then(
        function(response) {
          if (response.data.length == 0) {

          Materialize.toast('El establecimiento ' + establec + ' ha sido rechazado.', 5000);
          } else {
            for (var propertyName in response.data) {
              Materialize.toast(response.data[propertyName], 10000);
            };
          }

        },
        function(response) {
          Materialize.toast('Hemos cometido un error al procesar tu peticion, intenta nuevamente mas tarde.', 5000);

        });

      // Materialize.toast($rootScope.current.establecimiento + " ha sido rechazada.",4000);
       $('#demoModal').closeModal();
       $rootScope.current = {};
       loadAllLists();
    };

    $rootScope.removeNow= function(evalId){
      $rootScope.evalId = evalId;
       $('#demoModalEval').openModal();
    };

    $rootScope.removeEval = function(id){

      var eval = id[0][0];

      $http.get('api/v2/evaluation/'+eval)
        .then(
          function(response) {
            $http.get('api/v2/evaluation/getall')
              .success(function(response) {

                 Materialize.toast('La evaluación ha sido removida con éxito', 5000);
                  $rootScope.totalEvals = response.total;
                  $rootScope.evaluations = response.data;
                   $('#demoModalEval').closeModal();

          });       
           

          },
        function(response) {
          Materialize.toast('Error al eliminar la evaluación', 5000);

        });

      // Materialize.toast($rootScope.current.establecimiento + " ha sido rechazada.",4000);
      
       
                   
    };

    $scope.closeModal= function(place){
       $('#demoModal').closeModal();
       $scope.current = {};
    };


    placesFactory.getCountriesFilterByUser(function(countries){
        $rootScope.countries = countries;

      });



 $rootScope.changeLanguage = function() {

      localStorage.setItem("lang", $rootScope.selectedLanguage);
      localStorage.setItem("selectedByUser", true);
      $translate.use($rootScope.selectedLanguage);
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
