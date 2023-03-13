<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\UserController;

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
/*default preinstalled route
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/


Route::post('/players', [UserAuthController::class, 'register']);
Route::post('/login', [UserAuthController::class, 'login']);

<<<<<<< Updated upstream
Route::get('/players', [UserController::class, 'indexPlayers'])->middleware('auth:api');
//Route::get('/user', [UserController::class, 'index']);
=======
Route::get('/players', [PlayerController::class, 'index'])->middleware('auth:api');

>>>>>>> Stashed changes
//Route::apiResource('/game', GameController::class)->middleware('role:admin');

//Route::apiResource('/players', UserController::class)->middleware('auth:api');

//Route::apiResource('/players', PlayerController::class);
