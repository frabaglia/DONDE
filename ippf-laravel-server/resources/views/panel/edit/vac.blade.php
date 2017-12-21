<form class="col s12 m6">
                    <div class="row">
                      <div class="row">
<p>

                      <input  type="checkbox"
                      name="place.vacunatorio"
                      id="filled-in-box-vac"
                      ng-checked="isCheckBoxChecked(place.vacunatorio)"
                      ng-model="place.vacunatorio"/>
                      <label for="filled-in-box-vac" translate="haveVac"></label>
                    </p>

                      <div class="input-field col s12">
                        <input id="responsable_vac" type="text"
                        name="responsable_vac" class="validate"
                        ng-model="place.responsable_vac"
                        ng-change="formChange()">
                        <label for="responsable_vac" translate="responsable"></label>
                      </div>
                    </div>
                     <div class="row">
                      <div class="input-field col s12">
                        <input id="ubicacion_vac" type="text"
                        name="ubicacion_vac" class="validate"
                        ng-model="place.ubicacion_vac"
                        ng-change="formChange()">
                        <label for="ubicacion_vac" translate="location"></label>
                      </div>
                    </div>


                  <div class="row">
                      <div class="input-field col s12">
                        <input id="horario_vac" type="text"
                        name="horario_vac" class="validate"
                        ng-model="place.horario_vac"
                        ng-change="formChange()">
                        <label for="horario_vac" translate="schedule"></label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="input-field col s12">
                        <input id="mail_vac" type="email"
                        name="mail_vac" class="validate"
                        ng-model="place.mail_vac"
                        ng-change="formChange()">
                        <label for="mail_vac">Mail</label>
                      </div>
                    </div>

                    <div class="row">
                      <div class="input-field col s12">
                        <input id="tel_vac" type="text"
                        name="tel_vac" class="validate"
                        ng-model="place.tel_vac" ng-change="formChange()">
                        <label for="tel_vac" translate="tel"></label>
                      </div>
                    </div>

                         <div class="row">
                      <div class="input-field col s12">
                        <input id="web_vac" type="text"
                        name="web_vac" class="validate"
                        ng-model="place.web_vac" ng-change="formChange()">
                        <label for="web_vac">Web</label>
                      </div>
                    </div>

                    <div class="row">
                      <div class="input-field col s12">
                        <textarea id="comentarios_vac" type="text"
                        name="comentarios_vac"
                        class="validate materialize-textarea"
                        ng-model="place.comentarios_vac"
                        ng-change="formChange()"></textarea>
                        <label for="comentarios_vac" translate="obs"></label>
                      </div>
                    </div>
                     </div>
                      </div>

                         </form>
