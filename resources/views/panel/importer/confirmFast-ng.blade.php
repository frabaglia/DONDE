@extends('layouts.panel-master')

{!!Html::style('styles/import.min.css')!!}
{!!Html::style('bower_components/materialize/bin/materialize.css')!!}
{!!Html::script('bower_components/materialize/bin/materialize.js')!!}

@section('content')

<a>Confirmación</a>

<div class="container centrada">

	<h2>
		Filtrado de búsqueda realizado
	</h2>

<br>
<br>

	<h4 class="left-align"> <i class="mdi-navigation-arrow-drop-down"></i> <b>Nuevos ({{$cantidadNuevos}}) </b></h4>

	<div class="row">

		<table class="striped">

			<thead>
				<td translate="establishment"></td>
				<td translate="type"> </td>
				<td translate="street_address"></td>
				<td translate="form_establishment_street_height"></td>
				<td translate="panel_places_columntable_5"></td>
				<td translate="district"></td>
				<td translate="state"></td>
				<td translate="country"></td>
			</thead>

			@if (count($datosNuevos) > 0 )
			@foreach ($datosNuevos as $p)
			<tbody>
				<td class="text-center"> {{$p['establecimiento']}} </td>
				<td class="text-center"> {{$p['tipo']}} </td>
				<td class="text-center"> {{$p['calle']}} </td>
				<td class="text-center"> {{$p['altura']}} </td>
				<td class="text-center"> {{$p['ciudad']}} </td>
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
				<td class="text-center">  </td>
			</tbody>
			@endif
		</table>

	</div>

             {{-- ========================================================================= --}}

    <br>

    @if (count($datosNuevos) > 0 )
    <div class="row">

      <div class="col s3 offset-s10">

	      <a href="{{ url('panel/importer/nuevo') }}"  class="waves-effect waves-light btn-floating"><i class="mdi-action-get-app"></i></a>

      </div>

    </div>
    @endif

             {{-- ========================================================================= --}}

	<br><br>
	<h4 class="left-align"> <i class="mdi-navigation-arrow-drop-down"></i> <b>Repetidos ({{$cantidadRepetidos}}) </b></h4>

	<div class="row">

		<table class="striped">

			<thead>
				<td translate="establishment"></td>
				<td translate="type"> </td>
				<td translate="street_address"></td>
				<td translate="form_establishment_street_height"></td>
				<td translate="panel_places_columntable_5"></td>
				<td translate="district"></td>
				<td translate="state"></td>
				<td translate="country"></td>
			</thead>

			@if (count($datosRepetidos) > 0 )
			@foreach ($datosRepetidos as $p)
			<tbody>
				<td class="text-center"> {{$p['establecimiento']}} </td>
				<td class="text-center"> {{$p['tipo']}} </td>
				<td class="text-center"> {{$p['calle']}} </td>
				<td class="text-center"> {{$p['altura']}} </td>
				<td class="text-center"> {{$p['ciudad']}} </td>
				<td class="text-center"> {{$p['barrio_localidad']}} </td>
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
				<td class="text-center">  </td>
			</tbody>
			@endif
		</table>

	</div>

	         {{-- ========================================================================= --}}

    <br>

    @if (count($datosRepetidos) > 0 )
	    <div class="row">
	      <div class="col s3 offset-s10"><a href="{{ url('panel/importer/repetido') }}"  class="waves-effect waves-light btn-floating"><i class="mdi-action-get-app"></i></a></div>
	    </div>
	@endif

             {{-- ========================================================================= --}}

	<br><br>

	<h4 class="left-align"> <i class="mdi-navigation-arrow-drop-down"></i> <b>Incompletos ({{$cantidadIncompletos}})<b></h4>

	<div class="row">

		<table class="striped">

			<thead>
				<td translate="establishment"></td>
				<td translate="type"> </td>
				<td translate="street_address"></td>
				<td translate="form_establishment_street_height"></td>
				<td translate="panel_places_columntable_5"></td>
				<td translate="district"></td>
				<td translate="state"></td>
				<td translate="country"></td>
			</thead>

			@if (count($datosIncompletos) > 0 )
			@foreach ($datosIncompletos as $p)
			<tbody>
				<td class="text-center"> {{$p['establecimiento']}} </td>
				<td class="text-center"> {{$p['tipo']}} </td>
				<td class="text-center"> {{$p['calle']}} </td>
				<td class="text-center"> {{$p['altura']}} </td>
				<td class="text-center"> {{$p['ciudad']}} </td>
				<td class="text-center"> {{$p['barrio_localidad']}} </td>
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
				<td class="text-center">  </td>
			</tbody>
			@endif
		</table>

	</div>

	         {{-- ========================================================================= --}}

    <br>

    @if (count($datosIncompletos) > 0 )
    <div class="row">

    	<div class="col s3 offset-s10">

    		<a href="{{ url('panel/importer/incompleto') }}"  class="waves-effect waves-light btn-floating"><i class="mdi-action-get-app"></i></a>

    	</div>

    </div>
    @endif

             {{-- ========================================================================= --}}

	<br><br>

	<h4 class="left-align"> <i class="mdi-navigation-arrow-drop-down"></i> <b> Unificar ({{$cantidadUnificar}}) <b></h4>

	<div class="row">

		<table class="striped">

			<thead>
				<td translate="establishment"></td>
				<td translate="type"> </td>
				<td translate="street_address"></td>
				<td translate="form_establishment_street_height"></td>
				<td translate="panel_places_columntable_5"></td>
				<td translate="district"></td>
				<td translate="state"></td>
				<td translate="country"></td>
			</thead>

			@if (count($datosUnificar) > 0 )
			@foreach ($datosUnificar as $p)
			<tbody>
				<td class="text-center"> {{$p['establecimiento']}} </td>
				<td class="text-center"> {{$p['tipo']}} </td>
				<td class="text-center"> {{$p['calle']}} </td>
				<td class="text-center"> {{$p['altura']}} </td>
				<td class="text-center">  {{$p['ciudad']}}</td>
				<td class="text-center"> {{$p['barrio_localidad']}} </td>
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
				<td class="text-center">  </td>
			</tbody>
			@endif
		</table>

	</div>

	         {{-- ========================================================================= --}}

    <br>

    @if (count($datosUnificar) > 0 )
    <div class="row">

    	<div class="col s3 offset-s10">

    		<a href="{{ url('panel/importer/unificar') }}"  class="waves-effect waves-light btn-floating"><i class="mdi-action-get-app"></i></a>

    	</div>

    </div>
    @endif

    {{-- ========================================================================= --}}

