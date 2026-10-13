<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Api\TreeMarkerController;
use App\Http\Controllers\Api\BoundaryController;
use App\Http\Controllers\TreeMarkerResetController;
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

Route::redirect('home', '/')->name('home');

Route::middleware('auth')->group(function () {
    Route::apiResource('api/tree-markers', TreeMarkerController::class)->only(['index', 'store', 'destroy']);
    Route::delete('tree-markers', TreeMarkerResetController::class)->name('tree-markers.reset');
    Route::apiResource('api/boundaries', BoundaryController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::get('email/verify/{id}/{hash}', EmailVerificationController::class)
        ->middleware('signed')
        ->name('verification.verify');
    Route::post('logout', LogoutController::class)
        ->name('logout');
});
