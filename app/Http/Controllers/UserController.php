<?php

namespace App\Http\Controllers;

use App\Http\Resources\PlayerRankingResource;
use App\Http\Resources\PlayerWithoutRankResource;
use App\Http\Resources\UserNameResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function listPlayers()
    {
        $players = User::role('player')->get();

        return response([
            'players' =>
            UserResource::collection($players),
            'message' => 'Successful'
        ], 200);
    }

    
    public function show($userId)
    {
        $user = User::findOrFail($userId);

        return response(
            ['User' => new UserResource($user), 'message' => 'Success'], 200);
    }


    public function updateName(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'max:255|unique:users',
        ]);

        if ($data == null) {
            return response(['message' => 'You should send a name field'], 400);
        }

        $data = $this->emptyNameToAnonymous($data);

        $user = User::findOrFail($id);

        $user->name = $data['name'];

        $user->save();

        return response(['user' => new UserNameResource($user), 'message' => 'Success'], 200);
    }


    //Conversion of empty names into 'anonymous'
    private function emptyNameToAnonymous($data): array
    {
        if ($data['name'] == null) {
            $data['name'] = "anonymous";
        }
        return $data;
    }


    public function getPlayersRanking()
    {
        $players = User::role('player')->orderBy('success_rate', 'desc')->get();

        $playersWithRank = $players->map(function ($player, $i) {
            $player->rank = $i + 1;
            return $player;
        });

        return response([
            'Ranking' => PlayerRankingResource::collection($playersWithRank),
            'message' => 'Successful'
        ], 200);
    }


    public function getLoser()
    {
        $players = User::role('player')->orderBy('success_rate', 'asc')->take(1)->get();

        return response([
            'Loser' => PlayerWithoutRankResource::collection($players),
            'message' => 'Successful'
        ], 200);
    }


    public function getWinner()
    {
        $players = User::role('player')->orderBy('success_rate', 'desc')->take(1)->get();

        return response([
            'Winner' => PlayerWithoutRankResource::collection($players),
            'message' => 'Successful'
        ], 200);
    }
}
