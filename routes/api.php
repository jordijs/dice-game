<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\EnsureSelfPlayer;



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

//POST /players : crea un jugador/a.
Route::post('/players', [UserAuthController::class, 'register']);

//works perfect
Route::post('/login', [UserAuthController::class, 'login']);
//works perfect

//this one below is not required by the app, but useful for testing
Route::get('/players/{id}', [UserController::class, 'show'])->middleware(['auth:api', 'selfplayer']);


//PUT /players/{id} : modifica el nom del jugador/a. //THIS PLAYER
Route::put('/players/{id}', [UserController::class, 'updateName'])->middleware('auth:api', 'selfplayer');
//works perfect! :D

//POST /players/{id}/games/ : un jugador/a específic realitza una tirada dels daus. //THIS PLAYER
Route::post('/players/{id}/games', [GameController::class, 'makeGame'])->middleware('auth:api', 'selfplayer');
//great!!!!!

//DELETE /players/{id}/games: elimina les tirades del jugador/a. //THIS PLAYER
Route::delete('/players/{id}/games', [GameController::class, 'deleteGamesByPlayer'])->middleware('auth:api', 'selfplayer');
//DONE. Need to check if effectively deleted

//GET /players: retorna el llistat de tots els jugadors/es del sistema amb el seu percentatge mitjà d’èxits 
Route::get('/players', [UserController::class, 'listPlayers'])->middleware(['auth:api', 'role:admin']);
//works.

//GET /players/{id}/games: retorna el llistat de jugades per un jugador/a. //THIS PLAYER
Route::get('players/{id}/games', [GameController::class, 'showGamesByPlayer'])->middleware(['auth:api', 'selfplayer']);
//to-do

//GET /players/ranking: retorna el rànquing mitjà de tots els jugadors/es del sistema. És a dir, el percentatge mitjà d’èxits. //ADMIN
//to-do

//GET /players/ranking/loser: retorna el jugador/a amb pitjor percentatge d’èxit. //ADMIN
//to-do

//GET /players/ranking/winner: retorna el jugador/a amb millor percentatge d’èxit. //ADMIN
//to-do







//Route::group(['middleware' => ['role:Admin']], [UserController::class, 'index']);


//Route::apiResource('/game', GameController::class)->middleware('role:admin');

//Route::apiResource('/players', UserController::class)->middleware('auth:api');

//Route::apiResource('/players', UserController::class);
