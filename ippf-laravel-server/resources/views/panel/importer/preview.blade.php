@extends('layouts.panel-master')

{!!Html::style('styles/import.min.css')!!}
{!!Html::style('bower_components/materialize/bin/materialize.css')!!}

@section('content')


<a>Previsualización</a>



<div class="home full">
	<div class="container centrada">
		<p align="left"> <em>Datos nuevos referidos a localidades dentro del archivo a importar</em> </p>
	</div>
</div>

<br>

@if (count($nuevosPaises) == 0 )
	<p class="centrada">No se registran nuevos paises.</p>
@elseif ( (count($nuevosPaises) > 0 ) && (count($nuevosPaises) < 2 ) )
	Usted está a punto de crear el siguiente País
@else
	Usted está a punto de crear los siguientes Países
@endif
<div class="container">	
	<div >
		<table class="striped">
			<thead>
				<th class="text-center"><i class="mdi-navigation-arrow-drop-down"></i> Paises ({{$cantidadPais}})</th>
			</thead>
			@if (count($nuevosPaises) > 0 )
			@foreach ($nuevosPaises as $pais)
			<tbody>
				<td class="text-center"> {{$pais}} </td>
			</tbody>
			@endforeach
			@else
				<tbody>
					<td class="text-center"> <em>No se encontraron nuevos paises en su dataset.</em> </td>
				</tbody>
			@endif
		</table>
	</div>
</div>

<br><br>

@if (count($nuevosProvincias) == 0 )
	<p class="centrada">No se registran nuevas provincias.</p>
@elseif ( (count($nuevosProvincias) > 0 ) && (count($nuevosProvincias) < 2 ) )
	<p class="centrada">Usted está a punto de crear la siguiente provincia</p>
@else
	<p class="centrada">Usted está a punto de crear las siguientes provincia</p>
@endif

<div class="container">	
	<div>
		<table class="striped">
			<thead>
				<th class="text-center"> <i class="mdi-navigation-arrow-drop-down"></i> Provincias ({{$cantidadProvincia}})</th>
			</thead>
			@if (count($nuevosProvincias) > 0 )
			@foreach ($nuevosProvincias as $provincia)
			<tbody>
				<td class="text-center"> {{$provincia}} </td>    				
			</tbody>
			@endforeach
			@else
			<tbody>
				<td class="text-center"> <em>No se encontraron nuevos partidos en su dataset.</em> </td>
			</tbody>
			@endif				
		</table>
	</div>
</div>		
<br><br>


@if (count($nuevosPartidos) == 0 )
	<p class="centrada">No se registran nuevos partidos.</p>
@elseif ( (count($nuevosPartidos) > 0 ) && (count($nuevosPartidos) < 2 ) )
	<p class="centrada">Usted está a punto de crear el siguiente partido.</p>
@else
	<p class="centrada">Usted está a punto de crear los siguientes partidos.</p>
@endif

<div class="container">	
	<div>
		<table class="striped">
			<thead>
				<th class="text-center"><i class="mdi-navigation-arrow-drop-down"></i> Partido(Localidad) ({{$cantidadPartido}}) </th>
				<th class="text-center"><i class="mdi-navigation-arrow-drop-down"></i> Provincia </th>
			</thead>
			@if (count($nuevosPartidos) > 0 )
			@foreach ($nuevosPartidos as $partido)
			<tbody>
				<td class="text-center">{{$partido['Partido']}} </td>
				<td class="text-center">{{$partido['Provincia']}} </td> 
			</tbody>
			@endforeach
			@else
			<tbody>
				<td class="text-center"> <em>No se encontraron nuevos partidos(localidades) en su dataset.</em> </td>
				<td class="text-center">  </td>
			</tbody>
			@endif

		</table>
	</div>
</div>

<div class="container ">
	<div class="section search search-form row">

		<div class="row col s12 center">

			{!!Form::open(['url'=>['panel/importer/confirm'],'method'=>'POST'] )!!}
			<div class="col-md-4">
				{!!Form::hidden('fileName', $nombreFile)!!}

				{!!Form::button('ACEPTAR',
				array('type' => 'submit', 'class' => 'waves-effect waves-light btn green')) !!}
			</div>
			{!! Form::close()!!}

		</div>

		<br>
		<br>
		<br>

	</div>
</div>




@endsection


@section('js')

{!!Html::script('bower_components/ngm/ap/build/scripts/ng-map.min.js')!!}
{!!Html::script('scripts/panel/app.js')!!}
{!!Html::script('scripts/panel/controllers/city-list/controller.js')!!}

@stop
