<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //Create new user
    public function store(Request $request) {
        //Validate
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        //Create user
        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        //Create user token
        $token = $user->createToken('colaboratioToken')->plainTextToken;

        Auth::login($user);

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    //Login / Authenticate
    public function authenticate(Request $request) {

        //Validation
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        // Check if email exist
        $user = User::where('email', $fields['email'])->first();

        // If password does not match email, RETURN
        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Invalid login credentials'
            ], 401);
        }

        //If password and email match, create token and log in.
        $token = $user->createToken('myapptoken')->plainTextToken;
        
        //Login user
        Auth::login($user);

        $response = [
            'user' => $user,
            'token' => $token
        ];
        return response($response, 201);
    }

    //Logout
    public function logout(Request $request) {

        //Logout user
        Auth::logout();
        
        // Revoke token used for current request.
        $request->user()->currentAccessToken()->delete();


        return response ('Logged out succesfully', 200);
    }
}