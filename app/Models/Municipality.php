<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Province;

class Municipality extends Authenticatable
{
   /*	protected $table = 'municipality';
	protected $fillable = [
		'municipality_name', 'province_id', 'region_id' ,'status', 'created_by' ,'updated_by'
	];*/

	protected $table='municipality';
    protected $guarded=['id'];

	public function province()
	{
		return $this->belongsTo(Province::class,'province_id');
	}
}
