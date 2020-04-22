@extends('layouts.panel-master')

@section('content')

    <div class="home panel" ng-controller="panelIndexController">

    <div class="row" >

    <div class="col s12">
    
        <ul class="tabs" tabs>

            <li class="tab col s3"><a class="active" href="#dashboard"><i class="small mdi-content-inbox"></i><span translate="summary"></span></a></li>

            <li class="tab col s3"><a class="" href="#aprobar"><i class="small mdi-content-inbox"></i><span translate="panel_tab_pending" translate-values="{pendings_lenght: '[[penplaces.length]]'}"></span></a></li>

            <li class="tab col s3"><a href="#activos"> <i class="small mdi-action-done-all"></i><span translate="panel_tab_actives" translate-values="{actives_lenght: '[[places.length]]'}"></span></a></li>

            <li class="tab col s3"><a href="#rejected"> <i class="small mdi-action-delete  "></i><span translate="panel_tab_rejecteds" translate-values="{rejecteds_lenght: '[[rejectedplaces.length]]'}"></span></a></li>

            <li class="tab col s3"><a href="#tagsImportaciones"> <i class="small mdi-communication-import-export"></i><span translate="panel_tab_imports" translate-values="{imports_lenght: '[[tagsImportaciones.length]]'}"></span></a></li>

            <!-- New view for evaluations -->
            <li class="tab col s3"><a href="#eval"> <i class="small mdi-communication-comment"></i><span translate="evaluations" translate-values="{evaluations_length: '[[totalEvals]]'}"></span></a></li>

        </ul>

    </div>

    @include('panel/home/dashboard')
    @include('panel/home/evaluaciones')    
    @include('panel/home/aprobar')
    @include('panel/home/importaciones')
    @include('panel/home/desaprobados')
    @include('panel/home/activos')

  <!-- Modal Structure -->
  <div id="demoModal" class="modal">
      <div class="modal-content">
          <h4 translate="panel_reject_place_modal_confirmation_1"></h4>
          <h3><strong>[[current.establecimiento]]</strong></h3>
          <h4><small>[[current.nombre_provincia]], [[current.nombre_localidad]]</small></h4>
          <hr/>
          <p translate="panel_reject_place_modal_confirmation_2"></p>
          <hr/>
      </div>
      <div class="modal-footer">
          <a href="" class=" modal-action modal-close
            waves-effect waves-green btn-flat" translate="no"></a>
          <a ng-click="removePlace()" href="" class=" modal-action waves-effect waves-green btn-flat" translate="yes"></a>
      </div>
  </div>



</div>

  @stop

@section('js')
  
  {!!Html::script('scripts/genosha-geolibs.js')!!}
  {!!Html::script('scripts/panel/controllers/index/controller.js')!!}
  {!!Html::script('scripts/panel/controllers/importer/controller.js')!!}
  {!!Html::script('bower_components/ngmap/build/scripts/ng-map.min.js')!!}
  {!!Html::script('scripts/panel/controllers/index/importaciones/controller.js')!!}
  {!!Html::script('scripts/home/services/places.js')!!}
  {!!Html::script('scripts/home/services/copy.js')!!}

@stop
