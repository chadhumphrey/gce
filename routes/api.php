<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthAPIController;
use App\Http\Resources\UserResource;
use App\Http\Controllers\API\UserController;


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

Route::get('login', [App\Http\Controllers\API\AuthController::class, 'login']);
// Route::post('register', [AuthController::class, 'register']);

// Route::middleware('auth:sanctum')->get('/users', function (Request $request) {
//     return $request->user();
// });
// Route::middleware('auth:sanctum')->group('/user', function (Request $request) {
//   Route::Resource('users', UserController::class);
//     // return $request->user();
// });

Route::middleware('auth:sanctum')->group( function () {
    Route::resource('blogs', UserController::class);
});

// Route::apiResource('projects', UserProjectController::class)->middleware('auth:api');
// Route::apiResource('user', UserResource::class);
