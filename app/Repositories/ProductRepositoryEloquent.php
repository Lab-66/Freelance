<?php namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Str;
use Sentinel;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ProductRepositoryEloquent implements ProductRepository
{
    /**
     * @var Product
     */
    private $model;
    private $user;

    /**
     * ProductRepositoryEloquent constructor.
     * @param Product $model
     */
    public function __construct(Product $model)
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
        $model = $this->user->products()->create($data);
        return $model;
    }

    public function uploadProductImage(UploadedFile $file)
    {
        $destinationPath = public_path() . '/uploads/products/';
        $extension = $file->getClientOriginalExtension();
        $filename = $file->getClientOriginalName();
        $picture = Str::slug(substr($filename, 0, strrpos($filename, "."))) . '_' . time() . '.' . $extension;
        return $file->move($destinationPath, $picture);
    }
}