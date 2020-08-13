<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

use App\Evaluation;
use App\Pais;
use App\Provincia;
use App\Places;
use Validator;
use DB;
use Auth;

class EvaluationRESTController extends Controller {

	public function stats($countryName){
		$countryName = iconv('UTF-8','ASCII//TRANSLIT',$countryName);
		$countryName = strtolower($countryName);

		$dataSet = DB::select('select t1.disponibles as totalPlaces, IFNULL(t2.evaluados,0) as countEvaluatedPlaces, (t1.disponibles - IFNULL(t2.evaluados,0)) as countNotevaluatedPlaces, t1.provincia as nombreProvincia, t1.id idProvincia, t1.nombre_pais
			from
			(select
			count(distinct places.placeId) as disponibles,
			0 as evaluados,
			provincia.nombre_provincia as provincia,
			provincia.id as id,
			pais.nombre_pais as nombre_pais
			from provincia
			inner join pais on provincia.idPais = pais.id
			left join places on places.idProvincia = provincia.id
			group by idprovincia
			) t1
			left join
			(select
			0 as disponibles,
			count(distinct places.placeId) as evaluados,
			provincia.nombre_provincia as provincia,
			provincia.id as id,
			pais.nombre_pais as nombre_pais
			from provincia
			inner join pais on provincia.idPais = pais.id
			left join places on places.idProvincia = provincia.id
			inner join evaluation on evaluation.idPlace = places.placeId
			group by idprovincia

			) t2
			on
			t1.id = t2.id
			where t1.nombre_pais = "'. $countryName .'"');

		$totalPlaces = 0;
		$totalEvaluatedPlaces = 0;
		foreach ($dataSet as $provincia) {
			$totalEvaluatedPlaces += $provincia->countEvaluatedPlaces;
			$totalPlaces += $provincia->totalPlaces;
		}

		foreach ($dataSet as $provincia) {
			$provincia->{"porcentaje"} = 	$provincia->countEvaluatedPlaces * 100 / $totalEvaluatedPlaces;
		}

		return array("totalPlaces" => $totalPlaces, "totalEvaluatedPlaces" => $totalEvaluatedPlaces, "totalNotEvaluatedPlaces" => $totalPlaces - $totalEvaluatedPlaces, "placesCountArray" => $dataSet);
	}


	public function getCopies($id){
		return DB::table('places')->where('placeId',$id)->select('places.establecimiento')->get();
	}

	public function block($id){
		$evaluation = Evaluation::find($id);

		$evaluation->aprobado = 0;

		$evaluation->updated_at = date("Y-m-d H:i:s");
		$evaluation->save();

		$place = Places::find($evaluation->idPlace);
		$place->cantidad_votos = $this->countEvaluations($evaluation->idPlace);
		$place->rate = $this->getPlaceAverageVote($evaluation->idPlace);
		$place->rateReal = $this->getPlaceAverageVoteReal($evaluation->idPlace);
		$place->save();

		return [];
	}

	public function approve($id){

		$evaluation = Evaluation::find($id);

		$evaluation->aprobado = 1;

		$evaluation->updated_at = date("Y-m-d H:i:s");
		$evaluation->save();

		$place = Places::find($evaluation->idPlace);
		$place->cantidad_votos = $this->countEvaluations($evaluation->idPlace);
		$place->rate = $this->getPlaceAverageVote($evaluation->idPlace);
		$place->rateReal = $this->getPlaceAverageVoteReal($evaluation->idPlace);
		$place->save();

		return [];
	}

	function convertToArray($data){
		if ($data instanceof Collection)
			$data = $data->toArray();
		else if(!is_array($data))
			$data = (array) $data;
		return $data;
	}

	public function countEvaluations($id){
		return DB::table('evaluation')
		->join('places', 'places.placeId', '=', 'evaluation.idPlace')
		->where('evaluation.aprobado',1)
		->where('evaluation.idPlace',$id)
		->count();
	}

	public function countAllEvaluations($id){
		return DB::table('evaluation')
		->join('places', 'places.placeId', '=', 'evaluation.idPlace')
		->where('evaluation.idPlace',$id)
		->count();
	}

	public function showEvaluations($id){

		$data = Evaluation::join('places', 'places.placeId', '=', 'evaluation.idPlace')
		->where('evaluation.aprobado',1)
		->where('evaluation.idPlace',$id)
		->select('places.placeId','places.establecimiento', 'evaluation.comentario',
			'evaluation.que_busca', 'evaluation.service', 'evaluation.voto', 'evaluation.updated_at',
			'evaluation.reply_admin', 'evaluation.reply_date', 'evaluation.reply_content')
		->get();
		return json_encode($data);
	}

	public function showPanelEvaluations($id){ // evaluaciones para un id de establecimiento
		$evaluations = DB::table('evaluation')
		->join('places','evaluation.idPlace','=','places.placeId')
		->join('pais','pais.id','=','places.idPais')
		->join('provincia','provincia.id','=','places.idProvincia')
		->join('partido','partido.id','=','places.idPartido')
		->join('ciudad', 'ciudad.id', '=', 'places.idCiudad')
		->select('evaluation.*','places.*', DB::raw('CONCAT(places.calle," ",places.altura) as direccion'),'ciudad.nombre_ciudad','partido.nombre_partido','provincia.nombre_provincia','pais.nombre_pais','evaluation.id as id_evaluacion','evaluation.created_at as fechaEvaluacion', 'evaluation.aprobado as aprobadoEval')
		->where('places.placeId',$id)
		->select('evaluation.*')
		->get();
		return $evaluations;
	}

	public function showPanelServiceEvaluations($id){ // evaluaciones para un id de servicio
		$evaluations = DB::table('evaluation')
		->join('places','evaluation.idPlace','=','places.placeId')
		->join('pais','pais.id','=','places.idPais')
		->join('provincia','provincia.id','=','places.idProvincia')
		->join('partido','partido.id','=','places.idPartido')
		->join('ciudad', 'ciudad.id', '=', 'places.idCiudad')
		->select('evaluation.*','places.*', DB::raw('CONCAT(places.calle," ",places.altura) as direccion'),'ciudad.nombre_ciudad','partido.nombre_partido','provincia.nombre_provincia','pais.nombre_pais','evaluation.id as id_evaluacion','evaluation.created_at as fechaEvaluacion', 'evaluation.aprobado as aprobadoEval')
		->where('evaluation.service',$id)
		->get();
		return $evaluations;
	}

	public function showAllEvaluations(){ // todas las evaluaciones
		$evaluations = DB::table('evaluation')
		->join('places','evaluation.idPlace','=','places.placeId')
		->join('pais','pais.id','=','places.idPais')
		->join('provincia','provincia.id','=','places.idProvincia')
		->join('partido','partido.id','=','places.idPartido')
		->join('ciudad', 'ciudad.id', '=', 'places.idCiudad')
		->select('evaluation.*','places.*', DB::raw('CONCAT(places.calle," ",places.altura) as direccion'),'ciudad.nombre_ciudad','partido.nombre_partido','provincia.nombre_provincia','pais.nombre_pais','evaluation.id as id_evaluacion','evaluation.created_at as fechaEvaluacion', 'evaluation.aprobado as aprobadoEval')
		->get();
		return $evaluations;			
	}

	public function showAllEvaluationsByState($a){ // todas las evaluaciones aprobadas o desaprobadas
		$evaluations = DB::table('evaluation')
		->join('places','evaluation.idPlace','=','places.placeId')
		->join('pais','pais.id','=','places.idPais')
		->join('provincia','provincia.id','=','places.idProvincia')
		->join('partido','partido.id','=','places.idPartido')
		->join('ciudad', 'ciudad.id', '=', 'places.idCiudad')
		->select('evaluation.*','places.*', DB::raw('CONCAT(places.calle," ",places.altura) as direccion'),'ciudad.nombre_ciudad','partido.nombre_partido','provincia.nombre_provincia','pais.nombre_pais','evaluation.id as id_evaluacion','evaluation.created_at as fechaEvaluacion', 'evaluation.aprobado as aprobadoEval')
		->where('evaluation.aprobado', $a)
		->get();
		return $evaluations;
	}

	public function showEvaluationsByPlaces($places){	// evaluaciones para establecimientos dados
		$places = $this->convertToArray($places);
		$ids = [];
		foreach ($places as $key => $value) {
			array_push($ids,$value['placeId']);
		}

		$evaluations = DB::table('evaluation')
		->join('places','evaluation.idPlace','=','places.placeId')
		->join('pais','pais.id','=','places.idPais')
		->join('provincia','provincia.id','=','places.idProvincia')
		->join('partido','partido.id','=','places.idPartido')
		->join('ciudad', 'ciudad.id', '=', 'places.idCiudad')
		->select('evaluation.*','places.*', DB::raw('CONCAT(places.calle," ",places.altura) as direccion'),'ciudad.nombre_ciudad','partido.nombre_partido','provincia.nombre_provincia','pais.nombre_pais','evaluation.id as id_evaluacion','evaluation.created_at as fechaEvaluacion', 'evaluation.aprobado as aprobadoEval')
		->whereIn('evaluation.idPlace', $ids)
		->get();
		return $evaluations;
	}

	public function showEvaluationsPlaceByServices($placeId, $services){ // evaluaciones para un establecimiento y servicios seleccionados
		$evaluations = DB::table('evaluation')
		->join('places','evaluation.idPlace','=','places.placeId')
		->join('pais','pais.id','=','places.idPais')
		->join('provincia','provincia.id','=','places.idProvincia')
		->join('partido','partido.id','=','places.idPartido')
		->join('ciudad', 'ciudad.id', '=', 'places.idCiudad')
		->select('evaluation.*','places.*', DB::raw('CONCAT(places.calle," ",places.altura) as direccion'),'ciudad.nombre_ciudad','partido.nombre_partido','provincia.nombre_provincia','pais.nombre_pais','evaluation.id as id_evaluacion','evaluation.created_at as fechaEvaluacion', 'evaluation.aprobado as aprobadoEval')
		->where('places.placeId',$placeId)
		->whereIn('evaluation.service', $services)
		->get();
		return $evaluations;
	}

	public function getPlaceAverageVote($id){
		$resu =  Evaluation::where('idPlace',$id)
		->where('aprobado', '=', '1')
		    // ->select(array('evaluation.*', DB::raw('AVG(voto) as promedio') ))
		->select(DB::raw('AVG(voto) as promedio'))
		->orderBy('promedio', 'DESC')
		->get('promedio');

		return round($resu[0]->promedio,0,PHP_ROUND_HALF_UP);
	}

	public function getPlaceAverageVoteReal($id){
		$resu =  Evaluation::where('idPlace',$id)
		->where('aprobado', '=', '1')
		    // ->select(array('evaluation.*', DB::raw('AVG(voto) as promedio') ))
		->select(DB::raw('AVG(voto) as promedio'))
		->orderBy('promedio', 'DESC')
		->get('promedio');

		return $resu[0]->promedio;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		echo "hello";
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('tmp');
	}

	public function store(Request $request)
	{
		$request->le_dieron = strtolower($request->le_dieron);
		if (strpos($request->le_dieron, "cerrado") !== false) {
			$rules = array(
				'que_busca' => 'required',
				//'le_dieron' => 'required',
				'edad' => 'required',
				'genero' => 'required',
				'serviceShortName' => 'required',
				'voto' => 'required'
			);
			$messages = array(
				'que_busca.required' => 'Que fuiste a buscar? es requerido',
						//'le_dieron.required' => 'Te dieron lo que buscabas? es requerido',
				'edad.required' => 'La edad es requerida',
				'genero.required' => 'El género es requerido',
				'serviceShortName.required' => 'El serviceShortName es requerido',
				'voto.required' => 'La recomendación es requerida');
		}
		else {
			switch($request->serviceShortName){
				case "ssr":
				$rules = array(
					'que_busca' => 'required',
					'edad' => 'required',
					'genero' => 'required',
					'serviceShortName' => 'required',
					'voto' => 'required'
				);
				$messages = array(
					'que_busca.required' => 'Que fuiste a buscar? es requerido',
					'edad.required' => 'La edad es requerida',
					'genero.required' => 'El género es requerido',
					'serviceShortName.required' => 'El serviceShortName es requerido',
					'voto.required' => 'La recomendación es requerida');
				break;
				case "ILE":
				$rules = array(
									//'comodo' => 'required',
					'edad' => 'required',
									//'es_gratuito' => 'required',
					'genero' => 'required',
									//'info_ok' => 'required',
									// 'informacion_vacunas' => 'required',
									//'le_dieron' => 'required',
									//'privacidad_ok' => 'required',
					'que_busca' => 'required',
					'serviceShortName' => 'required',
					'voto' => 'required'
				);
				$messages = array(
											//'comodo.required' => 'Te sentiste comodo? es requerido',
					'edad.required' => 'La edad es requerida',
											//'es_gratuito.required' => 'Es gratuito? es requerido',
					'genero.required' => 'El género es requerido',
											//'info_ok.required' => 'Informacion clara?  es requerido',
											// 'informacion_vacunas.required' => 'Informacion de vacunas?  es requerido',
											//'le_dieron.required' => 'Te dieron lo que buscabas? es requerido',
											//'privacidad_ok.required' => 'Respetaron tu privacidad? es requerido',
					'que_busca.required' => 'Que fuiste a buscar? es requerido',
					'serviceShortName.required' => 'El serviceShortName es requerido',
					'voto.required' => 'Debe seleccionar un puntaje');
				break;
				case "cdi":
				$rules = array(
									//'comodo' => 'required',
					'edad' => 'required',
									// 'es_gratuito' => 'required',
					'genero' => 'required',
									//'info_ok' => 'required',
									// 'informacion_vacunas' => 'required',
									//'le_dieron' => 'required',
									//'privacidad_ok' => 'required',
					'que_busca' => 'required',
					'serviceShortName' => 'required',
					'voto' => 'required'
				);
				$messages = array(
											//'comodo.required' => 'Te sentiste comodo? es requerido',
					'edad.required' => 'La edad es requerida',
											// 'es_gratuito.required' => 'Es gratuito? es requerido',
					'genero.required' => 'El género es requerido',
											//'info_ok.required' => 'Informacion clara?  es requerido',
											// 'informacion_vacunas.required' => 'Informacion de vacunas?  es requerido',
											//'le_dieron.required' => 'Te dieron lo que buscabas? es requerido',
											//'privacidad_ok.required' => 'Respetaron tu privacidad? es requerido',
					'que_busca.required' => 'Que fuiste a buscar? es requerido',
					'serviceShortName.required' => 'El serviceShortName es requerido',
					'voto.required' => 'Debe seleccionar un puntaje');
				break;
				case "vacunatorios":
				$rules = array(
					'comodo' => 'required',
					'edad' => 'required',
									// 'es_gratuito' => 'required',
					'genero' => 'required',
					'info_ok' => 'required',
					'informacion_vacunas' => 'required',
					'le_dieron' => 'required',
									// 'privacidad_ok' => 'required',
					'que_busca' => 'required',
					'serviceShortName' => 'required',
					'voto' => 'required'
				);
				$messages = array(
					'comodo.required' => 'Te sentiste comodo? es requerido',
					'edad.required' => 'La edad es requerida',
					'genero.required' => 'El género es requerido',
					'info_ok.required' => 'Informacion clara?  es requerido',
					'informacion_vacunas.required' => 'Informacion sobre vacunas?  es requerido',
					'le_dieron.required' => 'Te dieron lo que buscabas? es requerido',
					'que_busca.required' => 'Que fuiste a buscar? es requerido',
					'privacidad_ok.required' => 'Respetaron tu privacidad? es requerido',
					'serviceShortName.required' => 'El serviceShortName es requerido',
					'voto.required' => 'Debe seleccionar un puntaje');
				break;
				case "prueba":
				$rules = array(
					'que_busca' => 'required',
									//'le_dieron' => 'required',
									//'info_ok' => 'required',
									//'privacidad_ok' => 'required',
					'edad' => 'required',
					'genero' => 'required',
									//'comodo' => 'required',
									//'es_gratuito' => 'required',
									// 'informacion_vacunas' => 'required',
					'serviceShortName' => 'required',
					'voto' => 'required'
				);
				$messages = array(
					'que_busca.required' => 'Que fuiste a buscar? es requerido',
											//'le_dieron.required' => 'Te dieron lo que buscabas? es requerido',
											//'info_ok.required' => 'Informacion clara?  es requerido',
											//'privacidad_ok.required' => 'Respetaron tu privacidad? es requerido',
					'edad.required' => 'La edad es requerida',
					'genero.required' => 'El género es requerido',
											//'comodo.required' => 'Te sentiste comodo? es requerido',
											//'es_gratuito.required' => 'Es gratuito? es requerido',
					'serviceShortName.required' => 'El serviceShortName es requerido',
					'voto.required' => 'Debe seleccionar un puntaje');
				break;
						default: //condones
						$rules = array(
									//'comodo' => 'required',
							'edad' => 'required',
									//'es_gratuito' => 'required',
							'genero' => 'required',
									//'info_ok' => 'required',
									// 'informacion_vacunas' => 'required',
									//'le_dieron' => 'required',
									// 'privacidad_ok' => 'required',
							'que_busca' => 'required',
							'serviceShortName' => 'required',
							'voto' => 'required'
						);
						$messages = array(
											//'comodo.required' => 'Te sentiste comodo? es requerido',
							'edad.required' => 'La edad es requerida',
											//'es_gratuito.required' => 'Es gratuito? es requerida',
							'genero.required' => 'El género es requerido',
											//'info_ok.required' => 'Informacion clara?  es requerido',
											//'le_dieron.required' => 'Te dieron lo que buscabas? es requerido',
											// 'privacidad_ok.required' => 'Respetaron tu privacidad? es requerido',
							'que_busca.required' => 'Que fuiste a buscar? es requerido',
							'serviceShortName.required' => 'El serviceShortName es requerido',
							'voto.required' => 'Debe seleccionar un puntaje');
					}

				}

				$request_params = $request->all();


				$validator = Validator::make($request_params,$rules,$messages);

				if ($validator->passes()){
					$ev = new Evaluation;

					$ev->que_busca = $request->que_busca;
					$ev->le_dieron = $request->le_dieron;
					$ev->info_ok = $request->info_ok == "SI" ? 1 : 0 ;
					$ev->privacidad_ok = strpos($request->privacidad_ok , 'no') === false ? 1 : 0 ;
					$ev->edad = $request->edad;
					$ev->genero = $request->genero;
					$ev->comentario = $request->comments;
					$ev->voto = $request->voto;
					$ev->aprobado = 1;
					$ev->idPlace = $request->idPlace;
					$ev->service = $request->serviceShortName;
					$ev->comodo = $request->comodo == "SI" ? 1 : 0 ;
					$ev->informacion_vacunas = $request->informacion_vacunas;
					$ev->es_gratuito = $request->informacion_vacunas;
					$ev->name = $request->name;
					$ev->tel = $request->tel;
					$ev->email = $request->email;

					$ev->save();
			//para el metodo aprove panel
					$this->updatePlaceEvaluationValues( $request->idPlace );
		//	return $ev->service;
				}
		//========

				return $validator->messages();

			}

			public function updatePlaceEvaluationValues( $idPlace ){
				$place = Places::find($idPlace);

				$place->cantidad_votos = $this->countEvaluations($idPlace);
				$place->rate = $this->getPlaceAverageVote($idPlace);
				$place->rateReal = $this->getPlaceAverageVoteReal($idPlace);

				$place->save();
			}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$evaluation = Evaluation::find($id);
		return $evaluation;
	}

