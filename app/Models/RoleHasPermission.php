<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleHasPermission extends Model
{
    protected $fillable = ['permission_id','role_id'];
    public $timestamps = false;
    public function permissions(){
    	return $this->belongsTo(Permission::class,'permission_id');
    }
    public function roles(){
    	return $this->belongsTo(Role::class,'role_id');
    }
}
