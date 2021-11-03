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
