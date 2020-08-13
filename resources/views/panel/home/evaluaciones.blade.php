<div id="eval" class="col s12">

  <h3 ng-cloak ng-hide="loadingPost"  class="title"></h3>
  <h3 ng-cloak ng-show="loadingPost" translate="panel_evaluations"></h3>

  <div ng-cloak ng-show="loadingPost" class="progress">
    <div class="indeterminate"></div>
  </div>

  <select class="rollSelect"
    ng-change="showProvince()" ng-model="selectedCountryEval"
    ng-options="v.nombre_pais for v in countries" material-select watch>
    <option value="" disabled selected translate="select_country"></option>
  </select>

  <select class="rollSelect"
    ng-change="showPartidos()" ng-model="selectedProvinceEval"
    ng-disabled= '!provinceEvalOn'
    ng-options="v.nombre_provincia for v in provincesEval" material-select watch>
    <option value="" disabled selected translate="select_state"></option>
  </select>

  <select class="rollSelect"
    ng-change="loadCity()"
    ng-options="item.nombre_partido for item in partiesEval"
    ng-model="selectedPartyEval"
    ng-disabled= '!partidoEvalOn'
    material-select watch>
    <option value="" disabled="" selected translate="select_department"></option>
  </select>

  <select class="rollSelect"
    ng-disabled= '!showCityEval'
    ng-options="c.nombre_ciudad for c in citiesEval"
    ng-model="selectedCityEval" material-select watch>
    <option value="" disabled selected translate="select_city"></option>
  </select>

  <div class="form-checkbox-cards">
    <div>
      <input type="radio"
      class="with-gap red"
      value="-1" 
      name="opcion"
      id="todas"
      ng-model="all"
      ng-checked="true" ng-change=""/>
      <label for="todas">Todas</label>
    </div>
    <div>
      <input type="radio"
      class="with-gap red"
      value="1" 
      name="opcion"
      id="aprobadas"
      ng-model="approved"
      ng-checked="" ng-change=""/>
      <label for="aprobadas">Solo aprobadas</label>
    </div>
    <div>
      <input type="radio"
      class="with-gap red"
      value="0" 
      name="opcion"
      id="rechazadas"
      ng-model="disapproved" 
      ng-checked="" ng-change=""/>
      <label for="rechazadas">Solo rechazadas</label>
    </div>
  </div>

  <div class="row">
    <div class="col s4">
      <h6> <strong> <span>&#8203;</span> </strong> </h6>
    </div>
    <div class="col s4">

      <a ng-click="getNowEval()" class="waves-effect waves-light btn green tooltipped" data-position="right" data-tooltip="Filtra las evaluaciones según la información ingresada en el formulario">
        <i class="mdi-navigation-chevron-right right"></i>
        <i class="mdi-editor-format-list-bulleted left"></i>
        <span translate="">Buscar y Filtrar</span>
      </a>
    </div>
  </div>

  <div class="row mt-1">
    <div class="col s4">
      <h6> <strong> <span>&#8203;</span> </strong> </h6>
    </div>
    <div class="col s4">
      <a target="_self" class="pointer tooltipped" ng-click="exportEvaluationsEval()" data-position="right" data-tooltip="Exporta las evaluaciones filtradas">
        <i class="mdi-file-file-download"></i>
        <span translate="">Exportar resultado</span>
      </a>
    </div>
  </div>

  <div class="row mt-1">
    <div class="col s1">
      <h6> <strong> <span>&#8203;</span> </strong> </h6>
    </div>
    <div class="col s3">
      <a target="_self" href="panel/importer/full-eval-export/es" ng-click="" class="waves-effect waves-light btn green tooltipped" data-position="top" data-tooltip="Exportar todas las evaluaciones registradas">
        <i class="mdi-file-file-download left"></i>
        <span translate="">Todas</span>
      </a>
    </div>
    <div class="col s3">
      <a target="_self" href="panel/importer/1" ng-click="" class="waves-effect waves-light btn green tooltipped" data-position="top" data-tooltip="Exportar todas las evaluaciones registradas y aprobadas">
        <i class="mdi-file-file-download left"></i>
        <span translate="">Aprobadas</span>
      </a>
    </div>
    <div class="col s3">
      <a target="_self" href="panel/importer/0" ng-click="" class="waves-effect waves-light btn red tooltipped" data-position="top" data-tooltip="Exportar todas las evaluaciones registradas y rechazadas">
        <i class="mdi-file-file-download left"></i>
        <span translate="">Rechazadas</span>
      </a>
    </div>
  </div>

  <div ng-controller="tableController" ng-init="init('evaluations','establecimiento')" class="row">

    <h3 ng-cloak ng-show="evaluations.length == 0 && !loadingPrev">
      <span translate="panel_actives_no_results_1"></span>
      <span>[[selectedCountryEval.nombre_pais]], [[selectedProvinceEval.nombre_provincia]], [[selectedPartyEval.nombre_partido]], [[selectedCityEval.nombre_ciudad]]</span>
    </h3>

    <div class="section copy row" ng-show="evaluations.length != 0">
      <h3 ng-show='!fromSearch && evaluations.length == 1' translate="result_evaluations_singular"></h3>
      <h3 ng-show='!fromSearch && evaluations.length > 1' translate="result_evaluations_plural" translate-values="{evaluations_length: '[[evaluations.length]]' }"></h3>
      <div class="row"></div>
      <hr>

      <div class="row mt-1">
        <div class="col s2">
          <a class="waves-effect waves-light btn btn-small wow animated" ng-class="{'disabled': currentPage == 0}" ng-click="previous()">
            <i class="mdi-navigation-chevron-left left"></i>
            <span translate="previous"></span>
          </a>
        </div>
        <div class="col s8">
          <h4>Página [[currentPage+1]]/[[totalPages]]</h4>
        </div>
        <div class="col s2">
          <a class="waves-effect waves-light btn btn-small wow animated" ng-class="{'disabled': currentPage >= filteredDataTable.length/pageSize - 1}" ng-click="next()">
            <span translate="next"></span>
            <i class="mdi-navigation-chevron-right right"></i>
          </a>
        </div>
      </div>

      <div class="col s12 m12 mt-1">
        <table id='eval' class="bordered striped responsive-table orderded">
          <thead ng-cloak ng-hide="loadingPrev">
            <tr>
              <th ng-click="orderDataTable('establecimiento')" class="col s3" data-field="establecimiento" translate="establishment"></th>
              <th ng-click="orderDataTable('nombre_ciudad')" class="col s2" data-field="nombre_ciudad">
                <span translate="panel_places_columntable_5"></span>, <span translate="district"></span>, <span translate="state"></span>, <span translate="country"></span>
              </th>
              <th ng-click="orderDataTable('service')" class="col s1" data-field="" translate="services"></th>
              <th ng-click="orderDataTable('voto')" class="col s1" class="center-align" data-field="" translate="puntuation"></th>
              <th ng-click="orderDataTable('comentario')" class="col s2" class="center-align" data-field="" translate="comment"></th>
              <th ng-click="orderDataTable('name')" class="col s1" class="center-align" data-field="" translate="name"></th>
              <th ng-click="orderDataTable('created_at')" class="col s1" class="center-align" data-field="date">Fecha</th>
              <th class="col s1" data-field="actions" translate="actions"></th>
            </tr>
          </thead>

          <tbody>
            <tr ng-repeat="e in (filteredDataTable | startFrom:currentPage*pageSize |  limitTo:pageSize) track by $index">
              <td class="col s3">[[e.establecimiento]]</td>
              <td class="col s2"> <small>[[e.nombre_ciudad]], [[e.nombre_partido]], [[e.nombre_provincia]], [[e.nombre_pais]] </small></td>
              <td class="col s1 services2">
                <div ng-include="'scripts/panel/views/evaluations-services-imgs.html'"></div>
                <span ng-show="!e.service">-</span>
              </td>
              <td class="center-align col s1 services2"><img src="images/emojis/[[e.voto]]active.png" alt="[[e.voto]]"></td>
              <td class="center-align col s2">
                <small>[[e.comentario || "-"]]</small>
              </td>

              <td class="center-align col s1"><small>[[e.name || "-"]]</small></td>
              <td class="center-align col s1"><small>[[e.created_at || "-"]]</small></td>

              <td class="actions col s1">
                <a ng-cloak target="_blank" ng-href="panel/places/[[e.idPlace]]" data-toggle="tooltip" title="[['edit'|translate]]" class="waves-effect waves-light btn-floating orange"><i class="mdi-content-create left"></i>
                </a>
                <a ng-show="e.aprobadoEval == 1" ng-click="removeNow(e.id)" data-toggle="tooltip" title="[['reject'|translate]]" class="waves-effect waves-light btn-floating red"><i class="mdi-av-not-interested left"></i>
                </a>
                <a ng-show="e.aprobadoEval == 1" ng-click="openReplyForm(e)"  href="#reply-modal" title="[['reply'|translate]]" modal open="openModal" ng-class="{'green': e.reply_content}" class="waves-effect waves-light btn-floating green">
                  <i class="mdi-content-reply left"></i>
                </a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

