<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Pais;
use App\Provincia;
use App\Partido;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;
use DB;

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

    public function showCountries(){
      $i18n = $this->getCountryCopy();
            
      $countries =  DB::table('pais')->orderBy('nombre_pais')->get();
      
      return view('seo.countries',compact('countries','i18n'));
   }

     /**
     * Set global lang value and return the setCountryKeyWords for the first view
     *
     * @param  null
     * @return array with key=>value
     */ 
      public function getCountryCopy(){
        if ( session()->get('lang') )
            session()->forget('lang');

        $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        // session(['lang' => $lang]);
        // return $this->setCountryKeyWords($lang);
        
        session(['lang' => "br"]);
        return $this->setCountryKeyWords("br");
        
     }

     /**
     * map global lang and their keywords
     *
     * @param  string langValue
     * @return array with key=>value
     */ 
     public function setCountryKeyWords($lang){
      $result = "";
      switch ($lang){
         case "br":
            $result = [
               "pais" => "pais",
               "provincia" => "provincia",
               "titulo" => "Seleccionao País",
               "volver" => "br"
            ];
         break;
         case "en":
            $result = [
               "pais" => "country",
               "provincia" => "state",
               "titulo" => "Select Country",
               "volver" => "Return"
            ];
         break;        
         default:
            $result = [
               "pais" => "pais",
               "provincia" => "provincia",
               "titulo" => "Selecciona un País",
               "volver" => "Volver"
            ];
         break;
      }
      return $result;
   }



   static public function showByNombre($nombre)
   {
     return Pais::where('nombre_pais',$nombre)->first();
  }
}
