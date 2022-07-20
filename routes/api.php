<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ColumnController;
use App\Http\Controllers\DumpController;
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

Route::get('columns', [ColumnController::class, 'index']);
Route::group(['prefix' => 'column'], function () {
	Route::post('/', [ColumnController::class, 'edit']);
	Route::post('add', [ColumnController::class, 'add']);
	Route::delete('/{id}', [ColumnController::class, 'delete']);
});

Route::group(['prefix' => 'dump'], function () {
	Route::get('/', [DumpController::class, 'generate']);
});

