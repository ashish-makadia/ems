<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave_management extends Model
{
    use HasFactory;
    protected $table='leave_management';
    protected $fillable = ['employee_id','holiday_id','from_date','to_date','type','description','status'];
}
