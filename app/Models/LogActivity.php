<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    use HasFactory;
    protected $fillable = [

       'id', 'subject', 'request_data','url', 'method', 'ip', 'agent', 'user_id','data_user_id'

    ];
}
