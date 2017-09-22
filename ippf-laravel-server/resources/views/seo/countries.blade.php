@extends('layouts.master')
@section('meta')

<title>@lang('site.seo_countries_headertitle')</title>
<meta name="google-site-verification" content="RQh3eES_sArPYfFybCM87HsV6mbwmttWlAIk-Upf1EQ" />
<meta name="description" content="@lang('site.seo_meta_description_content')">
<meta name="author" content="@lang('site.seo_meta_author_content')">
<link rel="canonical" href="@lang('site.seo_meta_canonicallink')"/>
<meta property='og:locale' content="@lang('site.seo_meta_property_local')"/>
<meta property='og:title' content="@lang('site.seo_meta_property_title')"/>
<meta property="og:description" content="@lang('site.seo_meta_property_description')" />


@stop

@section('content')

{{-- <nav>
	<div class="nav-wrapper">
		<ul id="nav-mobile" class="left hide-on-med-and-down">
	        <li><a href="{{ url('/#/') }}"> <i class="mdi-navigation-chevron-left right"></i></a></li>
	        <li>@lang('site.seo_countries_nav_init')</li>
	    </ul>
		<a href="{{ url('/#/') }}" class="brand-logo">
		<img class="logoTop" src="/images/logo_blanco.svg"> </a>
	</div>
</nav>

 --}}

    <nav>
    <div class="nav-wrapper">
      <a href="{{ url('/#/') }}" class="brand-logo"><img class="logoTop" src="images/logo_blanco.svg"> </a>
      <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="mdi-navigation-menu"></i></a>
      <ul class="right hide-on-med-and-down">
           <li><a class="modal-trigger" href="#modal1"><i class="mdi-action-info"></i></a></li>
           <li><a class="modal-trigger" href="/#/localizar/all/listado"><i class="mdi-maps-place left"></i></a></li>
           <li><a class="" href="/form"><i class="mdi-content-add-circle-outline"></i></a></li>
           <li><a class="" href="/listado-paises"><i class="mdi-action-language"></i></a></li>
      </ul>

      <ul ng-show="navigating"  class="left wow fadeIn nav-wrapper">
           <li style="width: 120px;"><a href="" onclick="window.history.back();"> <i class="mdi-navigation-chevron-left left"></i><span>@lang('site.seo_countries_nav_comeback')</span></a></li>
      </ul>

      <ul class="side-nav" id="mobile-demo">
          <li><a href="#/acerca">
            <i class="mdi-action-info left"></i>@lang('site.information')
            </a>
          </li>
          <li><a href="#/localizar/all/listado">
            <i class="mdi-maps-place left"></i>@lang('site.closer')</a></li>
          <li><a href="form">
            <i class="mdi-content-add-circle-outline left"></i>
            @lang('site.suggest_place')</a>
          </li>

      </ul>
    </div>
  </nav>
<div ng-app="dondeDataVizApp">
    <div class="container"> 
        <div ng-view></div>
    </div>
</div>





@include('acerca')


@stop

@section('js')
 

    <!-- build:js(.) scripts/vendor.js -->
    <!-- bower:js -->
    <script src="https://rawgit.com/allenhwkim/angularjs-google-maps/master/build/scripts/ng-map.js"></script>
    <script src="https://maps.google.com/maps/api/js?key=AIzaSyCjb5c-5XvzhvdMXCjIjNaK-Zdh-L_qVmM"></script>
    <script src="/bower_components/angular-translate/angular-translate.js"></script>
    <script src="/scripts/translations/es.js"></script>
    <script src="/scripts/translations/br.js"></script>
    <script src="/scripts/translations/en.js"></script>
  

    <script src="/bower_components/moment/moment.js"></script>
    <script src="/bower_components/angular-moment/angular-moment.js"></script>
    <script src="/bower_components/odometer/odometer.js"></script>
    <script src="/bower_components/angular-odometer-js/dist/angular-odometer.js"></script>
    <script src="/bower_components/angular-socialshare/angular-socialshare.js"></script>
    <script src="/bower_components/smooth-scroll/dist/js/smooth-scroll.min.js"></script>
    
    <!-- endbower -->
    <!-- endbuild -->

    <!-- build:js({.tmp,app}) scripts/scripts.js -->
    <script src="/resume/scripts/app.js"></script>
    <script src="/resume/scripts/controllers/home.js"></script>
    <!-- endbuild -->
@stop
