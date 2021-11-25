<?php

namespace App\Repository\Eloquent;

use App\Models\User;
use App\Repository\RegisterRepositoryInterface;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class RegisterRepository extends BaseRepository implements RegisterRepositoryInterface
{


    /**
     * UserRepository constructor.
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
    /**
     * @param array $data
     * @return Collection
     */
    public function register(array  $data): object{

        return $this->model->create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role_id' => 1
        ]);

    }

    /**
     * @param array $data
     * @return Collection
     */
    public function login(array  $data): object{


        if (!Auth::attempt($data)) {

            return \response([
                'error' => 'Invalid credentials!'
            ], Response::HTTP_UNAUTHORIZED);
        }


        /** @var User $user */
        $user = Auth::user();

        $jwt = $user->createToken('token')->plainTextToken;

        $cookie = cookie('jwt', $jwt, 60 * 24);

        return \response([
            'jwt' => $jwt
        ])->withCookie($cookie);
    }


    /**
     * @param array $data
     * @param object $user
     * @return ResponseFactory
     */
    public function updateInfo(array  $data, object $user):  ResponseFactory
    {
       return $user->update($data['first_name'],$data['last_name'], $data['email']);
    }

}
