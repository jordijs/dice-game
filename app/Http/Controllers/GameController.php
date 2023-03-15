<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\GameResource;
use Illuminate\Support\Facades\Validator;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $games = Game::all();
        return response([ 'games' => 
        GameResource::collection($games), 
        'message' => 'Successful'], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function makeGame(Request $request)
    {
        //Retrieving data
        $user_id = $request->user()->id;

        $dice1Value = rand(1,6);

        $dice2Value = rand(1,6);

        if (($dice1Value + $dice2Value) == 7) {
            $resultWin = true;
        } else {
            $resultWin = false;
        }

        
        //Creating game
        $game = new Game;

        //Passing data to the game
        $game->user_id = $user_id;
        $game->dice1Value = $dice1Value;
        $game->dice2Value = $dice2Value;
        $game->resultWin = $resultWin;
        $game->save();

        //Giving response to the user
        return response([ 'game' => new 
        GameResource($game), 
        'message' => 'Success'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function showGamesByPlayer(Request $request)
    {

        //Retrieving id of user
        $user_id = $request->user()->id;

        
        $gamesByUser = User::find($user_id)->games;
       
        return response([ 'games' => new 
        GameResource($gamesByUser), 'message' => 'Success'], 200);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Game $game)
    {

        $game->update($request->all());

        return response([ 'game' => new 
        GameResource($game), 'message' => 'Success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteGamesByPlayer(Request $request)
    {
        //Retrieving id of user
        $user_id = $request->user()->id;

        $deleted = Game::where('user_id', $user_id)->delete();

        return response(['message' => 'All your games have been deleted']);
    }
}
