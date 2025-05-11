<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'error' => $validation->errors(),
                'message' => 'Unprocessed Content',
                'status' => 422,
            ], 422);
        }


        if (!Auth::attempt($request->only(['email', 'password']))) {
            return response()->json(
                [
                    'message' => 'There is an error while trying to logged in ',
                    'status' => 422,
                ]

            );
        }

        $user = Auth::user();
        $token = $user->createToken('api-token')->plainTextToken;
        return response()->json([
            'user' => $user,
            'message' => 'User Logged in successfully',
            'token' => $token,
            'status' => 200,
        ]);
    }

    public function register(Request $request)
    {

        $validation = Validator::make(
            $request->all(),
            [
                'name' => 'required|min:3|string',
                'email' => 'required|min:3|unique:users,email',
                'password' => 'required|min:3',
            ]
        );
        if ($validation->fails()) {
            return response()->json([
                'errors' => $validation->errors(),
                'message' => 'Unprocessable Content',
                'status' => 422,
            ], 422);
        }

        $userData = $request->only(['name', 'email', 'password']);
        $user =  User::create($userData);

        $token = $user->createToken('api-token')->plainTextToken;
        return response()->json([
            'user' => $user,
            'message' => 'User created successfully',
            'token' => $token,
            'status' => 201,
        ], 201);
    }
    public function logout(Request $request)
    {

        //dd($request->user());
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'User Deleted successfully',
            'status' => 204
        ]);
    }
}
