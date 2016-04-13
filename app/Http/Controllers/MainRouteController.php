<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LocalidadRESTController;
use App\Http\Controllers\ProvinciaRESTController;
use App\Http\Controllers\PlacesRESTController;
use App\Provincia;
use DB;

class MainRouteController extends Controller
{
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



}
