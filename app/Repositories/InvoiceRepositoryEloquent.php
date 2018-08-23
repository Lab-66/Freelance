<?php namespace App\Repositories;


use App\Models\Invoice;
use Sentinel;

class InvoiceRepositoryEloquent implements InvoiceRepository
{
    /**
     * @var Invoice
     */
    private $model;
    private $user;

    /**
     * InvoiceRepositoryEloquent constructor.
     * @param Invoice $model
     */
    public function __construct(Invoice $model)
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
        $model = $this->user->invoiceReceivePayments()->create($data);
        return $model;
    }

    public function getAllOpen()
    {
        $models = $this->model->whereHas('user', function ($q) {
            $q->where('invoices.status', 'Open Invoice')
                ->where(function ($query) {
                    $query
                        ->orWhere('id', $this->user->parent->id)
                        ->orWhere('users.user_id', $this->user->parent->id);
                });
        });

        return $models;
    }

    public function getAllOverdue()
    {
        $models = $this->model->whereHas('user', function ($q) {
            $q->where('invoices.status', 'Overdue Invoice')
                ->where(function ($query) {
                    $query
                        ->orWhere('id', $this->user->parent->id)
                        ->orWhere('users.user_id', $this->user->parent->id);
                });
        });

        return $models;
    }

    public function getAllPaid()
    {
        $models = $this->model->whereHas('user', function ($q) {
            $q->where('invoices.status', 'Paid Invoice')
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
        $models = $this->model->whereHas('user', function ($q) use ($customer_id) {
            $q->where('customer_id', $customer_id);
        });

        return $models;
    }

    public function getAllOpenForCustomer($customer_id)
    {
        $models = $this->model->whereHas('user', function ($q) use ($customer_id) {
            $q->where('invoices.status', 'Open Invoice')
                ->where('customer_id', $customer_id);
        });

        return $models;
    }

    public function getAllOverdueForCustomer($customer_id)
    {
        $models = $this->model->whereHas('user', function ($q) use ($customer_id) {
            $q->where('invoices.status', 'Overdue Invoice')
                ->where('customer_id', $customer_id);
        });

        return $models;
    }

    public function getAllPaidForCustomer($customer_id)
    {
        $models = $this->model->whereHas('user', function ($q) use ($customer_id) {
            $q->where('invoices.status', 'Paid Invoice')
                ->where('customer_id', $customer_id);
        });

        return $models;
    }

    public function getAllOpenMonth()
    {
        $models = $this->model->whereHas('user', function ($q) {
            $q->where('invoices.status', 'Open Invoice')
                ->where('invoice_date','LIKE', date('Y-m').'%')
                ->where(function ($query) {
                    $query
                        ->orWhere('id', $this->user->parent->id)
                        ->orWhere('users.user_id', $this->user->parent->id);
                });
        });

        return $models;
    }

    public function getAllOverdueMonth()
    {
        $models = $this->model->whereHas('user', function ($q) {
            $q->where('invoices.status', 'Overdue Invoice')
                ->where('invoice_date','LIKE', date('Y-m').'%')
                ->where(function ($query) {
                    $query
                        ->orWhere('id', $this->user->parent->id)
                        ->orWhere('users.user_id', $this->user->parent->id);
                });
        });

        return $models;
    }

    public function getAllPaidMonth()
    {
        $models = $this->model->whereHas('user', function ($q) {
            $q->where('invoices.status', 'Paid Invoice')
                ->where('invoice_date','LIKE', date('Y-m').'%')
                ->where(function ($query) {
                    $query
                        ->orWhere('id', $this->user->parent->id)
                        ->orWhere('users.user_id', $this->user->parent->id);
                });
        });

        return $models;
    }
}