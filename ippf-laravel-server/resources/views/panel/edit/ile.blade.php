<form class="col s12 m6">
	<div class="row">
		<div class="row">
			<p>

				<input  type="checkbox"
				name="place.ile"
				id="filled-in-box-ile"
				ng-checked="isCheckBoxChecked(place.ile)"
				ng-model="place.ile"/>
				<label for="filled-in-box-ile" translate="form_ile_option"></label>
			</p>

			<p>
				<input  type="checkbox"
				name="friendly_ile"
				id="friendly_ile"
				ng-model="place.friendly_ile"/>
				<label for="friendly_ile" translate="form_service_friendly_option"></label>
			</p>

			<div class="input-field col s12">
			<input id="responsable_ile" type="text"
			name="responsable_ile" class="validate"
			ng-model="place.responsable_ile"
				ng-change="formChange()">
				<label for="responsable_ile" translate="responsable"></label>
			</div>
		</div>
		<div class="row">
			<div class="input-field col s12">
			<input id="ubicacion_ile" type="text"
			name="ubicacion_ile" class="validate"
			ng-model="place.ubicacion_ile"
				ng-change="formChange()">
				<label for="ubicacion_ile" translate="location"></label>
			</div>
		</div>


		<div class="row">
			<div class="input-field col s12">
			<input id="horario_ile" type="text"
			name="horario_ile" class="validate"
			ng-model="place.horario_ile"
				ng-change="formChange()">
				<label for="horario_ile" translate="schedule"></label>
			</div>
		</div>
		<div class="row">
			<div class="input-field col s12">
			<input id="mail_ile" type="email"
			name="mail_ile" class="validate"
			ng-model="place.mail_ile"
				ng-change="formChange()">
				<label for="mail_ile" translate="email"></label>
			</div>
		</div>

		<div class="row">
			<div class="input-field col s12">
			<input id="tel_ile" type="text"
			name="tel_ile" class="validate"
			ng-model="place.tel_ile" ng-change="formChange()">
				<label for="tel_ile" translate="tel"></label>
			</div>
		</div>

		<div class="row">
			<div class="input-field col s12">
			<input id="web_ile" type="text"
			name="web_ile" class="validate"
			ng-model="place.web_ile" ng-change="formChange()">
				<label for="web_ile">Web</label>
			</div>
		</div>

		<div class="row">
			<div class="input-field col s12">
			<textarea id="comentarios_ile" type="text"
			name="comentarios_ile"
				class="validate materialize-textarea"
				ng-model="place.comentarios_ile"
				ng-change="formChange()"></textarea>
				<label for="comentarios_ile" translate="observations"></label>
			</div>
		</div>
	</div>
</div>

</form>
