<?php

namespace App\Http\Controllers;

use App\Models\Society;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $society = Society::with('regional')->where('id_card_number', $request->id_card_number)->where('password', $request->password)->first();


        if (!$society) {
            return response()->json([
                "message" => "ID Card Number or Password incorrect"
            ], 401);
        }

        $token = md5($society->id_card_number);
        $society->update(['login_tokens' => $token]);
        $society->token = $token;

        $society->makeHidden(['id', 'id_card_number', 'password', 'login_tokens']);
        return response()->json($society);
    }


    public function logout(Request $request)
    {

        $token = $request->input('token');
        $society = Society::where('login_tokens', $token)->first();


        if (!$token || !$society) {
            return response()->json([
                'message' => 'Invalid token'
            ],401);
        }

        $society->update([
            'login_tokens' => null
        ]);

        return response()->json([
            'message' => 'Logout success'
        ]);
    }
}
