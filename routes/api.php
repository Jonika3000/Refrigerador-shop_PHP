<?php

use App\Http\Controllers\FrontEndController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|php artisan serve
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get("/category", [FrontEndController::class, 'index']);
Route::post("/category", [FrontEndController::class, 'store']);
Route::get('category/{slug}', [FrontEndController::class,'product']);
Route::get('/clearCategory', [FrontEndController::class,'indexWithoutPagginate']);
Route::post("/AddItem", [FrontEndController::class, 'AddItem']);
Route::post("/AddImage", [FrontEndController::class, 'AddImage']);
Route::delete("DeleteItem/{id}", [FrontEndController::class, 'DeleteItem']);
Route::get("/clearItems", [FrontEndController::class, 'ItemsWithoutPagginate']);
Route::post('/itemUpdate/{id}', [FrontEndController::class, 'update']);
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});
