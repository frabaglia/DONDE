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
		$pais = Pais::where('nombre_pais','LIKE','%'.$countryName.'%')->get();
		if (count($pais) > 0){
			$provincias = Provincia::where('idPais','=',$pais[0]->id)->get();
			$placesCountArray = [];
			$countTotal = 0;
			$totalCountryPlaces = DB::table('places')
			 ->join('pais', 'places.idPais', '=', 'pais.id')
			 ->where('places.idPais',$pais[0]->id)
			 ->get();
			 $totalEvaluatedPlaces = 0;
			 $totalNotEvaluatedPlaces = 0;
			 foreach ($totalCountryPlaces as $place) {
				 $evaluationsCount = DB::table('evaluation')
						->join('places', 'places.placeId', '=', 'evaluation.idPlace')
						->where('evaluation.aprobado',1)
						->where('evaluation.idPlace',$place->placeId)
						->count();
						if ($evaluationsCount > 0) $totalEvaluatedPlaces ++;
						else $totalNotEvaluatedPlaces ++;
			 }

			foreach ($provincias as $provincia) {
				$countPlaces = 0;
				$countNotEvalPlaces = 0;
				 $provinciaPlaces = DB::table('places')
					->join('provincia', 'places.idProvincia', '=', 'provincia.id')
					->where('places.idProvincia',$provincia->id)
					->get();

						foreach ($provinciaPlaces as $place) {
							$evaluationsCount = DB::table('evaluation')
								 ->join('places', 'places.placeId', '=', 'evaluation.idPlace')
								 ->where('evaluation.aprobado',1)
								 ->where('evaluation.idPlace',$place->placeId)
								 ->count();
								 if ($evaluationsCount > 0) $countPlaces ++;
								 else $countNotEvalPlaces ++;
						}
						$porcentaje = $countPlaces * 100 / $totalEvaluatedPlaces;

				array_push($placesCountArray,["idProvincia" => $provincia->id, "nombreProvincia" => $provincia->nombre_provincia, "countEvaluatedPlaces" => $countPlaces, "countNotevaluatedPlaces" => $countNotEvalPlaces, "porcentaje" => $porcentaje]);
			}
			return array("totalPlaces" => ($totalEvaluatedPlaces + $totalNotEvaluatedPlaces), "totalEvaluatedPlaces" => $totalEvaluatedPlaces, "totalNotEvaluatedPlaces" => $totalNotEvaluatedPlaces, "placesCountArray" => $placesCountArray);
		} else return array('type' => 'warning', 'code' => 501, 'description' => 'No se encuentran Paises para el string '. $countryName);
	}


	public function getCopies($id){
		return DB::table('places')->where('placeId',$id)->select('places.establecimiento')->get();
	}

	public function block($id){
		// $request_params = $request->all();

		$evaluation = Evaluation::find($id);

		$evaluation->aprobado = 0;

		$evaluation->updated_at = date("Y-m-d H:i:s");
		$evaluation->save();

		//para el metodo aprove panel
		$place = Places::find($evaluation->idPlace);
		$place->cantidad_votos = $this->countEvaluations($evaluation->idPlace);
		$place->rate = $this->getPlaceAverageVote($evaluation->idPlace);
		$place->rateReal = $this->getPlaceAverageVoteReal($evaluation->idPlace);
		$place->save();

		// return $evaluation;
		return [];
	}

	public function approve($id){

		// $request_params = $request->all();

		$evaluation = Evaluation::find($id);

		$evaluation->aprobado = 1;

		$evaluation->updated_at = date("Y-m-d H:i:s");
		$evaluation->save();

		//para el metodo aprove panel
		$place = Places::find($evaluation->idPlace);
		$place->cantidad_votos = $this->countEvaluations($evaluation->idPlace);
		$place->rate = $this->getPlaceAverageVote($evaluation->idPlace);
		$place->rateReal = $this->getPlaceAverageVoteReal($evaluation->idPlace);
		$place->save();



		// return $evaluation;
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
		return DB::table('evaluation')
			->join('places', 'places.placeId', '=', 'evaluation.idPlace')
			->where('evaluation.aprobado',1)
			->where('evaluation.idPlace',$id)
			->select('places.establecimiento','evaluation.comentario','evaluation.que_busca','evaluation.voto')
			->get();
	}

	public function showPanelEvaluations($id){ //id de un place
		return DB::table('evaluation')
			->where('places.placeId',$id)
			->join('places', 'places.placeId', '=', 'evaluation.idPlace')
			->select()
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
				'voto' => 'required'
			);
			$messages = array(
						'que_busca.required' => 'Que fuiste a buscar? es requerido',
						'edad.required' => 'La edad es requerida',
						'genero.required' => 'El género es requerido',
						'serviceShortName.required' => 'El serviceShortName es requerido',
						'voto.required' => 'Debe seleccionar un puntaje');


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
