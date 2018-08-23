<?php namespace App\Repositories;


use App\Models\Category;
use Sentinel;

class CategoryRepositoryEloquent implements CategoryRepository
{
    /**
     * @var Category
     */
    private $model;
    private $user;


    /**
     * CategoryRepositoryEloquent constructor.
     */
    public function __construct(Category $model)
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
        $company = $this->user->categories()->create($data);
        return $company;
    }
}