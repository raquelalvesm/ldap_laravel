<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/ldap-search', function(Request $request){
    try{
        $credentials = $request->only('username');
        $username = $credentials['username'];
        $ldapuser = \Adldap::search()->where(env('LDAP_USER_ATTRIBUTE'), '=', $username . "") -> first();
        return response() ->json($ldapuser);
    }catch(\Exception $e){
        return response()->json(["message" => $e->getMessage()], 200);
    }
});
