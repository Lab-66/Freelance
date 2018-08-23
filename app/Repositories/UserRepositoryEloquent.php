<?php namespace App\Repositories;

use App\Models\User;
use Cartalyst\Sentinel\Sentinel;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UserRepositoryEloquent implements UserRepository
{
    private $user;
    /**
     * @var User
     */
    private $model;
    /**
     * @var Sentinel
     */
    private $sentinel;

    /**
     * UserRepositoryEloquent constructor.
     * @param User $model
     */
    public function __construct(User $model, Sentinel $sentinel)
    {
        $this->model = $model;
        $this->sentinel = $sentinel;
        $this->user = $this->sentinel->getUser();
    }

    public function getStaff()
    {
        if ($this->user->inRole('staff')) {
            return $this->user->users->filter(function ($user) {
                return $user->inRole('staff');
            })->add($this->user);;
        } else if ($this->user->inRole('admin')) {
            $staffs = new Collection([]);
            $this
                ->user
                ->users()
                ->with('users.users')
                ->get()
                ->each(function ($user) use ($staffs) {
                    foreach ($user->users as $u) {
                        $staffs->push($u);
                    }
                    //$staffs->push($user);
                });

            $staffs = $staffs->filter(function ($user) {
                return $user->inRole('staff');
            });
            return $staffs;
        }

    }

    public function getCustomers()
    {
        if ($this->user->inRole('staff')) {
            return $this->user->users->filter(function ($user) {
                return $user->inRole('customer');
            });
        } else if ($this->user->inRole('admin')) {
            $staffs = new Collection([]);
            $this
                ->user
                ->users()
                ->with('users.users')
                ->get()
                ->each(function ($user) use ($staffs) {
                    foreach ($user->users as $u) {
                        $staffs->push($u);
                    }
                    //$staffs->push($user);
                });

            $staffs = $staffs->filter(function ($user) {
                return $user->inRole('customer');
            });
            return $staffs;
        }
    }

    public function getParentStaff()
    {
        $staffs = new Collection([]);
        $this->user
            ->parent->users()
            ->with('users.users')
            ->get()
            ->each(function ($user) use ($staffs) {
                foreach ($user->users as $u) {
                    $staffs->push($u);
                }
                //$staffs->push($user);
            });

        $staffs = $staffs->filter(function ($user) {
            return $user->inRole('staff');
        });
        return $staffs;
    }

    public function getParentCustomers()
    {
        $staffs = new Collection([]);
        $this
            ->user
            ->parent->users()
            ->with('users.users')
            ->get()
            ->each(function ($user) use ($staffs) {
                foreach ($user->users as $u) {
                    $staffs->push($u);
                }
                // $staffs->push($user);
            });

        $staffs = $staffs->filter(function ($user) {
            return $user->inRole('customer');
        });
        return $staffs;
    }

    public function getAll()
    {
        $models = $this->model->whereHas('user', function ($q) {
            $q->where(function ($query) {
                $query
                    ->orWhere('user_id', $this->user->parent->id)
                    ->orWhere('users.user_id', $this->user->parent->id);
            });
        });

        return $models;
    }

    public function getAllForCustomer()
    {
        $models = $this->model;

        return $models;
    }
    public function getUsersAndStaffs()
    {
        return $this->model->get()->filter(
            function ($user) {
                return ($user->inRole('user') && $user->inRole('staff'));
            }
        );
    }

    public function uploadAvatar(UploadedFile $file)
    {
        $destinationPath = public_path() . '/uploads/avatar/';
        $extension = $file->getClientOriginalExtension() ?: 'png';
        $fileName = str_random(10) . '.' . $extension;
        return $file->move($destinationPath, $fileName);
    }

    public function create(array $data, $activate = false)
    {
        $user = $this->sentinel->register($data, $activate);
        $this->user->users()->save($user);
        return $user;
    }

    public function assignRole(User $user, $roleName)
    {
        $role = $this->sentinel->getRoleRepository()->findByName($roleName);
        $role->users()->attach($user);
    }

}