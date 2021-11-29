<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleResource;
use App\Models\Role;
use App\Repository\RoleRepositoryInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    protected $roleRepository;

    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * @OA\Get(path="/api/roles",
     *   security={{"bearerAuth":{}}},
     *   tags={"Roles"},
     *   @OA\Response(response="200",
     *     description="Role Collection",
     *   )
     * )
     */
    public function index()
    {
        $roles = $this->roleRepository->getAll();
        return RoleResource::collection($roles);
    }

    /**
     * @OA\Post(
     *   path="/api/roles",
     *   security={{"bearerAuth":{}}},
     *   tags={"Roles"},
     *   @OA\Response(response="201",
     *     description="Role Create",
     *   )
     * )
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $data = $this->roleRepository->store($input);
        return response(new RoleResource($data), Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(path="/api/roles/{id}",
     *   security={{"bearerAuth":{}}},
     *   tags={"Roles"},
     *   @OA\Response(response="200",
     *     description="User",
     *   ),
     *   @OA\Parameter(
     *     name="id",
     *     description="Role ID",
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
        $role = $this->roleRepository->show($id);
        return new RoleResource($role);
    }

    /**
     * @OA\Put(
     *   path="/api/roles/{id}",
     *   security={{"bearerAuth":{}}},
     *   tags={"Roles"},
     *   @OA\Response(response="202",
     *     description="Role Update",
     *   ),
     *   @OA\Parameter(
     *     name="id",
     *     description="Role ID",
     *     in="path",
     *     required=true,
     *     @OA\Schema(
     *        type="integer"
     *     )
     *   )
     * )
     */
    public function update(Request $request, $id)
    {
        $name = $request->only('name');
        $permissions = $request->input('permissions');


        $data = $this->roleRepository->update($id,$name,$permissions);

        return response(new RoleResource($data), Response::HTTP_ACCEPTED);
    }

    /**
     * @OA\Delete(path="/api/roles/{id}",
     *   security={{"bearerAuth":{}}},
     *   tags={"Roles"},
     *   @OA\Response(response="204",
     *     description="Role Delete",
     *   ),
     *   @OA\Parameter(
     *     name="id",
     *     description="Role ID",
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
        $this->roleRepository->destroy($id);

        return \response(null, Response::HTTP_NO_CONTENT);
    }
}
