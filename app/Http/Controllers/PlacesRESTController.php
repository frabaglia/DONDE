<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ProvinciaRESTController;
use App\Provincia;
use App\Partido;
use App\Places;
use App\PlaceLog;
use Validator;
use DB;
use Auth;

class PlacesRESTController extends Controller
{

    public function debug_to_console( $data ) {
      $output = $data;
      if ( is_array( $output ) )
        $output = implode( ',', $output);

      echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
    }

    public static function showAll($pais, $provincia, $partido, $ciudad, $service)
    {
        $places = DB::table('places')
          ->join('ciudad', 'places.idciudad', '=', 'ciudad.id')
          ->join('partido', 'places.idPartido', '=', 'partido.id')
          ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
          ->join('pais', 'places.idPais', '=', 'pais.id')
          ->where($service, '=', 1)
          ->where('nombre_ciudad', $ciudad)
          ->where('nombre_pais', $pais)
          ->where('nombre_provincia', $provincia)
          ->where('nombre_partido', $partido)
          ->where('places.aprobado', '=', 1)
          ->select()
          ->get();
      // dd($service);

      $resu = array();

        if ($service == "condones") {
            $resu['title'] = 'Condones';
            $resu['icon'] = 'iconos-new_preservativos-3.png';
            $resu['titleCopySeo'] = 'consigo Condones';
            $resu['descriptionCopy'] = 'los lugares para retirar condones gratis';

            $resu['titleCopySingle'] = 'lugar que distribuye Condones de forma gratuita.';
            $resu['titleCopyMultiple'] = 'lugares que distribuyen Condones de forma gratuita.';

            $resu['newServiceTitle'] = ' Condones ';
            $resu['newServiceTitleSingle'] = ' Condones ';

            $resu['preCopyFound'] = ' lugares de entrega gratuita de ';
            $resu['preCopyFoundSingle'] = ' lugar de entrega gratuita de ';

            $resu['titleCopyNotFound'] = 'No tenemos registrados lugares de entrega gratuita de  ';
        }


        if ($service == "prueba") {
            $resu['title'] = 'Prueba VIH';
            $resu['icon'] = 'iconos-new_analisis-3.png';
            $resu['titleCopySeo'] = 'puedo hacer Prueba VIH';
            $resu['descriptionCopy'] = 'los lugares que realizan la prueba de VIH de manera gratuita';

            $resu['titleCopySingle'] = 'lugar para hacer Prueba VIH.';
            $resu['titleCopyMultiple'] = 'lugares que hagan Prueba VIH.';

            $resu['newServiceTitle'] = ' Centros de Testeo de VIH ';
            $resu['newServiceTitleSingle'] = ' Centro de Testeo de VIH ';

            $resu['preCopyFound'] = '';
            $resu['preCopyFoundSingle'] = '';

            $resu['titleCopyNotFound'] = 'No tenemos registrados  ';
        }

        if ($service == "infectologia") {
            $resu['title'] = 'Centros de Infectología';
            $resu['icon'] = 'iconos-new_atencion-3.png';
            $resu['titleCopySeo'] = 'hay Centros de Infectología';
            $resu['descriptionCopy'] = 'dónde hay Centros de Infectología';

            $resu['titleCopySingle'] = ' Centro de Infectología.';
            $resu['titleCopyMultiple'] = 'Centros de Infectología.';

            $resu['newServiceTitle'] = ' Centros de Infectología ';
            $resu['newServiceTitleSingle'] = ' Centro de Infectología ';

            $resu['preCopyFound'] = '';
            $resu['preCopyFoundSingle'] = '';

            $resu['titleCopyNotFound'] = "No tenemos registrados " ;
        }

        if ($service == "vacunatorio") {
            $resu['title'] = 'Vacunatorios';
            $resu['icon'] = 'iconos-new_vacunacion-3.png';
            $resu['titleCopySeo'] = 'hay vacunatorios';

            $resu['titleCopySingle'] = 'Vacunatorio.';
            $resu['descriptionCopy'] = 'los vacunatorios más cercanos, sus horarios de atención e información de contacto';
            $resu['titleCopyMultiple'] = 'Vacunatorios.';

            $resu['newServiceTitle'] = ' Vacunatorios ';
            $resu['newServiceTitleSingle'] = ' Vacunatorio ';

            $resu['preCopyFound'] = '';
            $resu['preCopyFoundSingle'] = '';

            $resu['titleCopyNotFound'] = 'No tenemos registrados ';
        }


        if ($service == "mac") {
            $resu['title'] = 'Servicios de Salud Sexual y Reproductiva';
            $resu['icon'] = 'iconos-new_sssr-3.png';
            $resu['titleCopySeo'] = 'obtengo métodos anticonceptivos';
            $resu['descriptionCopy'] = 'dónde obtener métodos anticonceptivos';

            $resu['titleCopySingle'] = 'lugar para obtener información y métodos anticonceptivos.';
            $resu['titleCopyMultiple'] = 'lugares para obtener información y métodos anticonceptivos.';

            $resu['newServiceTitle'] = ' métodos anticonceptivos ';
            $resu['newServiceTitleSingle'] = ' métodos anticonceptivos ';

            $resu['preCopyFound'] = ' lugares de entrega gratuita de ';
            $resu['preCopyFoundSingle'] = ' lugar de entrega gratuita de ';

            $resu['titleCopyNotFound'] = 'No tenemos registrados lugares de entrega gratuita de ';
        }

        if ($service == "ile") {
            $resu['title'] = 'Interrupción Legal del Embarazo';
            $resu['icon'] = 'iconos-new_ile-3.png';
            $resu['titleCopySeo'] = 'puedo obtener información sobre Interrupción Legal del Embarazo';

            $resu['titleCopySingle'] = 'lugar para obtener información sobre Interrupción Legal del Embarazo.';
            $resu['descriptionCopy'] = 'dónde obtener información sobre Interrupción Legal del Embarazo';
            $resu['titleCopyMultiple'] = 'lugares para obtener información sobre Interrupción Legal del Embarazo.';

            $resu['newServiceTitle'] = ' Interrupción Legal del Embarazo';
            $resu['newServiceTitleSingle'] = ' Interrupción Legal del Embarazo';

            $resu['preCopyFound'] = ' lugares para obtener información sobre';
            $resu['preCopyFoundSingle'] = ' lugar para obtener información sobre ';

            $resu['titleCopyNotFound'] = 'No tenemos registrados lugares para obtener información sobre ';
        }

        if ($service == "ssr") {
            $resu['title'] = 'Interrupción Legal del Embarazo';
            $resu['icon'] = 'iconos-new_ile-3.png';
            $resu['titleCopySeo'] = 'puedo obtener información sobre Interrupción Legal del Embarazo';

            $resu['titleCopySingle'] = 'lugar para obtener información sobre Interrupción Legal del Embarazo.';
            $resu['descriptionCopy'] = 'dónde obtener información sobre Interrupción Legal del Embarazo';
            $resu['titleCopyMultiple'] = 'lugares para obtener información sobre Interrupción Legal del Embarazo.';

            $resu['newServiceTitle'] = ' Interrupción Legal del Embarazo';
            $resu['newServiceTitleSingle'] = ' Interrupción Legal del Embarazo';

            $resu['preCopyFound'] = ' lugares para obtener información sobre';
            $resu['preCopyFoundSingle'] = ' lugar para obtener información sobre ';

            $resu['titleCopyNotFound'] = 'No tenemos registrados lugares para obtener información sobre ';
        }

        if ($service == "dc") {
            $resu['title'] = 'Interrupción Legal del Embarazo';
            $resu['icon'] = 'iconos-new_ile-3.png';
            $resu['titleCopySeo'] = 'puedo obtener información sobre Interrupción Legal del Embarazo';

            $resu['titleCopySingle'] = 'lugar para obtener información sobre Interrupción Legal del Embarazo.';
            $resu['descriptionCopy'] = 'dónde obtener información sobre Interrupción Legal del Embarazo';
            $resu['titleCopyMultiple'] = 'lugares para obtener información sobre Interrupción Legal del Embarazo.';

            $resu['newServiceTitle'] = ' Interrupción Legal del Embarazo';
            $resu['newServiceTitleSingle'] = ' Interrupción Legal del Embarazo';

            $resu['preCopyFound'] = ' lugares para obtener información sobre';
            $resu['preCopyFoundSingle'] = ' lugar para obtener información sobre ';

            $resu['titleCopyNotFound'] = 'No tenemos registrados lugares para obtener información sobre ';
        }



        $horario='';
        $responsable='';
        $telefono='';

        foreach ($places as $p) {
            switch ($p) {
          case ($service == "condones"):
            $p->horario = $p->horario_distrib;
            $p->responsable = $p->responsable_distrib;
            $p->telefono = $p->tel_distrib;
            break;

          case ($service == "prueba"):
            $p->horario = $p->horario_testeo;
            $p->responsable = $p->responsable_testeo;
            $p->telefono = $p->tel_testeo;
            break;

          case ($service == "vacunatorio"):
            $p->horario = $p->horario_vac;
            $p->responsable = $p->responsable_vac;
            $p->telefono = $p->tel_vac;
            break;

          case ($service == "infectologia"):
            $p->horario = $p->horario_infectologia;
            $p->responsable = $p->responsable_infectologia;
            $p->telefono = $p->tel_infectologia;
            break;

          case ($service == "mac"):
            $p->horario = $p->horario_mac;
            $p->responsable = $p->responsable_mac;
            $p->telefono = $p->tel_mac;
            break;

          case ($service == "ile"):
            $p->horario = $p->horario_ile;
            $p->responsable = $p->responsable_ile;
            $p->telefono = $p->tel_ile;
            break;

            case ($service == "dc"):
              $p->horario = $p->horario_dc;
              $p->responsable = $p->responsable_dc;
              $p->telefono = $p->tel_dc;
              break;

            case ($service == "ssr"):
              $p->horario = $p->horario_ssr;
              $p->responsable = $p->responsable_ssr;
              $p->telefono = $p->tel_ssr;
              break;
      }
            if (($p->horario == "" || $p->horario == " ")) {
                $p->horario = " - ";
            }
            if (($p->responsable == "" || $p->responsable == " ")) {
                $p->responsable = " - ";
            }
            if (($p->telefono == "" || $p->telefono == " ")) {
                $p->telefono = " - ";
            }
        }
        $cantidad = count($places);

        return json_encode(array('lugares' => $places, 'cantidad' => $cantidad, 'textos' => $resu));

       // return view('seo.placesList', compact('places', 'cantidad', 'pais', 'provincia', 'partido','ciudad', 'resu'));
    }


