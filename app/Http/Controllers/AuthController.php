<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateInfoRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repository\RegisterRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    protected $registerRepository;

    public function __construct(RegisterRepositoryInterface $registerRepository)
    {

        $this->registerRepository = $registerRepository;
    }

    /**
     * @OA\Post(
     *   path="/register",
     *   tags={"Public"},
     *   @OA\Response(response="200",
     *     description="Register",
     *   )
     * )
     */
    public function register(RegisterRequest $request)
    {
        $input = $request->all();
        $data = $this->registerRepository->register($input);

        return response(new UserResource($data), Response::HTTP_CREATED);
    }

    /**
     * @OA\Post(
     *   path="/api/login",
     *   tags={"Public"},
     *   @OA\Response(response="200",
     *     description="Login",
     *   )
     * )
     */
    public function login(Request $request)
    {
        $input = $request->only('email', 'password');
        $data = $this->registerRepository->login($input);
        return $data;
    }

    /**
     * @OA\Get(path="/api/user",
     *   security={{"bearerAuth":{}}},
     *   tags={"Profile"},
     *   @OA\Response(response="200",
     *     description="Authenticated User",
     *   )
     * )
     */
    public function user(Request $request)
    {
        $user = $request->user();

        return new UserResource($user->load('role'));
    }

    public function logout()
    {
        $cookie = \Cookie::forget('jwt');

        return \response([
            'message' => 'success'
        ])->withCookie($cookie);
    }

    /**
     * @OA\Put(
     *   path="/api/users/info",
     *   security={{"bearerAuth":{}}},
     *   tags={"Profile"},
     *   @OA\Response(response="202",
     *     description="User Info Update",
     *   ),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(ref="#/components/schemas/UpdateInfoRequest")
     *   )
     * )
     */

    public function updateInfo(UpdateInfoRequest $request)
    {
        $input = $request->only('first_name', 'last_name', 'email');
        $user = $request->user();
        $this->registerRepository->updateInfo($input,$user);
        return \response(new UserResource($user), Response::HTTP_ACCEPTED);
    }

    /**
     * @OA\Put(
     *   path="/api/users/password",
     *   security={{"bearerAuth":{}}},
     *   tags={"Profile"},
     *   @OA\Response(response="202",
     *     description="User Password Update",
     *   ),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(ref="#/components/schemas/UpdatePasswordRequest")
     *   )
     * )
     */
    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = $request->user();

        $user->update([
            'password' => Hash::make($request->input('password'))
        ]);

        return \response(new UserResource($user), Response::HTTP_ACCEPTED);
    }
}
