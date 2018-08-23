<?php

namespace App\Repositories;


use App\Models\EmailTemplate;
use Sentinel;

class EmailTemplateRepositoryEloquent implements EmailTemplateRepository
{
    /**
     * @var EmailTemplate
     */
    private $model;
    private $user;


    /**
     * CategoryRepositoryEloquent constructor.
     * @param EmailTemplate $model
     */
    public function __construct(EmailTemplate $model)
    {
        $this->model = $model;
        $this->user = Sentinel::getUser();
    }

    public function getAll()
    {
        $models = $this->model->whereHas('user', function ($q) {
            $q->where(function ($query) {
                $query
                    ->orWhere('user_id', $this->user->id)
                    ->orWhere('user_id', $this->user->parent->id);
            });
        });

        return $models;
    }

    public function create(array $data)
    {
        $company = $this->user->emailTemplates()->create($data);
        return $company;
    }
}