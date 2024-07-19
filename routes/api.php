<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ChecklistController;
use App\Http\Controllers\API\ChecklistItemController;
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


// Clean Code belum diterapkan
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::controller(ChecklistController::class)->group(function () {
        Route::get('checklist', 'index');
        Route::post('checklist', 'store');
        Route::delete('checklist/{checklistId}', 'destroy');
    });

    Route::controller(ChecklistItemController::class)->group(function () {
        Route::get('checklist/{checklistId}/item', 'index'); 
        Route::post('checklist/{checklistId}/item', 'store');
        Route::get('checklist/{checklistId}/item/{checklistItemId}', 'show');
        Route::put('checklist/{checklistId}/item/{checklistItemId}', 'update');
        Route::delete('checklist/{checklistId}/item/{checklistItemId}', 'destroy');
        Route::put('checklist/{checklistId}/item/rename/{checklistItemId}', 'rename');
    });    

});
