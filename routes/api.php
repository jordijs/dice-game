<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\GameController;
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

//POST /players : crea un jugador/a.
Route::post('/players', [UserAuthController::class, 'register']);   

//Login
Route::post('/login', [UserAuthController::class, 'login']);

//GET /players/ranking: retorna el rànquing mitjà de tots els jugadors/es del sistema. És a dir, el percentatge mitjà d’èxits. //ADMIN
Route::get('/players/ranking', [UserController::class, 'getPlayersRanking'])->middleware(['auth:api', 'role:admin']);

//this one below is not required by the app, but useful for testing
Route::get('/players/{id}', [UserController::class, 'show'])->middleware(['auth:api', 'selfplayer']);

//PUT /players/{id} : modifica el nom del jugador/a. //THIS PLAYER
Route::put('/players/{id}', [UserController::class, 'updateName'])->middleware('auth:api', 'selfplayer');

//POST /players/{id}/games/ : un jugador/a específic realitza una tirada dels daus. //THIS PLAYER
Route::post('/players/{id}/games', [GameController::class, 'makeGame'])->middleware('auth:api', 'selfplayer');

//DELETE /players/{id}/games: elimina les tirades del jugador/a. //THIS PLAYER
Route::delete('/players/{id}/games', [GameController::class, 'deleteGamesByPlayer'])->middleware('auth:api', 'selfplayer');

//GET /players: retorna el llistat de tots els jugadors/es del sistema amb el seu percentatge mitjà d’èxits  //ADMIN
Route::get('/players', [UserController::class, 'listPlayers'])->middleware(['auth:api', 'role:admin']);

//GET /players/{id}/games: retorna el llistat de jugades per un jugador/a. //THIS PLAYER
Route::get('/players/{id}/games', [GameController::class, 'showGamesByPlayer'])->middleware(['auth:api', 'selfplayer']);

//GET /players/ranking/loser: retorna el jugador/a amb pitjor percentatge d’èxit. //ADMIN
Route::get('/players/ranking/loser', [UserController::class, 'getLoser'])->middleware(['auth:api', 'role:admin']);

//GET /players/ranking/winner: retorna el jugador/a amb millor percentatge d’èxit. //ADMIN
Route::get('/players/ranking/winner', [UserController::class, 'getWinner'])->middleware(['auth:api', 'role:admin']);
