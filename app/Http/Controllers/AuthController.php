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

    public function register(RegisterRequest $request)
    {
        $input = $request->all();
        $data = $this->registerRepository->register($input);

        return response(new UserResource($data), Response::HTTP_CREATED);
    }

    public function login(Request $request)
    {

        $input = $request->all();
        $data = $this->registerRepository->login($input);
        return $data;
    }

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

    public function updateInfo(UpdateInfoRequest $request)
    {
        $input = $request->only('first_name', 'last_name', 'email');
        $user = $request->user();
        $this->registerRepository->updateInfo($input,$user);
        return \response(new UserResource($user), Response::HTTP_ACCEPTED);
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = $request->user();

        $user->update([
            'password' => Hash::make($request->input('password'))
        ]);

        return \response(new UserResource($user), Response::HTTP_ACCEPTED);
    }
}
