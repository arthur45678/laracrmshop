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

    /**
     * @OA\Get(path="/api/users",
     *   security={{"bearerAuth":{}}},
     *   tags={"Users"},
     *   @OA\Response(response="200",
     *     description="User Collection",
     *   ),
     *   @OA\Parameter(
     *     name="page",
     *     description="Pagination page",
     *     in="query",
     *     @OA\Schema(
     *        type="integer"
     *     )
     *   )
     * )
     */
    public function index()
    {
        $users = $this->userRepository->getAll();
        return UserResource::collection($users);
    }
    /**
     * @OA\Post(
     *   path="/api/users",
     *   security={{"bearerAuth":{}}},
     *   tags={"Users"},
     *   @OA\Response(response="201",
     *     description="User Create",
     *   ),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(ref="#/components/schemas/UserCreateRequest")
     *   )
     * )
     */
    public function store(UserCreateRequest $request)
    {
        $input = $request->only('first_name', 'last_name', 'email', 'role_id');
        $user = $this->userRepository->store($input);

        return response(new UserResource($user), Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(path="/api/users/{id}",
     *   security={{"bearerAuth":{}}},
     *   tags={"Users"},
     *   @OA\Response(response="200",
     *     description="User",
     *   ),
     *   @OA\Parameter(
     *     name="id",
     *     description="User ID",
     *     in="path",
     *     required=true,
     *     @OA\Schema(
     *        type="integer"
     *     )
     *   )
     * )
     */
    public function show($id)
    {
        $user = $this->userRepository->show($id);
        return new UserResource($user);
    }

    /**
     * @OA\Put(
     *   path="/api/users/{id}",
     *   security={{"bearerAuth":{}}},
     *   tags={"Users"},
     *   @OA\Response(response="202",
     *     description="User Update",
     *   ),
     *   @OA\Parameter(
     *     name="id",
     *     description="User ID",
     *     in="path",
     *     required=true,
     *     @OA\Schema(
     *        type="integer"
     *     )
     *   ),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(ref="#/components/schemas/UserUpdateRequest")
     *   )
     * )
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $input = $request->all();
        $user = $this->userRepository->update($input);

        return \response(new UserResource($user), Response::HTTP_ACCEPTED);
    }

    /**
     * @OA\Delete(path="/api/users/{id}",
     *   security={{"bearerAuth":{}}},
     *   tags={"Users"},
     *   @OA\Response(response="204",
     *     description="User Delete",
     *   ),
     *   @OA\Parameter(
     *     name="id",
     *     description="User ID",
     *     in="path",
     *     required=true,
     *     @OA\Schema(
     *        type="integer"
     *     )
     *   )
     * )
     */
    public function destroy($id)
    {
        $this->userRepository->destroy($id);

        return \response(null, Response::HTTP_NO_CONTENT);
    }
}
