'use strict';
// $.urlParam = function(url,name){
//     var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(url);
//     if (results===null){
//        return null;
//     }
//     else{
//        return results[1] || 0;
//        console.log(results[1]);
//     }
// };
$(document).ready(function(){
      new WOW().init();
      smoothScroll.init();
});

/**
 * @ngdoc overview
 * @name houstonDiversityMap
 * @description
 * # houstonDiversityMap
 *
 * Main module of the application.
 */
angular
  .module('dondeDataVizApp', [
    'ngCookies',
    'ngRoute',
    'ngMap',
    '720kb.socialshare',
    'angularMoment',
    'ui.odometer',
    'ngSanitize',
    'ui.materialize',
    'pascalprecht.translate'
  ])
  .config(function ($routeProvider) {
    $routeProvider
      .when('/', {
        templateUrl: 'resume/views/home.html',
        controller: 'HomeCtrl',
        controllerAs: 'home'
      })
       .when('map/:id', {
        templateUrl: 'resume/views/map.html',
        controller: 'mapCtrl',
        controllerAs: 'map'
      })
      .when('/pais/:pais/provincia', {
        templateUrl: 'resume/views/country-list.html',
        controller: 'countryCtrl',
        controllerAs: 'cCtrl'
      })
      .when('/pais/:pais/provincia/:provincia/partido', {
        templateUrl: 'resume/views/province-list.html',
        controller: 'provinceCtrl',
        controllerAs: 'proCtrl'
      })
      .when('/pais/:pais/provincia/:provincia/partido/:partido/ciudad', {
        templateUrl: 'resume/views/party-list.html',
        controller: 'partyCtrl',
        controllerAs: 'pCtrl'
      })
      .when('/pais/:pais/provincia/:provincia/partido/:partido/ciudad/:ciudad/servicio', {
        templateUrl: 'resume/views/service-list.html',
        controller: 'serviceCtrl',
        controllerAs: 'serCtrl'
      })
      .when('/pais/:pais/provincia/:provincia/partido/:partido/ciudad/:ciudad/servicio/:code', {
        templateUrl: 'resume/views/places-list.html',
        controller: 'placeCtrl',
        controllerAs: 'psCtrl'
      })
      .otherwise({
        redirectTo: '/'
      });
  }).config(function($interpolateProvider, $locationProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
  }).config(['$translateProvider', function ($translateProvider) {
         $translateProvider
           .translations('es', translations_es)
           .translations('br', translations_br)
           .translations('en', translations_en)
           .preferredLanguage('es');



  }]).run(function(amMoment) {
    amMoment.changeLocale('es');
  })
