<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    use HasFactory;
    protected $table='holiday_management';
   	protected $guarded=['id'];
       protected $fillable = ['name','from_date','to_date','type','image','description','status'];
}
