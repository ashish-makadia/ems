<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Country extends Authenticatable
{
    //
    //
    protected $table = 'country';
	protected $fillable = [
		'name' , 'status' , 'created_by' ,'updated_by'
	];

	
}
