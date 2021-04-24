<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Userdata;

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

Route::get('data/{name?}',[Userdata::class,'getdata']);
Route::post('adddata',[Userdata::class,'savedata']);
Route::put('update',[Userdata::class,'updatedata']);
Route::put('validate_api',[Userdata::class,'apivalidation_f']);
