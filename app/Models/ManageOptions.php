<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManageOptions extends Model
{
    use HasFactory;
    protected $table='manage_options';
   	protected $guarded=['id'];
}
