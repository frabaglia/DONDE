'use strict';

/* Filters */
dondev2App.factory('copyService', function($http, $filter) {

  var allElements = [{
    label: 'Condones',
    icon: 'condones.svg',
    title: 'condones_name',
    code: 'condones',
    newNotFoundResult: 'noResults',
    notFoundCities: 'noResults',
    content: 'condones_content',
    desc: 'condones_desc',
    short_desc: 'condones_short_desc'
  }, {
    icon: 'vih.svg',
    title: 'prueba_name',
    code: 'prueba',
    newNotFoundResult: 'noResults',
    label: 'Prueba',
    content: 'prueba_content',
    desc: 'prueba_desc',
    short_desc: 'prueba_short_desc'
  }, {
    icon: 'mac.svg',
    title: 'mac_name',
    code: 'mac',
    newNotFoundResult: 'noResults',
    label: 'Métodos Anticonceptivos',
    content: 'mac_content',
    desc: "mac_desc",
    short_desc: 'mac_short_desc'
  }, {
    icon: 'ile.svg',
    title: 'ile_name',
    code: 'ile',
    newNotFoundResult: 'noResults',
    label: 'Interrupción Legal del Embarazo',
    content: 'ile_content',
    desc: 'ile_desc',
    short_desc: 'ile_short_desc'
  }, {
    icon: 'deteccion.svg',
    title: 'dc_name',
    code: 'dc',
    newNotFoundResult: 'noResults',
    label: 'Detección de Cancer',
    content: 'dc_content',
    desc: 'dc_desc',
    short_desc: 'dc_short_desc'
  }, {
    icon: 'salud.svg',
    title: 'ssr_name',
    code: 'ssr',
    newNotFoundResult: 'noResults',
    label: 'Salud Sexual y Reproductiva',
    content: 'ssr_content',
    desc: 'ssr_desc',
    short_desc: 'ssr_short_desc'
  }]

  var factory = {
    getAll: function() {
      return allElements;
    },
    getFor: function(code) {
      for (var i = 0; i < allElements.length; i++) {
        var e = allElements[i];
        if (e.code === code) {
          return e;
        }
      };
    }
  };

  return factory;
});
