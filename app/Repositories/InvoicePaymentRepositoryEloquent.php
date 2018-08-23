<?php namespace App\Repositories;


use App\Models\InvoiceReceivePayment;
use Sentinel;

class InvoicePaymentRepositoryEloquent implements InvoicePaymentRepository
{
    /**
     * @var InvoiceReceivePayment
     */
    private $model;
    private $user;


    /**
     * InvoicePaymentRepositoryEloquent constructor.
     * @param InvoiceReceivePayment $model
     */
    public function __construct(InvoiceReceivePayment $model)
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
}