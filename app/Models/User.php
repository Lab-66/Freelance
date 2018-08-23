<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Cashier\Billable;
use Laravel\Cashier\Contracts\Billable as BillableContract;

class User extends EloquentUser implements AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract,
    BillableContract
{
    use Authenticatable, Authorizable, CanResetPassword;
    /**
     * To allow cashier
     */
    use Billable;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';


    protected $guarded = array('id');

    protected $hidden = ['password'];

    protected $appends = ['full_name', 'avatar'];

    public function customer()
    {
        return $this->hasOne('App\Models\Customer');
    }

    public function staff()
    {
        return $this->hasOne('App\Models\Staff');
    }

    public function salesTeams()
    {
        return $this->hasMany(Salesteam::class);
    }

    public function opportunities()
    {
        return $this->hasMany(Opportunity::class);
    }

    public function meetings()
    {
        return $this->hasMany(Meeting::class);
    }

    public function calls()
    {
        return $this->hasMany(Call::class);
    }

    public function qtemplates()
    {
        return $this->hasMany(Qtemplate::class);
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }

    public function authorized($permission = null)
    {
        return $this->hasAccess($permission);
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function companies()
    {
        return $this->hasMany(Company::class);
    }

    public function allChildCustomers()
    {
        return $this->hasManyThrough(Customer::class, User::class, 'user_id', 'belong_user_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function invoiceReceivePayments()
    {
        return $this->hasMany(InvoiceReceivePayment::class);
    }

    public function getAvatarAttribute()
    {
        $val = $this->attributes['user_avatar'];
        if (empty($val))
            return asset('uploads/avatar') . '/user.png';

        $val = asset('uploads/avatar') . '/' . $val;

        return $val;
    }

    public function emailTemplates()
    {
        return $this->hasMany(EmailTemplate::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function emails()
    {
        return $this->hasMany(Email::class, 'to');
    }

    public function logins()
    {
        return $this->hasMany(UserLogin::class);
    }

    public function invite()
    {
        return $this->hasMany(InviteUser::class);
    }

}
