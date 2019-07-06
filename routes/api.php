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

Route::apiResources(['store' => 'API\StoreController']);
Route::get('load/store/{code}', 'API\StoreController@loadStore');
Route::get('owners', 'API\StoreController@getOwners'); // For store Select Options
Route::put('store/update/by/user/{id}', 'API\StoreController@updateByUser');

Route::apiResources(['product' => 'API\ProductController']);
Route::get('load/product/{code}', 'API\ProductController@loadProducts');
Route::get('load/single/product/{id}/{code}', 'API\ProductController@loadSingleProduct');
Route::put('single/product/stock/update/{id}', 'API\ProductController@updateSingleProductStock');
Route::delete('single/product/stock/delete/{id}', 'API\ProductController@deleteSingleProductStock');

Route::get('load/product/vendor/{code}', 'API\ProductController@loadVendors');
Route::get('product/category/{code}', 'API\ProductController@loadCategories');
Route::post('product/category/store', 'API\ProductController@storeCategory');
Route::put('product/category/update/{code}', 'API\ProductController@updateCategory');


Route::apiResources(['vendor' => 'API\VendorController']);
Route::get('load/vendor/{code}', 'API\VendorController@loadVendors');
Route::get('load/vendor/due/{code}', 'API\VendorController@loadDues');
Route::put('load/vendor/pay/due/{id}', 'API\VendorController@payDue');
Route::get('load/duehistory/{code}', 'API\VendorController@loadDuehistories');

Route::apiResources(['purchase' => 'API\PurchaseController']);
Route::get('load/purchase/{code}', 'API\PurchaseController@loadPurchases');
Route::get('load/purchase/product/{code}', 'API\PurchaseController@loadProducts');

// each search function has a big bug, it does not filters user's stores!!!
// each search function has a big bug, it does not filters user's stores!!!
// each search function has a big bug, it does not filters user's stores!!!
// each search function has a big bug, it does not filters user's stores!!!
Route::get('searchuser/{query}', 'API\UserController@searchUser'); 
Route::get('searchrole/{query}', 'API\UserController@searchRole');
Route::get('searchstore/{query}', 'API\StoreController@searchStore');
Route::get('searchproduct/{query}', 'API\ProductController@searchProduct');
Route::get('searchpurchase/{query}', 'API\PurchaseController@searchPurchase');
Route::get('searchvendor/{query}', 'API\VendorController@searchVendor');
