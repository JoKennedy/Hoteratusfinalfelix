<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DefaultSetting extends Model
{
    protected $fillable = ['hotel_id',
        "language_id", "currency_id", "start_day_financial" , "end_day_financial", "start_month_financial" ,
        "end_month_financial" , "auto_convertion_rate" , "currency_convertion_margin", "currency_decimal_place" ,
        "exclusive_tax" , "show_header_tax" , "breakup_tax_invoice_folio" , "display_tax_invoice" , "group_tax_pos" ,
        "breakup_tax_account_statement" , "display_tax_statement" , "adjustment_invoice_folio" ,
         "account_folio_date" , "show_deposit_alert_checkin" , "date_format" , "time_zone_id", "time_format",
          "checkin_time" , "checkout_time" , "age_maximum_child", "minimum_child_age", "age_maximum_infant" ,
           "travel_agent_commission" , "corporate_discount" ,   "early_checkout_hour",
         "time_night_audit", "run_audit" , "audit_mark_checkin_noshow" , "audit_housekeeping_occupied" ,
         "audit_housekeeping_vacant" , "audit_housekeeping_checkout", "audit_housekeeping_change_room" ,
          "minimum_cancellation_fee" , "early_checkin_hour" , "early_checkin_charge" , "early_checkin_charge_type" ,
         "early_checkout_hour_type", "early_checkout_charge" , "early_checkout_charge_type" , "late_checkout_hour" ,
         "late_checkout_charge" , "late_checkout_charge_type",   "charge_noshow_time" , "charge_noshow_consider"];

    public function hotel(){
        return $this->belongsTo('App\Hotel');
    }

    public function high_weekdays()
    {
        return $this->hasOne('App\HighWeekday');
    }
    public function time_zone()
    {
        return $this->belongsTo('App\TimeZone');
    }

}
