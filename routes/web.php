<?php

use App\Http\Controllers\API\DetailProductController;
use App\Http\Controllers\API\OrderanController;
use App\Http\Controllers\API\ProductController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('frondend.home');
});

Route::get('/cms/backend/phone', function () {
    return view('backend.Phone');
});
Route::post('/cms/backend/phone', function () {
    return view('backend.Phone');
});
Route::put('/cms/backend/phone', function () {
    return view('backend.Phone');
});

Route::get('/detail/{uuid}', function () {
    return view('frondend.detail');
});
Route::post('/detail/{uuid}', function () {
    return view('frondend.detail');
});

Route::get('cms/backend/detail/phone', function () {
    return view('backend.DetailPhone');
});

Route::get('kuitansi/phone/{id}', function () {
    return view('frondend.kuitansi');
});






Route::prefix('v1')->controller(ProductController::class)->group(function () {
    Route::get('/phone', 'getAllData');
    Route::post('/phone/create', 'createData');
    Route::get('/phone/get/{uuid}', 'getDataByUuid');
    Route::put('/phone/update/{uuid}' , 'updateDataByUuid');
    Route::delete('/phone/delete/{uuid}', 'deleteData');
});

Route::prefix('v2')->controller(DetailProductController::class)->group(function () {
    Route::get('/detail', 'getAllData');
    Route::post('/detail/create', 'createData');
    Route::get('/detail/get/{uuid}','getDataByUuid');
    Route::put('/detail/update/{uuid}',  'updateData');
});

Route::prefix('v3')->controller(OrderanController::class)->group(function () {
    Route::get('/detail', 'getAllData');
    Route::post('/phone/order', 'createOrderan')->name('tambah.Phone');
    Route::get('/order/get/{id}','getDataByid');
    Route::put('/detail/update/{uuid}',  'updateData');
});
