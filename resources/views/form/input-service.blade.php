@if(isset($service))
<input type="checkbox" name="place.{!! $service !!}" 
id="filled-in-box-{!! $service !!}" 
ng-checked="isCheckBoxChecked(place.{!! $service !!})"
ng-model="place.{!! $service !!}" ng-change="formChange()"/>
@endif