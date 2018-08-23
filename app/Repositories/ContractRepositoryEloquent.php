<?php namespace App\Repositories;

use App\Models\Contract;
use Sentinel;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ContractRepositoryEloquent implements ContractRepository
{
    /**
     * @var Contract
     */
    private $model;
    private $user;

    /**
     * ContractRepositoryEloquent constructor.
     * @param Contract $model
     */
    public function __construct(Contract $model)
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
        $this->user->contracts()->create($data);
    }

    public function uploadRealSignedContract(UploadedFile $file)
    {
        $destinationPath = public_path() . '/uploads/contract/';
        $extension = $file->getClientOriginalExtension() ?: 'png';
        $fileName = str_random(10) . '.' . $extension;
        return $file->move($destinationPath, $fileName);
    }

    public function getAllForCustomer($companies)
    {
        $company_ids = array();
        foreach ($companies as $company)
        {
            $company_ids[] = $company->id;
        }

        $models = $this->model->whereIn('company_id',$company_ids);

        return $models;
    }

}