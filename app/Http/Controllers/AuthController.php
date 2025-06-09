<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
 {
    public function register(Request $request) {
        $validatedData = $request->validate([
            'name' => ['required', 'min:3', 'max:20'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8', 'max:20']
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        $user = User::create($validatedData);
        $token = $user->createToken("user-token")->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name'=> $user->name
            ]
        ], 201);
        
    }

    public function login(Request $request) {
        $validatedData = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8', 'max:20']
        ]);
        
        if ($user = User::where('email', $validatedData['email'])->first()) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('user-token')->plainTextToken;
                return response()->json([
                    'token'=> $token,
                    'user'=> [
                        'id'=> $user->id,
                        'name'=> $user->name
                    ],
                ], 200);
            } else {
                abort(401, 'Unauthorized');
            }
        } else {
            abort(401, 'Unauthorized');
        }


    }

    public function logout(Request $request) {
        $user = $request->user();

        if (!$user) {
            abort(401, "Unauthorized");
        }

        $token = $user->currentAccessToken();

        if ($token) {
            $token->delete();
        }

        return response()->json([
            'message' => 'Logged out!'
        ], 200);
        }

 }