    public static function getScalar($pid, $cid, $bid)
    {
        return DB::table('places')
      ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
      ->join('partido', 'places.idPartido', '=', 'partido.id')
      ->join('pais', 'places.idPais', '=', 'pais.id')
      ->where('places.idPais', $pid)
      ->where('places.idProvincia', $cid)
      ->where('places.idPartido', $bid)
      ->where('places.aprobado', '=', 1)
      ->select()
      ->get();
    }

    public static function getPlaceById($id){

     $place = DB::table('places')
      ->join('pais', 'pais.id', '=', 'places.idPais')
      ->join('ciudad', 'ciudad.id', '=', 'places.idCiudad')
      ->where('places.placeId', '=', $id)
      ->select('places.*', 'pais.nombre_pais', 'ciudad.nombre_ciudad')
      ->get();

      return $place;
    }

    public static function getPlaceByName($name){

     $places = DB::table('places')
      ->join('pais', 'pais.id', '=', 'places.idPais')
      ->join('ciudad', 'ciudad.id', '=', 'places.idCiudad')
      ->where('places.establecimiento', '=', $name)
      ->select('places.*', 'pais.nombre_pais', 'ciudad.nombre_ciudad')
      ->get();

      return $places;
    }

    public static function getScalarCampus($id)
    {
        return DB::table('places')
      ->where('places.idPartido', $id)
      ->where('places.aprobado', '=', 1)
      ->select()
      ->get();
    }

    public static function getScalarLatLon($lat, $lng)
    {
        return  DB::table('places')->select(DB::raw('*,round( 3959 * acos( cos( radians('.$lat.') )
              * cos( radians( places.latitude ) )
              * cos( radians( places.longitude ) - radians('.$lng.') )
              + sin( radians('.$lat.') )
              * sin( radians( places.latitude ) ) ) ,2) * 22 AS distance'), 'pais.nombre_pais', 'ciudad.nombre_ciudad')
                     ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
                     ->join('partido', 'places.idPartido', '=', 'partido.id')
                     ->join('pais', 'places.idPais', '=', 'pais.id')
                     ->join('ciudad', 'places.idCiudad', '=', 'ciudad.id')
                     ->where('places.aprobado', '=', 1)
                     ->having('distance', '<', 1000)
                     ->orderBy('distance')
                     //->take(30)
                     ->get();
    }

    // Check if this method is still useful
    public static function getScalarServices($pid, $cid, $bid, $service)
    {
        return DB::table('places')
      ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
      ->join('partido', 'places.idPartido', '=', 'partido.id')
      ->join('pais', 'places.idPais', '=', 'pais.id')
      ->where($service, '=', 1)
      ->where('places.idProvincia', $cid)
      ->where('places.idPartido', $bid)
      ->where('places.aprobado', '=', 1)
      ->select()
      ->get();
    }

    // List approved places that belong to a city by service
    static public function getScalarServicesByCity($pid,$cid,$bid,$lid,$service){

     $places = DB::table('places')
        ->join('ciudad', 'places.idCiudad', '=' , 'ciudad.id')
        ->join('partido', 'places.idPartido', '=', 'partido.id')
        ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
        ->join('pais', 'places.idPais', '=', 'pais.id')
        ->where($service,'=',1)
        ->where('places.idCiudad', $lid)
        ->where('places.aprobado', '=', 1)
        ->select()
        ->get();

    return $places;

    }

