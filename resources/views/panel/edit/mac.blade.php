<form class="col s12 m6">
  <div class="row">
    <p>
      <input  type="checkbox"
      name="place.mac"
      id="filled-in-box-mac"
      ng-checked="isCheckBoxChecked(place.mac)"
      ng-model="place.mac"/>
      <label for="filled-in-box-mac" translate="form_mac_option"></label>
    </p>

    <div ng-hide="!place.mac">
      <p>
        <label translate="form_select_service_type_title"></label>
      </p>
      <p>
        <input type="radio" id="st_mac1" name="servicetype_mac" value="arancel" ng-model="place.servicetype_mac" ng-change="formChange()">
        <label for="st_mac1" translate="form_service_type_option_arancel"></label>
      </p>
      <p>
        <input type="radio" id="st_mac2" name="servicetype_mac" value="gratuito" ng-model="place.servicetype_mac" ng-change="formChange()">
        <label for="st_mac2" translate="form_service_type_option_gratuito"></label>
      </p>
      <p>
        <input type="radio" id="st_mac3" name="servicetype_mac" value="cobertura" ng-model="place.servicetype_mac" ng-change="formChange()">
        <label for="st_mac3" translate="form_service_type_option_consultar"></label>
      </p>
    </div>

    <p>
      <input  type="checkbox"
      name="friendly_mac"
      id="friendly_mac"
      ng-model="place.friendly_mac"/>
      <label for="friendly_mac" translate="form_service_friendly_option"></label>
    </p>

    <div class="input-field col s12">
      <input id="responsable_mac" type="text"
      name="responsable_mac" class="validate"
      ng-model="place.responsable_mac"
      ng-change="formChange()">
      <label for="responsable_mac" translate="responsable"></label>
    </div>
  </div>

  <div class="row">
    <div class="input-field col s12">
      <input id="ubicacion_mac" type="text"
      name="ubicacion_mac" class="validate"
      ng-model="place.ubicacion_mac"
      ng-change="formChange()">
      <label for="ubicacion_mac" translate="location"></label>
    </div>
  </div>

  <div class="row">
    <div class="input-field col s12">
      <input id="horario_mac" type="text"
      name="horario_mac" class="validate"
      ng-model="place.horario_mac"
      ng-change="formChange()">
      <label for="horario_mac" translate="schedule"></label>
    </div>
  </div>
  <div class="row">
    <div class="input-field col s12">
      <input id="mail_mac" type="email"
      name="mail_mac" class="validate"
      ng-model="place.mail_mac"
      ng-change="formChange()">
      <label for="mail_mac" translate="email"></label>
    </div>
  </div>

  <div class="row">
    <div class="input-field col s12">
      <input id="tel_mac" type="text"
      name="tel_mac" class="validate"
      ng-model="place.tel_mac" ng-change="formChange()">
      <label for="tel_mac" translate="tel"></label>
    </div>
  </div>

  <div class="row">
    <div class="input-field col s12">
      <input id="web_mac" type="text"
      name="web_mac" class="validate"
      ng-model="place.web_mac" ng-change="formChange()">
      <label for="web_mac">Web</label>
    </div>
  </div>

  <div class="row">
    <div class="input-field col s12">
      <textarea id="comentarios_mac" type="text"
      name="comentarios_mac"
      class="validate materialize-textarea"
      ng-model="place.comentarios_mac"
      ng-change="formChange()"></textarea>
      <label for="comentarios_mac" translate="observations"></label>
    </div>
  </div>

</form>
