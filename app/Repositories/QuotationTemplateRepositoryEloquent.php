<?php namespace App\Repositories;


use App\Models\Qtemplate;
use Sentinel;

class QuotationTemplateRepositoryEloquent implements QuotationTemplateRepository
{
    /**
     * @var Qtemplate
     */
    private $model;
    private $user;

    /**
     * QuotationTemplateRepositoryEloquent constructor.
     */
    public function __construct(Qtemplate $model)
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
        $model = $this->user->qtemplates()->create($data);
        return $model;
    }
}