    public static function getScalarServicesCampus($id, $service){

        return DB::table('places')
          ->where($service, '=', 1)
          ->where('places.idPartido', $id)
          ->where('places.aprobado', '=', 1)
          ->select()
          ->get();

    }

    public static function scopeIsLike($query, $q)
    {
        foreach ($q as $eachQueryString) {
            $query->orWhere('establecimiento', 'LIKE', '%'.$eachQueryString .'%');
            $query->orWhere('calle', 'LIKE', '%'.$eachQueryString .'%');
            $query->orWhere('altura', 'LIKE', '%'.$eachQueryString .'%');
        }
        return $query;
    }

    public static function search($q)
    {
        $keys = explode(" ", $q);

        return DB::table('places')
      ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
      ->join('partido', 'places.idPartido', '=', 'partido.id')
      ->join('pais', 'places.idPais', '=', 'pais.id')
      ->where(function ($query) use ($keys) {
          foreach ($keys as $eachQueryString) {
              $query->orWhere('establecimiento', 'LIKE', '%'.$eachQueryString .'%');
              $query->orWhere('calle', 'LIKE', '%'.$eachQueryString .'%');
              $query->orWhere('altura', 'LIKE', '%'.$eachQueryString .'%');
          }
      })
      ->where('places.aprobado', '=', 1)
      ->select()
      ->get();
    }

    public static function searchFilterByUser($q)
    {
        if (Auth::user()->roll == 'administrador') {
            $keys = explode(" ", $q);

            $places = DB::table('places')
        ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
        ->join('partido', 'places.idPartido', '=', 'partido.id')
        ->join('pais', 'places.idPais', '=', 'pais.id')
        ->where(function ($query) use ($keys) {
            foreach ($keys as $eachQueryString) {
                $query->orWhere('establecimiento', 'LIKE', '%'.$eachQueryString .'%');
                $query->orWhere('calle', 'LIKE', '%'.$eachQueryString .'%');
                $query->orWhere('altura', 'LIKE', '%'.$eachQueryString .'%');
            }
        })
        ->where('places.aprobado', '=', 1)
        ->select()
        ->get();
        } else {
            $userId = Auth::user()->id;
            $keys = explode(" ", $q);

            $places = DB::table('places')
        ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
        ->join('partido', 'places.idPartido', '=', 'partido.id')
        ->join('pais', 'places.idPais', '=', 'pais.id')
        ->join('user_country', 'user_country.id_country', '=', 'pais.id')
        ->where(function ($query) use ($keys) {
            foreach ($keys as $eachQueryString) {
                $query->orWhere('establecimiento', 'LIKE', '%'.$eachQueryString .'%');
                $query->orWhere('calle', 'LIKE', '%'.$eachQueryString .'%');
                $query->orWhere('altura', 'LIKE', '%'.$eachQueryString .'%');
            }
        })
        ->where('places.aprobado', '=', 1)
        ->where('user_country.id_user', '=', $userId)
        ->select()
        ->get();
        }
        return $places;
    }

    public static function searchPlacesEval($q)
    {
        $keys = explode(" ", $q);

        return DB::table('places')
      ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
      ->join('partido', 'places.idPartido', '=', 'partido.id')
      ->join('pais', 'places.idPais', '=', 'pais.id')
      ->leftjoin('evaluation', 'places.placeId', '=', 'evaluation.idPlace')
      ->where(function ($query) use ($keys) {
          foreach ($keys as $eachQueryString) {
              $query->orWhere('establecimiento', 'LIKE', '%'.$eachQueryString .'%');
              $query->orWhere('calle', 'LIKE', '%'.$eachQueryString .'%');
              $query->orWhere('altura', 'LIKE', '%'.$eachQueryString .'%');
          }
      })
      ->where('places.aprobado', '=', 1)
      ->select()
      ->get();
    }



    public static function showApproved($pid, $cid, $bid)
    {
        return DB::table('places')
      ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
      ->join('partido', 'places.idPartido', '=', 'partido.id')
      ->join('pais', 'places.idPais', '=', 'pais.id')
      ->where('places.idPais', $pid)
      ->where('places.idProvincia', $cid)
      ->where('places.idPartido', $bid)
      ->where('places.aprobado', '=', 1)
      ->select()
      ->get();
    }

    public static function showApprovedSearchActive($pid, $bid, $did, $cid)
    {
        return DB::table('places')
      ->join('ciudad', 'places.idCiudad', '=', 'ciudad.id')
      ->join('partido', 'places.idPartido', '=', 'partido.id')
      ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
      ->join('pais', 'places.idPais', '=', 'pais.id')
      ->where('places.idPais', $pid)
      ->where('places.idProvincia', $bid)
      ->where('places.idPartido', $did)
      ->where('places.idCiudad', $cid)
      ->where('places.aprobado', '=', 1)
      ->select()
      ->get();
    }

    public static function showApprovedActiveByState($pid, $cid)
    {
        return DB::table('places')
      ->join('ciudad', 'places.idCiudad', '=', 'ciudad.id')
      ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
      ->where('places.idPais', $pid)
      ->where('places.idProvincia', $cid)
      ->where('places.aprobado', '=', 1)
      ->select()
      ->get();
    }

    public static function showApprovedActiveByDepartment($pid, $cid, $did)
    {
        return DB::table('places')
      ->join('ciudad', 'places.idCiudad', '=', 'ciudad.id')
      ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
      ->join('partido', 'places.idPartido', '=', 'partido.id')
      ->where('places.idPais', $pid)
      ->where('places.idProvincia', $cid)
      ->where('places.idPartido', $did)
      ->where('places.aprobado', '=', 1)
      ->select()
      ->get();
    }

    public static function showApprovedActive($pid, $cid, $did, $bid)
    {
        return DB::table('places')
      ->join('ciudad', 'places.idCiudad', '=', 'ciudad.id')
      ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
      ->join('partido', 'places.idPartido', '=', 'partido.id')
      ->join('pais', 'places.idPais', '=', 'pais.id')
      ->where('places.idPais', $pid)
      ->where('places.idProvincia', $cid)
      ->where('places.idPartido', $did)
      ->where('places.idciudad', $bid)
      ->where('places.aprobado', '=', 1)
      ->select()
      ->get();
    }

    public static function showApprovedFilterByService($paisId, $provinciaId, $partidoId, $servicios)
    {
        $places = DB::table('places')
      ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
      ->join('partido', 'places.idPartido', '=', 'partido.id')
      ->join('pais', 'places.idPais', '=', 'pais.id')
      ->where('places.idPais', $paisId)
      ->where('places.idProvincia', $provinciaId)
      ->where('places.idPartido', $partidoId)
      ->where('places.aprobado', '=', 1)
       ->where(function ($query) use ($servicios) {
           if (in_array("condones", $servicios)) {
               $query->orWhere('places.condones', 1);
           }
           if (in_array("prueba", $servicios)) {
               $query->orWhere('places.prueba', 1);
           }
           if (in_array("vacunatorios", $servicios)) {
               $query->orWhere('places.vacunatorio', 1);
           }
           if (in_array("cdi", $servicios)) {
               $query->orWhere('places.infectologia', 1);
           }
           if (in_array("ssr", $servicios)) {
               $query->orWhere('places.ssr', 1);
           }
           if (in_array("dc", $servicios)) {
               $query->orWhere('places.dc', 1);
           }
           if (in_array("mac", $servicios)) {
               $query->orWhere('places.mac', 1);
           }
       })
    ->get();
        return $places;
    }

