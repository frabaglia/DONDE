<form class="col s12 m6">
                    <div class="row">
                      <div class="row">
<p>

                      <input  type="checkbox" 
                      name="place.condones" 
                      id="filled-in-box-condones" 
                      ng-checked="isChecked(place.condones)"
                      ng-model="place.condones"/>
                      <label for="filled-in-box-condones">¿Entrega condones?</label>
                    </p>

                      <div class="input-field col s12">
                        <input id="responsable_distrib" type="text"
                        name="responsable_distrib" class="validate" 
                        ng-model="place.responsable_distrib" 
                        ng-change="formChange()">
                        <label for="responsable_distrib">Responsable</label>
                      </div>
                    </div>
                     <div class="row">
                      <div class="input-field col s12">
                        <input id="ubicacion_distrib" type="text"
                        name="ubicacion_distrib" class="validate" 
                        ng-model="place.ubicacion_distrib" 
                        ng-change="formChange()">
                        <label for="ubicacion_distrib">Ubicacion</label>
                      </div>
                    </div>


                  <div class="row">
                      <div class="input-field col s12">
                        <input id="horario_distrib" type="text"
                        name="horario_distrib" class="validate" 
                        ng-model="place.horario_distrib" 
                        ng-change="formChange()">
                        <label for="horario_distrib">Horario</label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="input-field col s12">
                        <input id="mail_distrib" type="email"
                        name="mail_distrib" class="validate" 
                        ng-model="place.mail_distrib" 
                        ng-change="formChange()">
                        <label for="mail_distrib">Mail</label>
                      </div>
                    </div>

                    <div class="row">
                      <div class="input-field col s12">
                        <input id="tel_distrib" type="text" 
                        name="tel_distrib" class="validate" 
                        ng-model="place.tel_distrib" ng-change="formChange()">
                        <label for="tel_distrib">Telefono</label>
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
                        <label for="comentarios_distrib">Observación</label>
                      </div>
                    </div>
                      </div>
                      </div>
                    
                         </form>

                
