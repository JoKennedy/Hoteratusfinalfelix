@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Defaults Settings')
{{-- vendor style --}}
@section('vendor-style')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2-materialize.css')}}">
@endsection
@section('page-style')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/form-select2.css')}}">
@endsection
{{-- page content --}}
@section('content')
<div class="section">
  <div class="row" >
    <div class="col s12">

      <div id="validations" class="card card-tabs">

        <div class="card-content">
            <div class="card-title">
                <div class="row center">
                    <div class="col s12">
                        <h5 class="center-align" style="font-weight: 900;">Defaults Settings</h5>
                    </div>
                </div>
                 <div class="row">
                        <ul class="tabs">
                            <li class="tab col  p-5"><a class="active p-0" href="#globalsetting">Global</a></li>
                            <li class="tab col  p-5"><a class="p-0" href="#night-audit">Night Audit</a></li>
                            <li class="tab col  p-5"><a class="p-0" href="#house-keeping">House Keeping</a></li>
                            <li class="tab col  p-5"><a class="p-0" href="#policy">Cancellation / Booking / Web Policy</a></li>
                            <li class="tab col  p-5"><a class="p-0" href="#checkin-out">Check In / Check Out / No Show</a></li>
                        </ul>

                </div>
            </div>

            <form enctype="multipart/form-data" class="formValidate" action="{{ route('default-settings.update', $defaultSetting) }}"style="margin-bottom: 20px;" id="formSubmit" method="POST">
                @csrf
                @method('PUT')
                <div class="row s12 right">
                    <button type="submit" class="mb-6 btn waves-effect waves-light gradient-45deg-green-teal" >Update </button>

                </div>
                <div class="row"></div>
                <div id="globalsetting" >
                    <div class="row">
                        <div class="col s6">
                            <div class="input-field">
                                <select    name="language_id" value="{{old('language_id',$defaultSetting['language_id']??'')}}" required >
                                    @foreach ($languages as $language)
                                        <option value="{{$language->id}}" {{$language->id == old('language_id',$defaultSetting['language_id']??'')? 'selected' : '' }}>{{$language->name}}</option>
                                    @endforeach
                                </select>
                                 <label for="language_id"><strong>Language</strong></label>
                                @error('language_id')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                            </div>
                        </div>
                        <div class="col s6">
                            <div class="input-field">
                                <select class="p-0" name="currency_id" value="{{old('currency_id',$defaultSetting['currency_id']??'')}}" required >
                                    @foreach ($currencies as $currency)
                                        <option value="{{$currency->id}}" {{$currency->id == old('currency_id',$defaultSetting['currency_id']??'')? 'selected' : '' }}>{{$currency->name}}</option>
                                    @endforeach
                                </select>
                                 <label for="currency_id"><strong>Currency</strong></label>
                                @error('currency_id')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <h6 class="text-center">Financial Year</h6>
                        </div>

                        <div class="col s2">
                            <div class="input-field">
                                <select    name="start_day_financial" value="{{old('start_day_financial',$defaultSetting['start_day_financial']??'')}}" required >
                                    @for ($i = 1; $i <= 31 ; $i++)
                                        <option value="{{$i}}" {{$i == old('start_day_financial',$defaultSetting['start_day_financial']??'')? 'selected' : '' }}>{{$i}}</option>
                                    @endfor
                                </select>
                                @error('start_day_financial')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                            </div>
                        </div>
                        <div class="col s3">
                            <div class="input-field">
                                <select class="p-0" name="start_month_financial" value="{{old('start_month_financial',$defaultSetting['start_month_financial']??'')}}" required >
                                    @foreach ($months as $month)
                                        <option value="{{$month->id}}" {{$month->id == old('start_month_financial',$defaultSetting['start_month_financial']??'')? 'selected' : '' }}>{{$month->name}}</option>
                                    @endforeach
                                </select>
                                @error('start_month_financial')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                            </div>
                        </div>
                        <div class="col s2 text-center"><br><span class="text-center">To</span></div>
                        <div class="col s2">
                            <div class="input-field">
                                <select    name="end_day_financial" value="{{old('end_day_financial',$defaultSetting['end_day_financial']??'')}}" required >
                                    @for ($i = 1; $i <= 31 ; $i++)
                                        <option value="{{$i}}" {{$i == old('end_day_financial',$defaultSetting['end_day_financial']??'')? 'selected' : '' }}>{{$i}}</option>
                                    @endfor

                                </select>
                                @error('end_day_financial')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                            </div>
                        </div>

                        <div class="col s3">
                            <div class="input-field">
                                <select class="p-0" name="end_month_financial" value="{{old('end_month_financial',$defaultSetting['end_month_financial']??'')}}" required >
                                    @foreach ($months as $month)
                                        <option value="{{$month->id}}" {{$month->id == old('end_month_financial',$defaultSetting['end_month_financial']??'')? 'selected' : '' }}>{{$month->name}}</option>
                                    @endforeach
                                </select>
                                @error('end_month_financial')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s4">
                            <div class="input-field">
                                <select    name="auto_convertion_rate" value="{{old('auto_convertion_rate',$defaultSetting['auto_convertion_rate']??'')}}" required >
                                    <option value="0" {{0 == old('auto_convertion_rate',$defaultSetting['auto_convertion_rate']??'')? 'selected' : '' }}>Automatic</option>
                                    <option value="1" {{1 == old('auto_convertion_rate',$defaultSetting['auto_convertion_rate']??'')? 'selected' : '' }}>Manual</option>
                                </select>
                                 <label for="auto_convertion_rate"><strong>Currency Conversion Rate</strong></label>
                                @error('auto_convertion_rate')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                            </div>
                        </div>
                        <div class="input-field col s4">
                            <label for="prueba">Currency Conversion Margin</label>
                            <input name="currency_convertion_margin" type="number" value="{{old('currency_convertion_margin', number_format($defaultSetting['currency_convertion_margin'],$defaultSetting['currency_decimal_place'],'.','') )}}" >
                            @error('currency_convertion_margin')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                        <div class="col s4">
                            <div class="input-field">
                                <select class="p-0" name="currency_decimal_place" value="{{old('currency_decimal_place',$defaultSetting['currency_decimal_place']??'')}}" required >
                                    @for ($i = 0; $i <= 3; $i++)
                                        <option value="{{$i}}" {{$i == old('currency_decimal_place',$defaultSetting['currency_decimal_place']??'')? 'selected' : '' }}>{{$i}}</option>
                                    @endfor
                                </select>
                                 <label for="currency_decimal_place"><strong>Currency Decimal Places</strong></label>
                                @error('currency_decimal_place')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s6">
                            <label>
                                <span>Account statement/invoices Exclusive of Tax(es)?&nbsp;</span>
                            <input value="1" {{old('exclusive_tax',$defaultSetting->exclusive_tax) == 1? 'checked' : '' }}  type="checkbox" id="exclusive_tax" name="exclusive_tax" />
                                <span>Yes</span>
                            </label>
                        </div>
                        <div class="col" style="display: {{old('exclusive_tax',$defaultSetting->exclusive_tax) == 1? 'none' : '' }};">
                            <label>
                            <input value="1" {{old('show_header_tax',$defaultSetting->show_header_tax) == 1? 'checked' : '' }}  type="checkbox" id="show_header_tax" name="show_header_tax" />
                                <span>Show Header This will show the text that includes Tax(es).</span>
                            </label>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col s6">
                            <label>
                                <span>Tax/Fee Break up in Invoice/Folios &nbsp;</span>
                            <input value="1" {{old('breakup_tax_invoice_folio',$defaultSetting->breakup_tax_invoice_folio) == 1? 'checked' : '' }}  type="checkbox"  name="breakup_tax_invoice_folio" />
                                <span>Yes</span>
                            </label>
                        </div>
                        <div class="col 3" style="display: {{old('breakup_tax_invoice_folio',$defaultSetting->breakup_tax_invoice_folio) == 0? 'none' : '' }};">
                            <label>
                            <input value="1" {{old('display_tax_invoice',$defaultSetting->display_tax_invoice) == 1? 'checked' : '' }}  type="checkbox" id="display_tax_invoice" name="display_tax_invoice" />
                                <span>Display Tax percentage</span>
                            </label>
                        </div>
                        <div class="col 3" style="display: {{old('breakup_tax_invoice_folio',$defaultSetting->breakup_tax_invoice_folio) == 0? 'none' : '' }};">
                            <label>
                            <input value="1" {{old('group_tax_pos',$defaultSetting->group_tax_pos) == 1? 'checked' : '' }}  type="checkbox" id="group_tax_pos" name="group_tax_pos" />
                                <span>Group Tax in POS Receipts</span>
                            </label>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col s6">
                            <label>
                                <span>Tax/Fee Break up in Account Statement&nbsp;</span>
                            <input value="1" {{old('breakup_tax_account_statement',$defaultSetting->breakup_tax_account_statement) == 1? 'checked' : '' }}  type="checkbox" id="breakup_tax_account_statement" name="breakup_tax_account_statement" />
                                <span>Yes</span>
                            </label>
                        </div>
                        <div class="col" style="display: {{old('breakup_tax_account_statement',$defaultSetting->breakup_tax_account_statement) == 0? 'none' : '' }};">
                            <label>
                            <input value="1" {{old('display_tax_statement',$defaultSetting->display_tax_statement) == 1? 'checked' : '' }}  type="checkbox" id="display_tax_statement" name="display_tax_statement" />
                                <span>Display Tax percentage</span>
                            </label>
                        </div>

                    </div>
                    <br>
                    <div class="row">
                        <div class="col s12">
                            <label>
                                <span>Adjustment in Invoice/Folios&nbsp;</span>
                                 <input value="1" {{old('adjustment_invoice_folio',$defaultSetting->adjustment_invoice_folio) == 1? 'checked' : '' }}  type="checkbox" id="adjustment_invoice_folio" name="adjustment_invoice_folio" />
                                <span>Yes</span>
                            </label>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col s12">
                            <label>
                                <span>Account Folio Date&nbsp;&nbsp;</span>
                                 <input value="0" {{old('account_folio_date',$defaultSetting->account_folio_date) == 0? 'checked' : '' }}  type="radio"  name="account_folio_date[]" />
                                <span>Closing Date&nbsp;</span>
                            </label>
                            <label>
                                  <input value="1" {{old('account_folio_date',$defaultSetting->account_folio_date) == 1? 'checked' : '' }}  type="radio"  name="account_folio_date[]" />
                                <span>Opening Date</span>
                            </label>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col s12">
                            <label>
                                <span>Show Deposit Alert on Check-in	&nbsp;</span>
                                 <input value="1" {{old('show_deposit_alert_checkin',$defaultSetting->show_deposit_alert_checkin) == 1? 'checked' : '' }}  type="checkbox"  name="show_deposit_alert_checkin" />
                                <span>Yes</span>
                            </label>
                        </div>
                    </div>
                    <br>
                    <h6 class="text-center" >You book Room Type(s) and not specific Room(s) / Room Number(s)</h6>
                    <div class="row">
                        <div class="col s12"><span style="font-size: .85em;">High Weekdays (Room reservation) Nights</span></div>
                        <div class="col s12">
                             <label>
                                 <input value="1" {{$defaultSetting->high_weekdays->monday == 1? 'checked' : '' }}  type="checkbox"  name="high_weekday[monday]" />
                                <span>Mon &nbsp;</span>
                            </label>

                            <label>
                                 <input value="1" {{$defaultSetting->high_weekdays->tuesday == 1? 'checked' : '' }}  type="checkbox"  name="high_weekday[tuesday]" />
                                <span>Tue &nbsp;</span>
                            </label>
                            <label>
                                 <input value="1" {{$defaultSetting->high_weekdays->wednesday == 1? 'checked' : '' }}  type="checkbox"  name="high_weekday[wednesday]" />
                                <span>Wed &nbsp;</span>
                            </label><label>
                                 <input value="1" {{$defaultSetting->high_weekdays->thursday == 1? 'checked' : '' }}  type="checkbox"  name="high_weekday[thursday]" />
                                <span>Thu &nbsp;</span>
                            </label><label>
                                 <input value="1" {{$defaultSetting->high_weekdays->friday == 1? 'checked' : '' }}  type="checkbox"  name="high_weekday[friday]" />
                                <span>Fri &nbsp;</span>
                            </label><label>
                                 <input value="1" {{$defaultSetting->high_weekdays->saturday == 1? 'checked' : '' }}  type="checkbox"  name="high_weekday[saturday]" />
                                <span>Sat &nbsp;</span>
                            </label><label>
                                 <input value="1" {{$defaultSetting->high_weekdays->sunday == 1? 'checked' : '' }}  type="checkbox"  name="high_weekday[sunday]" />
                                <span>Sun</span>
                            </label>
                        </div>
                        <div class="col s12"><span class="center-align" style="font-size: .7em">The high weekdays charge will apply on these day(s) automatically</span></div>
                    </div>
                    <div class="row">
                        <div class="col s6">
                            <div class="input-field">
                                <select    name="date_format" value="{{old('date_format',$defaultSetting['date_format']??'')}}" required >
                                    <option value="dd/MM/yyyy" {{ 'dd/MM/yyyy' == old('date_format',$defaultSetting['date_format']??'')? 'selected' : '' }}>dd/MM/yyyy</option>
                                    <option value="dd/MM/yy" {{ 'dd/MM/yy'== old('date_format',$defaultSetting['date_format']??'')? 'selected' : '' }}>dd/MM/yy</option>
                                </select>
                                  <label for="date_format"><strong>Date Format</strong></label>
                            </div>
                        </div>
                        <div class="col s6">

                            <div class="input-field">
                                <select class="p-0" name="time_zone_id" value="{{old('time_zone_id',$defaultSetting['time_zone_id']??'')}}" required >
                                    @foreach ($timeZones as $timeZone)
                                        <option value="{{$timeZone->id}}" {{$timeZone->id == old('time_zone_id',$defaultSetting['time_zone_id']??'')? 'selected' : '' }}>{{$timeZone->text}}</option>
                                    @endforeach
                                </select>
                                <label for="time_zone_id"><strong>Time Zone Location</strong></label>
                                @error('time_zone_id')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s4">
                            <div class="input-field">
                                <select    name="time_format" value="{{old('time_format',$defaultSetting['time_format']??'')}}" required >
                                    <option value="1" {{ 1 == old('time_format',$defaultSetting['time_format']??'')? 'selected' : '' }}>12 Hours</option>
                                    <option value="2" {{ 2== old('time_format',$defaultSetting['time_format']??'')? 'selected' : '' }}>24 Hours</option>
                                </select>
                                  <label for="time_format"><strong>Time Format</strong></label>
                            </div>
                        </div>
                        <div class="col s4">
                            <div class="input-field">
                                <label for="checkin_time"><strong>Check-in Time</strong></label>
                                <input type="time" name="checkin_time" value="{{$defaultSetting->checkin_time}}">
                            </div>
                        </div>
                         <div class="col s4">
                            <div class="input-field">
                                <label for="checkout_time"><strong>Check-Out Time</strong></label>
                                <input type="time" name="checkout_time" value="{{$defaultSetting->checkout_time}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s5">
                            <div class="input-field">
                                <select    name="age_maximum_child" value="{{old('age_maximum_child',$defaultSetting['age_maximum_child']??'')}}" required >
                                    @for ($i = 0; $i <= 21; $i++)
                                <option value="{{$i}}" {{ $i == old('age_maximum_child',$defaultSetting['age_maximum_child']??'')? 'selected' : '' }}>{{$i}}</option>
                                    @endfor
                                </select>
                                <label for="age_maximum_child"><strong>Guest less than 12 years of age will be considered Child</strong></label>
                            </div>
                        </div>
                         <div class="col s2">
                            <div class="input-field">
                                <select    name="minimum_child_age" value="{{old('minimum_child_age',$defaultSetting['minimum_child_age']??'')}}" required >
                                    @for ($i = 0; $i <= 21; $i++)
                                        <option value="{{$i}}" {{ $i == old('minimum_child_age',$defaultSetting['minimum_child_age']??'')? 'selected' : '' }}>{{$i}}</option>
                                    @endfor
                                </select>
                                <label for="minimum_child_age"><strong>Minimum Child Age</strong></label>
                            </div>
                        </div>
                        <div class="col s5">
                            <div class="input-field">
                                <select    name="age_maximum_infant" value="{{old('age_maximum_infant',$defaultSetting['age_maximum_infant']??'')}}" required >
                                    @for ($i = 0; $i <= 21; $i++)
                                        <option value="{{$i}}" {{ $i == old('age_maximum_infant',$defaultSetting['age_maximum_infant']??'')? 'selected' : '' }}>{{$i}}</option>
                                    @endfor
                                </select>
                                <label for="age_maximum_infant"><strong>Minimum age to consider a guest as Infant </strong></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s6">
                            <label for="travel_agent_commission"><strong>Global Travel Agent Commission</strong></label>
                            <input  name="travel_agent_commission" onkeypress="return isNumberKey(event)" type="text" value="{{old('travel_agent_commission', number_format($defaultSetting['travel_agent_commission'],$defaultSetting['currency_decimal_place'],'.',',') )}}" required>
                        </div>
                        <div class="col s6">
                            <label for="corporate_discount"><strong>Global Corporate Discount</strong></label>
                            <input  name="corporate_discount" onkeypress="return isNumberKey(event)" type="text" value="{{old('corporate_discount', number_format($defaultSetting['corporate_discount'],$defaultSetting['currency_decimal_place'],'.',',') )}}" required>
                        </div>
                    </div>
                </div>
                <div id="night-audit" style="display: none;">
                    <div class="row">
                        <div class="col s4">
                            <br>
                            <span>The Night Audit or roll over will not happen before</span>
                        </div>
                        <div class="col s4">
                            <div class="input-field">
                                <label for="time_night_audit"><strong>Hour</strong></label>
                                <input type="time" name="time_night_audit" value="{{$defaultSetting->time_night_audit}}">
                            </div>
                        </div>
                        <div class="col s4">
                            <div class="input-field">
                                <select name="run_audit" value="{{$defaultSetting->run_audit}}" >
                                    <option value="1" {{ 1 == old('run_audit',$defaultSetting->run_audit) ? 'selected' : ''}}>Same Calendar Date</option>
                                    <option value="2" {{ 2 == old('run_audit',$defaultSetting->run_audit) ? 'selected' : ''}}>Next Calendar Date</option>
                                </select>
                                <label for="run_audit"><strong>Allow run</strong></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <br>
                            <br>
                            <span>On Auto Night Audit mark all room(s) pending check-in to Room(s) pending check-out will Check-Out automatically</span>
                        </div>
                        <div class="col s2">
                            <div class="input-field">
                                <select name="audit_mark_checkin_noshow" value="{{$defaultSetting->audit_mark_checkin_noshow}}" >
                                    <option value="1" {{ 1 == old('audit_mark_checkin_noshow',$defaultSetting->audit_mark_checkin_noshow) ? 'selected' : ''}}>Check In</option>
                                    <option value="2" {{ 2 == old('audit_mark_checkin_noshow',$defaultSetting->audit_mark_checkin_noshow) ? 'selected' : ''}}>No Show</option>
                                </select>
                                <label for="audit_mark_checkin_noshow"><strong>Status</strong></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="house-keeping" style="display: none;">
                    <div class="row">
                        <div class="col">
                            <br>
                            <span>On Night Audit or roll over mark all occupied room(s) to</span>
                        </div>
                        <div class="col s2">
                            <div class="input-field">
                                <select name="audit_housekeeping_occupied" value="{{$defaultSetting->audit_housekeeping_occupied}}" >
                                    @foreach ($houseKeepingStatus as $item)
                                        <option value="{{$item->id}}" {{$item->id == $defaultSetting->audit_housekeeping_occupied?'selected' : '' }}>{{$item->name}}</option>
                                    @endforeach
                                </select>
                                <label for="audit_housekeeping_occupied"><strong>Status</strong></label>
                            </div>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col">
                            <br>
                            <span>On Night Audit or roll over mark all Vacant room(s) to </span>
                        </div>
                        <div class="col s2">
                            <div class="input-field">
                                <select name="audit_housekeeping_vacant" value="{{$defaultSetting->audit_housekeeping_vacant}}" >
                                    @foreach ($houseKeepingStatus as $item)
                                        <option value="{{$item->id}}" {{$item->id == $defaultSetting->audit_housekeeping_vacant?'selected' : '' }}>{{$item->name}}</option>
                                    @endforeach
                                </select>
                                <label for="audit_housekeeping_vacant"><strong>Status</strong></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <br>
                            <span>Mark the checked-out room(s) to  </span>
                        </div>
                        <div class="col s2">
                            <div class="input-field">
                                <select name="audit_housekeeping_checkout" value="{{$defaultSetting->audit_housekeeping_checkout}}" >
                                    @foreach ($houseKeepingStatus as $item)
                                        <option value="{{$item->id}}" {{$item->id == $defaultSetting->audit_housekeeping_checkout?'selected' : '' }}>{{$item->name}}</option>
                                    @endforeach
                                </select>
                                <label for="audit_housekeeping_checkout"><strong>Status</strong></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <br>
                            <span>Mark the Change room(s) to</span>
                        </div>
                        <div class="col s2">
                            <div class="input-field">
                                <select name="audit_housekeeping_change_room" value="{{$defaultSetting->audit_housekeeping_change_room}}" >
                                    @foreach ($houseKeepingStatus as $item)
                                        <option value="{{$item->id}}" {{$item->id == $defaultSetting->audit_housekeeping_change_room?'selected' : '' }}>{{$item->name}}</option>
                                    @endforeach
                                </select>
                                <label for="audit_housekeeping_change_room"><strong>Status</strong></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="policy" style="display: none;">
                     <div class="row">
                        <div class="col">
                            <br>
                            <span>Minimum Cancellation Fee </span>
                        </div>
                         <div class="col s1">
                            <div class="input-field">
                                <input  name="minimum_cancellation_fee" onkeypress="return isNumberKey(event)" type="text" value="{{old('minimum_cancellation_fee', number_format($defaultSetting['minimum_cancellation_fee'],$defaultSetting['currency_decimal_place'],'.',',') )}}" required>
                            </div>
                        </div>
                    </div>

                </div>
                <div id="checkin-out" style="display: none;">
                    <div class="row">
                        <div class="col">
                            <br>
                            <span>For early check In</span>
                        </div>
                         <div class="col s2">
                            <div class="input-field">
                               <select name="early_checkin_hour" value={{ $defaultSetting->early_checkin_hour}}>
                                   @for ($i = 0; $i <=23; $i++)
                                        <option value="{{$i}}" {{$i == $defaultSetting->early_checkin_hour? 'selected':''}}> {{$i}} </option>
                                   @endfor
                               </select>
                            </div>
                        </div>
                        <div class="col">
                            <br>
                            <span>Hour(s) before the actual time of check In, charge</span>
                        </div>
                       <div class="col s1">
                            <div class="input-field">
                                <input  name="early_checkin_charge" onkeypress="return isNumberKey(event)" type="text" value="{{old('early_checkin_charge', number_format($defaultSetting['early_checkin_charge'],$defaultSetting['currency_decimal_place'],'.',',') )}}" required>
                            </div>
                        </div>
                        <div class="col s2">
                            <label>
                                <input value="1" {{old('early_checkin_charge_type',$defaultSetting->early_checkin_charge_type) == 1? 'checked' : '' }}  type="radio"  name="early_checkin_charge_type[]" />
                                <span style="font-size: .9em;">% of booking</span>
                            </label>
                            <br>
                            <label>
                                <input value="2" {{old('early_checkin_charge_type',$defaultSetting->early_checkin_charge_type) == 2? 'checked' : '' }}  type="radio"  name="early_checkin_charge_type[]" />
                                <span style="font-size: .9em;">$</span>
                            </label>
                             <br>
                            <label>
                                <input value="3" {{old('early_checkin_charge_type',$defaultSetting->early_checkin_charge_type) == 3? 'checked' : '' }}  type="radio"  name="early_checkin_charge_type[]" />
                                <span style="font-size: .9em;">Room Night(s)</span>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <br>
                            <span>For early check Out	</span>
                        </div>
                         <div class="col s1">
                            <div class="input-field">
                               <select name="early_checkout_hour" value={{ $defaultSetting->early_checkout_hour}}>
                                   @for ($i = 0; $i <=23; $i++)
                                        <option value="{{$i}}" {{$i == $defaultSetting->early_checkout_hour? 'selected':''}}> {{$i}} </option>
                                   @endfor
                               </select>
                            </div>
                        </div>
                        <div class="col">
                            <label>
                                <input value="1" {{old('early_checkout_hour_type',$defaultSetting->early_checkout_hour_type) == 1? 'checked' : '' }}  type="radio"  name="early_checkout_hour_type[]" />
                                <span style="font-size: .9em;">Day(s)</span>
                            </label>
                            <br>
                            <label>
                                <input value="2" {{old('early_checkout_hour_type',$defaultSetting->early_checkout_hour_type) == 2? 'checked' : '' }}  type="radio"  name="early_checkout_hour_type[]" />
                                <span style="font-size: .9em;">Hour(s)</span>
                            </label>
                        </div>
                        <div class="col">
                            <br>
                            <span>before the actual time of check Out, charge</span>
                        </div>
                       <div class="col s1">
                            <div class="input-field">
                                <input  name="early_checkout_charge" onkeypress="return isNumberKey(event)" type="text" value="{{old('early_checkout_charge', number_format($defaultSetting['early_checkout_charge'],$defaultSetting['currency_decimal_place'],'.',',') )}}" required>
                            </div>
                        </div>
                        <div class="col s2">
                            <label>
                                <input value="1" {{old('early_checkout_charge_type',$defaultSetting->early_checkout_charge_type) == 1? 'checked' : '' }}  type="radio"  name="early_checkout_charge_type[]" />
                                <span style="font-size: .9em;">% of booking</span>
                            </label>
                            <br>
                            <label>
                                <input value="2" {{old('early_checkout_charge_type',$defaultSetting->early_checkout_charge_type) == 2? 'checked' : '' }}  type="radio"  name="early_checkout_charge_type[]" />
                                <span style="font-size: .9em;">$</span>
                            </label>
                             <br>
                            <label>
                                <input value="3" {{old('early_checkout_charge_type',$defaultSetting->early_checkout_charge_type) == 3? 'checked' : '' }}  type="radio"  name="early_checkout_charge_type[]" />
                                <span style="font-size: .9em;">Room Night(s)</span>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <br>
                            <span>For Late check Out</span>
                        </div>
                         <div class="col s2">
                            <div class="input-field">
                               <select name="late_checkout_hour" value={{ $defaultSetting->late_checkout_hour}}>
                                   @for ($i = 0; $i <=23; $i++)
                                        <option value="{{$i}}" {{$i == $defaultSetting->late_checkout_hour? 'selected':''}}> {{$i}} </option>
                                   @endfor
                               </select>
                            </div>
                        </div>
                        <div class="col">
                            <br>
                            <span>Hour(s) after the actual time of check Out, charge</span>
                        </div>
                       <div class="col s1">
                            <div class="input-field">
                                <input  name="late_checkout_charge" onkeypress="return isNumberKey(event)" type="text" value="{{old('late_checkout_charge', number_format($defaultSetting['late_checkout_charge'],$defaultSetting['currency_decimal_place'],'.',',') )}}" required>
                            </div>
                        </div>
                        <div class="col s2">
                            <label>late_checkin_charge
                                <input value="1" {{old('late_checkout_charge_type',$defaultSetting->late_checkout_charge_type) == 1? 'checked' : '' }}  type="radio"  name="late_checkout_charge_type[]" />
                                <span style="font-size: .9em;">% of booking</span>
                            </label>
                            <br>
                            <label>
                                <input value="2" {{old('late_checkout_charge_type',$defaultSetting->late_checkout_charge_type) == 2? 'checked' : '' }}  type="radio"  name="late_checkout_charge_type[]" />
                                <span style="font-size: .9em;">$</span>
                            </label>
                             <br>
                            <label>
                                <input value="3" {{old('late_checkout_charge_type',$defaultSetting->late_checkout_charge_type) == 3? 'checked' : '' }}  type="radio"  name="late_checkout_charge_type[]" />
                                <span style="font-size: .9em;">Room Night(s)</span>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <br>
                            <span>Charge No Show</span>
                        </div>
                         <div class="col s2">
                            <div class="input-field">
                               <select name="charge_noshow_time" value={{ $defaultSetting->charge_noshow_time}}>
                                   @for ($i = 0; $i <=23; $i++)
                                        <option value="{{$i}}" {{$i == $defaultSetting->charge_noshow_time? 'selected':''}}> {{$i}} </option>
                                   @endfor
                               </select>
                            </div>
                        </div>
                        <div class="col">
                            <br>
                            <span>Hour(s) after</span>
                        </div>
                        <div class="col">
                            <br>
                            <label>
                                <input value="1" {{old('charge_noshow_consider',$defaultSetting->charge_noshow_consider) == 1? 'checked' : '' }}  type="radio"  name="charge_noshow_consider[]" />
                                <span style="font-size: .9em;">Expected Arrival time</span>
                            </label>
                            <br>
                            <label>
                                <input value="2" {{old('charge_noshow_consider',$defaultSetting->charge_noshow_consider) == 2? 'checked' : '' }}  type="radio"  name="charge_noshow_consider[]" />
                                <span style="font-size: .9em;">Check in time</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row s12 right">
                   <button type="submit" class="mb-6 btn waves-effect waves-light gradient-45deg-green-teal" >Update </button>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

{{-- vendor script --}}
@section('vendor-script')
<script src="{{asset('vendors/jquery-validation/jquery.validate.min.js')}}"></script>

@endsection

{{-- page script --}}
@section('page-script')
<script src="{{asset('js/scripts/form-validation.js')}}"></script>
<script src="{{asset('js/scripts/ui-alerts.js')}}"></script>
@endsection