    public static function showApprovedFilterByTag($tagId)
    {
        $places = DB::table('places')
      ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
      ->join('partido', 'places.idPartido', '=', 'partido.id')
      ->join('pais', 'places.idPais', '=', 'pais.id')
      ->where('places.logId', $tagId)
      ->get();
        return $places;
    }

  public static function getAprobedPlaces($idPais, $idProvincia, $idPartido, $idCiudad)
    {

     // Export filter by country
     if ((isset($idPais)) && ($idPais != "null") && (($idProvincia == "null") || (!isset($idProvincia)))) {
      $places = DB::table('places')
      ->join('ciudad', 'places.idCiudad', '=', 'ciudad.id')
      ->join('partido', 'places.idPartido', '=', 'partido.id')
      ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
      ->join('pais', 'places.idPais', '=', 'pais.id')
      ->where('places.idPais', $idPais)
      ->where('places.aprobado', '=', 1)
      ->get();
    }

    // Export filter by country and province
    if ((isset($idPais)) && ($idPais != "null") && (isset($idProvincia)) && ($idProvincia != "null") && (($idPartido == "null") || (!isset($idPartido)))) {
      $places = DB::table('places')
      ->join('ciudad', 'places.idCiudad', '=', 'ciudad.id')
      ->join('partido', 'places.idPartido', '=', 'partido.id')
      ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
      ->join('pais', 'places.idPais', '=', 'pais.id')
      ->where('places.idPais', $idPais)
      ->where('places.idProvincia', $idProvincia)
      ->where('places.aprobado', '=', 1)
      ->get();
    }

    // Export filter by country, province and party
    if ((isset($idPais)) && ($idPais != "null") && (isset($idProvincia)) && ($idProvincia != "null") && (isset($idPartido)) && ($idPartido != "null") && (($idCiudad == "null") || (!isset($idCiudad)))) {
      $places = DB::table('places')
      ->join('ciudad', 'places.idCiudad', '=', 'ciudad.id')
      ->join('partido', 'places.idPartido', '=', 'partido.id')
      ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
      ->join('pais', 'places.idPais', '=', 'pais.id')
      ->where('places.idPais', $idPais)
      ->where('places.idProvincia', $idProvincia)
      ->where('places.idPartido', $idPartido)
      ->where('places.aprobado', '=', 1)
      ->get();
    }

    // Export filter by country, province, party and city
    if ((isset($idPais)) && ($idPais != "null") && (isset($idProvincia)) && ($idProvincia != "null") && (isset($idPartido)) && ($idPartido != "null") && (isset($idCiudad) && ($idCiudad != "null"))) {
      $places = DB::table('places')
      ->join('ciudad', 'places.idCiudad', '=', 'ciudad.id')
      ->join('partido', 'places.idPartido', '=', 'partido.id')
      ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
      ->join('pais', 'places.idPais', '=', 'pais.id')
      ->where('places.idPais', $idPais)
      ->where('places.idProvincia', $idProvincia)
      ->where('places.idPartido', $idPartido)
      ->where('places.idCiudad', $idCiudad)
      ->where('places.aprobado', '=', 1)
      ->get();
    }

    // Export all
    if ( $idPais == "null"  &&  $idProvincia == "null" && $idPartido == "null" && $idCiudad == "null") {
      $places = DB::table('places')
      ->join('ciudad', 'places.idCiudad', '=', 'ciudad.id')
      ->join('partido', 'places.idPartido', '=', 'partido.id')
      ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
      ->join('pais', 'places.idPais', '=', 'pais.id')
      ->where('places.aprobado', '=', 1)
      ->get();
    }

        return $places;
    }

    public static function counters()
    {
        $counters = array();
        $counters['lugares'] = DB::table('places')->count();
        $counters['rechazados'] = DB::table('places')
                    ->where('places.aprobado', '=', -1)
                     ->count();
        $counters['aprobados'] = DB::table('places')

                    ->where('places.aprobado', '=', 1)
                     ->count();
        $counters['pendientes'] = DB::table('places')

                    ->where('places.aprobado', '=', 0)
                     ->count();
        $counters['sinGeo'] = DB::table('places')

                    ->whereNull('places.latitude')
                    ->count();
        $counters['conGeo'] = DB::table('places')
                      ->whereNull('places.latitude')
                     ->count();
        $counters['errorGeo'] = DB::table('places')
                       ->where('places.confidence', '=', 0.5)
                     ->count();
        $counters['conGeo'] = DB::table('places')
                      ->whereNotNull('places.latitude')
                     ->count();

        $counters['paises'] = DB::table('pais')
                     ->count();
        $counters['ciudades'] = DB::table('provincia')
                     ->count();
        $counters['partido'] = DB::table('partido')
                     ->count();
        $counters['evaluations'] = DB::table('evaluation')
                     ->count();
      // $counters['placesEvaluation'] = DB::table('evaluation')->count();
      $counters['placesEvaluation'] = DB::table('evaluation')->distinct()->count(["idPlace"]);



        return $counters;
    }

