<?php

namespace App\Models;

use App\Services\SubCategoriesServices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table='customer';
   	protected $guarded=['id'];
    protected $appends = [
        'customer_edit_url'
    ];
    public function getCustomerEditUrlAttribute()
    {
        return route('customer.edit', ['customer' => $this->attributes['id']]);
    }

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category', 'id');
    }
    public function subCategory()
    {
        return $this->belongsTo(SubCategories::class, 'subCategory', 'id');
    }
}
