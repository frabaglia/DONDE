<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class SeoController extends Controller {

	public function showServices($pais,$provincia,$partido,$ciudad)
	{
		//info para la vista de services


$servicio1 = array('icon' => 'icondones.svg',
							'title' => 'site.condones_name',
							'code' => 'condones',
							'content'=>'site.condones_content');

		$servicio2 = array('icon' => 'vih.svg',
							'title' => 'site.prueba_name',
							'code' => 'prueba',
							'content' => 'site.prueba_content');

		$servicio3 = array('icon' => 'isalud.svg',
							'title' => 'site.ssr_name',
							'code' => 'ssr',
							'content' => 'site.ssr_content');

		$servicio4 = array('icon' => 'deteccion.svg',
							'title' => 'site.dc_name',
							'code' => 'dc',
							'content' => 'site.dc_content');

		$servicio5 = array('icon' => 'mac.svg',
							'title' => 'site.mac_name',
							'code' => 'mac',
							'content' => 'site.mac_content');

		$servicio6 = array('icon' => 'ile.svg',
							'title' => 'site.ile_name',
							'code' => 'ile',
							'content' => 'site.ile_content');



		$allElements = [$servicio1 , $servicio2 , $servicio3, $servicio4, $servicio5, $servicio6];
		return view('seo.services',compact('pais','provincia','partido','ciudad','allElements'));

	}

	public function changeLang($lang){

		if (isset($lang) && $lang !== null){
			try {
				\App::setLocale($lang);
				session(['lang' => $lang]);
				return $arrayName = array('status' => 'ok');
			} catch (Exception $e) {
				return $arrayName = array('status' => 'error');
			}
		}
		else return $arrayName = array('status' => 'error');
	}


	public function index()
	{
		echo "SEO";
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
