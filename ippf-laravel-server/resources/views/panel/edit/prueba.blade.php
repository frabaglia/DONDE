<form class="col s12 m6">
                    <div class="row">
                      <div class="row">
        <p>

                      <input  type="checkbox"
                      name="place.prueba"
                      id="filled-in-box-prueba"
                      ng-checked="isCheckBoxChecked(place.prueba)"
                      ng-model="place.prueba"/>
                      <label for="filled-in-box-prueba" translate="form_prueba_option"></label>
                    </p>
        <p>

                      <input  type="checkbox"
                      name="place.es_rapido"
                      id="filled-in-box-es_rapido"
                      ng-checked="isCheckBoxChecked(place.es_rapido)"
                      ng-model="place.es_rapido"/>
                      <label for="filled-in-box-es_rapido" translate="form_fast_test_option"></label>
                    </p>

                    <p>
                      <input  type="checkbox"
                      name="friendly_prueba"
                      id="friendly_prueba"
                      ng-model="place.friendly_prueba"/>
                      <label for="friendly_prueba" translate="form_service_friendly_option"></label>
                    </p>

                      <div class="input-field col s12">
                        <input id="responsable_testeo" type="text"
                        name="responsable_testeo" class="validate"
                        ng-model="place.responsable_testeo"
                        ng-change="formChange()">
                        <label for="responsable_testeo" translate="responsable"></label>
                      </div>
                    </div>
                     <div class="row">
                      <div class="input-field col s12">
                        <input id="ubicacion_testeo" type="text"
                        name="ubicacion_testeo" class="validate"
                        ng-model="place.ubicacion_testeo"
                        ng-change="formChange()">
                        <label for="ubicacion_testeo" translate="location"></label>
                      </div>
                    </div>


                  <div class="row">
                      <div class="input-field col s12">
                        <input id="horario_testeo" type="text"
                        name="horario_testeo" class="validate"
                        ng-model="place.horario_testeo"
                        ng-change="formChange()">
                        <label for="horario_testeo" translate="schedule"></label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="input-field col s12">
                        <input id="mail_testeo" type="email"
                        name="mail_testeo" class="validate"
                        ng-model="place.mail_testeo"
                        ng-change="formChange()">
                        <label for="mail_testeo" translate="email"></label>
                      </div>
                    </div>

                    <div class="row">
                      <div class="input-field col s12">
                        <input id="tel_testeo" type="text"
                        name="tel_testeo" class="validate"
                        ng-model="place.tel_testeo" ng-change="formChange()">
                        <label for="tel_testeo" translate="tel"></label>
                      </div>
                    </div>

                         <div class="row">
                      <div class="input-field col s12">
                        <input id="web_testeo" type="text"
                        name="web_testeo" class="validate"
                        ng-model="place.web_testeo" ng-change="formChange()">
                        <label for="web_testeo">Web</label>
                      </div>
                    </div>

                    <div class="row">
                      <div class="input-field col s12">
                        <textarea id="observaciones_testeo" type="text"
                        name="observaciones_testeo"
                        class="validate materialize-textarea"
                        ng-model="place.observaciones_testeo"
                        ng-change="formChange()"></textarea>
                        <label for="observaciones_testeo" translate="observations"></label>
                      </div>
                    </div>

                 </div>
                      </div>

                         </form>
