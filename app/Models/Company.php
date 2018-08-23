<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Venturecraft\Revisionable\RevisionableTrait;

class Company extends Model
{
    use SoftDeletes,RevisionableTrait;

    protected $dates = ['deleted_at'];
    protected $guarded = array('id');
    protected $table = 'companies';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contactPerson()
    {
        return $this->belongsTo(User::class,'main_contact_person');
    }

    public function salesTeam()
    {
        return $this->belongsTo(Salesteam::class, 'sales_team_id');
    }

    public function cities()
    {
        return $this->belongsTo(City::class, 'city_id');
    }


}
