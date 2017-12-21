@extends('layouts.clear')

@section('meta')

{{-- <title>@lang('site.seo_meta_property_title') -  {{$pais}}. {{$provincia}}, {{$partido}}, {{ciudad}} </title> --}}
{{-- <title>@lang('site.seo_meta_property_title') -  <?php echo html_entity_decode($pais)." . ".html_entity_decode($provincia)." , ".html_entity_decode($partido)." , ",html_entity_decode($ciudad) ; ?> </title> --}}
<title>VAMOS | vamoslac.org</title>
<meta name="description" content="@lang('site.seo_meta_property_description_4') <?php echo html_entity_decode($pais)." . ".html_entity_decode($provincia)." , ".html_entity_decode($partido)." , ".html_entity_decode($ciudad); ?>">
<meta name="author" content="@lang('site.seo_meta_author_content')">
<link rel="canonical" href="@lang('site.seo_meta_canonicallink')"/>
<meta property='og:locale' content="@lang('site.seo_meta_property_local')"/>
<meta property='og:title' content="@lang('site.seo_meta_property_title')"/>
<meta property="og:description" content="@lang('site.seo_meta_property_description_2') <?php echo html_entity_decode($pais)." . ".html_entity_decode($provincia)." , ".html_entity_decode($partido)." , ".html_entity_decode($ciudad); ?> @lang('site.seo_meta_property_description_3')" />

@stop

@section('content')

 <nav>

    <div class="nav-wrapper">

      <a href="{{ url('/#/') }}" class="brand-logo"><img class="logoTop" src="/images/logo_blanco.svg"> </a>

      <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="mdi-navigation-menu"></i></a>

      <ul class="right hide-on-med-and-down">

           <li><a class="modal-trigger" href="#modal"><i class="mdi-action-info"></i></a></li>

           <li><a class="modal-trigger" href="/#/localizar/all/listado"><i class="mdi-maps-place left"></i></a></li>

           <li><a class="" href="/form"><i class="mdi-content-add-circle-outline"></i></a></li>

           <li><a class="" href="/listado-paises"><i class="mdi-action-language"></i></a></li>

      </ul>

      <ul ng-show="navigating"  class="left wow fadeIn nav-wrapper">

           <li style="width: 120px;"><a href="" onclick="window.history.back();"> <i class="mdi-navigation-chevron-left left"></i>
           <span>@lang('site.seo_countries_nav_comeback')</span></a></li>

      </ul>

      <ul class="side-nav" id="mobile-demo">

          <li><a href="#/acerca">
            <i class="mdi-action-info left"></i>@lang('site.information')
            </a>
          </li>

          <li><a href="#/localizar/all/listado">
            <i class="mdi-maps-place left"></i>@lang('site.closer')</a>
          </li>

          <li><a href="form">
            <i class="mdi-content-add-circle-outline left"></i>
            @lang('site.suggest_place')</a>
          </li>

      </ul>

    </div>

  </nav>

<div class="boxLanding-seo">

	<ul class="collection">

		<li class="collection-item collection-seo">

			<div class="row valign">

				<div class="row left-align">

					<span>

            <b class="text-seo">{{$pais}}</b> > 
            <b class="text-seo">{{$provincia}}</b> > 
            <b class="text-seo">{{$partido}}</b> >
            <b class="text-seo">{{$ciudad}}</b>

          </span>

				</div>

			</div>

		</li>

		<li class="collection-item collection-seo">

			<div class="row valign ">

				<div class="Aligner-seo">

					<div class="Aligner-item Aligner-item--top"><i class="mdi-hardware-keyboard-arrow-down i-seo"></i></div>

					<div class="Aligner-item"><span><b>@lang('site.seo_services_whatareyoulookingfor_label')</b></span></div>

				</div>

			</div>

		</li>

    <div class="icon-seo">

      <div class="">

        <table class="highlight centered">

          <div class="row">

            @foreach ($allElements as $key => $service)
            <div class="col s6 m6 l6 grid-seo">

              <a class="services-seo" href="servicio/{{$service['code']}}">

                <div class="center promo">
                 <img width="70px" src="../../../../../../../../resume/images/{{$service['icon']}}">
                 {{-- <img width="70px" src="/images/{{$service['icon']}}"> --}}
                 <p class="item-seo">@lang($service['title'])</p>
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
