<form class="col s12 m6">
  <div class="row">
    <p>
      <input  type="checkbox"
      name="place.ssr"
      id="filled-in-box-ssr"
      ng-checked="isCheckBoxChecked(place.ssr)"
      ng-model="place.ssr"/>
      <label for="filled-in-box-ssr" translate="form_ssr_option"></label>
    </p>

    <div ng-hide="!place.ssr">
      <p>
        <label translate="form_select_service_type_title"></label>
      </p>
      <p>
        <input type="radio" id="st_ssr1" name="servicetype_ssr" value="arancel" ng-model="place.servicetype_ssr" ng-change="formChange()">
        <label for="st_ssr1" translate="form_service_type_option_arancel"></label>
      </p>
      <p>
        <input type="radio" id="st_ssr2" name="servicetype_ssr" value="gratuito" ng-model="place.servicetype_ssr" ng-change="formChange()">
        <label for="st_ssr2" translate="form_service_type_option_gratuito"></label>
      </p>
      <p>
        <input type="radio" id="st_ssr3" name="servicetype_ssr" value="cobertura" ng-model="place.servicetype_ssr" ng-change="formChange()">
        <label for="st_ssr3" translate="form_service_type_option_consultar"></label>
      </p>
    </div>

    <p>
      <input  type="checkbox"
      name="friendly_ssr"
      id="friendly_ssr"
      ng-model="place.friendly_ssr"/>
      <label for="friendly_ssr" translate="form_service_friendly_option"></label>
    </p>

    <div class="input-field col s12">
      <input id="responsable_ssr" type="text"
      name="responsable_ssr" class="validate"
      ng-model="place.responsable_ssr"
      ng-change="formChange()">
      <label for="responsable_ssr" translate="responsable"></label>
    </div>
  </div>

  <div class="row">
    <div class="input-field col s12">
      <input id="ubicacion_ssr" type="text"
      name="ubicacion_ssr" class="validate"
      ng-model="place.ubicacion_ssr"
      ng-change="formChange()">
      <label for="ubicacion_ssr" translate="location"></label>
    </div>
  </div>

  <div class="row">
    <div class="input-field col s12">
      <input id="horario_ssr" type="text"
      name="horario_ssr" class="validate"
      ng-model="place.horario_ssr"
      ng-change="formChange()">
      <label for="horario_ssr" translate="schedule"></label>
    </div>
  </div>
  <div class="row">
    <div class="input-field col s12">
      <input id="mail_ssr" type="email"
      name="mail_ssr" class="validate"
      ng-model="place.mail_ssr"
      ng-change="formChange()">
      <label for="mail_ssr" translate="email"></label>
    </div>
  </div>

  <div class="row">
    <div class="input-field col s12">
      <input id="tel_ssr" type="text"
      name="tel_ssr" class="validate"
      ng-model="place.tel_ssr" ng-change="formChange()">
      <label for="tel_ssr" translate="tel"></label>
    </div>
  </div>

  <div class="row">
    <div class="input-field col s12">
      <input id="web_ssr" type="text"
      name="web_ssr" class="validate"
      ng-model="place.web_ssr" ng-change="formChange()">
      <label for="web_ssr">Web</label>
    </div>
  </div>

  <div class="row">
    <div class="input-field col s12">
      <textarea id="comentarios_ssr" type="text"
      name="comentarios_ssr"
      class="validate materialize-textarea"
      ng-model="place.comentarios_ssr"
      ng-change="formChange()"></textarea>
      <label for="comentarios_ssr" translate="observations"></label>
    </div>
  </div>

</form>
