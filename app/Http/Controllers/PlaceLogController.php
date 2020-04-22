<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\PlaceLog;
use Excel;
use Illuminate\Support\Facades\Input;
use Storage;
use DB;
use App\Pais;
use App\Provincia;
use App\Partido;
use App\Places;
use App\Evaluation;
use League\Csv\Writer;
use League\Csv\Reader;
use Session;
use Image;
use ImageServiceProvider;
use Validator;
use Redirect;
use Exception;
use App\Exceptions\CustomException;

use PHPExcel_Cell;

use SplTempFileObject;
use SplFileObject;
use SplFileInfo;

class PlaceLogController extends Controller
{
    public $csvColumns = 'id,establecimiento,tipo,calle,altura,piso_dpto,cruce,barrio_localidad,partido_comuna,provincia_region,pais,aprobado,observacion,formattedAddress,latitude,longitude,habilitado,confidence,condones,prueba,mac,ile,dc,ssr,es_rapido,tel_condones,mail_condones,horario_condones,responsable_condones,web_condones,ubicacion_condones,comentarios_condones,tel_prueba,mail_prueba,horario_prueba,responsable_prueba,web_prueba,ubicacion_prueba,observaciones_prueba,tel_mac,mail_mac,horario_mac,responsable_mac,web_mac,ubicacion_mac,comentarios_mac,tel_ile,mail_ile,horario_ile,responsable_ile,web_ile,ubicacion_ile,comentarios_ile,tel_dc,mail_dc,horario_dc,responsable_dc,web_dc,ubicacion_dc,comentarios_dc,tel_ssr,mail_ssr,horario_ssr,responsable_ssr,web_ssr,ubicacion_ssr,comentarios_ssr,servicetype_condones,servicetype_prueba,servicetype_mac,servicetype_ile,servicetype_dc,servicetype_ssr,friendly_condones,friendly_prueba,friendly_mac,friendly_ile,friendly_dc,friendly_ssr';
    public $csvColumns_arrayFormat = array('id','establecimiento','tipo','calle','altura','piso_dpto','cruce','barrio_localidad','partido_comuna','provincia_region','pais,aprobado','observacion','formattedAddress','latitude','longitude','habilitado','confidence','condones','prueba','mac','ile','dc','ssr','es_rapido','tel_condones','mail_condones','horario_condones','responsable_condones','web_condones','ubicacion_condones','comentarios_condones','tel_prueba','mail_prueba','horario_prueba','responsable_prueba','web_prueba','ubicacion_prueba','observaciones_prueba','tel_mac,mail_mac','horario_mac','responsable_mac','web_mac','ubicacion_mac','comentarios_mac','tel_ile','mail_ile','horario_ile','responsable_ile','web_ile','ubicacion_ile','comentarios_ile','tel_dc','mail_dc','horario_dc','responsable_dc','web_dc','ubicacion_dc','comentarios_dc','tel_ssr','mail_ssr','horario_ssr','responsable_ssr','web_ssr','ubicacion_ssr','comentarios_ssr','servicetype_condones','servicetype_prueba','servicetype_mac','servicetype_ile','servicetype_dc','servicetype_ssr','friendly_condones','friendly_prueba','friendly_mac','friendly_ile','friendly_dc','friendly_ssr');

    public function parseToExport($string)
    {
        if ($string == 1) {
            $string = "SI";
        } else {
            $string = "NO";
        }
        return $string;
    }

