<?php

namespace App\Http\Controllers;

use App\Mail\RecoverPasswordEmail;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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

    public function recoverPassword(Request $request)
    {
        try {
            $email = $request->email;

            $user = User::where("email", $email)->first();

            if (!$user) {
                return response(
                    content: [
                        "success" => false,
                        "message" => "El correo no esta registrado"
                    ],
                    status: "404",
                );
            }

            $token = $user->createToken("auth_token")->plainTextToken;

            $details = [
                "title" => "Recuperar contraseña",
                "body" => "Siga el siguiente link para restaurar su contraseña",
                "url" => "https://grade-attendance-management-frontend.vercel.app/auth/recover-password?recover_key=" . $token,
            ];

            Mail::to($email)->send(new RecoverPasswordEmail($details));

            return response()->json([
                "success" => true,
                "payload" => "Se envio un mensaje a su correo"
            ]);
        } catch (Throwable $e) {
            return response(content: $e->getMessage(), status: "500",);
        }
    }


    public function resetPassword(Request $request)
    {
        try {
            $newPassword = $request->newPassword;
            $user = $request->user();

            $user = User::where("id", $user->id)
                ->update(["password" => Hash::make($newPassword)]);

            $user->tokens()->delete();

            return response()->json([
                "success" => true,
                "payload" => "Contraseña resturada"
            ]);
        } catch (Throwable $e) {
            return response(content: $e->getMessage(), status: "500",);
        }
    }
}
