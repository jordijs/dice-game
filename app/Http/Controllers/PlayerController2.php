<?php

namespace App\Http\Controllers;

use App\Http\Resources\PlayerResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

//class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $players = User::role('player')->get();
        return response([ 'players' => 
        PlayerResource::collection($players), 
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
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
