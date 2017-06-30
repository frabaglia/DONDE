<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class SeoController extends Controller {

	public function showServices($pais,$provincia,$partido)
	{
		//info para la vista de services
		
		$i18n = $this->getServiceCopy();
		


		$servicio1 = array('icon' => 'iconos-new_preservativos-3.png',
							'title' => 'Condones',
							'code' => 'condones',
							'content'=>'Encuentra los lugares más cercanos para retirar condones gratis.');

		$servicio2 = array('icon' => 'iconos-new_analisis-3.png',
							'title' => 'Prueba VIH',
							'code' => 'prueba',
							'content' => 'Encuentra los lugares más cercanos que realizan la prueba de VIH de manera gratuita.');
		
		$servicio3 = array('icon' => 'iconos-new_vacunacion-3.png',
							'title' => 'Vacunatorios',
							'code' => 'vacunatorio',
							'content' => 'Encuentra los vacunatorios más cercanos, sus horarios de atención e información de contacto.');
	
		$servicio4 = array('icon' => 'iconos-new_atencion-3.png',
							'title' => 'Centros de Infectología',
							'code' => 'infectologia',
							'content' => 'Encuentra los centros de infectología más cercanos, sus horarios de atención e información de contacto.');

		$servicio5 = array('icon' => 'iconos-new_sssr-3.png',
							'title' => 'Servicios de Salud Sexual y Reproductiva',
							'code' => 'mac',
							'content' => 'Tienes derecho a recibir gratuitamente, con respeto y privacidad, información clara y el método anticonceptivo que elijas: Preservativos, pastillas e inyección anticonceptiva, anticoncepción de emergencia, implante subdérmico, DIU, ligadura de trompas y vasectomía.');

		$servicio6 = array('icon' => 'iconos-new_ile-3.png',
							'title' => 'Interrupcion Legal del Embarazo',
							'code' => 'ile',
							'content' => 'Tienes derecho a recibir información para decidir frente a un embarazo. 
En Argentina la interrupción del embarazo es legal cuando está en riesgo tu vida o tu salud (física, mental o social) o cuando el embarazo es producto de una violación.
Más información: https://www.huesped.org.ar/
');



		$allElements = [$servicio1 , $servicio2 , $servicio3, $servicio4, $servicio5, $servicio6];
		        
		return view('seo.services',compact('pais','provincia','partido','allElements','i18n'));
	
	}

	/**
     * Set global lang value and return the setStateKeyWords for the first view
     *
     * @param  null
     * @return array with key=>value
     */ 
      public function getServiceCopy(){
        return $this->setServiceKeyWords(session()->get('lang'));
     }

     /**
     * map global lang and their keywords
     *
     * @param  string langValue
     * @return array with key=>value
     */ 
     public function setServiceKeyWords($lang){
      $result = "";
      switch ($lang){
         case "br":
            $result = [
               "pais" => "pais",
               "provincia" => "provincia",
               "partido" => "cidade",
               "servicio" => "serviço",
               "titulo" => "O que você está buscando?",
               "volver" => "br"
            ];
         break;
         case "en":
            $result = [
               "pais" => "country",
               "provincia" => "state",
               "partido" => "city",
               "servicio" => "service",
               "titulo" => "What are you looking for?",
               "volver" => "Return"
            ];
         break;        
         default:
            $result = [
               "pais" => "pais",
               "provincia" => "provincia",
               "partido" => "partido",
               "servicio" => "servicio",
               "titulo" => "¿Qué estás buscando?",
               "volver" => "Volver"
            ];
         break;
      }
      return $result;
   }



	public function index()
	{
		echo "SEO";
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}



}
