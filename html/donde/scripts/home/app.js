
var dondev2App = angular.module('dondev2App',['720kb.socialshare','ngMap','ngRoute','ui.materialize','angucomplete','vcRecaptcha','ngTextTruncate','l10n'])

.config(['$routeProvider', function($routeProvider) {
  $routeProvider
  .when('/', {
      templateUrl: 'scripts/home/controllers/home/view.html',
      controller: 'homeController'
    }).when('/servicios/:servicio/', {
      templateUrl: 'scripts/home/controllers/location/view.html',
      controller: 'locationController'
    })
    .when('/como-buscas/:servicio/', { //nueva Index
      templateUrl: 'scripts/home/controllers/location/viewTmp.html',
      controller: 'locationController'
    })
    .when('/como-buscas/:servicio/ubicacion', { //nueva vista Opcion 1 (sin uso)
      templateUrl: 'scripts/home/controllers/location/viewUbi.html',
      controller: 'locationController'
    })
    .when('/como-buscas/:servicio/geo', { //nueva vista Opcion 2
      templateUrl: 'scripts/home/controllers/location/viewGeo.html',
      controller: 'locationController'
    })
    .when('/como-buscas/:servicio/sug', { //nueva vista Opcion 3
      templateUrl: 'scripts/home/controllers/suggest-location/viewSug.html',
      controller: 'locationNewController'
    })
    .when('/lugar/nuevo', {
      templateUrl: 'scripts/places/controllers/map/view.html',
      controller: 'placesController'
    }).when('/localizar/:servicio/mapa', {
      templateUrl: 'scripts/home/controllers/city-map/view.html',
      controller: 'locateMapController'
    })
    .when('/localizar/:servicio/listado', {
      templateUrl: 'scripts/home/controllers/locate-list/view.html',
      controller: 'locateListController'
    })
    .when('/:pais/:provincia/:ciudad/:servicio/listado', {
      templateUrl: 'scripts/home/controllers/city-list/view.html',
      controller: 'cityListController'
    })
    .when('/:pais/:provincia/:ciudad/:servicio/mapa', {
      templateUrl: 'scripts/home/controllers/city-map/view.html',
      controller: 'cityMapController'
    })
    .when('/acerca', {
      templateUrl: 'scripts/home/controllers/acerca/view.html',
      controller: 'acercaController'
    })    
    .when('/detail/:id', {
      templateUrl: 'scripts/home/controllers/city-map/view2.html',
      controller: 'cityMapController2'
    })
    .when('/califica/:id', {
      templateUrl: 'scripts/home/controllers/evaluation/view.html',
      controller: 'evaluationController'
    })
    .when('/voted/:id', {
      templateUrl: 'scripts/home/controllers/evaluation/completed.html',
      controller: 'evaluationController'
    })

    .otherwise({
        redirectTo: '/'
    });


}])
.config( ['l10nProvider', function(l10n) {
     //settingUp localstorage varibale
  try {
    
    if (typeof(typeof(localStorage.getItem("lang"))) !== "undefined") { 
      l10n.setLocale(localStorage.getItem("lang"));
    }
    else{
      var userLang = navigator.language || navigator.userLanguage; // es-AR
      var userLang = userLang.split('-')[0]; // es
      localStorage.setItem("lang", userLang);
    }

  }
  catch(err) {
      console.log('No soporta localstorage')
      if (typeof(err) !== "undefined") {
        localStorage.setItem("lang", "es");
      }
  }

    // settingUp i18n config
    l10n.setLocale(localStorage.getItem("lang")); // first of all you must set locale. You can take it from anywhere, for instance navigator.language
    l10n.setExtension('json'); // not required. By default 'json'
    
  // Loading i18n files
  var langs = ["es","en","br"];
  try {
    langs.map(function (item, index) {
       readTextFile("scripts/translations/"+item+".json", function(text){
        var data = JSON.parse(text);
        l10n.add(item, data);
      });
    });    
  }
  catch(err) {
      console.log('Problema cargando los archivos i18n')
  }

}]);


dondev2App.run(function ($rootScope, $timeout, $location) {
  $rootScope.$on("$routeChangeStart", function (event, next, current) {
    var url = $location.url();
    if (url.includes("como-buscas")) {
      $("#mainMap").hide();
      $timeout(function () {
        $("#mainMap").show();
      });
    }
  });
});

dondev2App.directive('filterList', function($timeout) {
    return {
        link: function(scope, element, attrs) {

            var li = Array.prototype.slice.call(element[0].children);

            function filterBy(value) {
                li.forEach(function(el) {
                    el.className = el.textContent.toLowerCase().indexOf(value.toLowerCase()) !== -1 ? '' : 'ng-cloak ng-hide';
                });
            }

            scope.$watch(attrs.filterList, function(newVal, oldVal) {
                if (newVal !== oldVal) {
                    filterBy(newVal);
                }
            });
        }
    };
});
dondev2App.config(function($interpolateProvider, $locationProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
})


angular.module('ngMap').run(function($rootScope) {
  $rootScope.$on('mapInitialized', function(evt,map) {
    $rootScope.map = map;
    window.map = $rootScope.map;
    $rootScope.$apply();
  });
  $rootScope.$on( "$routeChangeStart", function(event, next, current) {
      if (!$rootScope.startedNav){
        $rootScope.startedNav =true;
      }
      else {
        $rootScope.navigating = true;
      }
  });
});

dondev2App.filter('unique', function() {
    return function(input, key) {
        var unique = {};
        var uniqueList = [];
        for(var i = 0; i < input.length; i++){
            if(typeof unique[input[i][key]] == "undefined"){
                unique[input[i][key]] = "";
                uniqueList.push(input[i]);
            }
        }
        return uniqueList;
    };
}).run(function($rootScope, $location,placesFactory) {
    placesFactory.load(function(data){});
 $rootScope.$on('$locationChangeStart', function(event) {
   if($location.hash().indexOf('anchor')> -1 || $location.hash().indexOf('acerca') > -1) {

          $anchorScroll();

       event.preventDefault();
    }
  });
    $rootScope.$on( "$routeChangeStart", function(event, next, current) {
        //Cada vez que cambia la vista, se fuerza el cierre del menu.
        $("#sidenav-overlay").trigger("click");



    });
  });



$(document).ready(function(){
    new WOW().init();
    $('.modal-trigger').leanModal();
    $(".button-collapse").sideNav();
});

// i18n
function readTextFile(file, callback) {
    var rawFile = new XMLHttpRequest();
    rawFile.overrideMimeType("application/json");
    rawFile.open("GET", file, true);
    rawFile.onreadystatechange = function() {
        if (rawFile.readyState === 4 && rawFile.status == "200") {
            callback(rawFile.responseText);
        }
    }
    rawFile.send(null);
}


function getDistanceFromLatLonInKm(lat1,lon1,lat2,lon2) {
  var R = 6371; // Radius of the earth in km
  var dLat = deg2rad(lat2-lat1);  // deg2rad below
  var dLon = deg2rad(lon2-lon1);
  var a =
    Math.sin(dLat/2) * Math.sin(dLat/2) +
    Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
    Math.sin(dLon/2) * Math.sin(dLon/2)
    ;
  var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
  var d = R * c; // Distance in km
  return d;
}

function deg2rad(deg) {
  return deg * (Math.PI/180)
}

function toTitleCase(str)
{
    return str.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
}
