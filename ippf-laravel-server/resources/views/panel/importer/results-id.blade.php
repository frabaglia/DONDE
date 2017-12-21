@extends('layouts.panel-master')
{!!Html::style('styles/import.min.css')!!}
{!!Html::style('bower_components/materialize/bin/materialize.css')!!}
{!!Html::script('bower_components/materialize/bin/materialize.js')!!}

@section('content')

<a>Resultados</a>

<div class="container centrada">

	<h2>
		Filtrado de búsqueda realizado
	</h2>
<br>
<br>
	<h4 class="left-align"> <i class="mdi-navigation-arrow-drop-down"></i> <b>Actualizar ({{$cantidadActualizar}}) </b></h4>

	<div class="row">
		<table class="striped">
			<thead>
				<td> Id </td>
				<td> Establecimiento</td>
				<td> Tipo </td>
				<td> Calle </td>
				<td> Altura </td>
				<td> Partido_comuna </td>
				<td> Provincia_region </td>
				<td> Pais </td>
			</thead>
			@if (count($datosActualizar) > 0 )
			@foreach ($datosActualizar as $p)
			<tbody>
				<td class="text-center"> {{$p['placeId']}} </td>
				<td class="text-center"> {{$p['establecimiento']}} </td>
				<td class="text-center"> {{$p['tipo']}} </td>
				<td class="text-center"> {{$p['calle']}} </td>
				<td class="text-center"> {{$p['altura']}} </td>
				@if ( $p['provincia_region'] == "Ciudad Autónoma de Buenos Aires")
					<td class="text-center"> {{$p['barrio_localidad']}} </td>
				@else
					<td class="text-center"> {{$p['partido_comuna']}} </td>
				@endif
				<td class="text-center"> {{$p['provincia_region']}} </td>
				<td class="text-center"> {{$p['pais']}} </td>
			</tbody>
			@endforeach
			@else
			<tbody>
				<td class="text-center"> <em>No se encontraron datos nuevos en su dataset.</em> </td>
				<td class="text-center">  </td>
				<td class="text-center">  </td>
				<td class="text-center">  </td>
				<td class="text-center">  </td>
				<td class="text-center">  </td>
				<td class="text-center">  </td>
			</tbody>
			@endif
		</table>
	</div>
             {{-- ========================================================================= --}}
    <br>
    @if (count($datosActualizar) > 0 )
    <div class="row">
      <div class="col s3 offset-s10"><a href="{{ url('panel/importer/actualizar') }}"  class="waves-effect waves-light btn-floating"><i class="mdi-action-get-app"></i></a></div>
    </div>
    @endif
           {{-- ========================================================================= --}}


	<br>
	<br>
	<br>
           {{-- ========================================================================= --}}
<h4 class="left-align"> <i class="mdi-navigation-arrow-drop-down"></i> <b>Id no existente ({{$cantidadBadActualizar}}) </b></h4>

	<div class="row">
		<table class="striped">
			<thead>
				<td> Id </td>
				<td> Establecimiento</td>
				<td> Tipo </td>
				<td> Calle </td>
				<td> Altura </td>
				<td> Partido_comuna </td>
				<td> Provincia_region </td>
				<td> Pais </td>
			</thead>
			@if (count($datosBadActualizar) > 0 )
			@foreach ($datosBadActualizar as $p)
			<tbody>
				<td class="text-center"> {{$p['placeId']}} </td>
				<td class="text-center"> {{$p['establecimiento']}} </td>
				<td class="text-center"> {{$p['tipo']}} </td>
				<td class="text-center"> {{$p['calle']}} </td>
				<td class="text-center"> {{$p['altura']}} </td>
				@if ( $p['provincia_region'] == "Ciudad Autónoma de Buenos Aires")
					<td class="text-center"> {{$p['barrio_localidad']}} </td>
				@else
					<td class="text-center"> {{$p['partido_comuna']}} </td>
				@endif
				<td class="text-center"> {{$p['provincia_region']}} </td>
				<td class="text-center"> {{$p['pais']}} </td>
			</tbody>
			@endforeach
			@else
			<tbody>
				<td class="text-center"> <em>No se encontraron datos nuevos en su dataset.</em> </td>
				<td class="text-center">  </td>
				<td class="text-center">  </td>
				<td class="text-center">  </td>
				<td class="text-center">  </td>
				<td class="text-center">  </td>
				<td class="text-center">  </td>
			</tbody>
			@endif
		</table>
	</div>
             {{-- ========================================================================= --}}
    <br>
    @if (count($datosBadActualizar) > 0 )
    <div class="row">
      <div class="col s3 offset-s10"><a href="{{ url('panel/importer/sin-actualizar') }}"  class="waves-effect waves-light btn-floating"><i class="mdi-action-get-app"></i></a></div>
    </div>
    @endif
           {{-- ========================================================================= --}}


	<br>
	<br>
	<br>


</div>



{{-- Buttons --}}
<div class="container ">
    <div class="col s12">
        <div class="row col s12 center">
            <a href="{{ url('panel/importer') }}" class="waves-effect waves-light btn">Volver al importador</a>
        </div>
        <br>
        <br>
        <br>
        <div class="row col s12 center">
            <a href="{{ url('panel') }}" class="waves-effect waves-light btn" style="margin-bottom: 5%;">Volver al panel </a>
        </div>
    </div>
</div>    
{{-- Buttons End --}}



@endsection


@section('js')

{{-- {!!Html::script('bower_components/ngm/ap/build/scripts/ng-map.min.js')!!}
{!!Html::script('scripts/panel/app.js')!!}
{!!Html::script('scripts/panel/controllers/city-list/controller.js')!!}
 --}}
@stop