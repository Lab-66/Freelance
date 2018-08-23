<?php namespace App\Repositories;

use App\Models\Lead;
use Sentinel;

class LeadRepositoryEloquent implements LeadRepository
{
    /**
     * @var Lead
     */
    private $model;
    private $user;

    /**
     * LeadRepositoryEloquent constructor.
     * @param Lead $model
     */
    public function __construct(Lead $model)
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

    public function store(array $data)
    {
        $lead = $this->user->leads()->create($data);
        return $lead;
    }


    public function getAllForCustomer($customer_id)
    {
        $models = $this->model->whereHas('user', function ($q) use ($customer_id) {
            $q->where('customer_id', $customer_id);
        });

        return $models;
    }
}