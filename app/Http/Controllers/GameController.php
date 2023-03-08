<?php

namespace App\Http\Controllers;

use App\Models\Game;
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
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'id_user' => 'required',
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
    public function show(Game $game)
    {
        return response([ 'game' => new 
        GameResource($game), 'message' => 'Success'], 200);

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
    public function destroy(Game $game)
    {
        $game->delete();

        return response(['message' => 'Game deleted']);
    }
}
