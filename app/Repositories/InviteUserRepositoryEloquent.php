<?php

namespace App\Repositories;

use App\Models\InviteUser;
use Sentinel;

class InviteUserRepositoryEloquent implements InviteUserRepository
{
    /**
     * @var InviteUser
     */
    private $model;
    private $user;


    /**
     * CallRepositoryEloquent constructor.
     * @param InviteUser $model
     */
    public function __construct(InviteUser $model)
    {
        $this->model = $model;
        $this->user = Sentinel::getUser();
    }

    public function getAll()
    {
        $calls = $this->model->whereHas('user', function ($q) {
            $q->where(function ($query) {
                $query
                    ->orWhere('id', $this->user->parent->id)
                    ->orWhere('users.user_id', $this->user->parent->id);
            });
        });

        return $calls;
    }

    public function create(array $data)
    {
        $data['code'] = bin2hex(openssl_random_pseudo_bytes(16));
        return $this->user->invite()->create($data);
    }


}