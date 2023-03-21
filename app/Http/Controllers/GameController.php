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
    public function makeGame(Request $request)

    {
        //Retrieving data
        $user_id = $request->user()->id;

        $dice1Value = rand(1, 6);

        $dice2Value = rand(1, 6);

        $resultWin = $this->gameLogic($dice1Value, $dice2Value);

        if ($resultWin) {
            $resultString = "You won!";
        } else {
            $resultString = "You lost!";
        }

        //Creating game
        $game = new Game;

        //Passing game results to the game
        $game->user_id = $user_id;
        $game->dice1Value = $dice1Value;
        $game->dice2Value = $dice2Value;
        $game->resultWin = $resultWin;
        $game->save();

        //Store new game was played
        $game->user->playedGames++;
        $game->user->save();

        //Saving game won to user and update successRate
        if ($resultWin) {
            //Add 1 game won
            $game->user->wonGames++;
            $game->user->save();
        }

        //Update successRate
        $playedGames = $game->user->playedGames;
        $wonGames = $game->user->wonGames;
        $successRate = ($wonGames / $playedGames) * 100;
        $game->user->successRate =  $successRate;
        $game->user->save();


        //Giving response to the user
        return response([
            'game' => new
                GameResource($game),
            'message' => 'First dice was ' . $dice1Value . ' and second was ' . $dice2Value . '. ' . $resultString
        ], 200);
    }

    // Game logic
    private function gameLogic($dice1Value, $dice2Value): bool
    {
        if (($dice1Value + $dice2Value) == 7) {
            $resultWin = true;
        } else {
            $resultWin = false;
        }

        return $resultWin;
    }

    public function showGamesByPlayer(Request $request)
    {
        //Retrieving id of user
        $user_id = $request->user()->id;

        $gamesByUser = User::find($user_id)->games;

        if (sizeof($gamesByUser) == 0) {
            return response(['message' => 'You have no games'], 200);
        } else {
            return response(['Your games' =>
            GameResource::collection($gamesByUser), 'message' => 'Success'], 200);
        }
    }

    public function deleteGamesByPlayer(Request $request)
    {
        //Retrieving id of user
        $user_id = $request->user()->id;

        $deleted = Game::where('user_id', $user_id)->delete();

        if ($deleted) {
            return response(['message' => 'All your games have been deleted']);
        } else {
            return response(['message' => 'There was a problem deleting your games']);
        }
    }
}
