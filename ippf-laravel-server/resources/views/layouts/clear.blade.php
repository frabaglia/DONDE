<!DOCTYPE html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>VAMOS | vamoslac.org</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="format-detection" content="telephone=no">

  @yield('meta')

  <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
  <link href='https://fonts.googleapis.com/css?family=Ultra' rel='stylesheet' type='text/css'>

  {!!Html::style('bower_components/materialize/bin/materialize.css')!!}
  {!!Html::style('bower_components/wow.js/css/libs/animate.css')!!}
  {!!Html::style('styles/main.min.css')!!}
  
</head>
<body>
  <main>
  	@yield('content')
  </main>
    @include('analytics')
 </body>
   @yield('js')
</html>
