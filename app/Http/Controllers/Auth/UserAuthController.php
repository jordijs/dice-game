<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlayerResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserAuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'max:255|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        //Conversion of empty names into 'anonymous'
        if ($data['name'] == null) {
            $data['name'] = "anonymous";
        }

        $data['password'] = bcrypt($request->password);

        $user = User::create($data)->assignRole('player');

        $token = $user->createToken('API Token')->accessToken;

        return response(
            [
                'user' => new PlayerResource($user),
                'token' => $token, 
                'message' => 'Success'
            ], 200
        );
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($data)) {
            return response(['error_message' => 'Incorrect Details. 
            Please try again']);
        }

        $token = auth()->user()->createToken('API Token')->accessToken;


        return response(
            [
                'user' => new PlayerResource(auth()->user()), 
                'token' => $token,
                'message' => 'Success'
            ], 200
        );

    }
}
