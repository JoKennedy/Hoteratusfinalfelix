<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FrontDeskPackage extends Model
{
    protected $fillable =
    [   'hotel_id', 'user_id', 'name', 'code', 'description', 'stay_length', 'day_package', '
        selling_period_id', 'update_price', 'prorated', 'inclusive_tax', 'travel_agent_commission', '
        travel_agent_commission_type', 'corporate_discount', 'season_attribute', 'season_id', '
        special_period_id', 'start_date', 'end_date', 'featured', 'sort_order', 'active'
    ];

    public function front_desk_package_rooms()
    {
        return $this->hasMany('App\FrontDeskPackageRoom');
    }
    public function inclusions()
    {
        return $this->belongsToMany('App\Inclusion');
    }

    public function package_weekdays()
    {
        return $this->morphOne('App\PackageWeekday', 'weekdayable');
    }
    public function images()
    {
        return $this->morphMany('App\Image', 'imageable');
    }

    public function inclusions_total(){
        $total =0;
        foreach ($this->inclusions as $key => $value) {
            $total += $value->price_after_discount();
        }

        return $total;
    }
    public function front_desk_package_activation_dates()
    {
        return $this->hasMany('App\FrontDeskPackageActivationDate');
    }

    public function activation_dates_str(){
        $data = '';
        if ($this->activated_forever == 0) {
            if ($this->front_desk_package_activation_dates->count() > 0) {
                $data .= '<table style="font-size: .80em">';
                foreach ($this->front_desk_package_activation_dates as $key => $value) {
                    $data .= ' <tr> <td>Activated From ' . date('M, d, Y', strtotime($value->start)) . ' to ' . date('M, d, Y', strtotime($value->end)) . '
                                    <a onclick="editActivated(this,' . $this->id . ',0, ' . $value->id . ',' . "'" . date('d/m/Y', strtotime($value->start)) . "'" . ',' . "'" . date('d/m/Y', strtotime($value->end)) . "'" . ')" href="javascript:void(0)" > <i class="material-icons" style="color:green" >update</i>  </a>
                                    <a onclick="deleteDate(' . $value->id . ')" href="javascript:void(0)"> <i class="material-icons" style="color:red">delete</i> </a> </td> </tr> ';
                }
                $data .= '<tr> <td style="text-align: center;" ><a onclick="editActivated(this, ' . $this->id . ',0)" style="color:blue;" href="javascript:void(0)">Add another Activation Date</a></td>  </tr> </table>';
            } else {
                $data = '<a onclick="editActivated(this, ' . $this->id . ',0)" "style="color:blue;" href="javascript:void(0)">Add Activation Date </a>';
            }
        } else {
            $data = '<div style="font-size: .80em"> Activated Forever <a onclick="editActivated(this, ' . $this->id . ',1)" style="color:blue;" href="javascript:void(0)"><i class="material-icons">update</i> </a> </div>';
        }

        return $data;
    }

}
