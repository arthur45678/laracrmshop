<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repository\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $users = $this->userRepository->getAll();
        return UserResource::collection($users);
    }

    public function store(UserCreateRequest $request)
    {
        $input = $request->only('first_name', 'last_name', 'email', 'role_id');
        $user = $this->userRepository->store($input);

        return response(new UserResource($user), Response::HTTP_CREATED);
    }

    public function show($id)
    {
        $user = $this->userRepository->show($id);
        return new UserResource($user);
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $input = $request->all();
        $user = $this->userRepository->update($input);

        return \response(new UserResource($user), Response::HTTP_ACCEPTED);
    }

    public function destroy($id)
    {
        $this->userRepository->destroy($id);

        return \response(null, Response::HTTP_NO_CONTENT);
    }
}
