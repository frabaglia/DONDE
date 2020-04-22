@extends('layouts.panel-master')

@section('content')
  <div class="home panel" ng-controller="usersController">
    <div class="row">
    <div class="col s12 m3">
      <p></p>
    </div>
  </div>
  <div class="section navigate row">
    <h3 ng-cloak ng-show="loadingPrev" translate="loadingCountries"> </h3>
  </div>
  <a class="waves-effect waves-light btn" ng-click="saveUserCountries()"><i class="material-icons left">cloud</i><span translate="save"> </span></a>
  <div class="section copy row">
    <div class="col s12 m12 ">
      <h3 ng-cloak ng-hide="loadingPrev"> <span translate="selectUserCountries"> </span> {{Auth::user()->name}} </h3>
      <table class="bordered striped responsive-table">
          <thead>
              <tr ng-cloak ng-hide="loadingPrev">
                <th data-field="nombre">Pais</th>
                <th data-field="nombre_localidad" translate="select"></th>
            </tr>
          </thead>
          <tbody>
              <tr ng-cloak ng-hide="loadingPrev" ng-repeat="country in countries">
                  <td>[[country.nombre_pais]]</td>
                  <td> <input type="checkbox" id="check_[[country.id]]" name="check_[[country.id]]" ng-checked="exists(country, selected)" ng-click="toggle(country, selected)" />
                      <label for="check_[[country.id]]"></label>
                  </td>
              </tr>
          </tbody>
        </table>
      </div>
    </div>
</div>
@stop

@section('js')

 {!!Html::script('bower_components/ngmap/build/scripts/ng-map.min.js')!!}


  {!!Html::script('scripts/panel/app.js')!!}
  {!!Html::script('scripts/panel/controllers/users/controller.js')!!}

@stop
