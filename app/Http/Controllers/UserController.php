<?php

namespace App\Http\Controllers;

use App\Http\Resources\PlayerRankingResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function listPlayers()
    {
        //TESTING to simplify $players = User::role('player')->get();
        $players = User::role('player')->get();


        return response([ 'players' => 
        UserResource::collection($players), 
        'message' => 'Successful'], 200);
    }


    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'user_id' => 'required',
            'dice1Value' => 'required|max:1',
            'dice2Value' => 'required|max:1',
        ]);

        if($validator->fails()){
            return response(['error' => $validator->errors(), 
            'Validation Error']);
        }

        $game = Game::create($data);

        return response([ 'game' => new 
        GameResource($game), 
        'message' => 'Success'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($userId)
    {
        $user = User::findOrFail($userId);
        return response([ 'user' => new 
        UserResource($user), 'message' => 'Success'], 200);

    }

    /**
     * Update the specified resource in storage.
     */
    public function updateName(Request $request, $userId)
    {
        {


            $data = $request->validate([
                'name' => 'max:255|unique:users',
            ]);

            if ($data == null) {
                return response(['message' => 'You should send a name field'], 400);
            }

            $data = $this->emptyNameToAnonymous($data);

            $user = User::findOrFail($userId);


            $user->name = $data['name'];
            $user->save();
    
            return response([ 'user' => new UserResource($user), 'message' => 'Success'], 200);
        }
    }

    //Conversion of empty names into 'anonymous'
    private function emptyNameToAnonymous ($data) : array {
        
        if ($data['name'] == null) {
            $data['name'] = "anonymous";
        }
        return $data;
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    
    public function getPlayersRanking()
    {
        $players = User::role('player')->orderBy('successRate', 'desc')->get();

        $playersWithRank = $players->map(function ($player, $i) {
            $player->rank = $i + 1;
            return $player;
        });

        return response([ 'ranking' => PlayerRankingResource::collection($playersWithRank), 
        'message' => 'Successful'], 200);
    }


    public function getLoser()
    {
        $players = User::role('player')->orderBy('successRate', 'asc')->take(1)->get();

        return response([ 'ranking' => PlayerRankingResource::collection($players), 
        'message' => 'Successful'], 200);
    }

    public function getWinner()
    {
        $players = User::role('player')->orderBy('successRate', 'desc')->get();

        $playersWithRank = $players->map(function ($player, $i) {
            $player->rank = $i + 1;
            return $player;
        });

        return response([ 'ranking' => PlayerRankingResource::collection($playersWithRank), 
        'message' => 'Successful'], 200);
    }
    

}
