<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //TESTING to simplify $players = User::role('player')->get();
        $players = User::all();
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
            //Conversion of empty names into 'anonymous'
            if ($data['name'] == null) {
                $data['name'] = "anonymous";
            }

            $user = User::findOrFail($userId);


            $user->name = $data['name'];
            $user->save();
    
            return response([ 'user' => new UserResource($user), 'message' => 'Success'], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
