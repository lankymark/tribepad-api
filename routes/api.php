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

Route::middleware('throttle:60,1')->group(function() {
// Get a singular reference
    Route::get('reference/{id}', 'API\ReferencesAPIController@show');
// Get all references
    Route::get('references', 'API\ReferencesAPIController@index');
// Get all references by email
    Route::get('references/{email}', 'API\ReferencesAPIController@index');
// Create or update a reference
    Route::put('reference', 'API\ReferencesAPIController@store');
    Route::post('reference', 'API\ReferencesAPIController@store');
// Delete a reference
    Route::delete('reference/{id}', 'API\ReferencesAPIController@destroy');
// Get reference providers
    Route::get('reference/providers/{id}', 'API\ReferencesAPIController@providers');
});
