<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchSaveProprty extends Model
{
    use HasFactory;
    protected $table='save_search';
    protected $guarded=['id'];
}
