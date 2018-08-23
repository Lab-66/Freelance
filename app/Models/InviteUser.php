<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InviteUser extends Model {

	protected $table = 'invite_user';
	protected $fillable = array('code', 'email','user_id');

	public function parent()
	{
		return $this->belongsTo(User::class, 'user_id');
	}

}