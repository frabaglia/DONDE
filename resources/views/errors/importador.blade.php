@extends('layouts.panel-master')
@section('meta')
<title>VAMOS | vamoslac.org</title>
<meta name="description" content="Conocé dónde hacerte el test de VIH o dónde conseguir preservativos gratuitos.">
<meta name="author" content="VAMOS">
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

@section('content')

<div >
	<div class="home no-page valign-demo valign-wrapper">
		<div class="row valign full-width">
			<div class="col s12">
			<br>
				<h1> No hemos podido hacer la importación de tu archivo.</h1>
				<h6>{{ $exception->getMessage() }}</h6>
				</div>	
				<div class="row">
			        <div class="col s5">
			          <strong> <span>&#8203;</span> </strong>
			        </div>
			         <div class="col s2">

			      <a  href="" onclick="window.history.go(-1); return false;" class="waves-effect waves-light btn btn-small red">
			        
			        <i class="mdi-hardware-keyboard-backspace left"></i>
			        <span translate=""> Volver</span>
			      </a>

			    </div>

			</div>

		</div>
	</div>
</div>
</div>
</div>

</div>
</div>

@stop


@section('js')

@stop
