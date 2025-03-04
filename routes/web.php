<?php

use App\Http\Controllers\TourController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Main routes
Route::get('/', [TourController::class, 'index'])->name('tours.index');
Route::post('/process', [TourController::class, 'process'])->name('tours.process');

// Health check for App Engine
Route::get('/health', [TourController::class, 'health'])->name('health');

// Documentation
Route::view('/docs', 'docs.index')->name('docs.index');
Route::view('/docs/installation', 'docs.installation')->name('docs.installation');
Route::view('/docs/usage', 'docs.usage')->name('docs.usage');
Route::view('/docs/api', 'docs.api')->name('docs.api');
Route::view('/docs/faq', 'docs.faq')->name('docs.faq');

// Legal
Route::view('/privacy', 'legal.privacy')->name('legal.privacy');
Route::view('/terms', 'legal.terms')->name('legal.terms');