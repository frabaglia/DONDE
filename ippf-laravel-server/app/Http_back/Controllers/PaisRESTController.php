<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Pais;
use App\Provincia;
use App\Partido;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class PaisRESTController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getAll()
    {
          return Pais::all();
    }

    public function getProvinces($id){
        
        return 
        Provincia::where('idPais', '=', $id)
            ->orderBy('nombre_provincia')->get();
    }

    public function getCities($id){
        
        return 
            Partido::where('idProvincia', '=', $id)
                ->where('habilitado','=',1)
                ->orderBy('nombre_partido')->get();
    }
    public function getAllCities($id){
        
        return 
            Partido::where('idProvincia', '=', $id)
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
    public function show($id)
    {
        return Pais::find($id);
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
        return Pais::where('nombre_pais',$nombre)->first();
    }
}
