@section('meta')
<div ng-app="dondeDataVizApp">
    <title>VAMOS | vamoslac.org</title>
    <meta name="description" content="Conocé dónde hacerte el test de VIH o dónde conseguir preservativos gratuitos.">
    <meta name="author" content="VAMOS">
    <link rel="canonical" href="http://vamoslac.org"/>
    <meta property='og:locale' content='es_LA'/>
    <meta property='og:title' content='VAMOS | vamoslac.org'/>
    <meta property="og:description" content="Conoce dónde hacerte la prueba de VIH y buscar condones gratis. También encuentra los vacunatorios y centros de infectología más cercanos." />
    <meta property='og:url' content='http://vamoslac.org'/>
    <meta property='og:site_name' content='VAMOS'/>
    <meta property='og:type' content='website'/>
    <meta property='og:image' content='http://vamoslac.orgimg/icon/apple-touch-icon-152x152.png'/>
    <meta property='fb:app_id' content='459717130793708' />
    <meta name="twitter:card" content="summary">
    <meta name='twitter:title' content='VAMOS | vamoslac.org'/>
    <meta name="twitter:description" content="Conocé dónde hacerte el test de VIH o dónde conseguir preservativos gratuitos." />
    <meta name='twitter:url' content='http://vamoslac.org'/>
    <meta name='twitter:image' content='http://vamoslac.orgimg/icon/apple-touch-icon-152x152.png'/>
    <meta name='twitter:site' content='@fundhuesped' />
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>
@stop
@extends('layouts.panel-master')

@section('content')

  <div class="home">
  <div class="section navigate">
      <div class="container">
        <div clas="row">
        <div class="col s12 m12 l12">
        <form method="POST" action="login">
           <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div>
                <span translate="email"></span>
                <input type="email" name="email" value="{{ old('email') }}">
            </div>

            <div>
                <span translate="password"></span>
                <input type="password" name="password" id="password">
            </div>

            <div>
              <div class="row">
                <div class="valign-demo  valign-wrapper">
                  <div class="valign full-width actions">
                    <button class="waves-effect waves-light btn btn-large full"
                    type="submit" ><i class="mdi-action-perm-identity left"></i><span translate="login"></span></button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
        <a href='{{url("password/email")}}' translate="forget_pass"></a>
      </div>
      </div>
  </div>

</div>
</div>
@stop


@section('js')
 {!!Html::script('bower_components/materialize/dist/js/materialize.min.js')!!}
  {!!Html::script('bower_components/ngmap/build/scripts/ng-map.min.js')!!}
    {!!Html::script('resume/scripts/app.js')!!}

@stop
