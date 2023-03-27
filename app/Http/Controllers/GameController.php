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

        $dice1_value = rand(1, 6);

        $dice2_value = rand(1, 6);

        $result_win = $this->gameLogic($dice1_value, $dice2_value);

        if ($result_win) {
            $resultString = "You won!";
        } else {
            $resultString = "You lost!";
        }

        //Creating game
        $game = new Game;

        //Passing game results to the game
        $game->user_id = $user_id;
        $game->dice1_value = $dice1_value;
        $game->dice2_value = $dice2_value;
        $game->result_win = $result_win;
        $game->save();

        //Store new game was played
        $game->user->played_games++;
        $game->user->save();

        //Saving game won to user and update success_rate
        if ($result_win) {
            //Add 1 game won
            $game->user->won_games++;
            $game->user->save();
        }

        //Update success_rate
        $played_games = $game->user->played_games;
        $won_games = $game->user->won_games;
        $success_rate = ($won_games / $played_games) * 100;
        $game->user->success_rate =  $success_rate;
        $game->user->save();


        //Giving response to the user
        return response([
            'game' => new
                GameResource($game),
            'message' => 'First dice was ' . $dice1_value . ' and second was ' . $dice2_value . '. ' . $resultString
        ], 200);
    }

    // Game logic
    private function gameLogic($dice1_value, $dice2_value): bool
    {
        if (($dice1_value + $dice2_value) == 7) {
            $result_win = true;
        } else {
            $result_win = false;
        }

        return $result_win;
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
