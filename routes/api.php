<?php

use App\Http\Controllers\Api\TourApiController;
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

// Tour API routes
Route::post('/tours/generate', [TourApiController::class, 'generate'])
    ->middleware('throttle:60,1');

Route::post('/tours/validate', [TourApiController::class, 'validate'])
    ->middleware('throttle:60,1');

// Health check endpoint
Route::get('/health', function () {
    return response()->json(['status' => 'ok']);
});