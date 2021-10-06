<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Throwable;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {

            $user = User::create([
                "firstname" => $request["firstname"],
                "lastname" => $request["lastname"],
                "email" => $request["email"],
                "password" => Hash::make($request["password"]),
            ]);

            $token = $user->createToken("auth_token")->plainTextToken;

            return response([
                "success" => true,
                "payload" =>  $token
            ]);
        } catch (Throwable  $e) {
            return response(content: $e->getMessage(), status: "500",);
        }
    }

    public function login(Request $request)
    {
        try {
            if (!Auth::attempt($request->only("email", "password"))) {
                return response()->json([
                    "success" => false,
                    "message" => "Credenciales invalidas"
                ], 401);
            }


            $user = User::where("email", $request["email"])->firstOrFail();

            $token = $user->createToken("auth_token")->plainTextToken;

            return response([
                "success" => true,
                "payload" =>  $token
            ]);
        } catch (Throwable  $e) {
            return response(content: $e->getMessage(), status: "500",);
        }
    }


    public function infoUser(Request $request)
    {
        try {
            return response()->json([
                "success" => true,
                "payload" => $request->user()
            ]);
        } catch (Throwable $e) {
            return response(content: $e->getMessage(), status: "500",);
        }
    }

    public function logout(Request $request)
    {
        try {
            $user = $request->user();

            $user->tokens()->delete();

            return response()->json([
                "success" => true,
                "payload" => "Sesion cerrada"
            ]);
        } catch (Throwable $e) {
            return response(content: $e->getMessage(), status: "500",);
        }
    }
}
