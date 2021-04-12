<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TerminalsController;
use App\Http\Controllers\Api\TransportationsController;
use App\Http\Controllers\Api\NavigationController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::apiResource('transportations', TransportationsController::class);
Route::apiResource('terminals', TerminalsController::class);
Route::get('navigation', [NavigationController::class, 'index']);

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('profile', [AuthController::class, 'profile'])->middleware('auth:api');
    Route::post('login', [AuthController::class, 'login']);
});