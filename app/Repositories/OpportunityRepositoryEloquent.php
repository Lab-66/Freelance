<?php namespace App\Repositories;

use App\Models\Opportunity;
use Illuminate\Support\Collection;
use Sentinel;

class OpportunityRepositoryEloquent implements OpportunityRepository
{
    /**
     * @var Opportunity
     */
    private $model;
    private $user;

    /**
     * OpportunityRepositoryEloquent constructor.
     * @param Opportunity $model
     */
    public function __construct(Opportunity $model)
    {

        $this->model = $model;
        $this->user = Sentinel::getUser();
    }

    public function getAll(array $with = [])
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
        $this->user->opportunities()->create($data);
    }


    public function getAllForCustomer($customer_id)
    {
        $models = $this->model->whereHas('user', function ($q) use ($customer_id) {
            $q->where('customer_id', $customer_id);
        });

        return $models;
    }
}