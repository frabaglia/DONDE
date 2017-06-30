<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Partido;
use DB;

class PartidoRESTController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
     public function index()
     {
         return DB::table('partido')
         ->orderBy('nombre_partido')->get();
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
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    static public function show($id)
    {
        return partido::find($id);
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
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
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

    /**
     * Aditional functions
     **/

    static public function showByProvincia($id)
    {
      return DB::table('partido')->where('idProvincia', $id)->orderBy('nombre_partido')->get();
        // return partido::where('',$id)->get();
    }

    static public function showByNombre($nombre)
    {
        return partido::where('nombre_partido',$nombre)->first();
    }

    public function updateHabilitado(Request $request, $id)
    {
        $request_params = $request->all();
        $partido = partido::find($id);

        if($request->has('habilitado')){
          $partido->habilitado = $request_params['habilitado'] ? 1 : 0;
          $partido->updated_at = date("Y-m-d H:i:s");
          $partido->save();
        }
          return [];

    }

    public function showWithProvincia()
    {
      return DB::table('partido')
      ->join('provincia', 'provincia.id', '=', 'partido.idProvincia')
      ->join('pais', 'pais.id', '=', 'partido.idPais')
      ->join('places', 'partido.id', '=', 'places.idPartido')
      ->select('partido.nombre_partido', 'partido.id', 'provincia.nombre_provincia','pais.nombre_pais','partido.habilitado', DB::raw("count(places.placeId) as countPlaces"))
      ->where('places.habilitado', '1')
      ->groupBy('partido.id')
      ->orderBy('countPlaces')
      ->get();
    }

    public function showCounty($pais,$provincia)
    {
         $i18n = $this->getCityCopy();

        $partidos = DB::table('partido')
          ->join('provincia', 'provincia.id', '=', 'partido.idProvincia')
          ->join('pais', 'pais.id', '=', 'partido.idPais')
          ->where('nombre_pais',$pais)
          ->where('nombre_provincia',$provincia)
          ->orderBy('nombre_partido')
          ->get();

        return view('seo.cities',compact('partidos','provincia','pais','i18n'));
    }

    /**
     * Set global lang value and return the setStateKeyWords for the first view
     *
     * @param  null
     * @return array with key=>value
     */ 
      public function getCityCopy(){
        return $this->setCityKeyWords(session()->get('lang'));
     }

     /**
     * map global lang and their keywords
     *
     * @param  string langValue
     * @return array with key=>value
     */ 
     public function setCityKeyWords($lang){
      $result = "";
      switch ($lang){
         case "br":
            $result = [
               "pais" => "pais",
               "provincia" => "provincia",
               "partido" => "cidade",
               "servicio" => "serviço",
               "titulo" => "Seleccionao um Distrito",
               "volver" => "br"
            ];
         break;
         case "en":
            $result = [
               "pais" => "country",
               "provincia" => "state",
               "partido" => "city",
               "servicio" => "service",
               "titulo" => "Select District",
               "volver" => "Return"
            ];
         break;        
         default:
            $result = [
               "pais" => "pais",
               "provincia" => "provincia",
               "partido" => "partido",
               "servicio" => "servicio",
               "titulo" => "Selecciona un Distrito",
               "volver" => "Volver"
            ];
         break;
      }
      return $result;
   }



}