	public function getAllEvaluations(Request $request){
		try {
			return DB::table('evaluation')
			->join('places', 'places.placeId', '=', 'evaluation.idPlace')
			->join('ciudad', 'ciudad.id', '=', 'places.idCiudad')
			->join('partido', 'partido.id', '=', 'places.idPartido')
			->join('provincia', 'provincia.id', '=', 'places.idProvincia')
			->join('pais', 'pais.id', '=', 'places.idPais')
			->select('evaluation.*', 'places.establecimiento', 'ciudad.nombre_ciudad', 'partido.nombre_partido', 'provincia.nombre_provincia', 'pais.nombre_pais')
			->orderByDesc('created_at')
			->get();
		}
		catch (Exception $e) {
			return $e->getMessage();
		}
	}
	
	public function getAllByCity($aprobado = '-1', $paisId = null, $pciaId = null, $partyId = null, $cityId = null){

		$q = DB::table('evaluation');
		
		if ($aprobado == '0' || $aprobado == '1'){
			$q->where('evaluation.aprobado', '=', $aprobado);
		}
		
		$q->join('places', 'places.placeId', '=', 'evaluation.idPlace')
		->join('ciudad', 'ciudad.id', '=', 'places.idCiudad')
		->join('partido', 'partido.id', '=', 'places.idPartido')
		->join('provincia', 'provincia.id', '=', 'places.idProvincia')
		->join('pais', 'pais.id', '=', 'places.idPais');

		if ($cityId !== "null" 	&& $cityId !== null){
			$q->where('ciudad.id','=', $cityId);
		}
		if ($partyId !== "null" && $partyId !== null){
			$q->where('partido.id','=', $partyId);
		}
		if ($pciaId !== "null" 	&& $pciaId !== null){
			$q->where('provincia.id','=', $pciaId);
		}	
		if ($paisId !== "null" 	&& $paisId !== null){
			$q->where('pais.id','=', $paisId);
		}

		$evaluations = $q->select('evaluation.*','places.*', DB::raw('CONCAT(places.calle," ",places.altura) as direccion'),'ciudad.nombre_ciudad','partido.nombre_partido','provincia.nombre_provincia','pais.nombre_pais','evaluation.id as id_evaluacion','evaluation.created_at as fechaEvaluacion', 'evaluation.aprobado as aprobadoEval')
		->get();
		return $evaluations;
	}

	public function removeEvaluation($evalId){
		$evaluation = Evaluation::find($evalId);

		$evaluation->aprobado = 0;

		$evaluation->updated_at = date("Y-m-d H:i:s");
		$evaluation->save();

		$place = Places::find($evaluation->idPlace);
		$place->cantidad_votos = $this->countEvaluations($evaluation->idPlace);
		$place->rate = $this->getPlaceAverageVote($evaluation->idPlace);
		$place->rateReal = $this->getPlaceAverageVoteReal($evaluation->idPlace);
		$place->save();

		return [];

		// $eval = Evaluation::find($evalId);
		// $idPlace = $eval->idPlace;
		// $eval->delete();
		// $this->updatePlaceEvaluationValues($idPlace);
	}

	public function replyEvaluation($evalId, $reply_content){
		$eval = DB::table( 'evaluation' )->where( 'id', $evalId );
		$eval->update(array(
			'reply_date'		=>	date("Y-m-d H:i:s"),
			'reply_admin'		=>	Auth::user()->name,
			'reply_content'	=>	$reply_content,
		));
	}
}
