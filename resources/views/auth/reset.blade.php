@section('meta')
    <title>VAMOS | vamoslac.org</title>
    <meta name="description" content="Conocé dónde hacerte el test de VIH o dónde conseguir preservativos gratuitos.">
    <meta name="author" content="IPPF">
    <link rel="canonical" href="http://vamoslac.org"/>
    <meta property='og:locale' content='es_LA'/>
    <meta property='og:title' content='VAMOS | vamoslac.org'/>
    <meta property="og:description" content="Conoce dónde hacerte la prueba de VIH y buscar condones gratis. También encuentra los vacunatorios y centros de infectología más cercanos." />
    <meta property='og:url' content='http://vamoslac.org'/>
    <meta property='og:site_name' content='DÓNDE'/>
    <meta property='og:type' content='website'/>
    <meta property='og:image' content='http://vamoslac.org/img/icon/apple-touch-icon-152x152.png'/>
    <meta property='fb:app_id' content='459717130793708' />
    <meta name="twitter:card" content="summary">
    <meta name='twitter:title' content='VAMOS | vamoslac.org'/>
    <meta name="twitter:description" content="Conocé dónde hacerte el test de VIH o dónde conseguir preservativos gratuitos." />
    <meta name='twitter:url' content='http://vamoslac.org'/>
    <meta name='twitter:image' content='http://vamoslac.org/img/icon/apple-touch-icon-152x152.png'/>
    <meta name='twitter:site' content='@fundhuesped' />
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>
@stop
@extends('layouts.panel-master')

@section('content')

  <div class="home">
  <div class="section navigate">
      <div class="container">
        <div clas="row">
        <div class="col s12 l4">
          <form method="POST" action="../../password/reset">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="token" value="{{ $token }}">

            @if (count($errors) > 0)
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <div>
                Email
                <input type="email" name="email" value="{{ old('email') }}">
            </div>

            <div>
                Password
                <input type="password" name="password">
            </div>

            <div>
                Confirm Password
                <input type="password" name="password_confirmation">
            </div>

            <div class="row">
              <div class="valign-demo  valign-wrapper">
                <div class="valign full-width actions">
                  <button class="waves-effect waves-light btn btn-large full"
                  type="submit"><i class="mdi-action-done-all left"></i>
                    Reset Password</button>
                </div>
              </div>
            </div>
          </br>
          </div>
        </form>

      </div>
      </div>
  </div>

</div>
@stop
