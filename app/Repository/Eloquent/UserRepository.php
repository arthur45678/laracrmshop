<?php

namespace App\Repository\Eloquent;

use App\Models\User;
use App\Repository\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class UserRepository extends BaseRepository implements UserRepositoryInterface
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
     * @return object
     */
    public function getAll(): object
    {
        return $this->model::with('role')->paginate();
    }

    /**
     * @param array $data
     * @return object
     */
    public function store(array $data): object
    {
        return $user = $this->model::create($data

            + ['password' => Hash::make(1234)]
        );
    }

    /**
     * @param $id
     * @return object
     */
    public function show($id): object
    {
        return $this->model::with('role')->find($id);
    }

    /**
     * @param array $input
     * @param $id
     * @return object
     */
    public function update(array $input, $id): object
    {
        $user = User::find($id);

        return $user->update($input);
    }

    /**
     * @param $id
     * @return object
     */
    public function destroy($id): object
    {
        return $this->model::destroy($id);
    }

}
