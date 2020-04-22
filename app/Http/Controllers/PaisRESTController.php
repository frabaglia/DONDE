<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Pais;
use App\Provincia;
use App\Partido;
use App\Ciudad;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class PaisRESTController extends Controller
{
    public function getCountriesByUser()
    {
      $countries;
        if (\Auth::user()->roll == 'administrador') {
            $countries = Pais::all();
        } else {
            $userId = \Auth::user()->id;
            $countries = DB::table('pais')
         ->join('user_country', 'user_country.id_country', '=', 'pais.id')
         ->where('user_country.id_user', $userId)
         ->get();
        }
        return $countries;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getAll()
    {
        return Pais::all();
    }

    public function getProvinces($id)
    {
        return
        Provincia::where('idPais', '=', $id)
            ->orderBy('nombre_provincia')
            ->get();
    }

    static public function getPartidos($id)
    {

      $partidos = Partido::where('idProvincia', $id)
            ->orderBy('nombre_partido')
            ->get();

        
       return $partidos;

    }     


    public function getCitiesByParty($id){

        $cities = Ciudad::where('idPartido', $id)
            ->orderBy('nombre_ciudad')
            ->get();

        return $cities;

    }   

    public function getCities($id)
    {
        return
            Partido::where('idProvincia', '=', $id)
                ->where('habilitado', '=', 1)
                ->orderBy('nombre_partido')->get();
    }
    public function getAllCities($id)
    {
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

    public function showCountries()
    {
        $countries =  DB::table('pais')->orderBy('nombre_pais')->get();
        return view('seo.countries', compact('countries'));
    }
    public function showCountriesDetail()
    {
        $countries =  DB::table('pais')->orderBy('nombre_pais')->get();
        return view('seo.detail', compact('countries'));
    }

    public static function showByNombre($nombre)
    {
        return Pais::where('nombre_pais', $nombre)->first();
    }
}
