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

      ->get();
    }

    public function showCounty($pais,$provincia)
    {
        $partidos = DB::table('partido')
         ->select('partido.nombre_partido', 'partido.id', 'provincia.nombre_provincia','pais.nombre_pais','partido.habilitado', DB::raw("count(ciudad.id) as countCities"))  
          ->join('provincia', 'provincia.id', '=', 'partido.idProvincia')
          ->join('pais', 'pais.id', '=', 'partido.idPais')
          ->join('ciudad', 'ciudad.idPartido', '=', 'partido.id')
          ->where('nombre_pais',$pais)
          ->where('nombre_provincia',$provincia)      
          ->groupBy('partido.id')
          ->orderBy('countCities')
          ->get();
          
        return view('seo.cities',compact('partidos','provincia','pais'));
    }

    public function showPartidosByIdProvincia($id)
    {
        $partidos = DB::table('partido')
         ->select('partido.nombre_partido', 'partido.id', 'provincia.nombre_provincia')
          ->join('provincia', 'provincia.id', '=', 'partido.idProvincia')
          ->where('idProvincia',$id)    
          ->orderBy('nombre_partido')
          ->get();
          
        return $partidos;
    }    

}
