<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateType extends Model
{
    use HasFactory;
    protected $table='template_type';
   	protected $guarded=['id'];
}