    public function insertArraObejectsDataIntoCsv_places($data)
    {
        $csv = Writer::createFromFileObject(new SplTempFileObject());
        //header
                //$csv->insertOne('id,establecimiento,tipo,calle,altura,piso_dpto,cruce,barrio_localidad,partido_comuna,provincia_region,pais,aprobado,observacion,formattedAddress,latitude,longitude,habilitado,confidence,condones,prueba,vacunatorio,infectologia,mac,ile,es_rapido,tel_testeo,mail_testeo,horario_testeo,responsable_testeo,web_testeo,ubicacion_testeo,observaciones_testeo,tel_distrib,mail_distrib,horario_distrib,responsable_distrib,web_distrib,ubicacion_distrib,comentarios_distrib,tel_infectologia,mail_infectologia,horario_infectologia,responsable_infectologia,web_infectologia,ubicacion_infectologia,comentarios_infectologia,tel_vac,mail_vac,horario_vac,responsable_vac,web_vac,ubicacion_vac,comentarios_vac,tel_mac,mail_mac,horario_mac,responsable_mac,web_mac,ubicacion_mac,comentarios_mac,tel_ile,mail_ile,horario_ile,responsable_ile,web_ile,ubicacion_ile,comentarios_ile');
                $csv->insertOne($this->csvColumns);
                //body
                foreach ($data as $key => $p) {
                    $p->condones = $this->parseToExport($p->condones);
                    $p->prueba= $this->parseToExport($p->prueba);
            //  	$p['vacunatorio']= $this->parseToExport($p['vacunatorio']);
            //  	$p['infectologia']= $this->parseToExport($p['infectologia']);
                    $p->mac= $this->parseToExport($p->mac);
                    $p->ile = $this->parseToExport($p->ile);
                    $p->ssr = $this->parseToExport($p->ssr);
                    $p->dc= $this->parseToExport($p->dc);
                    $p->es_rapido= $this->parseToExport($p->es_rapido);

                    $p->friendly_dc= $this->parseToExport($p->friendly_dc);
                    $p->friendly_ile= $this->parseToExport($p->friendly_ile);
                    $p->friendly_mac= $this->parseToExport($p->friendly_mac);
                    $p->friendly_ssr= $this->parseToExport($p->friendly_ssr);
                    $p->friendly_prueba= $this->parseToExport($p->friendly_prueba);
                    $p->friendly_condones= $this->parseToExport($p->friendly_condones);
                    $csv->insertOne([
                        $p->placeId,
                        $p->establecimiento,
                        $p->tipo,
                        $p->calle,
                        $p->altura,
                $p->piso_dpto,
                $p->cruce,
                $p->barrio_localidad,
                //$p->partido_comuna,
                $p->nombre_partido,
                //$p->provincia_region,
                $p->nombre_provincia,
                $p->nombre_pais,
                $p->aprobado,
                $p->observacion,
                $p->formattedAddress,
                $p->latitude,
                $p->longitude,
                $p->habilitado,
                $p->confidence,
                $p->condones,
                $p->prueba,
        //		$p['vacunatorio'],
            //	$p['infectologia'],
                $p->mac,
                $p->ile,
                $p->dc,
                $p->ssr,
                $p->es_rapido,
                $p->tel_distrib,
                $p->mail_distrib,
                $p->horario_distrib,
                $p->responsable_distrib,
                $p->web_distrib,
                $p->ubicacion_distrib,
                $p->comentarios_distrib,
                $p->tel_testeo,
                $p->mail_testeo,
                $p->horario_testeo,
                $p->responsable_testeo,
                $p->web_testeo,
                $p->ubicacion_testeo,
                $p->observaciones_testeo,
            /*	$p['tel_infectologia'],
                $p['mail_infectologia'],
                $p['horario_infectologia'],
                $p['responsable_infectologia'],
                $p['web_infectologia'],
                $p['ubicacion_infectologia'],
                $p['comentarios_infectologia'],
                $p['tel_vac'],
                $p['mail_vac'],
                $p['horario_vac'],
                $p['responsable_vac'],
                $p['web_vac'],
                $p['ubicacion_vac'],
                $p['comentarios_vac'],*/
                $p->tel_mac,
                $p->mail_mac,
                $p->horario_mac,
                $p->responsable_mac,
                $p->web_mac,
                $p->ubicacion_mac,
                $p->comentarios_mac,
                $p->tel_ile,
                $p->mail_ile,
                $p->horario_ile,
                $p->responsable_ile,
                $p->web_ile,
                $p->ubicacion_ile,
                $p->comentarios_ile,
                $p->tel_dc,
                $p->mail_dc,
                $p->horario_dc,
                $p->responsable_dc,
                $p->web_dc,
                $p->ubicacion_dc,
                $p->comentarios_dc,
                $p->tel_ssr,
                    $p->mail_ssr,
                    $p->horario_ssr,
                    $p->responsable_ssr,
                    $p->web_ssr,
                    $p->ubicacion_ssr,
                    $p->comentarios_ssr,
                    strtolower($p->servicetype_condones),
                    strtolower($p->servicetype_prueba),
                    strtolower($p->servicetype_mac),
                    strtolower($p->servicetype_ile),
                    strtolower($p->servicetype_dc),
                    strtolower($p->servicetype_ssr),
                    $p->friendly_condones,
                    $p->friendly_prueba,
                    $p->friendly_mac,
                    $p->friendly_ile,
                    $p->friendly_dc,
                    $p->friendly_ssr
            ]);
                }
                //descarga
        return $csv;
    }

