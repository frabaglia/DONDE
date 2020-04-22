@extends('layouts.clear')
@section('meta')

<title> @lang('site.seo_meta_placelist_title_1') <?php echo html_entity_decode($resu['titleCopySeo']);?> @lang('site.on') <?php echo html_entity_decode($pais)." . ".html_entity_decode($provincia)." , ".html_entity_decode($partido)." , ".html_entity_decode($ciudad); ?>? </title>
<meta name="description" content="@lang('site.seo_meta_description_content_2') <?php echo html_entity_decode($resu['descriptionCopy']);?> @lang('site.on') <?php echo html_entity_decode($pais)." . ".html_entity_decode($provincia)." , ".html_entity_decode($partido)." , ".html_entity_decode($ciudad); ?>">
<meta name="author" content="@lang('site.seo_meta_author_content')">
<link rel="canonical" href="@lang('site.seo_meta_canonicallink')"/>
<meta property='og:locale' content="@lang('site.seo_meta_property_local')"/>
<meta property='og:title' content="@lang('site.seo_meta_property_title')"/>
<meta property="og:description" content="@lang('site.seo_meta_placelist_title_1') <?php echo html_entity_decode($resu['descriptionCopy']);?> @lang('site.on') <?php echo html_entity_decode($pais)." . ".html_entity_decode($provincia)." , ".html_entity_decode($partido)." , ".html_entity_decode($ciudad); ?>" />

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


@if (count($places) > 0 )
  <div class="result-seo">
    <div class="Aligner">
    @if ( count($places) < 2 )
      {{$cantidad}} {{$resu['preCopyFoundSingle']}} &nbsp<b>{{$resu['newServiceTitleSingle']}}</b> &nbsp @lang('site.on') </b>
    @else
      {{$cantidad}} {{$resu['preCopyFound']}} &nbsp<b>{{$resu['newServiceTitle']}}</b> &nbsp @lang('site.on') </b>
    @endif
    </div>


    <div class="Aligner">
      <div class="Aligner-item Aligner-item--top"><img width="50px" src="/images/{{$resu['icon']}}"></div>
      <div class="Aligner-item">
        <b><span class="text-seo">{{$ciudad}}</span>, <span class="text-seo">{{$partido}}</span>, <span class="text-seo">{{$provincia}}</span></b>
      </div>
    </div>

</div>

<div class="container">
	<table class="striped" >
		<thead>
			<th>@lang('site.street_address')</th>
			<th>@lang('site.place')</th>
			<th>@lang('site.schedule')</th>
			<th>@lang('site.responsable')</th>
			<th>@lang('site.tel')</th>
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
        <i class="mdi-content-add-circle left"></i>@lang('site.suggest_place')</a>
      </div>
    </div>

@else
  <div class="result-seo">
    <div class="Aligner">
      {{$resu['titleCopyNotFound']}} &nbsp <b>{{$resu['newServiceTitle']}}</b> &nbsp @lang('site.on')
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
			<i class="mdi-action-search left"></i>@lang('site.seo_placeslist_new_search')/a>
		</div>

		<div class="centrada-seo">
			<a href="{{ url('/form') }}" class="waves-effect waves-light btn btn-seo">
				<i class="mdi-navigation-chevron-right right"></i>
				<i class="mdi-content-add-circle left"></i>@lang('site.suggest_place')</a>
			</div>
		</div>
@endif


@include('acerca')

@stop
