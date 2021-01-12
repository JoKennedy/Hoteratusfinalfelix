<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $fillable = [ 'hotel_id', 'user_id', 'name', 'code', 'featured', 'product_subcategory_id',
        'description', 'measurement_unit_id'
    ];
    public function product_subcategory()
    {
        return $this->belongsTo('App\ProductSubcategory');
    }
    public function images()
    {
        return $this->morphMany('App\Image', 'imageable');
    }
}
