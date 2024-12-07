<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Country;

class Region extends Authenticatable
{
    //
    /*protected $table = 'region';
	protected $fillable = [
		'region_name', 'country_id','status','seo_title','seo_description','seo_rewrite_url'
	];*/
	
	protected $table='region';
    protected $guarded=['id'];

	public function country()
	{
		return $this->belongsTo(Country::class,'country_id');
	}
	
}
