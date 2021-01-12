@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title',"Edit Package Details(Frontdesk)")
{{-- vendor style --}}
@section('vendor-style')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/flag-icon/css/flag-icon.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-sidebar.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-contacts.css')}}">
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
                        <h5 class="center-align" style="font-weight: 900;">Package Details(Frontdesk)</h5>
                        <p>{{$frontDeskPackage->name}}</p>
                    </div>
                </div>
            </div>

            <form enctype="multipart/form-data" class="formValidate" action="{{ route('frontdesk-packages.update', $frontDeskPackage) }}" onsubmit="return verifyInclusion()" style="margin-bottom: 20px;" id="formSubmit" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                        <div class="col s12">
                            <ul class="tabs">
                            <li class="tab col"><a class="active"  href="#details">Package Properties</a></li>
                            <li class="tab col"><a href="#images">Images</a></li>
                            <li class="tab col"><a href="#policies">Policies</a></li>
                            <li class="tab col"><a href="#discount">Discounts</a></li>
                            <li class="tab col"><a href="#rate">Rates</a></li>
                            </ul>
                        </div>
                </div>
                <div id="details">
                    <div class="row">
                        <div class="input-field col s6">
                            <label for="name">Name the Package*</label>
                            <input name="name" type="text" value="{{old('name', $frontDeskPackage->name)}}" required>
                            @error('name')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                         <div class="input-field col s4">
                            <label for="code">Rate Code*</label>
                            <input name="code" type="text" value="{{old('code',$frontDeskPackage->code)}}" required>
                            @error('code')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                        <div class="input-field col s2">
                            <label for="stay_length">Min. length of Stay*</label>
                            <input onkeypress="return isNumberKey(event)" name="stay_length" type="text" value="{{old('stay_length',$frontDeskPackage->stay_length)}}" required>
                            @error('stay_length')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="description">Description*</label>
                            <textarea required class="materialize-textarea"  name="description" type="text" >{{old('description', $frontDeskPackage->description)}}</textarea>
                                @error('description')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <span>Day Use Package?&nbsp;</span>
                            <label>
                                <input value="1" {{old('day_package', $frontDeskPackage->day_package) == 1? 'checked' : '' }}  type="radio"  name="day_package" />
                                <span>Yes</span>
                            </label>
                            <label >
                                <input value="0" {{old('day_package', $frontDeskPackage->day_package) == 0? 'checked' : '' }}  type="radio"  name="day_package" />
                                <span>No</span>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <h6 class="text-center">Rates to post every day</h6>
                        <label>This Package rate is available only when the minimum length of stay is equal or more than this.</label>
                    </div>
                    <div class="row">
                        <div class="col s12"><label style="color: rgb(22, 20, 20) !important;">This Package is valid on weekdays</label></div>
                        <div class="col s3">
                            <select onchange="filterDays()" name="days_valid_id" id="days_valid_id" value="{{old('days_valid_id',$frontDeskPackage->days_valid_id)}}">
                                <option value="1" {{old('days_valid_id',$frontDeskPackage->days_valid_id) == 1 ? 'selected': ''}} >Custom</option>
                                <option value="2" {{old('days_valid_id',$frontDeskPackage->days_valid_id) == 2 ? 'selected': ''}}>All Weekdays</option>
                                <option value="3" {{old('days_valid_id',$frontDeskPackage->days_valid_id) == 3 ? 'selected': ''}}>Low Weekdays</option>
                                <option value="4" {{old('days_valid_id',$frontDeskPackage->days_valid_id) == 4 ? 'selected': ''}}>High Weekdays</option>
                            </select>
                        </div>
                        <div class="col s8">
                            <br>
                             <label>
                                 <input class="weekdays" value="1"  type="checkbox" name="days[monday]" id="monday"  />
                                <span>Mon &nbsp;</span>
                            </label>

                            <label>
                                 <input class="weekdays" value="1"  type="checkbox"  name="days[tuesday]" id="tuesday"  />
                                <span>Tue &nbsp;</span>
                            </label>
                            <label>
                                 <input class="weekdays" value="1"   type="checkbox"  name="days[wednesday]" id="wednesday"  />
                                <span>Wed &nbsp;</span>
                            </label><label>
                                 <input class="weekdays" value="1"  type="checkbox"  name="days[thursday]" id="thursday"  />
                                <span>Thu &nbsp;</span>
                            </label><label>
                                 <input class="weekdays" value="1"   type="checkbox" name="days[friday]" id="friday"  />
                                <span>Fri &nbsp;</span>
                            </label><label>
                                 <input class="weekdays" value="1"   type="checkbox"  name="days[saturday]" id="saturday"  />
                                <span>Sat &nbsp;</span>
                            </label><label>
                                 <input class="weekdays" value="1"  type="checkbox"  name="days[sunday]" id="sunday"  />
                                <span>Sun</span>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <span>Will The Package price change on increase in price of any of the component?&nbsp;</span>
                            <label>
                                    <input value="1" {{old('update_price', $frontDeskPackage->day_package) == 1? 'checked' : '' }}  type="radio"  name="update_price" />
                                <span>Yes</span>
                            </label>
                            <label >
                                 <input value="0" {{old('update_price', $frontDeskPackage->day_package) == 0? 'checked' : '' }}  type="radio"  name="update_price" />
                                <span>No</span>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s6">
                            <span>Is This Package  Prorated. ?&nbsp;</span>
                            <label>
                                    <input value="1" {{old('prorated', $frontDeskPackage->prorated) == 1? 'checked' : '' }}  type="radio"  name="prorated" />
                                <span>Yes</span>
                            </label>
                            <label >
                                 <input value="0" {{old('prorated', $frontDeskPackage->prorated) == 0? 'checked' : '' }}  type="radio"  name="prorated" />
                                <span>No</span>
                            </label>
                        </div>
                        <div class="col s6">
                            <span>Inclusive of Tax&nbsp;</span>
                            <label>
                                    <input value="1" {{old('inclusive_tax', $frontDeskPackage->inclusive_tax) == 1? 'checked' : '' }}  type="radio"  name="inclusive_tax" />
                                <span>Yes</span>
                            </label>
                            <label >
                                 <input value="0" {{old('inclusive_tax', $frontDeskPackage->inclusive_tax) == 0? 'checked' : '' }}  type="radio"  name="inclusive_tax" />
                                <span>No</span>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <h6 class="text-center">The Package Price will change on tax change. </h6>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <span>Is This Package commissionable for Travel Agent?</span>
                            <label>
                                    <input onclick="travel_agent()" value="1" {{old('travel_agency', $frontDeskPackage->travel_agency) == 1? 'checked' : '' }}  type="radio" id="travel_agency"  name="travel_agency" />
                                <span>Yes</span>
                            </label>
                            <label >
                                 <input  onclick="travel_agent()" value="0" {{old('travel_agency', $frontDeskPackage->travel_agency) == 0? 'checked' : '' }}  type="radio"  name="travel_agency" />
                                <span>No</span>
                            </label>
                        </div>
                    </div>
                    <div class="row agent" style="display:{{old('travel_agency', $frontDeskPackage->travel_agency) == 0? 'none' : '' }}; ">
                        <div class="col s12">
                            <span>Publish to TA Console?</span>
                            <label>
                                    <input value="1" {{old('publish_ta', $frontDeskPackage->publish_ta) == 1? 'checked' : '' }}  type="radio" id="publish_ta"  name="publish_ta" />
                                <span>Yes</span>
                            </label>
                            <label >
                                 <input  value="0" {{old('publish_ta', $frontDeskPackage->publish_ta) == 0? 'checked' : '' }}  type="radio"  name="publish_ta" />
                                <span>No</span>
                            </label>
                        </div>
                    </div>
                    <div class="row agent mb-5" style="display:{{old('travel_agency', $frontDeskPackage->travel_agency) == 0? 'none' : '' }}; ">
                        <br>
                        <div class="col s4">
                            <label for="name">Commission Details :</label><br>
                            <label >Global Commission {{number_format($hotel->default_setting->travel_agent_commission,2)}}%</label>
                        </div>
                        <div class="input-field col s2">
                            <input onkeypress="return isNumberKey(event)" name="travel_agent_commission" type="text" value="{{old('travel_agent_commission',$frontDeskPackage->travel_agent_commission)}}" >

                            @error('travel_agent_commission_type')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                        <div class="col s2">
                            <br>
                                <label>
                                    <input value="1" {{old('travel_agent_commission_type', $frontDeskPackage->travel_agent_commission_type) == 1? 'checked' : '' }}  type="radio" id="travel_agent_commission_type"  name="travel_agent_commission_type" />
                                    <span>%</span>
                                </label>
                                <br>
                                <label >
                                    <input  value="0" {{old('travel_agent_commission_type', $frontDeskPackage->travel_agent_commission_type) == 0? 'checked' : '' }}  type="radio"  name="travel_agent_commission_type" />
                                    <span>$</span>
                                </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <span>Is This Package discountable for Corporate?</span>
                            <label>
                                    <input onclick="corporate_change()" value="1" {{old('corporate', $frontDeskPackage->corporate) == 1? 'checked' : '' }}  type="radio" id="corporate"  name="corporate" />
                                <span>Yes</span>
                            </label>
                            <label >
                                 <input  onclick="corporate_change()" value="0" {{old('corporate', $frontDeskPackage->corporate) == 0? 'checked' : '' }}  type="radio"  name="corporate" />
                                <span>No</span>
                            </label>
                        </div>
                    </div>
                    <div class="row corporate" style="display:{{old('travel_agency', $frontDeskPackage->corporate) == 0? 'none' : '' }}; ">
                        <div class="col s12">
                            <span>Publish to Corporate Console?</span>
                            <label>
                                    <input value="1" {{old('publish_corporate', $frontDeskPackage->publish_corporate) == 1? 'checked' : '' }}  type="radio" id="publish_corporate"  name="publish_corporate" />
                                <span>Yes</span>
                            </label>
                            <label >
                                 <input  value="0" {{old('publish_corporate', $frontDeskPackage->publish_corporate) == 0? 'checked' : '' }}  type="radio"  name="publish_corporate" />
                                <span>No</span>
                            </label>
                        </div>
                    </div>
                    <div class="row corporate mb-5" style="display:{{old('travel_agency', $frontDeskPackage->corporate) == 0? 'none' : '' }}; ">
                        <br>
                        <div class="col s4">
                            <label for="name">Commission Details :</label><br>
                            <label > Global Discount  {{number_format($hotel->default_setting->corporate_discount,2)}}%</label>
                        </div>
                        <div class="input-field col s2">
                            <input onkeypress="return isNumberKey(event)" name="corporate_discount" type="text" value="{{old('corporate_discount',$frontDeskPackage->corporate_discount)}}" >

                            @error('corporate_discount')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                        <div class="col s2">
                            <br>
                                <label>
                                    <input value="1" checked  type="radio" id="corporate_commission_type"  name="corporate_commission_type" />
                                    <span>%</span>
                                </label>

                        </div>
                    </div>
                </div>
                <div id="images">
                    <div class="row">
                        <div class="file-field input-field">
                            <div class="btn">
                                <span>Upload Image(s)</span>
                            <input id="image" name="image[]" type="file" value="{{old('image')}}" multiple>
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text" placeholder="(Image dimensions 274pxX130px)">
                            </div>
                        </div>
                        <div id="preview"></div>
                    </div>
                    <div class="row">
                        @foreach ($frontDeskPackage->images as $image )
                        <div class="row" class="file-path-wrapper">
                        <div class="col s9 border-bottom-1"><span> {{$image->url}} </span> -><strong>{{$image->caption}}</strong></div>
                           <div class="invoice-action col s3" style="display: flex;">
                           <a href="javascript:void(0)"  onclick="showImage('{{ $image->get_image }}', '{{ $image->caption }}')" class="invoice-action-view mr-12"> <i class="material-icons">remove_red_eye</i> </a>
                                <a data-token="{{ csrf_token() }}" href="javascript:void(0)" onclick="deleteimage({{ $image->id}}, this )" class="invoice-action-edit" > <i class="material-icons">delete</i></a>
                           </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div id="policies">
                    <div  style="font-size: .8em;" class="mr-6">
                        <h6 style="background-color: #F8F9F9">Cancellation Policies</h6>
                        <table id="cancellationlist" class="table">
                            <thead >
                                <tr >
                                    <th class="first-row-check">
                                        <input id="cancellation_all" style="opacity: 1;  pointer-events: all;"  type="checkbox"  />
                                    </th>
                                    <th>Title</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hotel->cancellation_policies as $cancellation)
                                    <tr>
                                        <td class="first-row-check">
                                            <input value="{{$cancellation->id}}" name="cancellation[]" class="cancellation" style="opacity: 1;  pointer-events: all;"  type="checkbox"  />
                                        </td>
                                        <td>{{$cancellation->name}}</td>
                                        <td>{{$cancellation->get_description($hotel->default_setting)}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div  style="font-size: .8em;" class="mr-6">
                        <h6 style="background-color: #F8F9F9">Booking Policies</h6>
                        <table id="bookinglist" class="table tablecustom">
                            <thead >
                                <tr >
                                    <th class="first-row-check">
                                        <input id="booking_all" style="opacity: 1;  pointer-events: all;"  type="checkbox"  />
                                    </th>
                                    <th>Title</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hotel->booking_policies as $booking)
                                    <td  class="first-row-check">
                                        <input value="{{$booking->id}}" name="booking[]" class="booking" style="opacity: 1;  pointer-events: all;"  type="checkbox"  />
                                    </td>
                                    <td>{{$booking->name}}</td>
                                    <td>{{$booking->get_description($hotel->default_setting)}}</td>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="discount">
                    <div class="row" style="font-size: .8em;" class="mr-6">
                        <h6 style="background-color: #F8F9F9">Early Bird</h6>
                        <table id="earlybird" class="table">
                            <thead >
                                <tr >
                                    <th style="padding: 5px !important; width:40px;  border: 1px solid #D5DBDB  !important; vertical-align: top; text-align: center;">
                                        <input id="earlybird_all" style="opacity: 1;  pointer-events: all;"  type="checkbox"  />
                                    </th>
                                    <th style="padding: 5px !important; margin-left :15px;  border: 1px solid #D5DBDB  !important; text-align: left;">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hotel->discount_early_birds as $early_bird)
                                    <tr>
                                        <td  style="padding: 5px !important; margin-left :5px;  border: 1px solid #D5DBDB  !important; vertical-align: top; text-align: center;">
                                        <input value="{{$early_bird->id}}" name="early_bird[]" class="early_bird" style="opacity: 1;  pointer-events: all;"  type="checkbox"  />
                                        </td>
                                        <td style="padding: 5px !important; margin-left :5px;  border: 1px solid #D5DBDB  !important; text-align: left;">
                                            <div class="row" style="margin-left :15px; color: black; font-weight: 900;">{{$early_bird->name}}</div>
                                            @foreach ( $early_bird->discount_early_bird_details as $detail)
                                                 <div class='row'  style="margin-left :20px;">For days from {{$detail->start}} to {{$detail->end}}, discount applicable is {{number_format($detail->start_percentage,2)}}% to {{number_format($detail->end_percentage,2)}}%</div>
                                            @endforeach
                                            <div class="row" style="margin-left :15px;">
                                                <span><strong style="color:black; font-weight: 900;">Validity:</strong> For throughout the </span>
                                                &nbsp; &nbsp; &nbsp;
                                                <label>
                                                    <input checked onclick="verifydicount('early_birds_validity',{{$early_bird->id}})" id="early_birds_validity_{{$early_bird->id}}_1" value="1" type="radio" name="early_birds_validity[{{$early_bird->id}}]" />
                                                    <span style="font-size: 14px;">year</span>
                                                </label>
                                                <label>
                                                    <input onclick="verifydicount('early_birds_validity',{{$early_bird->id}})" id="early_birds_validity_{{$early_bird->id}}_2" value="2" type="radio" name="early_birds_validity[{{$early_bird->id}}]" />
                                                    <span>For specific dates</span>
                                                </label>
                                            </div>
                                            <div  class="row early_birds_validity_date_{{$early_bird->id}} date"  style="margin-left :15px; display: none;">
                                                <div class="row" >
                                                    <div class="input-field col s3">
                                                        <label for="start_date">Start Date*</label>
                                                        <input  class="form-date datepicker"  placeholder="31/01/2020" name="early_birds_start[{{$early_bird->id}}]" type="text" >
                                                    </div>
                                                    <div class="input-field col s3">
                                                        <label for="end_date">End Date*</label>
                                                        <input  class="form-date datepicker"  placeholder="31/01/2020" name="early_birds_end[{{$early_bird->id}}]" type="text"  >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row early_birds_validity_date_{{$early_bird->id}}" style="margin-left :15px; display: none;">
                                                <div class="input-field col s3"></div>
                                                <div class="input-field col s3 ">
                                                     <a onclick="addDateDiscount('early_birds',{{$early_bird->id}})" href="javascript:void(0)">Add More</a>
                                                </div>

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div  class="row"  style="font-size: .8em;" class="mr-6">
                        <h6 style="background-color: #F8F9F9">Last Minute</h6>
                        <table id="lastminutelist" class="table">
                            <thead >
                                <tr >
                                    <th style="padding: 5px !important; width:40px;  border: 1px solid #D5DBDB  !important; vertical-align: top; text-align: center;">
                                        <input id="lastminute_all" style="opacity: 1;  pointer-events: all;"  type="checkbox"  />
                                    </th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hotel->discount_last_minutes as $last_minute)
                                    <tr>
                                        <td  style="padding: 5px !important; margin-left :5px;  border: 1px solid #D5DBDB  !important; vertical-align: top; text-align: center;">
                                        <input value="{{$last_minute->id}}" name="last_minute[]" class="last_minute" style="opacity: 1;  pointer-events: all;"  type="checkbox"  />
                                        </td>
                                        <td style="padding: 5px !important; margin-left :5px;  border: 1px solid #D5DBDB  !important; text-align: left;">
                                            <div class="row" style="margin-left :15px; color: black; font-weight: 900;">{{$last_minute->name}}</div>
                                            @foreach ( $last_minute->discount_last_minute_details as $detail)
                                                 <div class='row'  style="margin-left :20px;">For days from {{$detail->start}} to {{$detail->end}}, discount applicable is {{number_format($detail->start_percentage,2)}}% to {{number_format($detail->end_percentage,2)}}%</div>
                                            @endforeach
                                            <div class="row" style="margin-left :15px;">
                                                <span><strong style="color:black; font-weight: 900;">Validity:</strong> For throughout the </span>
                                                &nbsp; &nbsp; &nbsp;
                                                <label>
                                                    <input checked onclick="verifydicount('last_minute_validity',{{$last_minute->id}})" id="last_minute_validity_{{$last_minute->id}}_1" value="1" type="radio" name="last_minute_validity[{{$last_minute->id}}]" />
                                                    <span style="font-size: 14px;">year</span>
                                                </label>
                                                <label>
                                                    <input onclick="verifydicount('last_minute_validity',{{$last_minute->id}})" id="last_minute_validity_{{$last_minute->id}}_2" value="2" type="radio" name="last_minute_validity[{{$last_minute->id}}]" />
                                                    <span>For specific dates</span>
                                                </label>
                                            </div>
                                            <div  class="row last_minute_validity_date_{{$last_minute->id}} date"  style="margin-left :15px; display: none;">
                                                <div class="row" >
                                                    <div class="input-field col s3">
                                                        <label for="start_date">Start Date*</label>
                                                        <input  class="form-date datepicker"  placeholder="31/01/2020" name="last_minute_start[{{$last_minute->id}}]" type="text"  >
                                                    </div>
                                                    <div class="input-field col s3">
                                                        <label for="end_date">End Date*</label>
                                                        <input  class="form-date datepicker"  placeholder="31/01/2020" name="last_minute_end[{{$last_minute->id}}]" type="text"  >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row last_minute_validity_date_{{$last_minute->id}}" style="margin-left :15px; display: none;">
                                                <div class="input-field col s3"></div>
                                                <div class="input-field col s3 ">
                                                     <a onclick="addDateDiscount('last_minute',{{$last_minute->id}})" href="javascript:void(0)">Add More</a>
                                                </div>

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div  class="row"  style="font-size: .8em;" class="mr-6">
                        <h6 style="background-color: #F8F9F9">Long Stay</h6>
                        <table id="longstaylist" class="table">
                            <thead >
                                <tr >
                                    <th style="padding: 5px !important; width:40px;  border: 1px solid #D5DBDB  !important; vertical-align: top; text-align: center;">
                                        <input id="longstay_all" style="opacity: 1;  pointer-events: all;"  type="checkbox"  />
                                    </th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                 @foreach ($hotel->discount_long_stays as $long_stay)
                                    <tr>
                                        <td  style="padding: 5px !important; margin-left :5px;  border: 1px solid #D5DBDB  !important; vertical-align: top; text-align: center;">
                                        <input value="{{$long_stay->id}}" name="long_stay[]" class="long_stay" style="opacity: 1;  pointer-events: all;"  type="checkbox"  />
                                        </td>
                                        <td style="padding: 5px !important; margin-left :5px;  border: 1px solid #D5DBDB  !important; text-align: left;">
                                            <div class="row" style="margin-left :15px; color: black; font-weight: 900;">{{$long_stay->name}}</div>

                                            <div class='row'  style="margin-left :20px;">
                                                For Stay of {{$long_stay->min_stay}} Night(s) get {{$long_stay->discount_type == 2 ? '' : ' next '}} {{number_format($long_stay->value)}} {{$long_stay->discount_type ==2? ' percent discount': ' Night(s) free'}}
                                            </div>
                                            <div class="row" style="margin-left :15px;">
                                                <span><strong style="color:black; font-weight: 900;">Validity:</strong> For throughout the </span>
                                                &nbsp; &nbsp; &nbsp;
                                                <label>
                                                    <input checked onclick="verifydicount('long_stay',{{$long_stay->id}})" id="long_stay_validity_{{$long_stay->id}}_1" value="1" type="radio" name="long_stay_validity[{{$long_stay->id}}]" />
                                                    <span style="font-size: 14px;">year</span>
                                                </label>
                                                <label>
                                                    <input onclick="verifydicount('long_stay_validity',{{$long_stay->id}})" id="long_stay_validity_{{$long_stay->id}}_2" value="2" type="radio" name="long_stay_validity[{{$long_stay->id}}]" />
                                                    <span>For specific dates</span>
                                                </label>
                                            </div>
                                            <div  class="row long_stay_validity_date_{{$long_stay->id}} date"  style="margin-left :15px; display: none;">
                                                <div class="row" >
                                                    <div class="input-field col s3">
                                                        <label for="start_date">Start Date*</label>
                                                        <input  class="form-date datepicker"  placeholder="31/01/2020" name="long_stay_start[{{$long_stay->id}}]" type="text"  >
                                                    </div>
                                                    <div class="input-field col s3">
                                                        <label for="end_date">End Date*</label>
                                                        <input  class="form-date datepicker"  placeholder="31/01/2020" name="long_stay_end[{{$long_stay->id}}]" type="text"  >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row long_stay_validity_date_{{$long_stay->id}}" style="margin-left :15px; display: none;">
                                                <div class="input-field col s3"></div>
                                                <div class="input-field col s3 ">
                                                     <a onclick="addDateDiscount('long_stay',{{$long_stay->id}})" href="javascript:void(0)">Add More</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div  class="row"  style="font-size: .8em;" class="mr-6">
                        <h6 style="background-color: #F8F9F9">Dynamic Pricing</h6>
                        <table id="dynamiclist" class="table">
                            <thead >
                                <tr >
                                    <th style="padding: 5px !important; width:40px;  border: 1px solid #D5DBDB  !important; vertical-align: top; text-align: center;">
                                        <input id="dynamic_all" style="opacity: 1;  pointer-events: all;"  type="checkbox"  />
                                    </th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hotel->discount_dynamic_pricings as $dynamic)
                                    <tr>
                                        <td  style="padding: 5px !important; margin-left :5px;  border: 1px solid #D5DBDB  !important; vertical-align: top; text-align: center;">
                                        <input value="{{$dynamic->id}}" name="dynamic[]" class="dynamic" style="opacity: 1;  pointer-events: all;"  type="checkbox"  />
                                        </td>
                                        <td style="padding: 5px !important; margin-left :5px;  border: 1px solid #D5DBDB  !important; text-align: left;">
                                            <div class="row" style="margin-left :15px; color: black; font-weight: 900;">{{$dynamic->name}}</div>
                                            @foreach ( $dynamic->discount_dynamic_pricing_details as $detail)
                                                 <div class='row'  style="margin-left :20px;">For days from {{$detail->start}} to {{$detail->end}}, discount applicable is {{number_format($detail->start_percentage,2)}}% to {{number_format($detail->end_percentage,2)}}%</div>
                                            @endforeach
                                            <div class="row" style="margin-left :15px;">
                                                <span><strong style="color:black; font-weight: 900;">Validity:</strong> For throughout the </span>
                                                &nbsp; &nbsp; &nbsp;
                                                <label>
                                                    <input checked onclick="verifydicount('dynamic_validity',{{$dynamic->id}})" id="dynamic_validity_{{$dynamic->id}}_1" value="1" type="radio" name="dynamic_validity[{{$dynamic->id}}]" />
                                                    <span style="font-size: 14px;">year</span>
                                                </label>
                                                <label>
                                                    <input onclick="verifydicount('dynamic_validity',{{$dynamic->id}})" id="dynamic_validity_{{$dynamic->id}}_2" value="2" type="radio" name="dynamic_validity[{{$dynamic->id}}]" />
                                                    <span>For specific dates</span>
                                                </label>
                                            </div>
                                            <div  class="row dynamic_validity_date_{{$dynamic->id}} date"  style="margin-left :15px; display: none;">
                                                <div class="row" >
                                                    <div class="input-field col s3">
                                                        <label for="start_date">Start Date*</label>
                                                        <input  class="form-date datepicker"  placeholder="31/01/2020" name="dynamic_start[{{$dynamic->id}}]" type="text"  >
                                                    </div>
                                                    <div class="input-field col s3">
                                                        <label for="end_date">End Date*</label>
                                                        <input  class="form-date datepicker"  placeholder="31/01/2020" name="dynamic_end[{{$dynamic->id}}]" type="text"  >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row dynamic_validity_date_{{$dynamic->id}}" style="margin-left :15px; display: none;">
                                                <div class="input-field col s3"></div>
                                                <div class="input-field col s3 ">
                                                     <a onclick="addDateDiscount('dynamic',{{$dynamic->id}})" href="javascript:void(0)">Add More</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
                <div id="rate">
                    <div class="row">
                        <div class="row">
                            <div class="col">
                                <span><strong style="color:black;">Validity:</strong> Package is valid for </span>
                                &nbsp; &nbsp; &nbsp;
                                <label>
                                    <input onclick="verifyvalidity()" value="1" {{old('validity', $frontDeskPackage->validity) == 1 ? 'checked' : '' }}
                                    type="radio" name="validity" />
                                    <span>Throughout the year</span>
                                </label>
                                <label>
                                    <input onclick="verifyvalidity()" value="2" {{old('validity', $frontDeskPackage->validity) == 2 ? 'checked' : '' }} id="season_attribute_opt"  type="radio"
                                    name="validity"/>
                                    <span>Season Type</span>
                                </label>
                                <label >
                                    <input onclick="verifyvalidity()" value="3" {{old('validity', $frontDeskPackage->validity) == 3? 'checked' : '' }}  type="radio" id="date_id"  name="validity" />
                                    <span>Date</span>
                                </label>
                                <label >
                                    <input onclick="verifyvalidity()" value="4" {{old('validity', $frontDeskPackage->validity) == 4? 'checked' : '' }} id="season_id_opt"   type="radio"  name="validity" />
                                    <span>Season </span>
                                </label>
                                <label >
                                    <input onclick="verifyvalidity()" value="5" {{old('validity', $frontDeskPackage->validity) == 5? 'checked' : '' }} id="special_period_id_opt"   type="radio"  name="validity" />
                                    <span>Special Period </span>
                                </label>
                            </div>
                        </div>
                        <div class="row validity season_attribute" style="display: {{$frontDeskPackage->validity == 2?'':'none'}}">
                            <div class="col s4">
                                <select name="season_attribute" id="season_attribute">
                                    @foreach ($hotel->season_attributes as $season)
                                        <option value="{{$season->id}}">{{$season->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row validity date_id" style="display: {{$frontDeskPackage->season_attribute == 3?'':'none'}}">
                            <div class="input-field col s3">
                                <label for="start_date">Start Date*</label>
                                <input onclick="selectseason(0)" class="form-date datepicker"  id="start_date" placeholder="31/01/2020" name="start_date" type="text" value="{{old('start_date',$frontDeskPackage['start_date']??'')}}" >
                                @error('start_date')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                            </div>
                            <div class="input-field col s3">
                                <label for="end_date">End Date*</label>
                                <input onclick="selectseason(0)" class="form-date datepicker" id="end_date" placeholder="31/01/2020" name="end_date" type="text" value="{{old('end_date',$frontDeskPackage['end_date']??'')}}" >
                                @error('end_date')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                            </div>
                            <div class="col s1"><br>Or</div>
                            <div class="col s1"><label ><br>Seasons</label></div>

                            <div class="input-field col s3">
                                <select onchange="selectseason(1)" class="browser-default" name="season_date"  id="season_date">
                                    <option value=""></option>
                                    @foreach ($hotel->seasons as $season)
                                        <option  data-start="{{date('d/m/Y',strtotime($season->start))}}" data-end="{{date('d/m/Y',strtotime($season->end))}}"
                                            value="{{$season->id}}">{{$season->name}}
                                        </option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="row validity season_id" style="display: {{$frontDeskPackage->season_attribute == 4?'':'none'}}">
                            <label for="">Select Season</label>
                            <div class="input-field col s12">

                                <select class="browser-default"  id="season_id" name="season_id" >
                                    <option value=""></option>
                                    @foreach ($hotel->seasons as $season)
                                        <option  value="{{$season->id}}">{{$season->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row validity special_period_id" style="display: {{$frontDeskPackage->season_attribute == 5?'':'none'}}">
                            <label for="">Select Special Period</label>
                            <div class="input-field col s12">

                                <select class="browser-default"  id="special_period_id" name="special_period_id">
                                    <option value=""></option>
                                    @foreach ($hotel->special_periods as $special_period)
                                        <option  value="{{$special_period->id}}">{{$special_period->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="roomtypes" style="font-size: .7em;">
                        <h5 class="center-align">Room Types</h5>
                        <table class="table">
                            <thead >
                                <tr >
                                    <th rowspan="2">Room Types</th>
                                    <th rowspan="2">Base Occupancy</th>
                                    <th rowspan="2">Max Occupancy</th>
                                    <th colspan="3">Rack Rate</th>
                                    <th colspan="3">Discount Rate (Room Only)</th>
                                    <th colspan="4" rowspan="2">Select Minimum Person(s) for this package</th>
                                </tr>
                                <tr>
                                    <th>Room Only Price</th>
                                    <th>Upcharge per person</th>
                                    <th>Extra bed</th>
                                    <th>Room Only Price</th>
                                    <th>Upcharge per person</th>
                                    <th>Extra bed</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($frontDeskPackage->front_desk_package_rooms as $package_room)
                                     @php
                                        $rack = $package_room->room_type->rack_rate();
                                        $price = $package_room->price();
                                    @endphp
                                    <tr>
                                        <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; vertical-align: top;">
                                            {{$package_room->room_type->name}}
                                        </td>
                                        <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; vertical-align: top;">
                                            {{$package_room->room_type->base_occupancy}} {{Str::plural('Person', $package_room->room_type->base_occupancy)}}
                                        </td>
                                        <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; vertical-align: top;">
                                            {{$package_room->room_type->higher_occupancy}} {{Str::plural('Person', $package_room->room_type->higher_occupancy)}}
                                        </td>
                                         <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; vertical-align: top;">
                                            {{$rack->base_occupancy}}
                                        </td>
                                        <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; vertical-align: top;">
                                            {{$rack->extra_person}}
                                        </td>
                                        <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; vertical-align: top;">
                                            {{$rack->extra_bed}}
                                        </td>
                                        <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; text-align: center; vertical-align: top;">
                                            <input name="room_type[{{$package_room->room_type->id}}][base_price]" onkeypress="return isNumberKey(event)" style="width:50px;" type="text" class="browser-default" value="{{$price->base_price}}">
                                        </td>
                                        <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; text-align: center; vertical-align: top;">
                                            <input name="room_type[{{$package_room->room_type->id}}][extra_person]" onkeypress="return isNumberKey(event)" style="width:50px;" type="text" class="browser-default" value="{{$price->extra_person}}">
                                            <br>
                                                <div id="upcharge{{$package_room->room_type->id}}" style="font-size: .8em">
                                                    @foreach ($package_room->front_desk_package_upcharges as $item)
                                                        <span><strong style="color: black; font-weight:900;">Person {{$item->persons}}:</strong> ${{$item->adults}}(A)  ${{$item->children}}(C) <span><br>
                                                        <input type="hidden" name="upcharge[{{$package_room->room_type->id}}][adult][{{$item->persons}}]" id="upcharge_{{$package_room->room_type->id}}_adult_{{$item->persons}}" value="{{$item->adults}}" />
                                                        <input type="hidden" name="upcharge[{{$package_room->room_type->id}}][children][{{$item->persons}}]" id="upcharge_{{$package_room->room_type->id}}_children_{{$item->persons}}" value="{{$item->children}}"  />
                                                    @endforeach
                                                </div>
                                            <br>
                                            <a href="javascript:void(0)" onclick="displaydata({{$package_room->room_type->id}}, {{$package_room->room_type->higher_occupancy}} )" >Add/Edit Surcharge</a>
                                        </td>
                                        <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; text-align: center; vertical-align: top;">
                                            <input name="room_type[{{$package_room->room_type->id}}][extra_bed]" onkeypress="return isNumberKey(event)" style="width:50px;" type="text" class="browser-default" value="{{$price->extra_bed}}">
                                        </td>

                                        <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; vertical-align: top;">
                                            <select name="room_type[{{$package_room->room_type->id}}][adults_minimum]" class="browser-default">
                                                @for ($i = 0; $i <= $package_room->room_type->higher_occupancy; $i++)
                                                    <option {{$i == $price->adults_minimum? 'selected':''}} value="{{$i}}">{{$i}} {{Str::plural('Person', $i)}}</option>
                                                @endfor
                                            </select>
                                        </td>
                                        <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; vertical-align: top;">
                                            <select name="room_type[{{$package_room->room_type->id}}][children_minimum]" class="browser-default">
                                                @for ($i = 0; $i <= $package_room->room_type->higher_occupancy; $i++)
                                                    <option {{$i == $price->children_minimum? 'selected':''}}  value="{{$i}}">{{$i}} {{Str::plural('Child', $i)}}</option>
                                                @endfor
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div id="inclusions" style="font-size: .7em;">
                        <h5 class="center-align">Inclusions</h5>
                        <table id="inclusions" class="table tablecustom">
                            <thead >
                                <tr >
                                    <th>S. No.</th>
                                    <th >Inclusions</th>
                                    <th >Price</th>
                                    <th >Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total =0;
                                    $contador =0;
                                @endphp
                                @foreach ($frontDeskPackage->inclusions as $inclusion)
                                     @php
                                        $total +=$inclusion->price_after_discount();
                                        $contador++;
                                    @endphp
                                    <tr id="inclusion{{$inclusion->id}}" >
                                        <td >{{$contador}}</td>
                                        <td >{{$inclusion->name}}</td>
                                        <td >{{number_format($inclusion->price_after_discount(),2,".",",")}}<input class="inclusion_id" name="inclusion_id[]" type="hidden" value="{{$inclusion->id}}" /></td>
                                        <td class="invoice-action-edit mr-6"  >
                                            <a onclick="removeInclusion({{$inclusion->price_after_discount()}},{{$inclusion->id}})" href="javascript:void(0)">
                                                <i class="material-icons">delete</i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                @if ($frontDeskPackage->inclusions)
                                    <tr><td ></td>
                                        <td ><button onclick="showInclusion()" type="button" class="btn btn-light-green" >Add more inclusions</button></td>
                                    <td ><span id="total" data-total="{{$total}}">{{number_format($total,2,".",",")}}</span></td>
                                        <td ></td>
                                    </tr>
                                @else
                                    <td colspan="4"  style="text-align: center;"><button onclick="showInclusion()" class="btn btn-light-green" type="button">Add inclusions</button></td>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <br>
                <div class="row s12 right">
                    <button type="submit" class="mb-6 btn waves-effect waves-light gradient-45deg-green-teal" >Update </button>
                    <a href="{{ route('frontdesk-packages.index') }}" class="mb-6 btn waves-effect waves-light gradient-45deg-purple-deep-orange">Cancel</a>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
<div class="contact-compose-sidebar inclusion" style="width:80%; padding-right:5%;">
    <div class="card quill-wrapper">
            <div class="card-content pt-0">
                <div class="card-header display-flex pb-2">
                    <h3 class="card-title contact-title-label">Inclusions</h3>
                    <div class="close close-icon">
                    <i  class="material-icons closeico">close</i>
                    </div>
                </div>
                <div class="divider"></div>
                <!-- form start -->
                <form id="formaccountCode" class="edit-contact-item mb-5 mt-5" method="POST">
                    <table id="all_inclusions" class="table tablecustom">
                        <thead >
                            <tr >
                                <th>No.</th>
                                <th>
                                    <label ><input  type="checkbox" id="checkall" ></label>
                                </th>
                                <th >Inclusions</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $contador =0;
                            @endphp
                            @foreach ($hotel->inclusions as $inclusion)
                                @php
                                    $contador++;
                                @endphp
                                <tr>
                                    <td >
                                        {{$contador}}
                                    </td>
                                    <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; text-align: center;">
                                        <input {{$frontDeskPackage->inclusions->contains('id', $inclusion->id)? 'checked':''}} id="check{{$inclusion->id}}" data-id="{{$inclusion->id}}" data-name="{{$inclusion->name}}" data-price="{{$inclusion->price_after_discount()}}"
                                        class="selection" style="opacity: 1;  pointer-events: all;"  type="checkbox"  />
                                    </td>
                                    <td >
                                        {{$inclusion->name}}
                                    </td>

                                    <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; text-align: right;">
                                        {{number_format($inclusion->price_after_discount(), 2,".",",") }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <br>
                    <div class="row s12 right">
                    <button type="button" onclick="addInclusion()" class="mb-6 btn waves-effect waves-light gradient-45deg-green-teal" >Add to Package </button>
                    <a class="mb-6 btn waves-effect waves-light gradient-45deg-purple-deep-orange closeico">Cancel</a>
                </div>
                </form>
            </div>
    </div>
</div>
 <div class="contact-compose-sidebar surcharge" >
        <div class="card quill-wrapper">
                <div class="card-content pt-0">
                    <div class="card-header display-flex pb-2">
                        <h3 class="card-title contact-title-label">Upcharge</h3>
                        <div class="close close-icon">
                        <i  class="material-icons closeico">close</i>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <!-- form start -->
                    <form id="formUpcharge" class="edit-contact-item mb-5 mt-5" method="POST">
                        <input type="hidden" id="upcharge_hidden">
                        <table id="all_upcharge" class="table">
                            <thead style="padding: 0px !important;  display: table-header-group; vertical-align: middle; border-color: inherit; color:black;">
                                <tr style="border: 1px solid #F4F6F6; background-color: #F8F9F9  ; ">
                                    <th>Person</th>
                                    <th colspan="2">Charge</th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th>Adult</th>
                                    <th>Children</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                        <br>
                        <div class="row s12 right">
                        <button type="button" onclick="saveUpcharge()" class="mb-6 btn waves-effect waves-light gradient-45deg-green-teal" >Save</button>
                        <a class="mb-6 btn waves-effect waves-light gradient-45deg-purple-deep-orange closeico">Close</a>
                    </div>
                    </form>
                </div>
        </div>
    </div>
</div>
@endsection

{{-- vendor script --}}
@section('vendor-script')
<script src="{{asset('vendors/jquery-validation/jquery.validate.min.js')}}"></script>
<script src="{{asset('vendors/sweetalert/sweetalert.min.js')}}"></script>
@endsection

{{-- page script --}}
@section('page-script')
<script src="{{asset('js/scripts/form-validation.js')}}"></script>
<script src="{{asset('js/scripts/ui-alerts.js')}}"></script>
<script src="{{asset('js/scripts/hoteratus.js')}}"></script>
<script>
    var inclusionComposeSidebar = $(".contact-compose-sidebar.inclusion")
    var surchargeComposeSidebar = $(".contact-compose-sidebar.surcharge")
    var auth =0;
    $(document).ready(function () {

        filterDays();
    });
    $(".closeico").on('click', function(){
        inclusionComposeSidebar.removeClass("show");
        surchargeComposeSidebar.removeClass("show");
   });

    $("#cancellation_all").on('click', function(){
        $(".cancellation").prop('checked', $("#cancellation_all").prop('checked'));
    });
    $("#booking_all").on('click', function(){
        $(".booking").prop('checked', $("#booking_all").prop('checked'));
    });
    function showInclusion(){
        inclusionComposeSidebar.addClass("show");
    }
    function verifydicount(typo, id){

        if($('#'+typo+'_'+id+'_2').prop('checked')){
            $('.'+typo+'_date_'+id).show();
        }else{
            $('.'+typo+'_date_'+id).hide();
        }

    }
    function addDateDiscount(typo ,id){
        var tr  = '<div class="row" >'
            tr += '<div class="input-field col s3">'
            tr += '<label for="'+typo+'_start['+id+']">Start Date*</label>'
            tr += '<input  class="form-date datepicker"  placeholder="31/01/2020" name="'+typo+'_start['+id+']" type="text"  required>'
            tr += '</div>'
            tr += '<div class="input-field col s3">'
            tr += '<label for="'+typo+'_end['+id+']">End Date*</label>'
            tr += '<input  class="form-date datepicker"  placeholder="31/01/2020" name="'+typo+'_end['+id+']" type="text"  required>'
            tr += '</div> <div class="input-field col s1 center"><a href="javascript:void(0)" onclick="deleteDate(this)" ><i class="material-icons">delete</i></a></div> </div>'

        $('.'+typo+'_validity_date_'+id+'.date').append(tr);
        $('.datepicker').datepicker({ format: 'dd/mm/yyyy' });
    }
    function deleteDate(obj){
       $(obj).parent().parent().remove();

    }
    function selectseason(opt){


        if( opt == 1){
            var combo = document.getElementById("season_date");
            var selected = combo.options[combo.selectedIndex];
            if($(selected).data('start')){
                $("#start_date").val($(selected).data('start'));
                $("#end_date").val($(selected).data('end'));

            }else{
                $("#start_date").val("");
                $("#end_date").val("");
            }

        }else{
            $("#season_date").val("");
        }
    }
    function verifyvalidity(){

        $(".validity").hide();
        if ($("#season_attribute_opt").prop('checked')){
            $(".season_attribute").show();
        }
        if ($("#date_id").prop('checked')){
            $(".date_id").show();
        }
        if ($("#season_id_opt").prop('checked')){
            $(".season_id").show();
        }
        if ($("#special_period_id_opt").prop('checked')){
            $(".special_period_id").show();
        }


    }
    function dateChange(type){
        if(type == 1){
            if($("#activated_forever").prop('checked') ){
                $("#start").val('');
                $("#end").val('');
            }
        }else{
            $("#activated_forever").prop('checked', false)
        }
    }
    function corporate_change(){
          if($("#corporate").prop('checked')){
            $('.corporate').show();
        }else{
           $('.corporate').hide();
        }
    }
    function  travel_agent(){

        if($("#travel_agency").prop('checked')){
            $('.agent').show();
        }else{
           $('.agent').hide();
        }
    }
    function filterDays() {
        var type = $("#days_valid_id").val();
        var id = "{{$frontDeskPackage->id}}";

        $(".weekdays").prop('disabled', type != 1)

        $(".loader").show();
        $.ajax({
            type: "post",
            url: "{{route('frontdesk-packages.weekdayslist')}}",
            data: {id: id, type: type, _token: "{{ csrf_token() }}"},
            success: function (response) {
               if(response.success){
                   $(".loader").hide();
                    if(response.data == null){
                        return;
                    }
                     $("#monday").prop('checked',response.data.monday ==1)
                     $("#tuesday").prop('checked',response.data.tuesday ==1)
                     $("#wednesday").prop('checked',response.data.wednesday ==1)
                     $("#thursday").prop('checked',response.data.thursday ==1)
                     $("#friday").prop('checked',response.data.friday ==1)
                     $("#saturday").prop('checked',response.data.saturday ==1)
                     $("#sunday").prop('checked',response.data.sunday ==1)

               }
            },
            error: function (err) {
                $(".loader").hide();
                console.log(err);
            }
        });

    }
    function displaydata(room_id, adult){
        $("#all_upcharge tbody").html('');
        $("#upcharge_hidden").val(room_id)
        for (let index = 1; index <= adult; index++) {
            var adults = $('#upcharge_'+room_id+'_adult_'+index).val()
            var chldren = $('#upcharge_'+room_id+'_children_'+index).val()

            var tr = '<tr class="upcharge_modal"><td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; text-align: center;" >Person '+index+'</td>';
                tr += '<td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; text-align: center;" >'
                tr += '<input value="'+(adults??'0.00')+'" class="adult" data-person="'+index+'"  data-room="'+room_id+'" onkeypress="return isNumberKey(event)" style="width:50px;" type="text" class="browser-default"> </td>';
                tr += '<td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; text-align: center;" >';
                tr += '<input value="'+(chldren??'0.00')+'" class="children" data-person="'+adult+'" onkeypress="return isNumberKey(event)" style="width:50px;" type="text" class="browser-default"> </td></tr>';

            $("#all_upcharge tbody").append(tr);
        }
        surchargeComposeSidebar.addClass("show");
    }
    function saveUpcharge(){
            var room_id =$("#upcharge_hidden").val()
            $("#upcharge"+room_id).html('');
            $("#all_upcharge tbody tr.upcharge_modal").each(function (index, obj) {
            var adult = $(obj).find('.adult');
            var children = $(obj).find('.children');
            var info = '<span><strong style="color: black; font-weight:900;">Person '+adult.data('person')+':</strong> $'+
                (adult.val().length==0?'0.00': adult.val())+'(A)</span>  <span> $'+ (children.val().length==0?'0.00': children.val())+'(C)</span> <br>'+
                '<input type="hidden" name="upcharge['+room_id+'][adult]['+(index+1)+']" id="upcharge_'+room_id+'_adult_'+(index+1)+'" value="'+adult.val()+'" />'+
                '<input type="hidden" name="upcharge['+room_id+'][children]['+(index+1)+']" id="upcharge_'+room_id+'_children_'+(index+1)+'" value="'+children.val()+'"  />'
            $("#upcharge"+adult.data('room')).append(info);
        });
        surchargeComposeSidebar.removeClass("show");
        swal("All Changes has been Added, now you must save this information", {
                title: 'Saved',
                icon: "success",
        });
    }
     document.getElementById("image").onchange = function(e) {
        // Creamos el objeto de la clase FileReader
            let preview = document.getElementById('preview')
             preview.innerHTML = '';
        for (let index = 0; index < e.target.files.length; index++) {
            let reader = new FileReader();
             reader.readAsDataURL(e.target.files[index]);
        reader.onload = function(){
            let div = document.createElement('div');
            div.className = "col s4"
            let image = document.createElement('img'), input = document.createElement('input')
            input.name ="imagename[]"
            input.placeholder ="Image Caption"
            div.append(image)
            div.append(input)
            image.src = reader.result;
            image.width = 125
            image.height = 100
            preview.append(div);
        };

        }

        }
        function  deleteimage(id, obj ){


          swal({
                title: "Are you sure?",
                text: "You will not be able to recover this image!",
                icon: 'warning',
                dangerMode: true,
                buttons: {
                cancel: 'No, Please!',
                delete: 'Yes, Delete It'
                }
            }).then(function (willDelete) {
                if (willDelete) {

                    $.ajax({
                        url: "{!!URL::to('images/"+id+"' )!!}" ,
                        method: 'DELETE',
                        data: { _token: $(obj).data("token") }

                    }).done( function(response){
                        swal("Poof! image  has been deleted!", {
                            icon: "success",
                        });
                        $(obj).parent().parent().remove();
                    }).fail(function(response){
                        console.log(response)
                    });



                } else {
                swal("Your image is safe", {
                    title: 'Cancelled',
                    icon: "error",
                });
                }
            });
    }
    function showImage(url, txt){
        var el = document.createElement('span'),
            t = document.createElement("img");
            t.src= url
            t.width = 400
            el.appendChild(t);
            swal({
            title: txt,
            content: {
                element: el,
            }
            });
    }
        function addInclusion(){
            var contador =0;
            var total = 0;
            $(".loader").show();
            $('#inclusions tbody').html('');
            $("#all_inclusions tbody tr").each(function (index, obj) {
                if($(obj).find(".selection").is(':checked')){
                    contador++;

                    var data = $(obj).find(".selection");
                    total += parseFloat(data.data('price'))
                    var tr = '<tr id="inclusion'+data.data('id')+'" > <td >'+contador+'</td>';
                        tr += '<td >'+data.data('name')+'</td>';
                        tr += '<td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; text-align: right;">'
                        tr += thousands_separators(data.data('price'))+'<input class="inclusion_id" name="inclusion_id[]" type="hidden" value="'+data.data('id')+'" /></td>';
                        tr += '<td class="invoice-action-edit mr-6"  style="padding: 5px !important; border: 1px solid #D5DBDB  !important;text-align: center; "><a onclick="removeInclusion('+data.data('price')+','+data.data('id')+')" href="javascript:void(0)"><i class="material-icons">delete</i></a></td></tr>';
                    $('#inclusions tbody').append(tr)
                }

            });

            if(contador==0){
                $('#inclusions tbody').append('<tr><td colspan="4"  style="text-align: center;"><button onclick="showInclusion()" class="btn btn-light-green" type="button">Add inclusions</button></td></tr>');

            }else{
                var tr = '<tr><td ></td>';
                    tr+='<td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; text-align: center;"><button onclick="showInclusion()" type="button" class="btn btn-light-green" >Add more inclusions</button></td>';
                    tr += '<td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; text-align: right;"><span id="total" data-total="'+total+'">'+thousands_separators(total)+'</span></td>';
                    tr += '<td ></td></tr>';
                $('#inclusions tbody').append(tr);
            }
            $(".loader").hide();
            inclusionComposeSidebar.removeClass("show");

    }
    function  removeInclusion(amount, id){
       var total = parseFloat($('#total').data('total'))-parseFloat(amount);
       $('#total').data('total',total);
       $('#total').html(thousands_separators(total))
       $('#inclusion'+id).remove();
       $("#check"+id).prop('checked', false);
       if(total==0){
            $('#inclusions tbody').html('<tr><td colspan="4"  style="text-align: center;"><button onclick="showInclusion()" class="btn btn-light-green" type="button">Add inclusions</button></td></tr>');

       }
    }
    function thousands_separators(num)
    {
        var num_parts = num.toString().split(".");
        num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return num_parts.join(".");
    }

    function verifyInclusion(){
       if (auth ==1) return true;
       if($('.inclusion_id').length==0){
           setTimeout(() => {
                $(".loader").css('display', 'none');
           }, 100);
            swal({
                title: "Are you sure you want to create a package without inclusions?",
                text: "You can add it later!",
                icon: 'warning',
                dangerMode: true,
                buttons: {
                cancel: 'No, Please!',
                delete: 'Yes, Create It'
                }
            }).then(function (willDelete) {
                if (willDelete) {
                    auth=1;
                    $("#formSubmit").submit();
                } else {
                    swal("Select at least a inclusion", {
                        title: 'Cancelled',
                        icon: "error",
                    });
                    return false;
                }
            });
            return false;
       }
    }

</script>
@endsection
