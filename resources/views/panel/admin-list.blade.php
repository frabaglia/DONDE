@extends('layouts.panel-master')

@section('content')
  <div class="home panel" ng-controller="adminListController">
    <div class="row">
    <div class="col s12 m3">
      <p></p>
    </div>
      @if (Auth::user()->roll == 'administrador')
    <div class="col s12 m6 ">
      <a target="_self" class="waves-effect waves-light btn btn-large full"
      ng-href="../auth/register">
      <i class="left mdi-content-add-box"></i>
       <span translate="addAd"> </span></a>
    </div>
    @endif
  </div>
  <div class="section navigate row">
    <h3 ng-cloak ng-show="loadingPrev" translate="loadingAd"> </h3>
  </div>
  <div class="section copy row">
    <div class="col s12 m12 ">
      <h3 ng-cloak ng-hide="loadingPrev" translate="activeAds" translate-values="{ 'count': '[[admins.length]]' }"> </h3>
      <table class="bordered striped responsive-table">
        {{Auth::user()->roll}}
          <thead>
              <tr ng-cloak ng-hide="loadingPrev">
                <th data-field="nombre" translate="name"></th>
                <th data-field="nombre_localidad">E-mail</th>
                <th data-field="nombre_localidad">Rol</th>
              @if (Auth::user()->roll == 'administrador')
              <th data-field="nombre_localidad" translate="asociateCountry"></th> @endif
            </tr>
          </thead>
          <tbody>
              <tr ng-cloak ng-hide="loadingPrev" ng-repeat="admin in admins">
                  <td>[[admin.name]]</td>
                  <td>[[admin.email]]</td>
                  <td>[[admin.roll]]</td>
                @if (Auth::user()->roll == 'administrador')  <td><a ng-show="admin.roll == 'supervisor'" class="btn-floating btn-flat waves-effect waves-light red" ng-click="userCountries([[admin.id]])"><i class="material-icons">mode_edit</i></a> </td>@endif
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
  {!!Html::script('scripts/panel/controllers/admin-list/controller.js')!!}

@stop
