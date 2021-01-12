<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomTax extends Model
{
    protected $fillable =
    ['hotel_id','name','code','department_id', 'tax_applied_id','account_code_id','description','included','adult_child','adult_type'];



    public function department()
    {
        return $this->belongsTo('App\Department');
    }

    public function room_tax_details()
    {
        return $this->hasMany('App\RoomTaxDetail');
    }
    public function tax_applied()
    {
        return $this->belongsTo('App\TaxApplied');
    }
    public function room_types()
    {
        return $this->belongsToMany('App\RoomType');
    }
    public function getDetailsAttribute()
    {   $cantidad = count($this->room_tax_details);

        $info ="";
        foreach ($this->room_tax_details as $key => $value) {
            $info .= '<div style="border-bottom: 1px solid #5DADE2;" >';
            if ($key == 0 && $cantidad > 0){
                $info .= 'For ';
            }else if($key > 0 && $cantidad > 0){
                $info .= ' Else ';
            }
            if ($value->charge_less && $value->charge_less >1  ){
                $info .= ($this->tax_applied->name ?? '') .' Charge less than '.$value->charge_less .' '. $this->department->name."=" . $value->tax_value. ($this->tax_applied->tax_type_id == 1 ? '%' : '$');
            }else{
                $info .= "{$value->tax_value} ".($this->tax_applied->tax_type_id==1?'%':'$') ." ".($this->tax_applied->name ?? '');
            }
          $info .= '</div>';

        }
        return $info;
    }
}
