<?php namespace App\Repositories;

use App\Models\Company;
use Sentinel;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CompanyRepositoryEloquent implements CompanyRepository
{
    /**
     * @var Company
     */
    private $model;
    private $user;

    /**
     * CompanyRepositoryEloquent constructor.
     * @param Company $model
     */
    public function __construct(Company $model)
    {
        $this->model = $model;
        $this->user = Sentinel::getUser();
    }

    public function getAll()
    {
        $companies = $this->model->whereHas('user', function ($q) {
            $q->where(function ($query) {
                $query
                    ->orWhere('id', $this->user->parent->id)
                    ->orWhere('users.user_id', $this->user->parent->id);
            });
        });

        return $companies;
    }

    public function create(array $data)
    {
        $company = $this->user->companies()->create($data);
        return $company;
    }


    public function uploadAvatar(UploadedFile $file)
    {
        $destinationPath = public_path() . '/uploads/company/';
        $extension = $file->getClientOriginalExtension() ?: 'png';
        $fileName = str_random(10) . '.' . $extension;
        return $file->move($destinationPath, $fileName);
    }

}