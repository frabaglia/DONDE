<div id="eval" class="col s12">

  <h3 ng-cloak ng-hide="loadingPost"  class="title"></h3>

  <h3 ng-cloak ng-show="loadingPost" translate="loadingPlaces"></h3>

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

  <div class="row">

    <div class="col s6">

      <a href="" ng-click="getNowEval()" class="waves-effect waves-light btn wow">
        <i class="mdi-navigation-chevron-right right"></i>
        <i class="mdi-editor-format-list-bulleted left"></i>
        <span translate="search_by_location"></span>
      </a>

    </div>

    <div class="col s6">

      <a  href="" ng-click="exportEvaluationsEval()" class="waves-effect waves-light btn wow">
        <i class="mdi-navigation-chevron-right right"></i>
        <i class="mdi-file-file-download left"></i>
        <span translate="panel_actives_export_data"></span>
      </a>

    </div>

  </div>

  <h3 ng-cloak ng-show="totalEvals == '0' && !loadingPost"> <span translate="panel_actives_no_results_1"></span> [[selectedCityEval.nombre_ciudad]]</h3>


  <div class="section copy row" ng-show="totalEvals != '0'">

  </div>
    <h3 ng-show='!fromSearch && totalEvals == 1' translate="result_evaluations_singular"></h3>


    <h3 ng-show='!fromSearch && totalEvals > 1' translate="result_evaluations_plural" translate-values="{evaluations_length: '[[totalEvals]]' }"></h3>

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
                        class="btn modal-action modal-close btn-flat"></input>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <input ng-model="onlyShowNonAnsweredEvals" type="checkbox" id="evaluation-type">
    <label for="evaluation-type">Show only not answered evaluations</label>

    <div class="col s12 m12 ">

      <table id='eval' class="bordered striped responsive-table">

        <thead ng-cloak ng-hide="loadingPost">

          <tr>
            <th data-field="establecimiento" translate="establishment"></th>

            <th data-field="nombre_localidad"><span translate="panel_places_columntable_5"></span>, <span translate="district"></span>, <span translate="state"></span>, <span translate="country"></span></th>

            <th data-field="" translate="services"></th>

            <th class="center-align" data-field="" translate="puntuation"></th>

            <th class="center-align" data-field="" translate="comment"></th>

            <th class="center-align" data-field="" translate="name"></th>

            <th class="center-align" data-field="" translate="email"></th>

            <th class="center-align" data-field="" translate="tel"></th>

            <th data-field=""></th>

          </tr>

        </thead>

        <tbody>

          <tr  ng-repeat="e in evaluations" data-ng-if="!e.reply_content || !onlyShowNonAnsweredEvals" class="evaluation-info">

            <td>[[e.establecimiento]]</td>

            <td> [[e.nombre_ciudad]], [[e.nombre_partido]], [[e.nombre_provincia]], [[e.nombre_pais]]</td>

            <td class="services2">

              <img ng-show="e.service == 'condones'" alt="Este lugar distribuye condones" src="images/condones.svg">

              <img ng-show="e.service == 'prueba'" alt="Este lugar puede hacer prueba de HIV" src="images/vih.svg" >

              <img ng-show="e.service == 'mac'" alt="Este lugar cuenta con Servicios de Salud Sexual y Reproductiva" src="images/mac.svg" >

              <img ng-show="e.service == 'ile'" alt="Este lugar cuenta con centro de Interrupcion Legal del Embarazo" src="images/ile.svg" >

              <img ng-show="e.service == 'ssr'" alt="Este lugar cuenta con Servicios de Salud Sexual y Reproductiva" src="images/salud.svg" >

              <img ng-show="e.service == 'dc'" alt="Este lugar cuenta con centro de Detección de Cancer" src="images/deteccion.svg" >

            </td>

            <td class="center-align services2">[[e.voto]]</td>

            <td class="center-align services2">[[e.comentario]]</td>

            <td class="center-align services2">[[e.name]]</td>

            <td class="center-align services2">[[e.email]]</td>

            <td class="center-align services2">[[e.tel]]</td>

            <td class="actions">

              <a ng-cloak target="_blank" ng-href="panel/places/[[e.idPlace]]" data-toggle="tooltip" title="[[details]]" class="waves-effect waves-light btn-floating"><i class="mdi-image-loupe left"></i></a>

              <a ng-click="removeNow(e.id)" data-toggle="tooltip" title="[[delete]]" class="waves-effect waves-light btn-floating"><i class="mdi-av-not-interested left"></i></a>

              <a ng-click="openReplyForm(e)"  href="#reply-modal" title="Reply" modal open="openModal" ng-class="{'green': e.reply_content}" class="waves-effect waves-light btn-floating">
                  <i class="mdi-content-reply left"></i>
              </a>

            </td>

          </tr>

        </tbody>

      </table>

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
          <a href="" class=" modal-action modal-close
            waves-effect waves-green btn-flat" translate="no"></a>
          <a ng-click="removeEval([[evalId]])" href="" class=" modal-action waves-effect waves-green btn-flat" translate="yes"></a>
      </div>
  </div>
