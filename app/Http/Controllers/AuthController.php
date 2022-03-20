<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterFormRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

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
     *     tags = {"Users"},
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
     *     ),
     *     @OA\Response (
     *         response = 422,
     *         description = "Wrong fields",
     *         @OA\JsonContent (
     *             @OA\Property (property = "message", type = "string"),
     *             @OA\Property (property = "errors", type = "array", @OA\Items())
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

        return $this->sendResponse(null, 'Пользователь успешно зарегеистрирован.');
    }

    /**
     * @OA\Post  (
     *     path = "/auth/login",
     *     summary = "Authentification",
     *     description = "Send data to login",
     *     tags = {"Users"},
     *     @OA\RequestBody (
     *         required = true,
     *         @OA\JsonContent (
     *             required = {"password", "email"},
     *             @OA\Property (property = "email", type = "string", format = "email"),
     *             @OA\Property (property = "password", type = "string", format = "password"),
     *             @OA\Property (property = "remember_me", type = "boolean")
     *         )
     *     ),
     *     @OA\Response (
     *         response = 201,
     *         description = "Success logined",
     *         @OA\JsonContent (
     *             @OA\Property (property = "status", type = "boolean"),
     *             @OA\Property (property = "data", type = "object",
     *                  @OA\Property (property = "access_token", type = "string"),
     *                  @OA\Property (property = "token_type", type = "string", default = "bearer"),
     *                  @OA\Property (property = "expires_in", type = "string", format="datetime", example = "2022-03-21 13:11:56")
     *             ),
     *         )
     *     ),
     *     @OA\Response (
     *         response = 401,
     *         description = "Wrong email or password",
     *         @OA\JsonContent (
     *             @OA\Property (property = "status", type = "boolean", default = "false"),
     *             @OA\Property (property = "message", type = "string")
     *         )
     *     )
     * )
     */
    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        $credentials = $request->only(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return $this->sendError('Неверный логин или пароль', null, ResponseAlias::HTTP_UNAUTHORIZED);
        }

        $token = Auth::user()->createToken(config('app.name'));

        $token->token->expires_at = $request->remember_me ?
            Carbon::now()->addMonth() :
            Carbon::now()->addDay();

        $token->token->save();

        return $this->respondWithToken($token);
    }

    /**
     * @OA\Get(
     *      path="/auth/me",
     *      operationId="getAuthUser",
     *      tags={"Users"},
     *      summary="Get auth user",
     *      description="Returns auth user data",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property (property = "data", type = "array", @OA\Items(
     *                  @OA\Property (property = "status", type = "boolean"),
     *                  @OA\Property (property = "data", type = "object", ref="#/components/schemas/User")
     *             )),
     *          )
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function me()
    {
        return $this->sendResponse(new UserResource(User::findOrFail(\auth()->id())));
    }

    /**
     * @OA\Post  (
     *     path = "/auth/logout",
     *     summary = "Logout",
     *     description = "Logout",
     *     tags = {"Users"},
     *     @OA\Response (
     *         response = 200,
     *         description = "Successfully logged out",
     *         @OA\JsonContent (
     *             @OA\Property (property = "message", type = "string", default="Successfully logged out"),
     *         )
     *     ),
     *     @OA\Response (
     *         response = 401,
     *         description = "Not logged",
     *         @OA\JsonContent (
     *             @OA\Property (property = "message", type = "string", default="Unauthentificated")
     *         )
     *     )
     * )
     */
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
