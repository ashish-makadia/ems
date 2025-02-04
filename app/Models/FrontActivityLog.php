<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrontActivityLog extends Model
{
    use HasFactory;
    protected $table='front_log_activities';
    protected $guarded = ['id'];
    protected $with = ["users"];
    public function users(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
