<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductSubcategory extends Model
{

    protected $fillable = [
        'user_id', 'product_category_id', 'name', 'account_code_id', 'description', 'active'
    ];

    public function product_category()
    {
        return $this->belongsTo('App\ProductCategory');
    }

    public function products(){
        return $this->hasMany('App\Product');
    }
}
