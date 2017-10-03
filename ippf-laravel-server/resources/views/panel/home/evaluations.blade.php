<div id="eval" class="col s12">

  <h3 ng-cloak ng-hide="loadingPost"  class="title"></h3>

  <h3 ng-cloak ng-show="loadingPost" translate="loadingPlaces"></h3>

  <div ng-cloak ng-show="loadingPost" class="progress">
    <div class="indeterminate"></div>
  </div>
  
  <h4 ng-cloak ng-show="evaluations"  ng-hide="loadingPost" translate="panel_actives_title"></h4>

  <select class="rollSelect"
  ng-change="showProvince()" ng-model="selectedCountryEval"
  ng-options="v.nombre_pais for v in countries" material-select watch>
  <option value="" disabled selected translate="select_country"></option>
  </select>

  <select class="rollSelect"
  ng-change="showPartidos()" ng-model="selectedProvinceEval"
  ng-disabled= '!provinceOn'
  ng-options="v.nombre_provincia for v in provinces" material-select watch>
  <option value="" disabled selected translate="select_state"></option>
  </select>

  <select class="rollSelect"
  ng-change="loadCity()"
  ng-options="item.nombre_partido for item in parties"
  ng-model="selectedPartyEval"
  ng-disabled= '!partidoOn'
  material-select watch>
  <option value="" disabled="" selected translate="select_department"></option>
  </select>

  <select class="rollSelect"
  ng-disabled= '!showCity'
  ng-options="c.nombre_ciudad for c in cities"
  ng-model="selectedCityEval" material-select watch>
  <option value="" disabled selected translate="select_city"></option>
  </select>

  <div class="row">
    <div class="col s6" >

      <a  ng-show='selectedCountry' href="" ng-click="getNowEval()" class="waves-effect waves-light btn wow"  >
        <i class="mdi-navigation-chevron-right right"></i>
        <i class="mdi-editor-format-list-bulleted left">
        </i><span translate="search_by_location"></span></a>


        <a  ng-show='!selectedCountry' href="javascript:void(0);"  class="waves-effect waves-light btn wow"  >          
          <i class="mdi-navigation-chevron-right right"></i>
          <i class="mdi-file-file-download left">
          </i><span translate="search_by_location"></span></a>        

    </div>

    <div class="col s6" >

          <a  ng-show='selectedCountry' href="" ng-click="activePlacesExport()" class="waves-effect waves-light btn wow"  >
            <i class="mdi-navigation-chevron-right right"></i>
            <i class="mdi-file-file-download left">
            </i><span translate="panel_actives_export_data"></span></a>

            <a  ng-show='!selectedCountry' href="javascript:void(0);"  class="waves-effect waves-light btn wow"  >          
              <i class="mdi-navigation-chevron-right right"></i>
              <i class="mdi-file-file-download left">
              </i><span translate="panel_actives_export_data"></span></a>

    </div>

  </div>

 <h3 ng-cloak ng-show="evaluations.length == 0 && !loadingPost"> <span translate="panel_actives_no_results_1"></span> <span  ng-cloak ng-show="searchExistence">'[[searchExistence]]'</span> <span ng-cloak ng-show="filterLocalidad" translate="panel_actives_no_results_2" translate-values="{location:'[[filterLocalidad]]'}"></span> </h3>

  <div class="section copy row" ng-hide="evaluations.length === 0">

    <div class="col s12 m12 ">

        <table id='eval' class="bordered striped responsive-table">
        <thead ng-cloak ng-hide="loadingPost">
          <tr>
           <th data-field="establecimiento" translate="establishment"></th>
           <th data-field="nombre_localidad"><span translate="panel_places_columntable_5"></span>, <span translate="district"></span>, <span translate="state"></span>, <span translate="country"></span></th>
           <!--th data-field="direccion" translate="street_address"></th-->
           <th data-field="" translate="services"></th>
           <th class="center-align" data-field="" translate="puntuation"></th>
           <th data-field=""></th>
         </tr>
       </thead>
       <tbody>

 <tr ng-cloak ng-hide="loadingPost" ng-repeat="e in evaluations">
          <td>[[e.establecimiento]]</td>
          <td> [[e.nombre_ciudad]], [[e.nombre_partido]], [[e.nombre_provincia]], [[e.nombre_pais]]</td>
          <!--td ng-show='place.calle'>[[place.calle]] <span ng-show='place.altura'>[[place.altura]] </span><span ng-show='place.cruce' translate="and"> </span><span ng-show='place.cruce'> [[place.cruce]]</span></td>
           <td ng-show='!place.calle' translate="without_address"></td-->
          <td class="services2">
            <img ng-show="e.service == 'condones'" alt="Este lugar distribuye condones" src="images/condones.svg">
            <img ng-show="e.service == 'prueba'" alt="Este lugar puede hacer prueba de HIV" src="images/vih.svg" >
            <!--img ng-show="place.vacunatorio" alt="Este lugar cuenta con centro vacunatorio" src="images/iconos-new_vacunacion-3.png" -->
            <!--img ng-show="place.infectologia" alt="Este lugar cuenta con centro de infectologia" src="images/iconos-new_atencion-3.png" -->
            <img ng-show="e.service == 'mac'" alt="Este lugar cuenta con Servicios de Salud Sexual y Reproductiva" src="images/mac.svg" >
            <img ng-show="e.service == 'ile'" alt="Este lugar cuenta con centro de Interrupcion Legal del Embarazo" src="images/ile.svg" >
            <img ng-show="e.service == 'ssr'" alt="Este lugar cuenta con Servicios de Salud Sexual y Reproductiva" src="images/salud.svg" >
            <img ng-show="e.service == 'dc'" alt="Este lugar cuenta con centro de Detección de Cancer" src="images/deteccion.svg" >
          </td>

          <td class="center-align services2">[[e.voto]]</td>

          <td class="actions">
            <a target="_self" ng-href="panel/places/[[place.placeId]]" class="waves-effect waves-light btn-floating"><i class="mdi-content-create left"></i></a>
            <a ng-click="blockNow(place)"class="waves-effect waves-light btn-floating"><i class="mdi-av-not-interested left"></i></a>
          </td>
        </tr>

       </tbody>


  </table>
</div>
</div>

</div>