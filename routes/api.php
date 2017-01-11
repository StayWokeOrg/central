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

Route::get('user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

if (! app()->environment('production')) {
    Route::get('contacts', 'Api\ContactsController@index')->middleware('auth:api');
}

Route::post('contacts', 'Api\ContactsController@store')->middleware('auth:api');
