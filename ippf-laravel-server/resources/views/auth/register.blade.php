@section('meta')
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
  <div class="home" ng-controller="usersController">
  <div class="section navigate row">
      <form method="POST" action="register">
         <input type="hidden" name="_token" value="{{ csrf_token() }}">

          <div>
              Nombre
              <input type="text" name="name" value="{{ old('name') }}" ng-model="newUser.name" required>
          </div>

          <div>
              Email
              <input type="email" name="email" value="{{ old('email') }}" ng-model="newUser.email" required>
          </div>
          <div>
            Roll
            <select name="roll" id="roll" class="rollSelect" ng-model="newUser.roll" material-select watch>
              <option value="administrador" required ng-selected="[[newUser.roll]]">Administrador</option>
              <option value="supervisor" ng-selected="[[newUser.roll]]">Supervisor</option>
            </select>
            <label>Roll</label>
          <div>

          <div>
              Contraseña
              <input type="password" name="password" id="password" ng-model="newUser.password" required>
          </div>

          <div>
              Confirmar Contraseña
              <input type="password" name="password_confirmation" ng-model="newUser.password_confirmation" required>
          </div>

          <div>
            <div class="row">
              <div class="valign-demo  valign-wrapper">
                <div class="valign full-width actions">
                  <button class="waves-effect waves-light btn btn-large full"
                  type="submit"><i class="mdi-action-done-all left"></i>
                  Agregar</button>
                </div>
              </div>
            </div>
          </div>

      </form>
  </div>

</div>



@stop


@section('js')

 {!!Html::script('bower_components/ngmap/build/scripts/ng-map.min.js')!!}
  {!!Html::script('scripts/panel/app.js')!!}
  {!!Html::script('scripts/panel/controllers/users/controller.js')!!}

@stop
