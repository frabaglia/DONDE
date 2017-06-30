@extends('layouts.clear')
@section('meta')

<title> Fundación Huésped -  ¿#Donde <?php echo html_entity_decode($resu['titleCopySeo']);?> en <?php echo html_entity_decode($pais)." . ".html_entity_decode($provincia)." , ".html_entity_decode($partido); ?>? </title>
<meta name="description" content="Encuentra <?php echo html_entity_decode($resu['descriptionCopy']);?> en <?php echo html_entity_decode($pais)." . ".html_entity_decode($provincia)." , ".html_entity_decode($partido); ?>">
<meta name="author" content="Fundación Huésped">
<link rel="canonical" href="https://www.huesped.org.ar/donde/"/>
<meta property='og:locale' content='es_LA'/>
<meta property='og:title' content='donde.huesped.org.ar | Fundación Huésped'/>
<meta property="og:description" content="Encuentra <?php echo html_entity_decode($resu['descriptionCopy']);?> en <?php echo html_entity_decode($pais)." . ".html_entity_decode($provincia)." , ".html_entity_decode($partido); ?>" />

@stop

@section('content')

 <nav>
    <div class="nav-wrapper">
      <a href="{{ url('/#/') }}" class="brand-logo"><img class="logoTop" src="/images/HUESPED_logo_donde_RGB-07_cr.png"> </a>
      <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="mdi-navigation-menu"></i></a>
      <ul class="right hide-on-med-and-down">
           <li><a class="modal-trigger" href="#modal1"><i class="mdi-action-info"></i></a></li>
           <li><a class="modal-trigger" href="/#/localizar/all/listado"><i class="mdi-maps-place left"></i></a></li>
           <li><a class="" href="/form"><i class="mdi-content-add-circle-outline"></i></a></li>
           <li><a class="" href="/listado-paises"><i class="mdi-action-language"></i></a></li>
      </ul>
      
      <ul ng-show="navigating"  class="left wow fadeIn nav-wrapper">
           <li style="width: 120px;"><a href="" onclick="window.history.back();"> <i class="mdi-navigation-chevron-left left"></i><span>{{$i18n['volver']}}</span></a></li>
      </ul>

      <ul class="side-nav" id="mobile-demo">
          <li><a href="#/acerca">
            <i class="mdi-action-info left"></i>Información
            </a>
          </li>
          <li><a href="#/localizar/all/listado">
            <i class="mdi-maps-place left"></i>Cercanos</a></li>
          <li><a href="form">
            <i class="mdi-content-add-circle-outline left"></i>
            Sugerir</a>
          </li>

      </ul>
    </div>
  </nav>







@if (count($places) > 0 )
  <div class="result-seo">
    <div class="Aligner">
    @if ( count($places) < 2 )
      {{$cantidad}} {{$resu['preCopyFoundSingle']}} &nbsp<b>{{$resu['newServiceTitleSingle']}}</b> &nbsp en </b>
    @else
      {{$cantidad}} {{$resu['preCopyFound']}} &nbsp<b>{{$resu['newServiceTitle']}}</b> &nbsp en </b>
    @endif
    </div>


    <div class="Aligner">
      <div class="Aligner-item Aligner-item--top"><img width="50px" src="/images/{{$resu['icon']}}"></div>
      <div class="Aligner-item">
        <span class="text-seo"><b>{{$partido}}</span>, <span class="text-seo">{{$provincia}}</span></b>
      </div>
    </div>

</div>

<div class="container">
	<table class="striped" >
		<thead>
			<th>Dirección</th>
			<th>Lugar</th>
			<th>Horario</th>
			<th>Responsable</th>
			<th>Teléfono</th>
		</thead>
		<tbody>     
			@foreach ($places as $p)
			<tr>
        @if (isset($p->altura) && ($p->altura != "" ) && ($p->altura != " " ) )  
            <td><a class="item-seo" href="/share/{{$p->placeId}}">{{$p->calle}}  {{$p->altura}}</a></td>
        @else
				  <td><a class="item-seo" href="/share/{{$p->placeId}}">{{$p->calle}} Sin número</a></td>
        @endif

				<td><a class="item-seo" href="/share/{{$p->placeId}}">{{$p->establecimiento}}</a></td>
				<td><a class="item-seo" href="/share/{{$p->placeId}}">{{$p->horario}}</a></td>
				<td><a class="item-seo" href="/share/{{$p->placeId}}">{{$p->responsable}}</a></td>
				<td><a class="item-seo" href="/share/{{$p->placeId}}">{{$p->telefono}}</a></td>
			</tr>	
			@endforeach
		</tbody>

	</table>
</div>

<br>
<div class="container option-seo">
    <div class="centrada-seo">
      <a href="{{ url('/form') }}" class="waves-effect waves-light btn btn-seo">
        <i class="mdi-navigation-chevron-right right"></i>
        <i class="mdi-content-add-circle left"></i>{{$i18n['SugerirLugar']}}</a>
      </div>  
    </div>

@else 
  <div class="result-seo">
    <div class="Aligner">
      {{$resu['titleCopyNotFound']}} &nbsp <b>{{$resu['newServiceTitle']}}</b> &nbsp en
    </div>

    <div class="Aligner">
      <div class="Aligner-item Aligner-item--top"><img width="50px" src="/images/{{$resu['icon']}}"></div>
      <div class="Aligner-item">
        <span class="text-seo"><b>{{$partido}}</span>, <span class="text-seo">{{$provincia}}</span></b>
      </div>
    </div>


</div>
{{--  --}}
<div class="container option-seo">
	<div class="centrada-seo">
		<a href="{{ url('listado-paises') }}" class="waves-effect waves-light btn btn-seo">
			<i class="mdi-navigation-chevron-right right"></i>
			<i class="mdi-action-search left"></i>{{$i18n['NuevaBusqueda']}}</a>
		</div>

		<div class="centrada-seo">
			<a href="{{ url('/form') }}" class="waves-effect waves-light btn btn-seo">
				<i class="mdi-navigation-chevron-right right"></i>
				<i class="mdi-content-add-circle left"></i>{{$i18n['SugerirLugar']}}</a>
			</div>	
		</div>
@endif


@include('acerca')

@stop