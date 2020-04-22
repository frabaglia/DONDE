<form class="col s12 m6">
  <div class="row">
    <p>
      <input  type="checkbox"
      name="place.condones"
      id="filled-in-box-condones"
      ng-checked="isCheckBoxChecked(place.condones)"
      ng-model="place.condones"/>
      <label for="filled-in-box-condones" translate="form_select_condones"></label>
    </p>

    <div ng-hide="!place.condones">
      <p>
        <label translate="form_select_service_type_title"></label>
      </p>
      <p>
        <input type="radio" id="st_condones1" name="servicetype_condones" value="arancel" ng-model="place.servicetype_condones" ng-change="formChange()">
        <label for="st_condones1" translate="form_service_type_option_arancel"></label>
      </p>
      <p>
        <input type="radio" id="st_condones2" name="servicetype_condones" value="gratuito" ng-model="place.servicetype_condones" ng-change="formChange()">
        <label for="st_condones2" translate="form_service_type_option_gratuito"></label>
      </p>
      <p>
        <input type="radio" id="st_condones3" name="servicetype_condones" value="cobertura" ng-model="place.servicetype_condones" ng-change="formChange()">
        <label for="st_condones3" translate="form_service_type_option_consultar"></label>
      </p>
    </div>

    <p>
      <input  type="checkbox"
      name="friendly_condones"
      id="friendly_condones"
      ng-model="place.friendly_condones"/>
      <label for="friendly_condones" translate="form_service_friendly_option"></label>
    </p>

    <div class="input-field col s12">
      <input id="responsable_distrib" type="text"
      name="responsable_distrib" class="validate"
      ng-model="place.responsable_distrib"
      ng-change="formChange()">
      <label for="responsable_distrib" translate="responsable"></label>
    </div>
  </div>

  <div class="row">
    <div class="input-field col s12">
      <input id="ubicacion_distrib" type="text"
      name="ubicacion_distrib" class="validate"
      ng-model="place.ubicacion_distrib"
      ng-change="formChange()">
      <label for="ubicacion_distrib" translate="location"></label>
    </div>
  </div>

  <div class="row">
    <div class="input-field col s12">
      <input id="horario_distrib" type="text"
      name="horario_distrib" class="validate"
      ng-model="place.horario_distrib"
      ng-change="formChange()">
      <label for="horario_distrib" translate="schedule"></label>
    </div>
  </div>

  <div class="row">
    <div class="input-field col s12">
      <input id="mail_distrib" type="email"
      name="mail_distrib" class="validate"
      ng-model="place.mail_distrib"
      ng-change="formChange()">
      <label for="mail_distrib" translate="email"></label>
    </div>
  </div>

  <div class="row">
    <div class="input-field col s12">
      <input id="tel_distrib" type="text"
      name="tel_distrib" class="validate"
      ng-model="place.tel_distrib" ng-change="formChange()">
      <label for="tel_distrib" translate="tel"></label>
    </div>
  </div>

  <div class="row">
    <div class="input-field col s12">
      <input id="web_distrib" type="text"
      name="web_distrib" class="validate"
      ng-model="place.web_distrib" ng-change="formChange()">
      <label for="web_distrib">Web</label>
    </div>
  </div>

  <div class="row">
    <div class="input-field col s12">
      <textarea id="comentarios_distrib" type="text"
      name="comentarios_distrib"
      class="validate materialize-textarea"
      ng-model="place.comentarios_distrib"
      ng-change="formChange()"></textarea>
      <label for="comentarios_distrib" translate="observations"></label>
    </div>
  </div>

</form>
