<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function getAll(Request $request) {
        return response()->json(User::all());
    }

    public function create(Request $request) {
        $user = new User;
        $user->name = "";
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json([
            "message" => "Successfully signup."
        ]);
    }

    public function signup(Request $request) {
        $credentials = ["email" => $request->email, "password" => $request->password];
        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            return response()->json(["token" => $user->createToken('Token')->accessToken]);
        }
        return response()->json(["message" => "Login or password incorrect."]);
    }
}
