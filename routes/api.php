<?php

use App\Http\Controllers\FrontEndController;
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
Route::delete("DeleteItem/{id}", [FrontEndController::class, 'DeleteItem']);
Route::get("/clearItems", [FrontEndController::class, 'ItemsWithoutPagginate']);
Route::post('/itemUpdate/{id}', [FrontEndController::class, 'update']);
