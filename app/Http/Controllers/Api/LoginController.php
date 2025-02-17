<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Tag(
 *     name="Auth",
 *     description="Authentication endpoints"
 * )
 */
class LoginController extends Controller {

    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     summary="Login",
     *     description="Logs in a user with valid credentials and returns a token.",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful login",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example="true"),
     *             @OA\Property(property="msg", type="string", example="Success login"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="user",
     *                     type="object",
     *                      @OA\Property(property="id", type="string", example="your_user_id"),
     *                      @OA\Property(property="name", type="string", example="your name"),
     *                      @OA\Property(property="email", type="string", example="your email"),
     *                 ),
     *                  @OA\Property(
     *                      property="access",
     *                      type="object",
     *                       @OA\Property(property="access_token", type="string", example="your-access-token"),
     *                       @OA\Property(property="token_type", type="string", example="bearer"),
     *                  ),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *              @OA\JsonContent(
     *              @OA\Property(property="status", type="boolean", example="false"),
     *              @OA\Property(property="msg", type="string", example="Failed login"),
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *              ),
     *          )
     *     )
     * )
     */
    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse{
        if (! Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status'        => false,
                'msg'           => 'Login Failled',
                'data'          => null
            ], 401);
        }

        $check = User::query()
            ->where('email', $request->input('email'))
            ->first();

        $token = $check->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status'    => true,
            'msg'       => 'Login Success',
            'data'      => [
                'user'      => [
                    'id'        => $check->id,
                    'email'     => $check->email,
                    'name'      => $check->name,
                ],
                'access'    => [
                    'access_token'  => $token,
                    'token_type'    => 'Bearer'
                ],
            ],
        ]);
    }
}
