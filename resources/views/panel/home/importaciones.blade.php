<div id="tagsImportaciones" class="col s12"  ng-controller="tagsImportacionController">

   <div class="section navigate row">
 <h3 class="title"  ng-cloak ng-hide="loadingPrev" translate="panel_imports_summary_1" translate-values="{imports : '[[tagsImportaciones.length]]'}"><h3>
 <h3 ng-cloak ng-show="loading" translate="loadingTags"></h3>
 <div ng-cloak ng-show="loading" class="progress">
           <div class="indeterminate"></div>
      </div>
</div>
<nav>
 <div class="ng-cloak nav-wrapper"  ng-cloak ng-hide="loading">
   <form>
     <div class="input-field">
       <input type="search" ng-model="csvSearchValue" required
       placeholder="[['panel_imports_searchinput_placeholder' | translate]]">
       <label for="search"><i class="mdi-action-search"></i></label>
     </div>
   </form>
 </div>
</nav>
<div class="section">
  <div class="card-panel teal lighten-2" translate="panel_imports_disabledbutton_label"></div>
 <div class="col s12 m12 ">
   <table class="bordered striped responsive-table">
       <thead>
           <tr>
             <th data-field="csvname" translate="panel_imports_csv_th"></th>
             <th data-field="descripcion" translate="description"></th>
             <th data-field="fecha" translate="date"></th>
             <th data-field="usuario" translate="user"></th>
             <th data-field="action" translate="panel_imports_download_th"></th>
           </tr>
       </thead>
       <tbody>
           <tr ng-repeat="tag in tagsImportaciones | filter:csvSearchValue:strict">
             <td>[[tag.csvname]]</td>
              <td>[[tag.entry_type]]</td>
              <td> [[tag.modification_date]]</td>
              <td>[[tag.user_name]]</td>
              <td class="actions">
                 <a target="_self" id="exportbutton_[[tag.id]]" ng-href="[[disableExportButtonLink(tag.countPlaces,tag.id)]]" class="waves-effect waves-light btn-floating"><i class="mdi-file-file-download left"></i></a>
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
           <h4 translate="panel_imports_modal_title"></h4>
           <h3><strong>[[current.establecimiento]]</strong></h3>
           <h4><small>[[current.nombre_provincia]], [[current.nombre_localidad]]</small></h4>
           <hr/>
           <p translate="panel_imports_modal_warning"></p>
           <hr/>
       </div>
       <div class="modal-footer">
           <a href="" class=" modal-action modal-close
             waves-effect waves-green btn-flat" translate="no"></a>
           <a ng-click="removePlace()" href="" class=" modal-action waves-effect waves-green btn-flat" translate="yes"></a>
       </div>
   </div>
