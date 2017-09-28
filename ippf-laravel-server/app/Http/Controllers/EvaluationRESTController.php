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

		if(!$data){

			$data = DB::table('places')
				->select('establecimiento')
				->where('placeId','=', $id)
				->get();

		}

		return $data;
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
		$rules = array(
			'que_busca' => 'required',
			'edad' => 'required',
			'genero' => 'required',
			'serviceShortName' => 'required',
			'voto' => 'required',
		);
		$messages = array(
			'que_busca.required' => 'Que fuiste a buscar? es requerido',
			'edad.required' => 'La edad es requerida',
			'genero.required' => 'El género es requerido',
			'serviceShortName.required' => 'El serviceShortName es requerido',
			'voto.required' => 'Seleccione una carita');

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
			$ev->es_gratuito = $request->es_gratuito;
			$ev->informacion_vacunas = $request->informacion_vacunas;
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
		return DB::table('evaluation')->paginate(100);
		}
		catch (Exception $e) {
			return $e->getMessage();
		}
	}


}
