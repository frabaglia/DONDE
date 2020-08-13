
dondev2App.controller('panelIndexController', function(NgMap,copyService, placesFactory,$filter, $scope, $timeout, $rootScope, $http, $interpolate, $location, $route, $translate) {
  $scope.onlyApproved = true;
  $rootScope.onlyApproved = true;
  $rootScope.exportEvalClick = "";

  var userLang = 'es';
  if (typeof localStorage.selectedByUser === "undefined" || typeof localStorage.lang === "undefined") {
    localStorage.setItem("lang", userLang);
    localStorage.setItem("selectedByUser", false);
    $translate.use(userLang);
  }

  var lang = localStorage.getItem("lang");
  $rootScope.selectedLanguage = lang;

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

  $rootScope.$watch('loadingPost', function(){
    $scope.loadingPost = $rootScope.loadingPost;
  });

  $rootScope.showInfo = $scope.showInfo = function(e,i){
    window.open("panel/places/" + i.placeId);
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

  $scope.exportEvaluations = function(){
    $rootScope.loadingPost = true;
    var idPais;
    var idProvincia;
    var idPartido;
    if (typeof $scope.selectedCountry == "undefined") {
      idPais = null;
    }
    else idPais = $scope.selectedCountry.id;
    if (typeof $scope.selectedProvince == "undefined") {
      idProvincia = null;
    }
    else idProvincia = $scope.selectedProvince.id;
    if (typeof $scope.selectedCity === 'undefined'){
      idPartido = null;
    }
    else idPartido = $scope.selectedCity.id;


    var f = document.createElement("form");
    f.setAttribute('method',"post");
    f.setAttribute('action',"panel/importer/activePlacesEvaluationsExport");
    f.style.display = 'none';

    var i1 = document.createElement("input");
    i1.setAttribute('type',"hidden");
    i1.setAttribute('name',"idPais");
    i1.setAttribute('value', idPais);

    var i2 = document.createElement("input");
    i2.setAttribute('type',"hidden");
    i2.setAttribute('name',"idProvincia");
    i2.setAttribute('value', idProvincia);

    var i3 = document.createElement("input");
    i3.setAttribute('type',"hidden");
    i3.setAttribute('name',"idPartido");
    i3.setAttribute('value',idPartido);

    var i4 = document.createElement("input");
    i4.setAttribute('type',"hidden");
    i4.setAttribute('name',"selectedServiceList");
    i4.setAttribute('value',$scope.selectedServiceList);

    var s = document.createElement("input");
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

  $scope.exportEvaluationsEval = function(){

    $rootScope.loadingPost = true;
    var idPais;
    var idProvincia;
    var idPartido;
    var idCiudad;
    var valor;
    var opciones = document.getElementsByName("opcion");
    for(var i=0; i<opciones.length; i++){
      if(opciones[i].checked){
        valor = opciones[i].value;
      }
    }
    if(valor == null){
      valor = 'null';
    }

    if (!$scope.selectedCountryEval || typeof $scope.selectedCountryEval === undefined) {
      idPais = null;
    }
    else idPais = $scope.selectedCountryEval.id;

    if (!$scope.selectedProvinceEval || typeof $scope.selectedProvinceEval === undefined) {
      idProvincia = null;
    }
    else idProvincia = $scope.selectedProvinceEval.id;

    if (!$scope.selectedPartyEval || typeof $scope.selectedPartyEval === undefined ){
      idPartido = null;
    }
    else idPartido = $scope.selectedPartyEval.id;

    if (!$scope.selectedCityEval || typeof $scope.selectedCityEval === undefined){
      idCiudad = null;
    }
    else idCiudad = $scope.selectedCityEval.id;

    var f = document.createElement("form");
    f.setAttribute('method',"post");
    f.setAttribute('action',"panel/importer/filteredEvaluations");
    f.style.display = 'none';
    var i1 = document.createElement("input");
    i1.setAttribute('type',"hidden");
    i1.setAttribute('name',"idPais");
    i1.setAttribute('value', idPais);

    var i2 = document.createElement("input");
    i2.setAttribute('type',"hidden");
    i2.setAttribute('name',"idProvincia");
    i2.setAttribute('value', idProvincia);

    var i3 = document.createElement("input");
    i3.setAttribute('type',"hidden");
    i3.setAttribute('name',"idPartido");
    i3.setAttribute('value',idPartido);

    var i4 = document.createElement("input");
    i4.setAttribute('type',"hidden");
    i4.setAttribute('name',"idCiudad");
    i4.setAttribute('value',idCiudad);

    var aprob = document.createElement("input");
    aprob.setAttribute('type',"hidden");
    aprob.setAttribute('name',"aprob");
    aprob.setAttribute('value',valor);

    var lang = document.createElement("input");
    lang.setAttribute('type',"hidden");
    lang.setAttribute('name',"lang");
    lang.setAttribute('value',$scope.selectedLanguage);

    var s = document.createElement("input");
    s.setAttribute('type',"submit");
    s.setAttribute('value',"Submit");
    s.setAttribute('display',"hidden");

    f.appendChild(i1);
    f.appendChild(i2);
    f.appendChild(i3);
    f.appendChild(i4);
    f.appendChild(lang);
    f.appendChild(s);
    f.appendChild(aprob);

    document.getElementsByTagName('body')[0].appendChild(f);
    f.submit();
    $rootScope.loadingPost = false;
    document.getElementsByTagName('body')[0].removeChild(f);
  };

  var processPlaces = function(response){
    for (var i = 0; i < response.length; i++) {
      response[i] = filterAccents(response[i]);

    };
    $rootScope.filteredplaces = $scope.filteredplaces = $rootScope.places = $scope.places = response;

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

    if (typeof $scope.selectedCountry == "undefined"|| $scope.selectedCountry == null){
      idPais = null;

    }
    else idPais = $scope.selectedCountry.id;
    if (typeof $scope.selectedProvince == "undefined"|| $scope.selectedProvince == null){
      idProvincia = null;

    }
    else idProvincia = $scope.selectedProvince.id;
    if (typeof $scope.selectedParty == 'undefined'|| $scope.selectedParty == null){
      idPartido = null;

    }
    else {
      idPartido = $scope.selectedParty.id;
    }

    if (typeof $scope.selectedCity == 'undefined' || $scope.selectedCity == null){
      idCiudad = null;

    }
    else{ 
      idCiudad = $scope.selectedCity.id;
    }

    var data =  $.param({
      'idPais' : idPais,
      'idProvincia' : idProvincia,
      'idPartido' : idPartido,
      'idCiudad' : idCiudad
    });

    if (idPais == null && idProvincia == null && idPartido == null && idCiudad==null){
      window.open("panel/importer/activePlacesExport?idPais=null&idPartido=null&idProvincia=null&idCiudad=null");
      return;
    }

    var f = document.createElement("form");
    f.setAttribute('method',"post");
    f.setAttribute('action',"panel/importer/activePlacesExport");
    f.style.display = 'none';

    var i1 = document.createElement("input");
    i1.setAttribute('type',"hidden");
    i1.setAttribute('name',"idPais");
    i1.setAttribute('value', idPais);

    var i2 = document.createElement("input");
    i2.setAttribute('type',"hidden");
    i2.setAttribute('name',"idProvincia");
    i2.setAttribute('value', idProvincia);

    var i3 = document.createElement("input");
    i3.setAttribute('type',"hidden");
    i3.setAttribute('name',"idPartido");
    i3.setAttribute('value',idPartido);

    var i4 = document.createElement("input");
    i4.setAttribute('type',"hidden");
    i4.setAttribute('name',"idCiudad");
    i4.setAttribute('value',idCiudad);


    var s = document.createElement("input");
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

  $scope.getNow = function(){

    var params = "/" ;

    if ($scope.selectedCountry){
      params += $scope.selectedCountry.id  + '/'; 
    }
    if ($scope.selectedProvince){
      params += $scope.selectedProvince.id  + '/'; 
    }
    if ($scope.selectedParty){
      params += $scope.selectedParty.id  + '/'; 
    }
    if ($scope.selectedCity){
      params += $scope.selectedCity.id  + '/'; 
    }

    $rootScope.loadingPost = true;
    $http.get('api/v1/panel/places/progressive/approved' + params)
    .success(function(response) {
      $rootScope.optionMaster1 = true;
      $rootScope.optionMaster2 = false;

      processPlaces(response);
    });

  }

  $rootScope.changeApprovedEva = function(v){
    $rootScope.onlyApproved = v;
    alert(v);
  }
  $rootScope.getNowEval = function(){

    $rootScope.loadingPost = true;

    var valor;
    var opciones = document.getElementsByName("opcion");
    for(var i=0; i<opciones.length; i++){
      if(opciones[i].checked){
        valor = opciones[i].value;
      }
    }
    if(valor == null){
      valor = '-1';
    }

    var getNowEvalUrl = 'api/v2/evaluation/getallBy';

    getNowEvalUrl += '/' + valor;

    if( $scope.selectedCountryEval){
      getNowEvalUrl += '/' +   $scope.selectedCountryEval.id ;
    }
    if( $scope.selectedProvinceEval){
      getNowEvalUrl += '/' +   $scope.selectedProvinceEval.id ;   
    }
    if( $scope.selectedPartyEval){
      getNowEvalUrl += '/' +   $scope.selectedPartyEval.id  ;  
    }
    if( $scope.selectedCityEval){
      getNowEvalUrl += '/' +   $scope.selectedCityEval.id  ;  
    }

    $http.get(getNowEvalUrl)
    .success(function(response) {
      var ev = response;
      var evShow = [];
      if(valor == '-1' | valor == 'null'){
        evShow = ev;
      }
      else{
        for(var i=0; i<ev.length; i++){
          if(ev[i].aprobadoEval == valor){
            evShow.push(ev[i]);
          }
        }
      }
      $rootScope.evaluations = evShow;
      $rootScope.loadingPost = false;
    });

  }

  $http.get('api/v2/panel/places/countersfilterbyuser')
  .success(function(response) {
    $rootScope.counters = $scope.counters = response;
  });

  $scope.searchQuery = "";
  $scope.searchNow = function(){
    $rootScope.optionMaster1 = false;
    $rootScope.optionMaster2 = true;

    if ($scope.searchQuery.length <=3){
      Materialize.toast("Por favor, ingresa mas de 3 letras para buscar" ,4000);
      return;
    }

    $rootScope.loadingPost = true;
    if($scope.exactSearchOnly){
      $http.get('api/v1/panel/places/searchfilterbyuserExacta/' +  $scope.searchQuery)
      .success(function(response) {
        processPlaces(response);

      });
    }
    else {
      $http.get('api/v1/panel/places/searchfilterbyuser/' +  $scope.searchQuery)
      .success(function(response) {
        processPlaces(response);

      });
    }

  };

  $rootScope.loadCity = function() {

    var flag =$(".tabs li a").last().hasClass('active');

    if(!flag){
      $rootScope.showCity = true;
      placesFactory.getCitiesForPartidos({
        id: $scope.selectedParty.id
      }, function(data) {
        $scope.cities = data;
        $rootScope.cities = data;
      })
    }
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

    if(!flag){
      $rootScope.provinceOn= true;
      placesFactory.getProvincesForCountry($scope.selectedCountry.id,function(data){
        $rootScope.provinces = data;
      });
    }
    else{
      $rootScope.provinceEvalOn= true;
      placesFactory.getProvincesForCountry($scope.selectedCountryEval.id,function(data){
        $rootScope.provincesEval = data;
      });
    }
  }

  $rootScope.showPartidos = function(){

    var flag =$(".tabs li a").last().hasClass('active');

    if(!flag){
      $rootScope.partidoOn= true;
      placesFactory.getPartidosForProvince($scope.selectedProvince.id,function(data){
        $rootScope.parties = data;
      });
    }
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

  };

  loadAllLists();
  $rootScope.onlyBadGeo = true;
  $scope.exactSearchOnly = false;
  $rootScope.onlyGoodGeo = true;
  $rootScope.searchExistence = "";
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
        if(response.data.length == 0) {
          placesFactory.getPendingPlaces((response) => loadPending(response));
          Materialize.toast('El establecimiento ' + establec + ' ha sido rechazado.', 5000);
        }
        else {
          for (var propertyName in response.data) {
            Materialize.toast(response.data[propertyName], 10000);
          };
        }

      },
      function(response) {
        Materialize.toast('Hemos cometido un error al procesar tu peticion, intenta nuevamente mas tarde.', 5000);

      });

    $('#demoModal').closeModal();
    $rootScope.current = {};
    loadAllLists();
  };

  $rootScope.toRemovePlaces = new Array();


  $rootScope.addToBlockList = function(p){
    p.inList = true;

    $rootScope.toRemovePlaces = $rootScope.toRemovePlaces.filter(function(pp){
      return p.placeId != pp.placeId;
    });
    $rootScope.toRemovePlaces.push(p);

  }

  $rootScope.removeFromBlockList = function(p){
    p.inList = false;
    $rootScope.toRemovePlaces = $rootScope.toRemovePlaces.filter(function(pp){
      return p.placeId != pp.placeId;
    });
  }

  function loadPending(response){
    for (var i = 0; i < response.length; i++) {
      response[i] = filterAccents(response[i]);
    };
    $rootScope.penplaces = response;
    $scope.loadingPrev = false;
  }

  $rootScope.removeAllPlace = function(){

    var allItems = $rootScope.toRemovePlaces.map(function(m){
      return m.placeId;
    }).join(",");

    $http.post('api/v1/panel/places/block-all/' + allItems).then(
      function(response) {
        if(response.data.length == 0) {
          placesFactory.getPendingPlaces((response) => loadPending(response));
          Materialize.toast('Se han rechadado  ' + $rootScope.toRemovePlaces.length + ' lugares sugeridos.', 5000);
          $rootScope.toRemovePlaces = [];
        }
        else {
          for (var propertyName in response.data) {
            Materialize.toast(response.data[propertyName], 10000);
          };
        }
      },
      function(response) {
        Materialize.toast('Hemos cometido un error al procesar tu peticion, intenta nuevamente mas tarde.', 5000);
      });

    $('#removeAllModal').closeModal();
    $rootScope.current = {};
    loadAllLists();
  };
  $rootScope.removeAllSelected= function(evalId){
    $rootScope.evalId = evalId;
    $('#removeAllModal').openModal();
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
          $rootScope.totalEvals = response.lenght;
          $rootScope.evaluations = response;
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

  $rootScope.openModal = false;
  $rootScope.openReplyForm = function(evaluation){
    $rootScope.openModal = true;
    $rootScope.currentev = evaluation;
  }

  $rootScope.submitReplyForm = function(){
    var evaluationID = $rootScope.currentev.id;
    var replyContent = $rootScope.replyContent;
    $http.post('api/v2/evaluacion/panel/comentarios/' + evaluationID + '/' + replyContent )
    .then(
      function(response) {
        if (response.data.length == 0) {
          console.log("The form has been submited", "Form content: ", $rootScope.replyContent);
          Materialize.toast('Respuesta enviada', 5000);
          $rootScope.replyContent = "";

          $http.get('api/v2/evaluation/getall')
          .success(function(response) {
            $rootScope.totalEvals = response.total;
            $rootScope.evaluations = response.data;
          });
        }
        else {
          Materialize.toast("Session timed out, log back in", 10000);
        }
      },
      function(response) {
        Materialize.toast('Hemos cometido un error al procesar tu peticion, intenta nuevamente mas tarde.', 5000);
        console.log(response);
      });
  }

  $scope.tieneServicioFriendly = function(item) {
    if(item === undefined) return false;
    if (item.friendly_infeclogia == 1 || item.friendly_ssr == 1 || item.friendly_ile == 1 || item.friendly_vacunatorio == 1 || item.friendly_prueba == 1 || item.friendly_condones == 1) {
      return true;
    } else {
      return false;
    }
  }

  $rootScope.changeLanguage = function() {

    localStorage.setItem("lang", $rootScope.selectedLanguage);
    localStorage.setItem("selectedByUser", true);
    $translate.use($rootScope.selectedLanguage);
    $http.get('changelang/' + $rootScope.selectedLanguage)
    .then(
      function(response) {

        if (response.data.status == 'ok') {

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
