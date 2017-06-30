@extends('layouts.clear')

@section('meta')

{{-- <title>donde.huesped.org.ar | Fundación Huésped -  {{$pais}}. {{$provincia}}, {{$partido}} </title> --}}
<title>donde.huesped.org.ar | Fundación Huésped -  <?php echo html_entity_decode($pais)." . ".html_entity_decode($provincia)." , ".html_entity_decode($partido); ?> </title>
<meta name="description" content="Ubica centros centros de salud sexual y reproductiva y dónde hacerte la prueba de VIH en <?php echo html_entity_decode($pais)." . ".html_entity_decode($provincia)." , ".html_entity_decode($partido); ?>">
<meta name="author" content="Fundación Huésped">
<link rel="canonical" href="https://www.huesped.org.ar/donde/"/>
<meta property='og:locale' content='es_LA'/>
<meta property='og:title' content='donde.huesped.org.ar | Fundación Huésped'/>
<meta property="og:description" content="Encuentra en  <?php echo html_entity_decode($pais)." . ".html_entity_decode($provincia)." , ".html_entity_decode($partido); ?> donde puedes acceder a servicios de salud sexual y reproductiva, buscar condones o preservativos gratis, ubicar centros de infectología y vacunatorios, y dónde hacerte la prueba de VIH.." />


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
           <li style="width: 120px;"><a href="" onclick="window.history.back();"> <i class="mdi-navigation-chevron-left left"></i>
           <span>{{$i18n['volver']}}</span></a></li>
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


<div class="boxLanding-seo">
	<ul class="collection">
		<li class="collection-item collection-seo">
			<div class="row valign">
				<div class="row left-align">
					<span><b class="text-seo">{{$pais}}</b> > <b class="text-seo">{{$provincia}}</b> > <b class="text-seo">{{$partido}}</b></span>
				</div>
			</div>
		</li>
		<li class="collection-item collection-seo">
			<div class="row valign ">
				<div class="Aligner-seo">
					<div class="Aligner-item Aligner-item--top"><i class="mdi-hardware-keyboard-arrow-down i-seo"></i></div>
					<div class="Aligner-item"><span><b>{{$i18n['titulo']}}</b></span></div>
				</div>
			</div>
		</li>
<div class="icon-seo">
            <div class="">
                <table class="highlight centered">
                <div class="row">
                    @foreach ($allElements as $key => $service)
                        <div class="col s6 m6 l6 grid-seo">
                            <a class="services-seo" href="{{$i18n['servicio']}}/{{$service['code']}}">
                                <div class="center promo">
                                 <img width="70px" src="../../../../../../images/{{$service['icon']}}">
                                 {{-- <img width="70px" src="/images/{{$service['icon']}}"> --}}
                                <p class="item-seo"> {{$service['title']}}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
	</ul>
</div>



@include('acerca')

@stop


