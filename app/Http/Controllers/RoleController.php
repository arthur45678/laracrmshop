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

    public function index()
    {
        $roles = $this->roleRepository->getAll();
        return RoleResource::collection($roles);
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $data = $this->roleRepository->store($input);
        return response(new RoleResource($data), Response::HTTP_CREATED);
    }

    public function show($id)
    {
        $role = $this->roleRepository->show($id);
        return new RoleResource($role);
    }

    public function update(Request $request, $id)
    {
        $name = $request->only('name');
        $permissions = $request->input('permissions');


        $data = $this->roleRepository->update($id,$name,$permissions);

        return response(new RoleResource($data), Response::HTTP_ACCEPTED);
    }

    public function destroy($id)
    {
        $this->roleRepository->destroy($id);

        return \response(null, Response::HTTP_NO_CONTENT);
    }
}
