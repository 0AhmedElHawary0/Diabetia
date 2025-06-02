<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserUpdateController;
use App\Http\Controllers\CompanionLinkingController;
use App\Http\Controllers\DietController;

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

Route::group(['middleware' => 'api', 'prefix' =>'auth'],function($router){
    Route::post('/register',[AuthController::class,'register']);
    Route::post('/login',[AuthController::class,'login']);
    Route::get('/user-data',[AuthController::class,'userData'])->middleware('auth.guard');
    Route::post('/logout',[AuthController::class,'logout'])->middleware('auth.guard');
    Route::put('/info1',[UserUpdateController::class,'aboutYourself'])->middleware('auth.guard');
    Route::put('/info2',[UserUpdateController::class,'diabetesType'])->middleware('auth.guard');
    Route::put('/profile-update',[UserUpdateController::class,'profileUpdate'])->middleware('auth.guard');
    Route::post('/add-companion',[CompanionLinkingController::class,'addCompanion'])->middleware('auth.guard');
    Route::delete('/delete-companion',[CompanionLinkingController::class,'deleteCompanion'])->middleware('auth.guard');
    Route::get('/get-companions',[CompanionLinkingController::class,'getCompanions'])->middleware('auth.guard');
    Route::get('/get-all-meals',[DietController::class,'getAllMeals'])->middleware('auth.guard');
    Route::post('/get-searched-meals',[DietController::class,'getSearchedMeals'])->middleware('auth.guard');
});
