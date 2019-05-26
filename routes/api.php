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

Route::apiResources(['user' => 'API\UserController']);

Route::get('roles', 'API\UserController@getRoles'); // For user Select Options
Route::get('roles/list', 'API\UserController@getRolesList');
Route::post('role/create', 'API\UserController@createRole');
Route::put('role/update/{id}', 'API\UserController@updateRole');
Route::delete('role/delete/{id}', 'API\UserController@deleteRole');

Route::get('permissions', 'API\UserController@getPermissions'); // For role Select Options
Route::get('permissions/names/{id}', 'API\UserController@getPermissionsNames'); // For Permission 

Route::get('searchuser/{query}', 'API\UserController@searchUser');
