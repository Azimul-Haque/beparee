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

Route::get('pdf/product/report/{id}/{type}/{code}', 'PDFController@productReportPDF');
Route::get('pdf/staff/report/{staff_id}/{month}/{year}/{code}', 'PDFController@staffReportPDF');

// Auth::routes();
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
// Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
// Route::post('register', 'Auth\RegisterController@register');

// Reset Password Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// Verify Routes...
Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

// Route::get('/dashboard', 'HomeController@index')->name('dashboard');
Route::get('{path}', 'HomeController@index')->where( ['path', '([A-z\d\-\/_.]+)?', 'path']);
Route::get('{path}/{path2}', 'HomeController@index')->where( ['path', '([A-z\d\-\/_.]+)?', 'path']);
Route::get('{path}/{path2}/{path3}', 'HomeController@index')->where( ['path', '([A-z\d\-\/_.]+)?', 'path']);
Route::get('{path}/{path2}/{path3}/{path4}', 'HomeController@index')->where( ['path', '([A-z\d\-\/_.]+)?', 'path']);
Route::get('{path}/{path2}/{path3}/{path4}/{path5}', 'HomeController@index')->where( ['path', '([A-z\d\-\/_.]+)?', 'path']);
