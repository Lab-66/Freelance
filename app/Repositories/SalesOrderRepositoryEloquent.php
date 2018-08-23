<?php namespace App\Repositories;

use App\Models\Saleorder;
use Sentinel;

class SalesOrderRepositoryEloquent implements SalesOrderRepository
{
    /**
     * @var QuotationSaleorder
     */
    private $model;
    private $user;

    /**
     * SalesOrderRepositoryEloquent constructor.
     */
    public function __construct(Saleorder $model)
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

    public function getAllToday()
    {
        $models = $this->model->whereHas('user', function ($q) {
            $q->where('date', strtotime(date('Y-m-d')))
                ->where(function ($query) {
                    $query
                        ->orWhere('id', $this->user->parent->id)
                        ->orWhere('users.user_id', $this->user->parent->id);
                });
        });

        return $models;
    }

    public function getAllYesterday()
    {
        $models = $this->model->whereHas('user', function ($q) {
            $q->where('date', strtotime(date('Y-m-d', strtotime("-1 days"))))
                ->where(function ($query) {
                    $query
                        ->orWhere('id', $this->user->parent->id)
                        ->orWhere('users.user_id', $this->user->parent->id);
                });
        });

        return $models;
    }

    public function getAllWeek()
    {
        $models = $this->model->whereHas('user', function ($q) {
            $q->whereBetween('date',
                array(strtotime((date('D') != 'Mon') ? date('Y-m-d', strtotime('last Monday')) : date('Y-m-d')),
                    strtotime((date('D') != 'Sat') ? date('Y-m-d', strtotime('next Saturday')) : date('Y-m-d'))))
                ->where(function ($query) {
                    $query
                        ->orWhere('id', $this->user->parent->id)
                        ->orWhere('users.user_id', $this->user->parent->id);
                });
        });

        return $models;
    }

    public function getAllMonth()
    {
        $models = $this->model->whereHas('user', function ($q) {
            $q->whereBetween('date',
                array(date('d-m-Y', strtotime('first day of this month')),
                    date('d-m-Y', strtotime('last day of this month'))))
                ->where(function ($query) {
                    $query
                        ->orWhere('id', $this->user->parent->id)
                        ->orWhere('users.user_id', $this->user->parent->id);
                });
        });

        return $models;
    }

    public function getAllForCustomer($customer_id)
    {
        $models = $this->model->whereHas('customer', function ($q) use ($customer_id) {
            $q->where('customer_id', $customer_id);
        });

        return $models;
    }
}