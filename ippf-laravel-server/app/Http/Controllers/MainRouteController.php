<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ProvinciaRESTController;
use App\Http\Controllers\PlacesRESTController;
use App\Provincia;
use DB;
use Mail;
use Redirect;
use Auth;

class MainRouteController extends Controller
{
  public function userCountries(){
    return view('panel.user-countries');

  }

  public function shareDetail($lang, $id)
    {
      $p = DB::table('places')
      ->join('ciudad', 'places.idCiudad', '=', 'ciudad.id')
      ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
      ->join('partido', 'places.idPartido', '=', 'partido.id')
      ->join('pais', 'places.idPais', '=', 'pais.id')
      ->where('places.aprobado', '=', 1)
      ->where('placeId','=',$id)
      ->select()
      ->get();
      $l = $p[0] ;
      $l->image = "https://maps.googleapis.com/maps/api/staticmap?center=".$l->latitude.",".$l->longitude."&zoom=14&size=300x300&markers=color:blue%7Clabel:C%7C".$l->latitude.",".$l->longitude;

      // dd($l);
      // dd($p[0]);

      return view('share')
      ->with('p', $p[0])
      ->with('lang', $lang);
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
     public function home()
     {
         return view('home');
     }


     public function notFound()
     {

        abort(404);
     }
    public function llamada()
    {

        return view('llamada');
    }
    public function information()
    {

        return view('information');
    }
    public function terms()
    {

        return view('terms');
    }



    public function form()
    {

        return view('form');
    }
    public function formConfirmation()
    {

      return view('form-confirmation');
    }
    public function formEditConfirmation()
    {

      return view('edit-confirmation');
    }



    public function panel()
    {

        return view('panel.index');
    }

     public function places($id)
    {

        return view('panel.places')->with('placeId',$id);
    }

    public function placesPre($id)
    {

        return view('panel.places-pre')->with('placeId',$id);
    }

    public function getRegister()
    {
        return view('auth.register');
    }

    public function adminList()
    {
        return view('panel.admin-list');
    }

    public function cityList()
    {
        return view('panel.city-list');
    }

    public function download(){

      return view('download');
    }

    public function sendConfirmation(){
      $data = Auth::user();
      // Mail::raw('Usuario creado correctamente. ',function($msj){
      Mail::send('emails.confirmation',[Auth::user()],function($msj){
    		$msj->subject('¡Ya podés empezar a usar #Dónde!');
    		$msj->to(Auth::user()->email);
    	});
    	return redirect::to('/panel');

    }



}
