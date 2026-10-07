<?php

use App\Http\Controllers\LocationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/states', [LocationController::class, 'states']);
Route::get('/cities', [LocationController::class, 'cities']);
Route::get('/areas', [LocationController::class, 'areas']);
Route::get('/subcategories', [LocationController::class, 'subcategories']);
