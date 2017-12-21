<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;
class AdminRESTController extends Controller
{

  public function userCountries($idUser)
  {
    $response = array();
    $userCountries = DB::table('user_country')->where('id_user',$idUser)->select('id_country')->get();
    foreach ($userCountries as $country) {
      array_push($response, $country->id_country);
    }
    return $response;
  }

  public function saveUserCountries($userId, Request $request)
  {
    $request_params = $request->all();
    $userId = $userId;
    $rowArray = array();
    $queryArray = array();
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    DB::table('user_country')->where('id_user', $userId)->delete();

    foreach ($request_params as $countryId) {
      $rowArray = array('id_user' => $userId, 'id_country' => $countryId);
      array_push($queryArray,$rowArray);
    }

    DB::table('user_country')->insert($queryArray);
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    return;
  }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return User::all();
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

    public function logged(){
      return Auth::user();
    }
}