    public static function countersFilterByUser()
    {
        $userId = Auth::user()->id;
        $roll = Auth::user()->roll;
        $counters = array();
        if ($roll == 'administrador') {
            $counters['lugares'] = DB::table('places')->count();
            $counters['rechazados'] = DB::table('places')
                        ->where('places.aprobado', '=', -1)
                         ->count();
            $counters['aprobados'] = DB::table('places')

                        ->where('places.aprobado', '=', 1)
                         ->count();
            $counters['pendientes'] = DB::table('places')

                        ->where('places.aprobado', '=', 0)
                         ->count();
            $counters['sinGeo'] = DB::table('places')

                        ->whereNull('places.latitude')
                        ->count();
            $counters['conGeo'] = DB::table('places')
                          ->whereNull('places.latitude')
                         ->count();
            $counters['errorGeo'] = DB::table('places')
                           ->where('places.confidence', '=', 0.5)
                         ->count();
            $counters['conGeo'] = DB::table('places')
                          ->whereNotNull('places.latitude')
                         ->count();

            $counters['paises'] = DB::table('pais')
                         ->count();
            $counters['ciudades'] = DB::table('provincia')
                         ->count();
            $counters['partido'] = DB::table('partido')
                         ->count();
            $counters['evaluations'] = DB::table('evaluation')
                         ->count();
          // $counters['placesEvaluation'] = DB::table('evaluation')->count();
          $counters['placesEvaluation'] = DB::table('evaluation')->distinct()->count(["idPlace"]);
        } else {
            $counters['lugares'] = DB::table('places')
                                   ->join('user_country', 'user_country.id_country', '=', 'places.idPais')
                                   ->where('user_country.id_user', '=', $userId)
                                   ->count();
            $counters['rechazados'] = DB::table('places')
                        ->join('user_country', 'user_country.id_country', '=', 'places.idPais')
                        ->where('user_country.id_user', '=', $userId)
                        ->where('places.aprobado', '=', -1)
                         ->count();
            $counters['aprobados'] = DB::table('places')
                          ->join('user_country', 'user_country.id_country', '=', 'places.idPais')
                          ->where('user_country.id_user', '=', $userId)
                        ->where('places.aprobado', '=', 1)
                         ->count();
            $counters['pendientes'] = DB::table('places')
                     ->join('user_country', 'user_country.id_country', '=', 'places.idPais')
                     ->where('user_country.id_user', '=', $userId)
                        ->where('places.aprobado', '=', 0)
                         ->count();
            $counters['sinGeo'] = DB::table('places')
                        ->join('user_country', 'user_country.id_country', '=', 'places.idPais')
                        ->where('user_country.id_user', '=', $userId)
                        ->whereNull('places.latitude')
                        ->count();
            $counters['conGeo'] = DB::table('places')
                        ->join('user_country', 'user_country.id_country', '=', 'places.idPais')
                        ->where('user_country.id_user', '=', $userId)
                          ->whereNull('places.latitude')
                         ->count();
            $counters['errorGeo'] = DB::table('places')
                          ->join('user_country', 'user_country.id_country', '=', 'places.idPais')
                          ->where('user_country.id_user', '=', $userId)
                           ->where('places.confidence', '=', 0.5)
                         ->count();
            $counters['conGeo'] = DB::table('places')
                        ->join('user_country', 'user_country.id_country', '=', 'places.idPais')
                        ->where('user_country.id_user', '=', $userId)
                          ->whereNotNull('places.latitude')
                         ->count();

            $counters['paises'] = DB::table('pais')
                        ->join('user_country', 'user_country.id_country', '=', 'pais.id')
                        ->where('user_country.id_user', '=', $userId)
                         ->count();
            $counters['ciudades'] = DB::table('provincia')
                        ->join('user_country', 'user_country.id_country', '=', 'provincia.idPais')
                        ->where('user_country.id_user', '=', $userId)
                         ->count();
            $counters['partido'] = DB::table('partido')
                        ->join('user_country', 'user_country.id_country', '=', 'partido.idPais')
                        ->where('user_country.id_user', '=', $userId)
                         ->count();
            $counters['evaluations'] = DB::table('evaluation')
          ->join('places', 'places.placeId', '=', 'evaluation.idPlace')
          ->join('user_country', 'user_country.id_country', '=', 'places.idPais')
          ->where('user_country.id_user', '=', $userId)
                         ->count();
          // $counters['placesEvaluation'] = DB::table('evaluation')->count();
          $counters['placesEvaluation'] = DB::table('evaluation')
          ->join('places', 'places.placeId', '=', 'evaluation.idPlace')
          ->join('user_country', 'user_country.id_country', '=', 'places.idPais')
          ->where('user_country.id_user', '=', $userId)
          ->distinct()
          ->count(["idPlace"]);
        }

        return $counters;
    }