<br><br>

<h4 class="left-align"> <i class="mdi-navigation-arrow-drop-down"></i> <b> Baja Confianza ({{$cantidadDescartados}}) <b></h4>

	<div class="row">

		<table class="striped">
			
			<thead>
				<td translate="establishment"></td>
				<td translate="type"> </td>
				<td translate="street_address"></td>
				<td translate="form_establishment_street_height"></td>
				<td translate="panel_places_columntable_5"></td>
				<td translate="district"></td>
				<td translate="state"></td>
				<td translate="country"></td>
			</thead>

			@if (count($datosDescartados) > 0 )
			@foreach ($datosDescartados as $p)
			<tbody>
				<td class="text-center"> {{$p['establecimiento']}} </td>
				<td class="text-center"> {{$p['tipo']}} </td>
				<td class="text-center"> {{$p['calle']}} </td>
				<td class="text-center"> {{$p['altura']}} </td>
				<td class="text-center"> {{$p['ciudad']}} </td>
				<td class="text-center"> {{$p['barrio_localidad']}} </td>
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
				<td class="text-center">  </td>
			</tbody>
			@endif
		</table>

	</div>

	         {{-- ========================================================================= --}}

    <br>

 @if (count($datosDescartados) > 0 )
    <div class="row">

      <div class="col s3 offset-s10">

      	<a href="{{ url('panel/importer/bc')}}" class="waves-effect waves-light btn-floating"><i class="mdi-action-get-app"></i></a>

      </div>

    </div>
@endif

             {{-- ========================================================================= --}}

	<br>
	<br>
	<br>

</div>

<div class="row">

	<div class="col s6">

		<a href="{{ url('panel/importer') }}" class="waves-effect waves-light btn" style="margin-bottom: 5%;">Cancelar</a>

	</div>

	<div class="col s6">

		<a href="{{ url('panel/importer/results') }}" class="waves-effect waves-light btn green">Confirmar</a>

	</div>

</div>

@endsection

@section('js')

{!!Html::script('bower_components/ngm/ap/build/scripts/ng-map.min.js')!!}
{!!Html::script('scripts/panel/app.js')!!}
{!!Html::script('scripts/panel/controllers/city-list/controller.js')!!}

@stop
