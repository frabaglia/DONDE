<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Provincia;
use DB;

class ProvincesRESTController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
     public function getByPais($id)
     {
       $provinces =  DB::table('provincia')
           ->where('idPais',$id)
           ->orderBy('nombre_provincia')
           ->get();
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
        return Provincia::find($id);
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

    public function showProvinces($pais){
        //si filtro por id
        // $provinces =  DB::table('provincia')->where('idPais', $id)->orderBy('nombre_provincia')->get();
        $provinces =  DB::table('provincia')
            ->join('pais', 'pais.id', '=', 'provincia.idPais')
            ->where('nombre_pais',$pais)
            ->orderBy('nombre_provincia')
            ->select('nombre_provincia')
            ->get();
            
        return view('seo.provinces',compact('provinces','pais'));

    }

    public function showProvincesByIdPais($id){
        //si filtro por id
        // $provinces =  DB::table('provincia')->where('idPais', $id)->orderBy('nombre_provincia')->get();
        $provinces =  DB::table('provincia')
            ->join('pais', 'pais.id', '=', 'provincia.idPais')
            ->where('idPais',$id)
            ->orderBy('nombre_provincia')
            ->select('provincia.nombre_provincia', 'provincia.id')
            ->get();
            
        //return view('seo.provinces',compact('provinces','pais'));
            return $provinces;
    }    

    static public function showByProvincia($id)
    {
      return DB::table('localidad')->where('idProvincia', $id)->orderBy('nombre_localidad')->get();

    }

    static public function showByNombre($nombre)
    {
        return Provincia::where('nombre_localidad',$nombre)->first();
    }

    public function updateHidden(Request $request, $id)
    {
        $request_params = $request->all();
        $localidad = Provincia::find($id);

        if($request->has('hidden')){
          $localidad->hidden = $request_params['hidden'];
          $localidad->updated_at = date("Y-m-d H:i:s");
          $localidad->save();
        }
        return [];
    }

    public function showWithProvincia()
    {
      return
      DB::table('localidad')
      ->join('provincia', 'provincia.id', '=', 'localidad.idProvincia')
      ->select('localidad.nombre_localidad', 'localidad.id', 'provincia.nombre_provincia', 'localidad.hidden')
      ->get();
    }

}