    public static function getCitiRanking()
    {
        $userId = Auth::user()->id;
        $roll = Auth::user()->roll;
        if ($roll == 'administrador') {
            return
              DB::table('places')
                     ->select(

                      DB::raw('count(*) as lugares, nombre_pais,
                        nombre_provincia, nombre_partido'))
                     ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
                     ->join('partido', 'places.idPartido', '=', 'partido.id')
                     ->join('pais', 'places.idPais', '=', 'pais.id')
                     ->orderBy('lugares', 'desc')
                     ->groupBy('idPartido')
                     ->get();
        } else {
            $plac= DB::table('places')
                     ->select(

                      DB::raw('count(*) as lugares, nombre_pais,
                        nombre_provincia, nombre_partido'))
                     ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
                     ->join('partido', 'places.idPartido', '=', 'partido.id')
                     ->join('pais', 'places.idPais', '=', 'pais.id')
                     ->join('user_country', 'user_country.id_country', '=', 'places.idPais')
                     ->where('user_country.id_user', '=', $userId)
                     ->orderBy('lugares', 'desc')
                     ->groupBy('idPartido')
                     ->get();

            return $plac;
        }
    }

    public static function getCountryRanking()
    {

            return
              DB::table('places')
                     ->select(
                      DB::raw('count(*) as lugares, nombre_pais , id'))
                     ->join('pais', 'places.idPais', '=', 'pais.id')
                     ->orderBy('lugares', 'desc')
                     ->groupBy('idPais')
                     ->get();

    }


    public static function getNonGeoFilterByUser()
    {
        $userId = Auth::user()->id;
        $roll = Auth::user()->roll;
        if ($roll == 'administrador') {
            return
            DB::table('places')
                   ->select(DB::raw('count(*) as lugares, nombre_pais,
                      nombre_provincia, nombre_partido'))
                   ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
                   ->join('partido', 'places.idPartido', '=', 'partido.id')
                   ->join('pais', 'places.idPais', '=', 'pais.id')
                   ->whereNull('latitude')
                   ->orderBy('lugares', 'desc')
                   ->groupBy('idPartido')
                   ->get();
        } else {
            return
            DB::table('places')
                   ->select(DB::raw('count(*) as lugares, nombre_pais,
                      nombre_provincia, nombre_partido'))
                   ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
                   ->join('partido', 'places.idPartido', '=', 'partido.id')
                   ->join('pais', 'places.idPais', '=', 'pais.id')
                   ->join('user_country', 'user_country.id_country', '=', 'places.idPais')
                   ->where('user_country.id_user', '=', $userId)
                   ->whereNull('latitude')
                   ->orderBy('lugares', 'desc')
                   ->groupBy('idPartido')
                   ->get();
        }
    }

    public static function getNonGeo()
    {
        return
              DB::table('places')
                     ->select(DB::raw('count(*) as lugares, nombre_pais,
                        nombre_provincia, nombre_partido'))
                     ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
                     ->join('partido', 'places.idPartido', '=', 'partido.id')
                     ->join('pais', 'places.idPais', '=', 'pais.id')
                     ->whereNull('latitude')
                     ->orderBy('lugares', 'desc')
                     ->groupBy('idPartido')
                     ->get();
    }

    public static function getBadGeoFilterByUser()
    {
      $userId = Auth::user()->id;
      $roll = Auth::user()->roll;
      if ($roll == 'administrador') {
        return
              DB::table('places')
                     ->select(DB::raw('count(*) as lugares, nombre_pais,
                        nombre_provincia, nombre_partido'))
                     ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
                     ->join('partido', 'places.idPartido', '=', 'partido.id')
                     ->join('pais', 'places.idPais', '=', 'pais.id')
                     ->where('confidence', '=', 0.5)
                     ->orderBy('lugares', 'desc')
                     ->groupBy('idPartido')
                     ->get();
      }
      else {
        return
              DB::table('places')
                     ->select(DB::raw('count(*) as lugares, nombre_pais,
                        nombre_provincia, nombre_partido'))
                     ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
                     ->join('partido', 'places.idPartido', '=', 'partido.id')
                     ->join('pais', 'places.idPais', '=', 'pais.id')
                     ->join('user_country', 'user_country.id_country', '=', 'places.idPais')
                     ->where('user_country.id_user', '=', $userId)
                     ->where('confidence', '=', 0.5)
                     ->orderBy('lugares', 'desc')
                     ->groupBy('idPartido')
                     ->get();
      }


    }

    public static function getBadGeo()
    {
        return
              DB::table('places')
                     ->select(DB::raw('count(*) as lugares, nombre_pais,
                        nombre_provincia, nombre_partido'))
                     ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
                     ->join('partido', 'places.idPartido', '=', 'partido.id')
                     ->join('pais', 'places.idPais', '=', 'pais.id')
                     ->where('confidence', '=', 0.5)
                     ->orderBy('lugares', 'desc')
                     ->groupBy('idPartido')
                     ->get();
    }

    public static function showDreprecated()
    {
        return DB::table('places')
      ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
      ->join('partido', 'places.idPartido', '=', 'partido.id')
      ->join('pais', 'places.idPais', '=', 'pais.id')
      ->where('places.aprobado', '=', -1)
      ->select()
      ->get();
    }

    public static function showDreprecatedFilterByUser()
    {
        $userId = Auth::user()->id;
        $roll = Auth::user()->roll;
        if ($roll == 'administrador') {
            return DB::table('places')
          ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
          ->join('partido', 'places.idPartido', '=', 'partido.id')
          ->join('pais', 'places.idPais', '=', 'pais.id')
          ->where('places.aprobado', '=', -1)
          ->select()
          ->get();
        } else {
            return DB::table('places')
          ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
          ->join('partido', 'places.idPartido', '=', 'partido.id')
          ->join('pais', 'places.idPais', '=', 'pais.id')
          ->join('user_country', 'user_country.id_country', '=', 'places.idPais')
          ->where('user_country.id_user', '=', $userId)
          ->where('places.aprobado', '=', -1)
          ->select()
          ->get();
        }
    }

    public function showPending()
    {
        // return
    $resu = DB::table('places')
      ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
      ->join('partido', 'places.idPartido', '=', 'partido.id')
      ->join('pais', 'places.idPais', '=', 'pais.id')
      ->where('places.aprobado', '=', 0)
      ->select()
      ->get();


        return $resu;
    }

    public function showPendingFilterByUser()
    {
        $userId = Auth::user()->id;
        $roll = Auth::user()->roll;

        if ($roll == 'administrador') {
            $resu = DB::table('places')
          ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
          ->join('partido', 'places.idPartido', '=', 'partido.id')
          ->join('pais', 'places.idPais', '=', 'pais.id')
          ->where('places.aprobado', '=', 0)
          ->select()
          ->get();
        } else {
            $resu = DB::table('places')
          ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
          ->join('partido', 'places.idPartido', '=', 'partido.id')
          ->join('pais', 'places.idPais', '=', 'pais.id')
          ->join('user_country', 'user_country.id_country', '=', 'places.idPais')
          ->where('user_country.id_user', '=', $userId)
          ->where('places.aprobado', '=', 0)
          ->select()
          ->get();
        }

        return $resu;
    }

    public function showPanel($id)
    {
        return DB::table('places')
        ->join('ciudad', 'places.idCiudad', '=', 'ciudad.id')
      ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
      ->join('partido', 'places.idPartido', '=', 'partido.id')
      ->join('pais', 'places.idPais', '=', 'pais.id')
      ->where('places.placeId', '=', $id)
      ->select()
      ->get();
    }

    public function block(Request $request, $id)
    {
        $request_params = $request->all();

        $place = Places::find($id);

        $place->aprobado = -1;

        $place->updated_at = date("Y-m-d H:i:s");
        $place->save();

        return [];
    }

    public function approve(Request $request, $id)
    {
        $request_params = $request->all();

        $place = Places::find($id);

        $place->aprobado = 1;

        $place->updated_at = date("Y-m-d H:i:s");
        $place->save();

        return [];
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
        $request_params = $request->all();

        $rules = array(
          'establecimiento' => 'required|max:150|min:2',
          'nombre_partido' => 'required|max:50|min:2',
          'nombre_provincia' => 'required|max:50|min:2',
          'nombre_pais' => 'required|max:50|min:4',
      );

        $messages = array(
          'required'    => 'El :attribute es requerido.',
          'max'    => 'El :attribute debe poseer un maximo de :max caracteres.',
        'min'    => 'El :attribute debe poseer un minimo de :min caracteres.');

        $validator = Validator::make($request_params, $rules, $messages);

        if ($validator->passes()) {
            $place = Places::find($id);

            $placeLog = new PlaceLog;
            $placeLog->entry_type = "update_manual";
            $placeLog->modification_date = date("Y-m-d");
            $placeLog->user_id = Auth::user()->id;
            $placeLog->save();

            $place->establecimiento = $request_params['establecimiento'];
            $place->calle = $request_params['calle'];
            $place->tipo = $request_params['tipo'];
            $place->altura = $request_params['altura'];
            $place->piso_dpto = $request_params['piso_dpto'];
            $place->observacion = $request_params['observacion'];
            $place->cruce = $request_params['cruce'];
            $place->latitude = $request_params['latitude'];
            $place->longitude = $request_params['longitude'];
            $place->confidence = $request_params['confidence'];
            $place->barrio_localidad = $request_params['barrio_localidad'];

            $place->idPais = $request_params['idPais'];
            $place->idProvincia = $request_params['idProvincia'];
            $place->idPartido = $request_params['idPartido'];


            $place->prueba = $request_params['prueba'];
            $place->responsable_testeo = $request_params['responsable_testeo'];
            $place->ubicacion_testeo = $request_params['ubicacion_testeo'];
            $place->horario_testeo = $request_params['horario_testeo'];
            $place->mail_testeo = $request_params['mail_testeo'];
            $place->tel_testeo = $request_params['tel_testeo'];
            $place->web_testeo = $request_params['web_testeo'];
            $place->observaciones_testeo = $request_params['observaciones_testeo'];

            $place->condones = $request_params['condones'];
            $place->responsable_distrib = $request_params['responsable_distrib'];
            $place->ubicacion_distrib = $request_params['ubicacion_distrib'];
            $place->horario_distrib = $request_params['horario_distrib'];
            $place->mail_distrib = $request_params['mail_distrib'];
            $place->tel_distrib = $request_params['tel_distrib'];
            $place->web_distrib = $request_params['web_distrib'];
            $place->comentarios_distrib = $request_params['comentarios_distrib'];

            $place->infectologia = $request_params['infectologia'];
            $place->responsable_infectologia = $request_params['responsable_infectologia'];
            $place->ubicacion_infectologia = $request_params['ubicacion_infectologia'];
            $place->horario_infectologia = $request_params['horario_infectologia'];
            $place->mail_infectologia = $request_params['mail_infectologia'];
            $place->tel_infectologia = $request_params['tel_infectologia'];
            $place->web_infectologia = $request_params['web_infectologia'];
            $place->comentarios_infectologia = $request_params['comentarios_infectologia'];

            $place->vacunatorio = $request_params['vacunatorio'];
            $place->responsable_vac = $request_params['responsable_vac'];
            $place->ubicacion_vac = $request_params['ubicacion_vac'];
            $place->horario_vac = $request_params['horario_vac'];
            $place->mail_vac = $request_params['mail_vac'];
            $place->tel_vac = $request_params['tel_vac'];
            $place->web_vac = $request_params['web_vac'];
            $place->comentarios_vac = $request_params['comentarios_vac'];

            //nuevos datos para checkBox
            $place->es_rapido = $request_params['es_rapido'];


            $place->mac = $request_params['mac'];
            $place->responsable_mac = $request_params['responsable_mac'];
            $place->ubicacion_mac = $request_params['ubicacion_mac'];
            $place->horario_mac = $request_params['horario_mac'];
            $place->mail_mac = $request_params['mail_mac'];
            $place->tel_mac = $request_params['tel_mac'];
            $place->web_mac = $request_params['web_mac'];
            $place->comentarios_mac = $request_params['comentarios_mac'];

            $place->ile = $request_params['ile'];
            $place->responsable_ile = $request_params['responsable_ile'];
            $place->ubicacion_ile = $request_params['ubicacion_ile'];
            $place->horario_ile = $request_params['horario_ile'];
            $place->mail_ile = $request_params['mail_ile'];
            $place->tel_ile = $request_params['tel_ile'];
            $place->web_ile = $request_params['web_ile'];
            $place->comentarios_ile = $request_params['comentarios_ile'];

            $place->ssr = $request_params['ssr'];
            $place->responsable_ssr = $request_params['responsable_ssr'];
            $place->ubicacion_ssr = $request_params['ubicacion_ssr'];
            $place->horario_ssr = $request_params['horario_ssr'];
            $place->mail_ssr = $request_params['mail_ssr'];
            $place->tel_ssr = $request_params['tel_ssr'];
            $place->web_ssr = $request_params['web_ssr'];
            $place->comentarios_ssr = $request_params['comentarios_ssr'];

            $place->dc = $request_params['dc'];
            $place->responsable_dc = $request_params['responsable_dc'];
            $place->ubicacion_dc = $request_params['ubicacion_dc'];
            $place->horario_dc = $request_params['horario_dc'];
            $place->mail_dc = $request_params['mail_dc'];
            $place->tel_dc = $request_params['tel_dc'];
            $place->web_dc = $request_params['web_dc'];
            $place->comentarios_dc = $request_params['comentarios_dc'];

            $place->servicetype_dc = $request_params['servicetype_dc'];
            $place->servicetype_ssr = $request_params['servicetype_ssr'];
            $place->servicetype_mac = $request_params['servicetype_mac'];
            $place->servicetype_prueba = $request_params['servicetype_prueba'];
            $place->servicetype_ile = $request_params['servicetype_ile'];
            $place->servicetype_condones = $request_params['servicetype_condones'];

            $place->friendly_dc = $request_params['friendly_dc'];
            $place->friendly_ssr = $request_params['friendly_ssr'];
            $place->friendly_mac = $request_params['friendly_mac'];
            $place->friendly_ile = $request_params['friendly_ile'];
            $place->friendly_prueba = $request_params['friendly_prueba'];
            $place->friendly_condones = $request_params['friendly_condones'];


        //Updating localidad

        if (isset($request_params['otro_partido'])) {
            if ($request_params['otro_partido'] != '') {
                $localidad_tmp =
               DB::table('partido')
                ->where('partido.idPais', $place->idPais)
                ->where('partido.idProvincia', $place->idProvincia)
                ->where('nombre_partido', '=', $request_params['otro_partido'])
                ->select()
                ->get();



                if (count($localidad_tmp) === 0) {
                    $localidad = new Partido;
                    $localidad->nombre_partido =
                    $request_params['otro_partido'];
                    $localidad->idProvincia = $place->idProvincia;
                    $localidad->idPais = $place->idPais;
                    $localidad->habilitado = true;
                    $localidad->updated_at = date("Y-m-d H:i:s");
                    $localidad->created_at = date("Y-m-d H:i:s");
                    $localidad->save();
                    $place->idPartido = $localidad->id;
                } else {
                    $place->idPartido = $localidad_tmp[0]->id;
                }
            }
        }

            $place->updated_at = date("Y-m-d H:i:s");
            $place->logId = $placeLog->id;
            $place->save();
        }

        return $validator->messages();
    }

    public function getAllPlaces(Request $request)
    {
        try {
            return DB::table('places')
            ->paginate(100);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public function getApproved(Request $request)
    {
        try {
            return DB::table('places')
            ->where('aprobado', '=' , 1)
            ->paginate(100);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public function getAllApproved(Request $request)
    {
        try {
            return DB::table('places')
              ->where('aprobado', '=' , 1)
              ->select('establecimiento')
              ->get();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getAllPartidos(Request $request)
    {
        try {
            return DB::table('partido')->paginate(100);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getAllProvincias(Request $request)
    {
        try {
            return DB::table('provincia')->paginate(100);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getAllPaises(Request $request)
    {
        try {
            return DB::table('pais')->paginate(100);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getAllAutocomplete(Request $request){

          if($request->has("nombre_partido")){

              $param = "%".$request->nombre_partido."%";

              $ciudades = DB::table('ciudad')
                            ->select('ciudad.id','ciudad.nombre_ciudad', 'partido.nombre_partido', 'provincia.nombre_provincia', 'pais.nombre_pais', 'ciudad.idPartido', 'ciudad.idProvincia', 'ciudad.idPais')
                            ->join('partido', 'partido.id', '=', 'ciudad.idPartido')
                            ->join('provincia', 'provincia.id', '=', 'ciudad.idProvincia')
                            ->join('pais', 'pais.id', '=', 'ciudad.idPais')
                            ->where('ciudad.habilitado', '=', 1)
                            ->where('ciudad.nombre_ciudad', 'like', $param)
                            ->get();

              $partidos = DB::table('partido')
                            ->select('partido.id','partido.nombre_partido', 'provincia.nombre_provincia', 'pais.nombre_pais', 'partido.idProvincia', 'partido.idPais')
                            ->join('provincia', 'provincia.id', '=', 'partido.idProvincia')
                            ->join('pais', 'pais.id', '=', 'partido.idPais')
                            ->where('partido.habilitado', '=', 1)
                            ->where('partido.nombre_partido', 'like', $param)
                            ->get();

              $multimedia = $partidos->merge($ciudades);

              return response()->json($multimedia);

           }
    }

    public function getAllAutocompleteName(Request $request){

        if($request->has("nombre_partido")){

            $param = "%".$request->nombre_partido."%";

            $places = DB::table('places')
              ->select('places.establecimiento')
              ->where('places.establecimiento', 'like', $param)
              ->get();

            $multimedia = (array)$places;

            return response()->json($multimedia);
         }

    }

    public function getPlacesByName($name, $service){

        $places = DB::table('places')
        ->join('partido', 'places.idPartido', '=', 'partido.id')
        ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
        ->join('pais', 'places.idPais', '=', 'pais.id')
        ->join('ciudad', 'places.idCiudad', '=', 'ciudad.id')
        ->where($service,'=',1)
        ->where(function ($query) use ($name) {
            $query->orWhere('calle', 'LIKE', '%'. $name .'%')
            ->orWhere('altura', 'LIKE', '%'. $name .'%')
            ->orWhere(DB::raw('concat(calle," ",altura)'), 'LIKE', '%'. $name .'%')
            ->orWhere('places.establecimiento', 'like', '%'.$name. '%');
         })
         ->select('places.*', 'pais.nombre_pais', 'ciudad.nombre_ciudad',
         'partido.nombre_partido', 'provincia.nombre_provincia')
         ->get();

        return response()->json($places);
    }

    public function listAllAutocompleteName(){
        // For the app
        $multimedia = array();

        $places = DB::table('places')
          ->select('places.establecimiento')
          ->where('places.aprobado', '=', 1)
          ->get();

        $multimedia = (array)$places;

        return response()->json($multimedia);

    }

    public function getpPlacesByParty($pid, $service){


      $places = DB::table('places')
        ->join('partido', 'places.idPartido', '=', 'partido.id')
        ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
        ->join('pais', 'places.idPais', '=', 'pais.id')
        ->join('ciudad', 'places.idCiudad', '=', 'ciudad.id')
        ->where($service,'=',1)
        ->where('places.idPartido', $pid)
        ->where('places.aprobado', '=', 1)
        ->select()
        ->get();

      return $places;

    }

    public function elimina_acentos($text) {
      $text = htmlentities($text, ENT_QUOTES, 'UTF-8');
      $text = strtolower($text);
      $patron = array (
        '/\+/' => '',
        '/&agrave;/' => 'a',
        '/&egrave;/' => 'e',
        '/&igrave;/' => 'i',
        '/&ograve;/' => 'o',
        '/&ugrave;/' => 'u',
        '/&aacute;/' => 'a',
        '/&eacute;/' => 'e',
        '/&iacute;/' => 'i',
        '/&oacute;/' => 'o',
        '/&uacute;/' => 'u',
        '/&acirc;/' => 'a',
        '/&ecirc;/' => 'e',
        '/&icirc;/' => 'i',
        '/&ocirc;/' => 'o',
        '/&ucirc;/' => 'u',
        '/&atilde;/' => 'a',
        '/&etilde;/' => 'e',
        '/&itilde;/' => 'i',
        '/&otilde;/' => 'o',
        '/&utilde;/' => 'u',
        '/&auml;/' => 'a',
        '/&euml;/' => 'e',
        '/&iuml;/' => 'i',
        '/&ouml;/' => 'o',
        '/&uuml;/' => 'u',
        '/&auml;/' => 'a',
        '/&euml;/' => 'e',
        '/&iuml;/' => 'i',
        '/&ouml;/' => 'o',
        '/&uuml;/' => 'u',
            // Otras letras y caracteres especiales
        '/&aring;/' => 'a',
        '/&ntilde;/' => 'n',
            // Agregar aqui mas caracteres si es necesario
        );
      $text = preg_replace(array_keys($patron),array_values($patron),$text);
      return $text;
    }

    public function listAllAutocomplete(){
    // For the app
    $multimedia = array();

    $partidos = DB::table('partido')
         ->select('partido.id','partido.nombre_partido','partido.idProvincia','provincia.nombre_provincia', 'partido.idPais','pais.nombre_pais')
         ->join('provincia', 'provincia.id', '=', 'partido.idProvincia')
         ->join('pais', 'pais.id', '=', 'partido.idPais')
         ->where('partido.habilitado', '=', 1)
         ->get();

    $ciudades = DB::table('ciudad')
      ->select('ciudad.id','ciudad.nombre_ciudad','ciudad.idPartido', 'partido.nombre_partido', 'ciudad.idProvincia','provincia.nombre_provincia','ciudad.idPais','pais.nombre_pais')
      ->join('partido', 'partido.id', '=', 'ciudad.idPartido')
      ->join('provincia', 'provincia.id', '=', 'ciudad.idProvincia')
      ->join('pais', 'pais.id', '=', 'ciudad.idPais')
      ->where('ciudad.habilitado', '=', 1)
      ->get();

    $multimedia = $partidos->merge($ciudades);

    return response()->json($multimedia);

  }
  public function citiesAllAutocomplete(){
   
     $ciudades = DB::table('ciudad')
      ->select('ciudad.id','ciudad.nombre_ciudad','ciudad.idPartido', 'partido.nombre_partido', 'ciudad.idProvincia','provincia.nombre_provincia','ciudad.idPais','pais.nombre_pais')
      ->join('partido', 'partido.id', '=', 'ciudad.idPartido')
      ->join('provincia', 'provincia.id', '=', 'ciudad.idProvincia')
      ->join('pais', 'pais.id', '=', 'ciudad.idPais')
      ->where('ciudad.habilitado', '=', 1)
      ->get();


    return response()->json($ciudades);

  }

    public static function getBestRatedPlaces($pid)
    {
        return DB::table('places')
        ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
        ->join('partido', 'places.idPartido', '=', 'partido.id')
        ->join('pais', 'places.idPais', '=', 'pais.id')
        ->where('places.idPartido', $pid)
        ->select('places.cantidad_votos', 'places.puntaje', 'places.rate')
        // ->select()
        ->orderBy('rate', 'desc') //asc el otro metodo
        ->get();
    }

    public static function getPlaceEvaluationsFilterByService($placeId, $services)
    {
      $evaluations = DB::table('evaluation')
      ->where('evaluation.idPlace', $placeId)
      ->join('places', 'evaluation.idPlace', '=', 'places.placeId')
      ->join('provincia', 'places.idProvincia', '=', 'provincia.id')
      ->join('partido', 'places.idPartido', '=', 'partido.id')
      ->join('ciudad', 'places.idCiudad', '=', 'ciudad.id')
      ->join('pais', 'places.idPais', '=', 'pais.id')
      ->select('ciudad.nombre_ciudad','provincia.nombre_provincia', 'partido.nombre_partido', 'pais.nombre_pais', 'places.placeId', 'places.establecimiento', 'places.calle', 'places.altura', 'places.barrio_localidad', 'places.condones', 'places.prueba', 'places.ssr', 'places.dc', 'places.mac', 'places.ile', 'places.es_rapido', 'evaluation.*')
      ->get();

      return $evaluations;
    }
}
