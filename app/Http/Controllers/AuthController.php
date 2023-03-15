<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController
{
    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'access_token' => $request->input('token'),
        ]);
    }
}
