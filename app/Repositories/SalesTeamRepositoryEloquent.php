<?php namespace App\Repositories;

use App\Models\Salesteam;
use Sentinel;

class SalesTeamRepositoryEloquent implements SalesTeamRepository
{
    /**
     * @var Salesteam
     */
    private $model;
    private $user;

    /**
     * SalesTeamRepositoryEloquent constructor.
     */
    public function __construct(Salesteam $model)
    {
        $this->model = $model;
        $this->user = Sentinel::getUser();
    }

    public function getAll()
    {
        $salesTeams = $this->model->whereHas('user', function ($q) {
            $q->where(function ($query) {
                $query
                    ->orWhere('id', $this->user->parent->id)
                    ->orWhere('users.user_id', $this->user->parent->id);
            });
        });
        return $salesTeams;
    }

    public function teamLeader()
    {
        return $this->model->teamLeader();
    }

    public function create(array $data)
    {
        $model = $this->user->salesTeams()->create($data);
        return $model;
    }

    public function getAllQuotations()
    {
        $salesTeams = $this->model->whereHas('user', function ($q) {
            $q->where(function ($query) {
                $query
                    ->orWhere('id', $this->user->parent->id)
                    ->orWhere('users.user_id', $this->user->parent->id);
            })
                ->where('quotations',1);
        });
        return $salesTeams;
    }

    public function getAllLeads()
    {
        $salesTeams = $this->model->whereHas('user', function ($q) {
            $q->where(function ($query) {
                $query
                    ->orWhere('id', $this->user->parent->id)
                    ->orWhere('users.user_id', $this->user->parent->id);
            })
                ->where('leads',1);
        });
        return $salesTeams;
    }

    public function getAllOpportunities()
    {
        $salesTeams = $this->model->whereHas('user', function ($q) {
            $q->where(function ($query) {
                $query
                    ->orWhere('id', $this->user->parent->id)
                    ->orWhere('users.user_id', $this->user->parent->id);
            })
                ->where('opportunities',1);
        });
        return $salesTeams;
    }
}