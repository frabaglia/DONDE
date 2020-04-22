@extends('layouts.master')
@section('meta')
<title>Sugiere un Nuevo Centro - @lang('site.page_title')</title>
<meta name="google-site-verification" content="RQh3eES_sArPYfFybCM87HsV6mbwmttWlAIk-Upf1EQ" />
<meta name="description" content="@lang('site.seo_meta_description_content')">
<meta name="author" content="IPPF">
<link rel="canonical" href="https://vamoslac.org/"/>
<meta property='og:locale' content='es_LA'/>
<meta property='og:title' content="@lang('site.page_title')" />
<meta property="og:description" content="@lang('site.seo_meta_description_content')" />
<meta property='og:url' content=''/>
<meta property='og:site_name' content='VAMOS'/>
<meta property='og:type' content="@lang('site.page_title')" />
<meta property='og:image' content='https://vamoslac.org/og.png'/>
<meta property='fb:app_id' content='1964173333831483' />
<meta name="twitter:card" content="summary">
<meta name='twitter:title' content="@lang('site.page_title')" />
<meta name="twitter:description" content="@lang('site.seo_meta_description_content')" />
<meta name='twitter:url' content='"https://vamoslac.org/'/>
<meta name='twitter:image' content='https://vamoslac.org/og.png'/>
<meta name='twitter:site' content='@vamoslac' />

<link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>
@stop

@section('content')
<div ng-app="dondev2App">

  <nav>

    <div class="nav-wrapper">

      <a href="{{ url('/#/') }}" class="brand-logo">
        <img class="logoTop" src="images/logo_blanco.svg">
      </a>

      <a href="#" data-activates="mobile-demo" class="button-collapse">
        <i class="mdi-navigation-menu"></i></a>

    </div>

  </nav>

    <div class="home new-home" ng-controller="formController">

     <!-- Terms & Conditions -->

     <div class="row">

			<div class="col s6 m6 center-align">

				<a href='https://www.ippfwhr.org/' target="_blank">
					<img src="images/logo_ippf.png" width="50%" />
				</a>

			</div>

			<div class="col s6 m6 center-align  ">

				<a href='https://www.huesped.org.ar/' target="_blank">
					<img src="images/logo_huesped.png" width="40%" />
				</a>

			</div>

			<br />
			<br />
			<br />

			<h4 id="menu" translate="tyc_title"> </h4>

			<br/>

			<p translate="tyc_description_1"></p>
			<p translate="tyc_description_2"></p>
			<p translate="tyc_description_3"></p>
			<p translate="tyc_description_4"></p>
			<p translate="tyc_description_5"></p>
			<p translate="tyc_description_6"></p>
			<p translate="tyc_description_7"></p>
			<p><span translate="tyc_description_8"></span>
			  <a href="mailto:vamoslacapp@gmail.com" rel="external" target="_blank" class="ui-link" translate="about_description6_add_info"></a>
			</p>


		</div>
	</div>

</div>

@stop

@section('js')
<script
src="https://www.google.com/recaptcha/api.js?hl=es-419&onload=vcRecaptchaApiLoaded&render=explicit"
async defer
></script>
{!!Html::script('bower_components/materialize/dist/js/materialize.min.js')!!}
{!!Html::script('bower_components/ngmap/build/scripts/ng-map.min.js')!!}
{!!Html::script('bower_components/angular-recaptcha/release/angular-recaptcha.min.js')!!}
{!!Html::script('bower_components/angular-translate/angular-translate.js')!!}
{!!Html::script('scripts/translations/es.js')!!}
{!!Html::script('scripts/translations/en.js')!!}
{!!Html::script('scripts/translations/br.js')!!}

{!!Html::script('scripts/form/app.js')!!}
{!!Html::script('scripts/form/controllers/form/controller.js')!!}
{!!Html::script('scripts/home/services/places.js')!!}

@stop
