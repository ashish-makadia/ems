<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Region;

class Province extends Authenticatable
{
    /*protected $table = 'province';
	protected $fillable = [
		'province_name', 'region_id','status', 'created_by' ,'updated_by'
	];*/

	protected $table='province';
    protected $guarded=['id'];

	public function region()
	{
		return $this->belongsTo(Region::class,'region_id');
	}
}
