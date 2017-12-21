<form class="col s12 m6">
                    <div class="row">
                      <div class="row">
<p>

                      <input  type="checkbox"
                      name="place.infectologia"
                      id="filled-in-box-infectologia"
                      ng-checked="isCheckBoxChecked(place.infectologia)"
                      ng-model="place.infectologia"/>
                      <label for="filled-in-box-infectologia" translate="haveAttention"></label>
                    </p>

                      <div class="input-field col s12">
                        <input id="responsable_infectologia" type="text"
                        name="responsable_infectologia" class="validate"
                        ng-model="place.responsable_infectologia"
                        ng-change="formChange()">
                        <label for="responsable_infectologia" translate="responsable"></label>
                      </div>
                    </div>
                     <div class="row">
                      <div class="input-field col s12">
                        <input id="ubicacion_infectologia" type="text"
                        name="ubicacion_infectologia" class="validate"
                        ng-model="place.ubicacion_infectologia"
                        ng-change="formChange()">
                        <label for="ubicacion_infectologia" translate="location"></label>
                      </div>
                    </div>


                  <div class="row">
                      <div class="input-field col s12">
                        <input id="horario_infectologia" type="text"
                        name="horario_infectologia" class="validate"
                        ng-model="place.horario_infectologia"
                        ng-change="formChange()">
                        <label for="horario_infectologia" translate="schedule"></label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="input-field col s12">
                        <input id="mail_infectologia" type="email"
                        name="mail_infectologia" class="validate"
                        ng-model="place.mail_infectologia"
                        ng-change="formChange()">
                        <label for="mail_infectologia">Mail</label>
                      </div>
                    </div>

                    <div class="row">
                      <div class="input-field col s12">
                        <input id="tel_infectologia" type="text"
                        name="tel_infectologia" class="validate"
                        ng-model="place.tel_infectologia" ng-change="formChange()">
                        <label for="tel_infectologia" translate="tel"></label>
                      </div>
                    </div>

                         <div class="row">
                      <div class="input-field col s12">
                        <input id="web_infectologia" type="text"
                        name="web_infectologia" class="validate"
                        ng-model="place.web_infectologia" ng-change="formChange()">
                        <label for="web_infectologia">Web</label>
                      </div>
                    </div>

                    <div class="row">
                      <div class="input-field col s12">
                        <textarea id="comentarios_infectologia" type="text"
                        name="comentarios_infectologia"
                        class="validate materialize-textarea"
                        ng-model="place.comentarios_infectologia"
                        ng-change="formChange()"></textarea>
                        <label for="comentarios_infectologia tra" translate="obs"></label>
                      </div>
                    </div>

                        </div>
                      </div>

                         </form>
