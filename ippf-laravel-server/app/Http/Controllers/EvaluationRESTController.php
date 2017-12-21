<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Evaluation;
use App\Pais;
use App\Provincia;
use App\Places;
use Validator;
use DB;

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

		$data = DB::table('evaluation')
			->join('places', 'places.placeId', '=', 'evaluation.idPlace')
			->where('evaluation.aprobado',1)
			->where('evaluation.idPlace',$id)
			->select('places.establecimiento','evaluation.comentario','evaluation.que_busca','evaluation.voto')
			->get();


		return json_encode($data);
	}

	public function showPanelEvaluations($id){ //id de un place
		return DB::table('evaluation')
			->join('places', 'places.placeId', '=', 'evaluation.idPlace')
			->where('places.placeId',$id)
			->select('evaluation.*')
			->get();
	}


	/**
	* Retrieve a DB query result with id's service evaluation
	*
	* @param  string $id
	* @return object of arrays
	*/
	public function showPanelServiceEvaluations($id){ //actualmente id de un servicio

		//NUEVO, tener en cuenta el nombre del campo
		return DB::table('evaluation')
			->where('service',$id) //service = new table att.
			->select()
			->get();
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
									//'le_dieron' => 'required',
									//'info_ok' => 'required',
									//'privacidad_ok' => 'required',
									'edad' => 'required',
									'genero' => 'required',
									//'es_gratuito' => 'required',
									//'comodo' => 'required',
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
											//'es_gratuito.required' => 'Saber si es gratuito es requerido',
											//'comodo.required' => 'Te sentiste comodo? es requerido',
											// 'informacion_vacunas.required' => 'Recibiste informacion de vacunas? es requerido',
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
	        $ev->info_ok = $request->info_ok;
	        $ev->privacidad_ok = $request->privacidad_ok;
	        $ev->edad = $request->edad;
	        $ev->genero = $request->genero;
	        $ev->comentario = $request->comments;
	        $ev->voto = $request->voto;
	        $ev->aprobado = 1;
	        $ev->idPlace = $request->idPlace;
			$ev->service = $request->serviceShortName;
			$ev->comodo = $request->comodo;
			$ev->informacion_vacunas = $request->informacion_vacunas;
			$ev->es_gratuito = 0;
			$ev->name = $request->name;
			$ev->tel = $request->tel;
			$ev->email = $request->email;
				
			$ev->save();
			//para el metodo aprove panel
			$place = Places::find($request->idPlace);

			$place->cantidad_votos = $this->countEvaluations($request->idPlace);

			$place->rate = $this->getPlaceAverageVote($request->idPlace);
			$place->rateReal = $this->getPlaceAverageVoteReal($request->idPlace);

			$place->save();
		//	return $ev->service;
		}
		//========

	return $validator->messages();

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
			->paginate(100);
		}
		catch (Exception $e) {
			return $e->getMessage();
		}
	}

	public function getAllFileteredEvaluations(){
		
		$evaluations = DB::table('evaluation')
		->join('places', 'places.placeId','=', 'evaluation.idPlace')
		->join('ciudad', 'ciudad.id', '=', 'places.idCiudad')
		->join('partido', 'partido.id', '=', 'places.idPartido')
		->join('provincia', 'provincia.id', '=', 'places.idProvincia')
		->join('pais', 'pais.id', '=', 'places.idPais')
		->select('ciudad.nombre_ciudad','partido.nombre_partido','provincia.nombre_provincia','pais.nombre_pais', 'evaluation.*', 'places.establecimiento', 'places.placeId')
		->get();
		return $evaluations;
	}

	public function getAllByCity($paisId, $pciaId, $partyId, $cityId){
		
			$evaluations = DB::table('evaluation')
				->join('places', 'places.placeId', '=', 'evaluation.idPlace')
				->join('ciudad', 'ciudad.id', '=', 'places.idCiudad')
				->join('partido', 'partido.id', '=', 'places.idPartido')
				->join('provincia', 'provincia.id', '=', 'places.idProvincia')
				->join('pais', 'pais.id', '=', 'places.idPais')
				->where('ciudad.id', '=', $cityId)
				->select('ciudad.nombre_ciudad','partido.nombre_partido','provincia.nombre_provincia','pais.nombre_pais', 'evaluation.*', 'places.establecimiento', 'places.placeId')
				->get();
				return $evaluations;
		}

	public function removeEvaluation($evalId){

		$eval = Evaluation::find($evalId);
		$eval->delete();
	}

}
