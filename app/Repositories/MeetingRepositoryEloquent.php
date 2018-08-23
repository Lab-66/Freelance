<?php namespace App\Repositories;


use App\Models\Meeting;
use Sentinel;

class MeetingRepositoryEloquent implements MeetingRepository
{
    /**
     * @var Meeting
     */
    private $model;
    private $user;

    /**
     * MeetingRepositoryEloquent constructor.
     * @param Meeting $model
     */
    public function __construct(Meeting $model)
    {
        $this->model = $model;
        $this->user = Sentinel::getUser();
    }

    public function getAll()
    {
        $models = $this->model->whereHas('user', function ($q) {
            $q->where(function ($query) {
                $query
                    ->orWhere('id', $this->user->parent->id)
                    ->orWhere('users.user_id', $this->user->parent->id);
            });
        });

        return $models;
    }

    public function create(array $data)
    {
        $model = $this->user->meetings()->create($data);
        return $model;

    }
}