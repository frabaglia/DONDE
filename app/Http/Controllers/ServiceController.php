<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use DB;

class ServiceController extends Controller
{

     /* Display a listing of the resource.
     *
     * @return Response
     */
    public function getAllServices()
    {
        return \App\Service::all();
    }

    public function getIleTag($idPais)
    {
			$pais = \App\Pais::where('id',$idPais)->select('nombre_pais')->get();
			$pais = strtolower($pais);
			$pais = trim($pais);
      $pais = iconv('UTF-8','ASCII//TRANSLIT',$pais);

			return $pais;
    }

    public static function getServiceByCode($serviceCode){

     $service = DB::table('service')
      ->where('service.shortname', '=', $serviceCode)
      ->first();

      return get_object_vars($service);
    }

    public function getPlaceServices($placeId)
    {
      try {
        $place = \App\Places::where('placeId', $placeId)->first();
        $services = [];
        if (isset($place) && $place != null){
          if ($place->condones == 1) {
              $service = \App\Service::where('shortname', 'condones')->select('id', 'name', 'shortname')->get();
              array_push($services, $service[0]);

          }
          if ($place->prueba == 1) {
              $service = \App\Service::where('shortname', 'prueba')->select('id', 'name', 'shortname')->get();
              array_push($services, $service[0]);
          }
          if ($place->mac == 1) {
              $service = \App\Service::where('shortname', 'mac')->select('id', 'name', 'shortname')->get();
              array_push($services, $service[0]);
          }
          if ($place->ile == 1) {
              $service = \App\Service::where('shortname', 'ile')->select('id', 'name', 'shortname')->get();
              array_push($services, $service[0]);
          }
          if ($place->dc == 1) {
              $service = \App\Service::where('shortname', 'dc')->select('id', 'name', 'shortname')->get();
              array_push($services, $service[0]);
          }
          if ($place->ssr == 1) {
              $service = \App\Service::where('shortname', 'ssr')->select('id', 'name', 'shortname')->get();
              array_push($services, $service[0]);
          }
        }


        return $services;
      } catch (Exception $e) {
        return $e->getMessage();
      }
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
