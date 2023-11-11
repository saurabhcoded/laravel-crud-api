<?php

use App\Http\Controllers\api\studentController;
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
Route::get("students", [studentController::class, 'index']);
Route::post("students", [studentController::class, 'addStudent']);
Route::get("students/{id}", [studentController::class, 'getSingleStudent']);
Route::put("students/edit/{id}", [studentController::class, 'updateStudent']);
