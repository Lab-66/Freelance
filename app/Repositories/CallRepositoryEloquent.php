<?php namespace App\Repositories;

use App\Models\Call;
use Sentinel;

class CallRepositoryEloquent implements CallRepository
{
    /**
     * @var Call
     */
    private $model;
    private $user;


    /**
     * CallRepositoryEloquent constructor.
     * @param Call $model
     */
    public function __construct(Call $model)
    {
        $this->model = $model;
        $this->user = Sentinel::getUser();
    }

    public function getAll()
    {
        $calls = $this->model;

        return $calls;
    }

    public function getAllLeads()
    {
        $calls = $this->model->where('call_type', 'leads')
            ->whereHas('user', function ($q) {
                $q->where(function ($query) {
                    $query
                        ->orWhere('id', $this->user->parent->id)
                        ->orWhere('users.user_id', $this->user->parent->id);
                });
            });

        return $calls;
    }

    public function getAllOppotunity()
    {
        $calls = $this->model->where('call_type', 'opportunities')
            ->whereHas('user', function ($q) {
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
        $call = $this->user->calls()->create($data);
        return $call;
    }


}