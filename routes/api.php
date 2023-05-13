<?php

use App\Http\Controllers\API\DetailProductController;
use App\Http\Controllers\API\OrderanController;
use App\Http\Controllers\API\ProductController;
use App\Models\OrderanModel;
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

Route::prefix('v3')->controller(OrderanController::class)->group(function () {
    Route::get('/order', 'getAllData');
    Route::post('/phone/order', 'createOrderan')->name('tambah.Phone');
    Route::get('/order/get/{id}','getDataByid');
    Route::put('/detail/update/{uuid}',  'updateData');
});