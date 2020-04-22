   <div id="aprobar" class="col s12">

      <div class="section navigate row">
    <h3 class="title"  ng-cloak ng-hide="loadingPrev"> <span translate="panel_actives_summary_2" translate-values="{places:'[[penplaces.length]]'}"></span> <span translate="pending"></span> <h3>
    <h3 ng-cloak ng-show="loadingPrev" translate="panel_pendings_loading_label"></h3>
    <div ng-cloak ng-show="loadingPrev" class="progress">
              <div class="indeterminate"></div>
         </div>
  </div>
  <nav>
    <div class="ng-cloak nav-wrapper"  ng-cloak ng-hide="loadingPrev">
      <form>
        <div class="input-field">
          <input type="search" ng-model="search" required
          placeholder="Escribí acá el lugar, ciudad, provincia o teléfono que querés encontrar">
          <label for="search"><i class="mdi-action-search"></i></label>
        </div>
      </form>
    </div>
  </nav>
  <div class="section copy row">
    <div class="col s12 m12 ">
      <table class="bordered striped responsive-table">
          <thead>
              <tr ng-cloak ng-hide="loadingPrev">
                  <tr>
                   <th data-field="establecimiento" translate="establishment"></th>
                  <th data-field="nombre_localidad"><span translate="district"></span>, <span translate="state"></span>, <span translate="country"></span></th>
                  <th data-field="direccion" translate="street_address"></th>
                  <th data-field=""></th>
            </tr>

          </thead>
          <tbody>
              <tr ng-cloak ng-hide="loadingPrev" ng-repeat="place in penplaces | filter:search:strict">
                  <td>
                        [[place.establecimiento]]
                      </td>
                      <td> [[place.barrio_localidad]] [[place.nombre_partido]], [[place.nombre_provincia]], [[place.nombre_pais]]</td>
                      <td>[[place.calle]] [[place.altura]] [[place.cruce]]</td>
                       <td class="actions">

                        <a target="_self" ng-href="panel/places/[[place.placeId]]" class="waves-effect waves-light btn-floating"><i class="mdi-content-create left"></i></a>
                        <!-- Modal Trigger -->
                        <a ng-click="blockNow(place)" class="waves-effect waves-light btn-floating"><i class="mdi-av-not-interested left"></i></a>
                      </td

              </tr>
          </tbody>
        </table>
      </div>
    </div>


    </div>

      <!-- Modal Structure -->
      <div id="demoModal" class="modal">
          <div class="modal-content">
              <h4 translate="panel_pendings_modal_title"></h4>
              <h3><strong>[[current.establecimiento]]</strong></h3>
              <h4><small>[[current.nombre_provincia]], [[current.nombre_localidad]]</small></h4>
              <hr/>
              <p translate="panel_pendings_modal_warning"></p>
              <hr/>
          </div>
          <div class="modal-footer">
              <a href="" class=" modal-action modal-close
                waves-effect waves-green btn-flat" translate="no"></a>
              <a ng-click="removePlace()" href="" class=" modal-action waves-effect waves-green btn-flat" translate="yes"></a>
          </div>
      </div>