    public function insertDataIntoCsv_places($data)
    {
        $csv = Writer::createFromFileObject(new SplTempFileObject());
        //header
                $csv->insertOne($this->csvColumns);
        //body
        foreach ($data as $key => $p) {
            $p['condones']= $this->parseToExport($p['condones']);
            $p['prueba']= $this->parseToExport($p['prueba']);
      //  	$p['vacunatorio']= $this->parseToExport($p['vacunatorio']);
      //  	$p['infectologia']= $this->parseToExport($p['infectologia']);
            $p['mac']= $this->parseToExport($p['mac']);
            $p['ile']= $this->parseToExport($p['ile']);
            $p['ssr']= $this->parseToExport($p['ssr']);
            $p['dc']= $this->parseToExport($p['dc']);
            $p['es_rapido']= $this->parseToExport($p['es_rapido']);
            $csv->insertOne([
                $p['placeId'],
                $p['establecimiento'],
                $p['tipo'],
                $p['calle'],
                $p['altura'],
                $p['piso_dpto'],
                $p['cruce'],
                $p['barrio_localidad'],
                $p['nombre_partido'],
                $p['nombre_provincia'],
                $p['nombre_pais'],
                $p['aprobado'],//
                $p['observacion'],
                $p['formattedAddress'],
                $p['latitude'],
                $p['longitude'],
                $p['habilitado'],
                $p['confidence'],
                $p['condones'],
                $p['prueba'],
        //		$p['vacunatorio'],
            //	$p['infectologia'],
                $p['mac'],
                $p['ile'],
                $p['dc'],
                $p['ssr'],
                $p['es_rapido'],
                $p['tel_distrib'],
                $p['mail_distrib'],
                $p['horario_distrib'],
                $p['responsable_distrib'],
                $p['web_distrib'],
                $p['ubicacion_distrib'],
                $p['comentarios_distrib'],
                $p['tel_testeo'],
                $p['mail_testeo'],
                $p['horario_testeo'],
                $p['responsable_testeo'],
                $p['web_testeo'],
                $p['ubicacion_testeo'],
                $p['observaciones_testeo'],
            /*	$p['tel_infectologia'],
                $p['mail_infectologia'],
                $p['horario_infectologia'],
                $p['responsable_infectologia'],
                $p['web_infectologia'],
                $p['ubicacion_infectologia'],
                $p['comentarios_infectologia'],
                $p['tel_vac'],
                $p['mail_vac'],
                $p['horario_vac'],
                $p['responsable_vac'],
                $p['web_vac'],
                $p['ubicacion_vac'],
                $p['comentarios_vac'],*/
                $p['tel_mac'],
                $p['mail_mac'],
                $p['horario_mac'],
                $p['responsable_mac'],
                $p['web_mac'],
                $p['ubicacion_mac'],
                $p['comentarios_mac'],
                $p['tel_ile'],
                $p['mail_ile'],
                $p['horario_ile'],
                $p['responsable_ile'],
                $p['web_ile'],
                $p['ubicacion_ile'],
                $p['comentarios_ile'],
                $p['tel_dc'],
                $p['mail_dc'],
                $p['horario_dc'],
                $p['responsable_dc'],
                $p['web_dc'],
                $p['ubicacion_dc'],
                $p['comentarios_dc'],
                $p['tel_ssr'],
                    $p['mail_ssr'],
                    $p['horario_ssr'],
                    $p['responsable_ssr'],
                    $p['web_ssr'],
                    $p['ubicacion_ssr'],
                    $p['comentarios_ssr'],
                    strtolower($p['servicetype_condones']),
                    strtolower($p['servicetype_prueba']),
                    strtolower($p['servicetype_mac']),
                    strtolower($p['servicetype_ile']),
                    strtolower($p['servicetype_dc']),
                    strtolower($p['servicetype_ssr']),
                    $p['friendly_condones'],
                    $p['friendly_prueba'],
                    $p['friendly_mac'],
                    $p['friendly_ile'],
                    $p['friendly_dc'],
                    $p['friendly_ssr']

            ]);
        }
        //descarga
        return $csv;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getall()
    {
        //return PlaceLog::with('user')->get();
        $dataset = DB::select('SELECT count(places.placeId) as countPlaces, places_log.id, places_log.csvname, places_log.entry_type, places_log.modification_date, places_log.user_id, users.name as user_name
		FROM places_log
		left join places on places.logId = places_log.id
		left join users on places_log.user_id = users.id
		group by places_log.id
		order by places_log.modification_date desc');
        return $dataset;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function exportplacesfilterbytag($tagId)
    {
        if (isset($tagId)) {
            $tag = PlaceLog::where('id', $tagId)->first();
            if (isset($tag)) {
                $placesController = new PlacesRESTController;
                $places = $placesController->showApprovedFilterByTag($tagId);
                if (count($places) > 0) {
                    if (isset($tag->csvname)) {
                        $csvName = $tag->csvname;
                    } elseif (isset($tag->user->name)) {
                        $csvName = "places_". $tag->entry_type ."_". $tag->modification_date."_" . $tag->user->name . ".csv";
                    } else {
                        $csvName = "places_". $tag->entry_type ."_". $tag->modification_date.".csv";
                    }
                } else {
                    $csvName = "nodata.csv";
                }
                $csv= $this->insertArraObejectsDataIntoCsv_places($places);
                //descarga
                $csv->output($csvName);
            } else {
                return $arrayName = array('error' => 'tag not found with id ' . $tagId);
            }
        } else {
            return $arrayName = array('error' => 'TagId null or undefined');
        }
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
