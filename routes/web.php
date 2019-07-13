<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/clear', ['as'=>'clear','uses'=>'IndexController@clear']);
Route::get('/', ['as'=>'index','uses'=>'IndexController@index']);

// Report Generation Controller... without API
Route::get('pdf/purchase/{id}', 'PDFController@singlePurchaseReceiptPDF');
Route::get('pdf/sale/{id}', 'PDFController@singleSaleReceiptPDF');

Auth::routes();

// Route::get('/dashboard', 'HomeController@index')->name('dashboard');
Route::get('{path}', 'HomeController@index')->where( ['path', '([A-z\d\-\/_.]+)?', 'path']);
Route::get('{path}/{path2}', 'HomeController@index')->where( ['path', '([A-z\d\-\/_.]+)?', 'path']);
Route::get('{path}/{path2}/{path3}', 'HomeController@index')->where( ['path', '([A-z\d\-\/_.]+)?', 'path']);
Route::get('{path}/{path2}/{path3}/{path4}', 'HomeController@index')->where( ['path', '([A-z\d\-\/_.]+)?', 'path']);
Route::get('{path}/{path2}/{path3}/{path4}/{path5}', 'HomeController@index')->where( ['path', '([A-z\d\-\/_.]+)?', 'path']);
