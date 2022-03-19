<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterFormRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseController
{
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * @OA\Post  (
     *     path = "/register",
     *     summary = "Registration",
     *     description = "Send data to registration",
     *     tags = {"register"},
     *     @OA\RequestBody (
     *         required = true,
     *         @OA\JsonContent (
     *             required = {"username", "password", "email", "c_password", "standoff_id"},
     *             @OA\Property (property = "username", type = "string"),
     *             @OA\Property (property = "email", type = "string", format = "email"),
     *             @OA\Property (property = "password", type = "string", format = "password"),
     *             @OA\Property (property = "c_password", type = "string", format = "password"),
     *             @OA\Property (property = "standoff_id", type = "integer")
     *         )
     *     ),
     *     @OA\Response (
     *         response = 200,
     *         description = "Success response",
     *         @OA\JsonContent (
     *             @OA\Property (property = "message", type = "string")
     *         )
     *     )
     * )
     */
    public function register(RegisterFormRequest $request)
    {
        $user = User::create(array_merge(
            $request->except(['password']),
            ['password' => bcrypt($request->password)]
        ));

        return $this->sendResponse($user, 'Пользователь успешно зарегеистрирован.');
    }

    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        $credentials = $request->only(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return $this->sendError('Неверный логин или пароль', null, 401);
        }

        $token = Auth::user()->createToken(config('app.name'));

        $token->token->expires_at = $request->remember_me ?
            Carbon::now()->addMonth() :
            Carbon::now()->addDay();

        $token->token->save();

        return $this->respondWithToken($token);
    }

    public function me()
    {
        return $this->sendResponse(new UserResource(User::findOrFail(\auth()->id())));
    }

    public function logout(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->user()->token()->revoke();

        return $this->sendResponse('Successfully logged out');
    }

    protected function respondWithToken($token): \Illuminate\Http\JsonResponse
    {
        return $this->sendResponse([
            'access_token' => $token->accessToken,
            'token_type' => 'bearer',
            'expires_in' => Carbon::parse($token->token->expires_at)->toDateTimeString()
        ]);
    }
}
