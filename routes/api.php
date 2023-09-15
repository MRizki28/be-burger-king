<?php

use App\Http\Controllers\CMS\BannerController;
use App\Http\Controllers\CMS\JenisProductController;
use App\Http\Controllers\CMS\MenuController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1/jenisproduct')->controller(JenisProductController::class)->group(function () {
    Route::get('/' , 'getAllData');
    Route::post('/create' , 'createData');
    Route::get('/generateCode' , 'generateProductCode');
    Route::get('/get/{id}' , 'getDataById');
    Route::post('/update/{id}' , 'updateData');
    Route::delete('/delete/{id}' , 'deleteData');
});

Route::prefix('v2/menu')->controller(MenuController::class)->group(function () {
    Route::get('/' , 'getAllData');
    Route::post('/create' , 'createData');
    Route::get('/generateCode' , 'generateProductCode');
    Route::get('/get/{id}' , 'getDataById');
    Route::post('/update/{id}' , 'updateData');
    Route::delete('/delete/{id}' , 'deleteData');
});

Route::prefix('v3/banner')->controller(BannerController::class)->group(function () {
    Route::get('/' , 'getAllData');
    Route::get('/gambar' , 'getAllGambar');
    Route::post('/create' , 'createData');
    Route::get('/get/{id}' , 'getDataById');
    Route::post('update/{id}' , 'updateData');
 
});

