<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Http\Requests\RegisterRequest;

use App\Models\User;
use Illuminate\Support\Str;
use OpenApi\Annotations as OA;

class AuthController
{
    /**
     * @OA\Post(
     *     path="/register",
     *     operationId="register",
     *     tags={"Авторизация"},
     *     summary="Register",
     *     description="Register action",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Pass user credentials",
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="name", type="string", format="email", example="test"),
     *             @OA\Property(property="surname", type="string", format="email", example="test"),
     *             @OA\Property(property="patronymic", type="string", format="email", example="test"),
     *             @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
     *             @OA\Property(property="phone", type="string", format="email", example="+78005553535"),
     *             @OA\Property(property="password", type="string", format="password", example="PassWord12345@"),
     *             @OA\Property(property="password_confirmation", type="string", format="password", example="PassWord12345"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="User added",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Norm"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Returns when server error",
     *     ),
     * )
     *
     * @param \App\Http\Requests\RegisterRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            User::create($request->validated());
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'message' => 'Norm',
        ]);
    }

    /**
     * @OA\Post(
     *     path="/login",
     *     operationId="login",
     *     tags={"Авторизация"},
     *     summary="Login",
     *     description="Login action",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Pass user credentials",
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
     *             @OA\Property(property="password", type="string", format="password", example="PassWord12345@"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="User logged in",
     *         @OA\JsonContent(
     *             @OA\Property(property="access_token", type="string"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Returns when user credentials incorrect",
     *     ),
     * )
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = null;
        if ($request->has('email')) {
            $user = User::query()->firstWhere('email', $request->input('email'));
        }
        if ($request->has('phone')) {
            $user = User::query()->firstWhere('phone', $request->input('phone'));
        }
        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return response()->json([
                'message' => 'Not found',
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json([
            'access_token' => $user->createToken(Str::random(22))->plainTextToken,
        ]);
    }
}