<!-- Modal Structure -->
<div id="reply-modal" class="modal">
  <i class="modal-close mdi-navigation-close right close-reply-form"></i>
  <div class="modal-content">
    <h3 class="reply-form-header">Reply form [[currentev.id]]</h3>
    <div class="reply-form-comment-container">
      <h4>Comment</h4>
      <blockquote>"[[currentev.comentario]]"</blockquote>
    </div>
    <div ng-show="currentev.reply_content" class="evaluation-replay-container">
      <h4>Reply made by <span class="evaluation-replay-admin">[[currentev.reply_admin]]</span> <span ng-bind="currentev.reply_date | date:'dd/MM/yyyy'"></span></h4>
      <blockquote>[[currentev.reply_content]]</blockquote>
    </div>
    <div class="reply-form-input-container">
      <h4>Reply</h4>
      <span ng-class="{'few-chars-left': replyContent.length >= 100}"
        class="right">
        [[150 - replyContent.length]] characters left
      </span>
      <form name="evalForm">
        <textarea name="replyContent" ng-model="replyContent"
        ng-class="{'too-many-chars': !evalForm.replyContent.$valid}"
        maxlength="150" ng-maxlength="150" ng-minlength="1"></textarea>
        <div class="modal-footer">
          <input type="submit" value="Submit" href="#!"
          ng-click="submitReplyForm()"
          ng-class="{'invalid-form': !evalForm.replyContent.$valid}"
          ng-disabled="!evalForm.replyContent.$valid
          || !replyContent.length"
          class="btn modal-action modal-close btn-flat"/>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Evaluations -->
<div id="demoModalEval" class="modal">
  <div class="modal-content">
    <h4 translate="confirm_delete_evaluation"></h4><br />
    <hr/>
    <p translate="confirm_description"></p>
    <hr/>
  </div>
  <div class="modal-footer">
    <div class="col offset-s3 s2">
      <a href="" class="modal-action modal-close waves-effect waves-green btn btn-small red" translate="no"></a>
    </div>
    <div class="col offset-s1 s2">
      <a ng-click="removeEval([[evalId]])" href="" class="modal-action waves-effect waves-green btn btn-small green" translate="yes"></a>
    </div>
  </div>
</div>