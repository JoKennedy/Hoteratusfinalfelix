<?php

namespace App\Http\Controllers;

use App\Currency;
use App\DefaultSetting;
use App\HousekeepingStatus;
use App\Language;
use App\Month;
use App\TimeZone;
use Illuminate\Http\Request;

class DefaultSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   $hotel_id = $request->session()->get('hotel_id');
        $defaultSetting = DefaultSetting::with('high_weekdays')->where('hotel_id', $hotel_id)->first();
        if(!$defaultSetting){
            DefaultSetting::create(['hotel_id' => $hotel_id]);
            $defaultSetting = DefaultSetting::with('high_weekdays')->where('hotel_id', $hotel_id)->first();
        }


        if ($defaultSetting->high_weekdays == null || !$defaultSetting->high_weekdays->count()){
            $defaultSetting->high_weekdays()->create();
            $defaultSetting = DefaultSetting::with('high_weekdays')->where('hotel_id', $hotel_id)->first();
        }

        $languages  =    Language::where('active',1)->get();
        $currencies =   Currency::where('active', 1)->get();
        $timeZones = TimeZone::where('active', 1)->get();
        $houseKeepingStatus = HousekeepingStatus::all();
        $months= Month::all();
        return view('pages.defaultsettings.index', compact('defaultSetting', 'languages', 'currencies', 'months',
                                                            'timeZones', 'houseKeepingStatus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DefaultSetting  $defaultSetting
     * @return \Illuminate\Http\Response
     */
    public function show(DefaultSetting $defaultSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DefaultSetting  $defaultSetting
     * @return \Illuminate\Http\Response
     */
    public function edit(DefaultSetting $defaultSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DefaultSetting  $defaultSetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DefaultSetting $defaultSetting)
    {

        $defaultSetting->update([
            "language_id" => $request->language_id,
            "currency_id" => $request->currency_id,
            "start_day_financial" => $request->start_day_financial,
            "end_day_financial" => $request->end_day_financial,
            "start_month_financial" => $request->start_month_financial,
            "end_month_financial" =>$request->end_month_financial,
            "auto_convertion_rate" => $request->auto_convertion_rate,
            "currency_convertion_margin" => $request->currency_convertion_margin,
            "currency_decimal_place" => $request->currency_decimal_place,
            "exclusive_tax" => $request->exclusive_tax??0,
            "show_header_tax" => $request->show_header_tax??0,
            "breakup_tax_invoice_folio" =>$request->breakup_tax_invoice_folio??0,
            "display_tax_invoice" => $request->display_tax_invoice??0,
            "group_tax_pos" => $request->group_tax_pos??0,
            "breakup_tax_account_statement" => $request->breakup_tax_account_statement??0,
            "display_tax_statement" => $request->display_tax_statement??0,
            "adjustment_invoice_folio" => $request->adjustment_invoice_folio??0,
            "account_folio_date" => $request->account_folio_date[0],
            "show_deposit_alert_checkin" => $request->show_deposit_alert_checkin??0,
            "date_format" => $request->date_format,
            "time_zone_id" => $request->time_zone_id,
            "time_format" => $request->time_format,
            "checkin_time" =>$request->checkin_time,
            "checkout_time" => $request->checkout_time,
            "age_maximum_child" => $request->age_maximum_child,
            "minimum_child_age" => $request->minimum_child_age,
            "age_maximum_infant" =>$request->age_maximum_infant,
            "travel_agent_commission" => $request->travel_agent_commission,
            "corporate_discount" => $request->corporate_discount,
            "time_night_audit" => $request->time_night_audit,
            "run_audit" => $request->run_audit,
            "audit_mark_checkin_noshow" =>$request->audit_mark_checkin_noshow,
            "audit_housekeeping_occupied" => $request->audit_housekeeping_occupied,
            "audit_housekeeping_vacant" => $request->audit_housekeeping_vacant,
            "audit_housekeeping_checkout" => $request->audit_housekeeping_checkout,
            "audit_housekeeping_change_room" => $request->audit_housekeeping_change_room,
            "minimum_cancellation_fee" => $request->minimum_cancellation_fee,
            "early_checkin_hour" => $request->early_checkin_hour,
            "early_checkin_charge" => $request->early_checkin_charge,
            "early_checkin_charge_type" => $request->early_checkin_charge_type[0],
            "early_checkout_hour" => $request->early_checkout_hour,
            "early_checkout_hour_type" => $request->early_checkout_hour_type[0],
            "early_checkout_charge" => $request->early_checkout_charge,
            "early_checkout_charge_type" => $request->early_checkout_charge_type[0],
            "late_checkout_hour" => $request->late_checkout_hour,
            "late_checkout_charge" => $request->late_checkout_charge,
            "late_checkout_charge_type" => $request->late_checkout_charge_type[0],
            "charge_noshow_time" => $request->charge_noshow_time,
            "charge_noshow_consider" => $request->charge_noshow_consider[0],
        ]);
        $defaultSetting->high_weekdays->update([
            'monday' => $request->high_weekday['monday']??0,
            'tuesday' => $request->high_weekday['tuesday']??0,
            'wednesday' => $request->high_weekday['wednesday']??0,
            'thursday' => $request->high_weekday['thursday']??0,
            'friday' => $request->high_weekday['friday']??0,
            'saturday' => $request->high_weekday['saturday']??0,
            'sunday' => $request->high_weekday['sunday']??0
        ]);

        return redirect('default-settings')->with('message_success', 'Default Settings have been updated!!!');



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DefaultSetting  $defaultSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(DefaultSetting $defaultSetting)
    {
        //
    }
}
