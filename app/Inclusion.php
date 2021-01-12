<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inclusion extends Model
{
    protected $fillable = [
        'hotel_id', 'user_id', 'name', 'code', 'description',
        'pos_product_id', 'price', 'update_price', 'discount',
        'discount_type', 'calculation_rule_id', 'posting_rhythm_id', 'public_web'
    ];

    public function hotel(){
        return $this->belongsTo('App\Hotel');
    }
    public function images()
    {
        return $this->morphMany('App\Image', 'imageable');
    }
    public function pos_product(){
        return $this->belongsTo('App\PosProduct');
    }
    public function packages_masters()
    {
        return $this->belongsToMany('App\PackagesMaster');
    }
    public function price_after_discount(){
        $price =$this->price;
        $discount = $this->discount;

        if($this->discount_type == 1){
            $result = $price -($price*$discount/100);
        }else{
            $result = $price - $discount;
        }

        return  $result;
    }
}
