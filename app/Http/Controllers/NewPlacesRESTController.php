<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ProvinciaRESTController;
use App\Provincia;
use App\Places;
use App\PlaceLog;
use Validator;
use DB;

class NewPlacesRESTController extends Controller
{

    public function getParam($params, $key, $default ='')
    {
        // Get all of our request params

        return ( (

          !isset($params[$key])) || empty($params[$key]))
        ? $default : $params[$key];
    }

    /**
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
      $request_params = $request->all();

      $rules = array(
          'establecimiento' => 'required|max:150|min:2',
          'idPartido' => 'required',
          'idPais' => 'required',
          'idProvincia' => 'required',
          'idCiudad' => 'required',
          'calle' => 'required',

      );

      $messages = array(
          'required'    => 'El :attribute es requerido.',
          'max'    => 'El :attribute debe poseer un maximo de :max caracteres.',
        'min'    => 'El :attribute debe poseer un minimo de :min caracteres.');

      $validator = Validator::make($request_params,$rules,$messages);
      $params = $request_params;
      if ($validator->passes ()){
        $placeLog = new PlaceLog;
        $placeLog->entry_type = "sugerido";
        $placeLog->modification_date = date("Y-m-d");
        $placeLog->save();

        $place = new Places;
        $place->establecimiento = $this->getParam($params,'establecimiento');
        $place->calle = $this->getParam($params,'calle');
        $place->tipo = $this->getParam($params,'tipo');
        $place->altura = $this->getParam($params,'altura');
        $place->piso_dpto = $this->getParam($params,'piso_dpto');
        $place->observacion = $this->getParam($params,'observacion');
        $place->cruce = $this->getParam($params,'cruce');
        $place->latitude = $this->getParam($params,'latitude');
        $place->longitude = $this->getParam($params,'longitude');
        $place->barrio_localidad = $this->getParam($params,'barrio_localidad');


        $place->condones = $this->getParam($params,'condones',false);
        $place->responsable_distrib = $this->getParam($params,'responsable_distrib');
        $place->ubicacion_distrib = $this->getParam($params,'ubicacion_distrib');
        $place->horario_distrib = $this->getParam($params,'horario_distrib');
        $place->mail_distrib = $this->getParam($params,'mail_distrib');
        $place->tel_distrib = $this->getParam($params,'tel_distrib');
        $place->web_distrib = $this->getParam($params,'web_distrib');
        $place->comentarios_distrib = $this->getParam($params,'comentarios_distrib');

        $place->prueba = $this->getParam($params,'prueba',false);
        $place->responsable_testeo = $this->getParam($params,'responsable_testeo');
        $place->ubicacion_testeo = $this->getParam($params,'ubicacion_testeo');
        $place->horario_testeo = $this->getParam($params,'horario_testeo');
        $place->mail_testeo = $this->getParam($params,'mail_testeo');
        $place->tel_testeo = $this->getParam($params,'tel_testeo');
        $place->web_testeo = $this->getParam($params,'web_testeo');
        $place->observaciones_testeo = $this->getParam($params,'observaciones_testeo');

        $place->infectologia = $this->getParam($params,'infectologia',false);
        $place->responsable_infectologia = $this->getParam($params,'responsable_infectologia');
        $place->ubicacion_infectologia = $this->getParam($params,'ubicacion_infectologia');
        $place->horario_infectologia = $this->getParam($params,'horario_infectologia');
        $place->mail_infectologia = $this->getParam($params,'mail_infectologia');
        $place->tel_infectologia = $this->getParam($params,'tel_infectologia');
        $place->web_infectologia = $this->getParam($params,'web_infectologia');
        $place->comentarios_infectologia = $this->getParam($params,'comentarios_infectologia');

        $place->vacunatorio = $this->getParam($params,'vacunatorio',false);
        $place->responsable_vac = $this->getParam($params,'responsable_vac');
        $place->ubicacion_vac = $this->getParam($params,'ubicacion_vac');
        $place->horario_vac = $this->getParam($params,'horario_vac');
        $place->mail_vac = $this->getParam($params,'mail_vac');
        $place->tel_vac = $this->getParam($params,'tel_vac');
        $place->web_vac = $this->getParam($params,'web_vac');
        $place->comentarios_vac = $this->getParam($params,'comentarios_vac');

        $place->mac = $this->getParam($params,'mac',false);
        $place->responsable_mac = $this->getParam($params,'responsable_mac');
        $place->ubicacion_mac = $this->getParam($params,'ubicacion_mac');
        $place->horario_mac = $this->getParam($params,'horario_mac');
        $place->mail_mac = $this->getParam($params,'mail_mac');
        $place->tel_mac = $this->getParam($params,'tel_mac');
        $place->web_mac = $this->getParam($params,'web_mac');
        $place->comentarios_mac = $this->getParam($params,'comentarios_mac');

        $place->ile = $this->getParam($params,'ile',false);
        $place->responsable_ile = $this->getParam($params,'responsable_ile');
        $place->ubicacion_ile = $this->getParam($params,'ubicacion_ile');
        $place->horario_ile = $this->getParam($params,'horario_ile');
        $place->mail_ile = $this->getParam($params,'mail_ile');
        $place->tel_ile = $this->getParam($params,'tel_ile');
        $place->web_ile = $this->getParam($params,'web_ile');
        $place->comentarios_ile = $this->getParam($params,'comentarios_ile');

        $place->dc = $this->getParam($params,'dc',false);
        $place->responsable_dc = $this->getParam($params,'responsable_dc');
        $place->ubicacion_dc = $this->getParam($params,'ubicacion_dc');
        $place->horario_dc = $this->getParam($params,'horario_dc');
        $place->mail_dc = $this->getParam($params,'mail_dc');
        $place->tel_dc = $this->getParam($params,'tel_dc');
        $place->web_dc = $this->getParam($params,'web_dc');
        $place->comentarios_dc = $this->getParam($params,'comentarios_dc');

        $place->ssr = $this->getParam($params,'ssr',false);
        $place->responsable_ssr = $this->getParam($params,'responsable_ssr');
        $place->ubicacion_ssr = $this->getParam($params,'ubicacion_ssr');
        $place->horario_ssr = $this->getParam($params,'horario_ssr');
        $place->mail_ssr = $this->getParam($params,'mail_ssr');
        $place->tel_ssr = $this->getParam($params,'tel_ssr');
        $place->web_ssr = $this->getParam($params,'web_ssr');
        $place->comentarios_ssr = $this->getParam($params,'comentarios_ssr');

        $place->aprobado = 0;

        $place->idPais = $this->getParam($params,'idPais');
        $place->idProvincia = $this->getParam($params,'idProvincia');
        $place->idPartido = $this->getParam($params,'idPartido');
        $place->idCiudad = $this->getParam($params,'idCiudad');

        if ($this->getParam($params,'condones') && $this->getParam($params,'servicetype_condones')) $place->servicetype_condones =  $this->getParam($params,'servicetype_condones');
        if ($this->getParam($params,'prueba') && $this->getParam($params,'servicetype_prueba')) $place->servicetype_prueba =  $this->getParam($params,'servicetype_prueba');
        if ($this->getParam($params,'mac') && $this->getParam($params,'servicetype_mac')) $place->servicetype_mac =  $this->getParam($params,'servicetype_mac');
        if ($this->getParam($params,'ile') && $this->getParam($params,'servicetype_ile')) $place->servicetype_ile =  $this->getParam($params,'servicetype_ile');
        if ($this->getParam($params,'ssr') && $this->getParam($params,'servicetype_ssr')) $place->servicetype_ssr =  $this->getParam($params,'servicetype_ssr');
        if ($this->getParam($params,'dc') && $this->getParam($params,'servicetype_dc')) $place->servicetype_dc =  $this->getParam($params,'servicetype_dc');

        if ($this->getParam($params,'condones')) $place->friendly_condones =  $this->getParam($params,'friendly_condones');
        if ($this->getParam($params,'ile')) $place->friendly_ile =  $this->getParam($params,'friendly_ile');
        if ($this->getParam($params,'mac')) $place->friendly_mac =  $this->getParam($params,'friendly_mac');
        if ($this->getParam($params,'prueba')) $place->friendly_prueba =  $this->getParam($params,'friendly_prueba');
        if ($this->getParam($params,'ssr')) $place->friendly_ssr =  $this->getParam($params,'friendly_ssr');
        if ($this->getParam($params,'dc')) $place->friendly_dc =  $this->getParam($params,'friendly_dc');

        if (isset($request_params['otro_partido']))
        {
            if ($request_params['otro_partido'] != '')
            {
               $localidad_tmp =
               DB::table('partido')
                ->where('partido.idPais',$place->idPais)
                ->where('partido.idProvincia', $place->idProvincia)
                ->where('nombre_partido','=',$request_params['otro_partido'])
                ->select()
                ->get();



              if(count($localidad_tmp) === 0){
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
              }else{
                  $place->idPartido = $localidad_tmp[0]->id;
              }
            }

        }
        $place->created_at = date("Y-m-d H:i:s");
        $place->updated_at = date("Y-m-d H:i:s");
        $place->logId = $placeLog->id;
        $place->save();

      }

      return $validator->messages();
    }



}
