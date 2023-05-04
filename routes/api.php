<?php

use App\Http\Controllers\API\DetailProductController;
use App\Http\Controllers\API\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/v1/phone', [ProductController::class, 'getAllData']);
Route::post('/v1/phone/create', [ProductController::class, 'createData']);
Route::get('/v1/phone/get/{uuid}', [ProductController::class, 'getDataByUuid']);


Route::get('/v2/detail', [DetailProductController::class ,'getAllData']);
Route::post('/v2/detail/create' , [DetailProductController::class, 'createData']);
Route::get('/v2/detail/get/{uuid}' , [DetailProductController::class, 'getDataByUuid']);
