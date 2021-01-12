<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $fillable = [

        'hotel_id', 'user_id', 'name', 'property_department_id', 'account_code_id',
        'description'
    ];

    public function subcategories(){
        return $this->hasMany('App\ProductSubcategory');
    }
}
