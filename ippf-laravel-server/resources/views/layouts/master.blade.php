<!DOCTYPE html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='https://fonts.googleapis.com/css?family=Ultra' rel='stylesheet' type='text/css'>
    {{-- <link rel="stylesheet" href="bower_components/angucomplete-alt/angucomplete-alt.css"/> --}}

<head>
    <meta charset="utf-8" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
      @yield('meta')

    {!!Html::style('bower_components/angucomplete/angucomplete.css')!!}
    {!!Html::style('bower_components/angucomplete-alt/angucomplete-alt.css')!!}
    {!!Html::style('bower_components/materialize/dist/css/materialize.min.css')!!}
    {{-- <link rel="stylesheet" href="bower_components/materialize/dist/css/materialize.min.css"> --}}
    {!!Html::style('bower_components/font-awesome/css/font-awesome.min.css')!!}
    {{-- <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css"> --}}
    {!!Html::style('bower_components/wow.js/css/libs/animate.css')!!}
    {{-- <link rel="stylesheet" href="bower_components/wow.js/css/libs/animate.css"/> --}}
    {!!Html::style('styles/main.min.css')!!}
    {{-- <link rel="stylesheet" href="styles/main.min.css"> --}}
    {!!Html::style('css/adhoc.css')!!}
     {{-- <link rel="stylesheet" href="css/adhoc.css"> --}}
    

    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
    <!-- Icons -->
  <link rel='shortcut icon' href='https://www.huesped.org.ar/testimonios/assets/img/favicon.png'>


</head>
<body>


  <main>

  @yield('content')
  </main>


  {{-- <script src="https://maps.google.com/maps/api/js?key=AIzaSyACdNTXGb7gdYwlhXegObZj8bvWtr-Sozc"></script> --}}
  <script src="https://maps.google.com/maps/api/js?key=AIzaSyBoXKGMHwhiMfdCqGsa6BPBuX43L-2Fwqs"></script>
  {!!Html::script('bower_components/jquery/dist/jquery.js')!!}
  {!!Html::script('bower_components/underscore/underscore-min.js')!!}
  {!!Html::script('bower_components/materialize/bin/materialize.js')!!}
  {!!Html::script('bower_components/moment/min/moment-with-locales.min.js')!!}
  {!!Html::script('bower_components/angular/angular.min.js')!!}
  {!!Html::script('bower_components/angular-materialize/src/angular-materialize.js')!!}
  {!!Html::script('bower_components/angular-route/angular-route.min.js')!!}
  {!!Html::script('bower_components/angular-sanitize/angular-sanitize.min.js')!!}
  {!!Html::script('bower_components/angular-cookies/angular-cookies.min.js')!!}
  {!!Html::script('bower_components/wow.js/dist/wow.min.js')!!}
  {!!Html::script('bower_components/angucomplete/angucomplete.js')!!}

  @yield('js')
  @include('analytics')

</body>
</html>
