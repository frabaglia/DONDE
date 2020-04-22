@extends('layouts.master')
@section('meta')
<div ng-app="dondeDataVizApp">

<title>VAMOS | vamoslac.org</title>
<meta name="google-site-verification" content="7Myd-74iCkDjnz5HEK2-iF7gNuDUL8TMmkg6DiwxsZc" />
<meta name="description" content="@lang('site.seo_meta_description_content')">
<meta name="author" content="@lang('site.seo_meta_author_content')">
<link rel="canonical" href="@lang('site.seo_meta_canonicallink')">
<meta property='og:locale' content="@lang('site.seo_meta_property_local')">
<meta property='og:title' content="@lang('site.seo_meta_property_title')">
<meta property="og:description" content="@lang('site.seo_meta_property_description')" >
<!--base href="./../"-->
@stop

@section('content')
<link rel="stylesheet" href="resume/styles/resume.css">
  <div ng-controller="countryListController">

  </div>

  @include('navbar')

  <div class="container home new-home ">

      <div class = "container " ng-view></div>

  </div>
@include('acerca')
</div>

@stop



@section('js')

  <!-- build:js(.) scripts/vendor.js -->
  <!-- bower:js -->
  <script src="https://rawgit.com/allenhwkim/angularjs-google-maps/master/build/scripts/ng-map.js"></script>
  <script src="bower_components/angular-translate/angular-translate.js"></script>
  <script src="scripts/translations/es.js"></script>
  <script src="scripts/translations/br.js"></script>
  <script src="scripts/translations/en.js"></script>
  <script src="bower_components/moment/moment.js"></script>
  <script src="bower_components/angular-moment/angular-moment.js"></script>
  <script src="bower_components/odometer/odometer.js"></script>
  <script src="bower_components/angular-odometer-js/dist/angular-odometer.js"></script>
  <script src="bower_components/angular-socialshare/angular-socialshare.js"></script>
  <script src="bower_components/smooth-scroll/dist/js/smooth-scroll.min.js"></script>
  <!-- endbower -->
  <!-- endbuild -->

  <!-- build:js({.tmp,app}) scripts/scripts.js -->
  <script src="resume/scripts/app.js"></script>
  <script src="scripts/home/app.js"></script>
  <script src="resume/scripts/controllers/home.js"></script>
  <script src="resume/scripts/controllers/country.js"></script>
  <script src="resume/scripts/controllers/province.js"></script>
  <script src="resume/scripts/controllers/party.js"></script>
  <script src="resume/scripts/controllers/service.js"></script>
  <script src="resume/scripts/controllers/place.js"></script>
  <script src="resume/scripts/controllers/country-list.js"></script>
  <!-- endbuild -->

@stop
