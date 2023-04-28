<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

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

Route::get('/doc/{id}', [ApiController::class, "show"]);
Route::get('/doc', [ApiController::class, "index"]);
Route::get('/doc/search/{name}', [ApiController::class, "search"]);

Route::post('/doc/{id}', [ApiController::class, "returnDoc"]);
