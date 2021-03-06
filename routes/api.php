<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



use App\Http\Controllers\RegisterController;
use App\Http\Controllers\OrderController;


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





Route::group(['middleware' => 'auth:api'], function(){
   Route::apiResource("order", OrderController::class); 
});


Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login'])->middleware("throttle:10,2");

