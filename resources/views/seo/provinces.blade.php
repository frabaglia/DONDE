@extends('layouts.clear')
@section('meta')


<title>@lang('site.seo_meta_property_title') -  <?php echo html_entity_decode($pais); ?> </title>
<meta name="description" content="@lang('site.seo_meta_property_description_4') <?php echo html_entity_decode($pais); ?>">
<meta name="author" content="@lang('site.seo_meta_author_content')">
<link rel="canonical" href="@lang('site.seo_meta_canonicallink')"/>
<meta property='og:locale' content="@lang('site.seo_meta_property_local')"/>
<meta property='og:title' content="@lang('site.seo_meta_property_title')"/>
<meta property="og:description" content="@lang('site.seo_meta_property_description_2') <?php echo html_entity_decode($pais); ?> @lang('site.seo_meta_property_description_3')" />


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
      <a href="{{ url('/#/') }}" class="brand-logo"><img class="logoTop" src="/images/logo_blanco.svg"> </a>
      <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="mdi-navigation-menu"></i></a>
      <ul class="right hide-on-med-and-down">
           <li><a class="modal-trigger" href="#modal"><i class="mdi-action-info"></i></a></li>
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


<div class="boxLanding">
  <ul class="collection">
    <!-- Header Tabble -->
    <li class="collection-item collection-seo">
      <div class="row valign">
        <div class="row left-align">
          <span class="distanceLanding"><b class="text-seo">{{$pais}}</b></span>
        </div>
      </div>
    </li>
    <li class="collection-item collection-seo">
      <div class="row valign">
        <div class="row left-align">
          <i class="mdi-hardware-keyboard-arrow-down i-seo"></i> <span class="distanceLanding"><b>@lang('site.select_state')</b></span>
        </div>
      </div>
    </li>
    <div class="palcesLanding">
      <div class="container">
        <table class="highlight left">
          <tbody>
            @foreach ($provinces as $p)
            <tr>
              <td ><a class="item-seo" href="provincia/{{$p->nombre_provincia}}/partido">{{$p->nombre_provincia}}</a></td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </ul>
</div>

@include('acerca')

@stop
