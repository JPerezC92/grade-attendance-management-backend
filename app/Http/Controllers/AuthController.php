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
            // $validatedData = $request->validate([
            //     "firstname" => "required|string|max:255",
            //     "lastname" => "required|string|max:255",
            //     "email" => "required|string|email:255:unique:users",
            //     "password" => "required|string|min:8",
            // ]);

            // $user = User::create($request->all());

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
}
