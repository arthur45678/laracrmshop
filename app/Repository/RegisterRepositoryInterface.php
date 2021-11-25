<?php

namespace App\Repository;
use App\Http\Requests\UpdateInfoRequest;
use Illuminate\Routing\ResponseFactory;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

interface RegisterRepositoryInterface
{

    /**
     * @param array $data
     * @return Collection
     */
    public function register(array  $data): object;

    /**
     * @param array $data
     * @return object
     */
    public function login(array  $data): object;



    /**
     * @param array $data
     * @param object $user
     * @return ResponseFactory
     */
    public function updateInfo(array  $data, object $user):  ResponseFactory;


}
