@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Room Price List')
{{-- vendor style --}}
@section('vendor-style')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2-materialize.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-sidebar.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-contacts.css')}}">
@endsection

@section('page-style')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/form-select2.css')}}">
@endsection

{{-- page content --}}
@section('content')
<style>
    #roomlist{
        td {
            padding 5px;
        }
    }
</style>
<div class="section">
  <div class="row" >
    <div class="col s12">

      <div id="validations" class="card card-tabs" >
        @csrf
        <div class="card-content" style="padding: 0px !important;">
            <div class="card-title">
                <div class="row center">
                    <div class="col s12">
                        <h5 class="center-align" style="font-weight: 900;">Room Price List</h5>
                    </div>

                </div>
            </div>
        </div>
        <div id="messages">

        </div>
         <div id="roomlist" style="font-size: .7em;">
            <table class="table" >
                <thead style="padding: 0px !important; background-color: #F8F9F9  ; display: table-header-group; vertical-align: middle; border-color: inherit; color:black;">
                    <tr style="border: 1px solid #F4F6F6 ">
                        <th  style="padding: 5px !important; margin-left :5px;  border: 1px solid #D5DBDB  !important; text-align: center;" width="1">#</th>
                        <th style="width: 100px; padding: 5px !important;  border: 1px solid #D5DBDB  !important; text-align: center;">Room Type</th>
                        <th  style="padding: 5px !important;  border: 1px solid #D5DBDB  !important; text-align: center;">Price Structure</th>
                    </tr>
                </thead>
                <tbody>
                    @php $count= 0;  @endphp
                    @foreach ($roomTypes as $roomType)
                        @php $count++;  @endphp
                        <tr>
                            <td style="padding: 1px !important; border: 1px solid #D5DBDB  !important;">{{$count}}</td>
                        <td style="padding: 0px !important; border: 1px solid #D5DBDB  !important;">
                            {{$roomType->name }} <br>
                            Base Occupancy: {{$roomType->base_occupancy}} {{Str::plural('Person', $roomType->base_occupancy)}}
                            <br>Max Occupancy: {{$roomType->higher_occupancy}} {{Str::plural('Person', $roomType->higher_occupancy)}}
                        </td>
                            <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important;">
                                <table class="table" >
                                    <thead style="background-color: #F8F9F9; display: table-header-group; vertical-align: middle; border-color: inherit; color:black;">
                                        <tr style="border: 1px solid #F4F6F6 ">
                                            <th style="padding: 0px !important; width: 15%; border: 1px solid #D5DBDB  !important;"></th>
                                            <th colspan="3" style="text-align: center; width: 25%; padding: 0px !important; border: 1px solid #D5DBDB  !important;">Low Weekdays</th>
                                            <th colspan="3" style="text-align: center; width: 25%; padding: 0px !important; border: 1px solid #D5DBDB  !important;">High Weekdays</th>
                                            <th colspan="7"  style="width: 35%; padding: 0px !important; border: 1px solid #D5DBDB  !important;"></th>
                                        </tr>
                                    </thead>
                                     <thead style="background-color: #AAB7B8; display: table-header-group; vertical-align: middle; border-color: inherit; color:black;">
                                        <tr style="border: 1px solid #F4F6F6 ">
                                            <th rowspan="2" style="text-align: center;  padding: 0px !important; border: 1px solid #D5DBDB  !important;"> Seasons/Special<br> Periods </th>
                                            <th rowspan="2"  style="text-align: center;  padding: 0px !important; border: 1px solid #D5DBDB  !important;"> Base Occupancy</th>
                                            <th rowspan="2" style="text-align: center;  padding: 0px !important; border: 1px solid #D5DBDB  !important;"> Extra Person</th>
                                            <th rowspan="2"  style="text-align: center;  padding: 0px !important; border: 1px solid #D5DBDB  !important;"> Extra Bed </th>
                                            <th rowspan="2"  style="text-align: center;  padding: 0px !important; border: 1px solid #D5DBDB  !important;"> Base Occupancy</th>
                                            <th rowspan="2" style="text-align: center;  padding: 0px !important; border: 1px solid #D5DBDB  !important;"> Extra Person</th>
                                            <th rowspan="2"  style="text-align: center;  padding: 0px !important; border: 1px solid #D5DBDB  !important;"> Extra Bed </th>
                                            <th colspan="3"  style="text-align: center;  padding: 0px !important; border: 1px solid #D5DBDB  !important;"> Publish On</th>
                                            <th colspan="3" style="text-align: center;  padding: 0px !important; border: 1px solid #D5DBDB  !important;"> Policy </th>
                                            <th rowspan="2" style="text-align: center;  padding: 0px !important; border: 1px solid #D5DBDB  !important;"> Action </th>
                                        </tr>
                                        <tr>
                                            <th align="left" style="text-align: center;  padding: 0px !important; border: 1px solid #D5DBDB  !important;"> Web </th>
                                            <th align="left" style="text-align: center;  padding: 0px !important; border: 1px solid #D5DBDB  !important;"> Corp </th>
                                            <th align="left" style="text-align: center;  padding: 0px !important; border: 1px solid #D5DBDB  !important;"> Agent </th>
                                             <th align="left" style="text-align: center;  padding: 0px !important; border: 1px solid #D5DBDB  !important;"> Cxncl </th>
                                            <th align="left" style="text-align: center;  padding: 0px !important; border: 1px solid #D5DBDB  !important;"> Booking </th>
                                            <th align="left" style="text-align: center;  padding: 0px !important; border: 1px solid #D5DBDB  !important;"> Web </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            @php
                                                $rack = $roomType->rack_rate();
                                            @endphp
                                            <td id="ratename{{$roomType->id}}Rack" style="padding: 5px !important; border: 1px solid #D5DBDB  !important;">
                                                Rack Rate <br>( Since {{ date('d/m/Y', strtotime($rack->created_at??date('Y-m-d'))) }})
                                            </td>
                                            <td id="base_occupancy{{$roomType->id}}Rack" style="padding: 5px !important; border: 1px solid #D5DBDB  !important;">
                                                {{number_format($rack->base_occupancy??0.00,$defaultSetting['currency_decimal_place'],'.',',')  }}
                                            </td>
                                            <td id="extra_person{{$roomType->id}}Rack"  style="padding: 5px !important; border: 1px solid #D5DBDB  !important;">
                                                {{number_format($rack->extra_person??0.00,$defaultSetting['currency_decimal_place'],'.',',')  }}
                                            </td>
                                            <td  id="extra_bed{{$roomType->id}}Rack"  style="padding: 5px !important; border: 1px solid #D5DBDB  !important;">
                                                {{number_format($rack->extra_bed??0.00,$defaultSetting['currency_decimal_place'],'.',',')  }}
                                            </td>
                                            <td  id="base_occupancy_high{{$roomType->id}}Rack"  style="padding: 5px !important; border: 1px solid #D5DBDB  !important;">
                                                {{number_format($rack->base_occupancy_high??0.00,$defaultSetting['currency_decimal_place'],'.',',')  }}
                                            </td>
                                            <td  id="extra_person_high{{$roomType->id}}Rack"  style="padding: 5px !important; border: 1px solid #D5DBDB  !important;">
                                                {{number_format($rack->extra_person_high??0.00,$defaultSetting['currency_decimal_place'],'.',',')  }}
                                            </td>
                                            <td  id="extra_bed_high{{$roomType->id}}Rack"  style="padding: 5px !important; border: 1px solid #D5DBDB  !important;">
                                                {{number_format($rack->extra_bed_high??0.00,$defaultSetting['currency_decimal_place'],'.',',')  }}
                                            </td>
                                            <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; text-align: center;">
                                              <input  id="web{{$roomType->id}}Rack" disabled style="opacity:1; pointer-events: all; position: relative;" name="web[]"  value="1" type="checkbox" {{$rack->web??0 == 1? 'checked': ''}}>
                                            </td>
                                            <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important;  text-align: center;">
                                                <input  id="corp{{$roomType->id}}Rack" disabled style="opacity:1; pointer-events: all;  position: relative;"   name="corp[]" value="1"  type="checkbox" {{$rack->corp??0 == 1? 'checked': ''}}>
                                            </td>
                                            <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; text-align: center;">
                                              <input  id="agent{{$roomType->id}}Rack" style="opacity:1; pointer-events: all;  position: relative;"  name="agent[]" disabled value="1"  type="checkbox" {{$rack->agent??0 == 1? 'checked': ''}}>
                                            </td>
                                             <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; text-align: center;">
                                                <a onclick="otherPolicies('{{$roomType->id??0}}', 'Rack', 1, 'add', 'cancel')" href="javascript:void(0)">Add</a>/<br>
                                                <a onclick="otherPolicies('{{$roomType->id??0}}', 'Rack', 1, 'view', 'cancel')" href="javascript:void(0)">View</a>
                                             </td>
                                            <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; text-align: center;">
                                                <a onclick="otherPolicies('{{$roomType->id??0}}', 'Rack', 1, 'add', 'booking')" href="javascript:void(0)">Add</a>/<br>
                                                <a onclick="otherPolicies('{{$roomType->id??0}}', 'Rack', 1, 'view', 'booking')" href="javascript:void(0)">View</a>
                                             </td>
                                             <td  style="padding: 5px !important; border: 1px solid #D5DBDB  !important; text-align: center;">
                                                <a  onclick="policyWeb('{{$roomType->id??0}}', 'Rack')" href="javascript:void(0)">Add</a>/<br>
                                                <a onclick="policyWeb('{{$roomType->id??0}}', 'Rack')" href="javascript:void(0)">View</a>
                                             </td>
                                             <td  style="padding: 5px !important; border: 1px solid #D5DBDB  !important; text-align: center;">
                                                <div class="invoice-action" style="display: flex;">
                                                    <a href="javascript:void(0)" onclick="displayUpdate('{{$roomType->id??0}}', 'Rack')"  class="invoice-action-view mr-2"> <i class="material-icons" style="font-size: 20px">edit</i> </a>
                                                    <a href="{{route('room-price.history', [$roomType->id, 'Rack', 1])}}"  class="invoice-action-edit mr-2" > <i class="material-icons" style="font-size: 20px">history</i> </a>
                                                </div>
                                             </td>
                                        </tr>
                                        <!--Season-->
                                        @foreach ($seasons as $season)
                                            <tr>
                                                @php
                                                    $season_data = $roomType->season_rate($season->id);
                                                @endphp
                                                <td  style="padding: 5px !important; border: 1px solid #D5DBDB  !important;">
                                                    {{$season->name}} <br> ({{ date('d/m/Y', strtotime($season->start))}} to
                                                    <br>{{ date('d/m/Y', strtotime($season->end))}})
                                                </td>
                                                <td id="base_occupancy{{$roomType->id}}App-Season"  style="padding: 5px !important; border: 1px solid #D5DBDB  !important;">
                                                    {{number_format($season_data->base_occupancy??0.00,$defaultSetting['currency_decimal_place'],'.',',')  }}
                                                </td>
                                                <td id="extra_person{{$roomType->id}}App-Season"  style="padding: 5px !important; border: 1px solid #D5DBDB  !important;">
                                                    {{number_format($season_data->extra_person??0.00,$defaultSetting['currency_decimal_place'],'.',',')  }}
                                                </td>
                                                <td   id="extra_bed{{$roomType->id}}App-Season" style="padding: 5px !important; border: 1px solid #D5DBDB  !important;">
                                                    {{number_format($season_data->extra_bed??0.00,$defaultSetting['currency_decimal_place'],'.',',')  }}
                                                </td>
                                                <td  id="base_occupancy_high{{$roomType->id}}App-Season"  style="padding: 5px !important; border: 1px solid #D5DBDB  !important;">
                                                    {{number_format($season_data->base_occupancy_high??0.00,$defaultSetting['currency_decimal_place'],'.',',')  }}
                                                </td>
                                                <td id="extra_person_high{{$roomType->id}}App-Season" style="padding: 5px !important; border: 1px solid #D5DBDB  !important;">
                                                    {{number_format($season_data->extra_person_high??0.00,$defaultSetting['currency_decimal_place'],'.',',')  }}
                                                </td>
                                                <td id="extra_bed_high{{$roomType->id}}App-Season" style="padding: 5px !important; border: 1px solid #D5DBDB  !important;">
                                                    {{number_format($season_data->extra_bed_high??0.00,$defaultSetting['currency_decimal_place'],'.',',')  }}
                                                </td>
                                                <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; text-align: center;">
                                                <input id="web{{$roomType->id}}App-Season" disabled style="opacity:1; pointer-events: all; position: relative;" name="web[]"  value="1" type="checkbox" {{$season_data->web??0 == 1? 'checked': ''}}>
                                                </td>
                                                <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important;  text-align: center;">
                                                    <input id="corp{{$roomType->id}}App-Season" disabled style="opacity:1; pointer-events: all;  position: relative;"   name="corp[]" value="1"  type="checkbox" {{$season_data->corp??0 == 1? 'checked': ''}}>
                                                </td>
                                                <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; text-align: center;">
                                                <input   id="agent{{$roomType->id}}App-Season" disabled style="opacity:1; pointer-events: all;  position: relative;"  name="agent[]"  value="1"  type="checkbox" {{$season_data->agent??0 == 1? 'checked': ''}}>
                                                </td>
                                                <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; text-align: center;">
                                                    <a onclick="otherPolicies('{{$roomType->id??0}}', 'App-Season', '{{$season->id}}', 'add', 'cancel')" href="javascript:void(0)">Add</a>/<br>
                                                    <a onclick="otherPolicies('{{$roomType->id??0}}', 'App-Season', '{{$season->id}}', 'view', 'cancel')" href="javascript:void(0)">View</a>
                                                </td>
                                                <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; text-align: center;">
                                                    <a onclick="otherPolicies('{{$roomType->id??0}}', 'App-Season', '{{$season->id}}', 'add', 'booking')" href="javascript:void(0)">Add</a>/<br>
                                                    <a onclick="otherPolicies('{{$roomType->id??0}}', 'App-Season', '{{$season->id}}', 'view', 'booking')" href="javascript:void(0)">View</a>
                                                </td>
                                                <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; text-align: center;">
                                                    <a onclick="policyWeb('{{$roomType->id??0}}', 'App-Season', '{{$season->id}}')" href="javascript:void(0)">Add</a>/<br>
                                                    <a onclick="policyWeb('{{$roomType->id??0}}', 'App-Season', '{{$season->id}}')" href="javascript:void(0)">View</a>
                                                </td>
                                                <td  style="padding: 5px !important; border: 1px solid #D5DBDB  !important; text-align: center;">
                                                    <div class="invoice-action" style="display: flex;">
                                                        <a href="javascript:void(0)"  onclick="displayUpdate('{{$roomType->id??0}}', 'App-Season','{{$season->id??0}}' )"  class="invoice-action-view mr-2"> <i class="material-icons" style="font-size: 20px">edit</i> </a>
                                                        <a  href="{{route('room-price.history', [$roomType->id, 'App-Season', $season->id])}}" class="invoice-action-edit mr-2" > <i class="material-icons" style="font-size: 20px">history</i> </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <!--Special Period-->
                                        @foreach ($specialPeriods as $specialPeriod)
                                            <tr style="background-color: #FCF3CF">
                                                @php
                                                    $special_data = $roomType->special_period_rate($specialPeriod->id);
                                                @endphp
                                                <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important;">
                                                    {{$specialPeriod->name}} <br> ({{ date('d/m/Y', strtotime($specialPeriod->start))}} to
                                                    <br>{{ date('d/m/Y', strtotime($specialPeriod->end))}})
                                                </td>
                                                <td  id="base_occupancy{{$roomType->id}}App-SpecialPeriod" style="padding: 5px !important; border: 1px solid #D5DBDB  !important;">
                                                    {{number_format($special_data->base_occupancy??0.00,$defaultSetting['currency_decimal_place'],'.',',')  }}
                                                </td>
                                                <td  id="extra_person{{$roomType->id}}App-SpecialPeriod"  style="padding: 5px !important; border: 1px solid #D5DBDB  !important;">
                                                    {{number_format($special_data->extra_person??0.00,$defaultSetting['currency_decimal_place'],'.',',')  }}
                                                </td>
                                                <td  id="extra_bed{{$roomType->id}}App-SpecialPeriod" style="padding: 5px !important; border: 1px solid #D5DBDB  !important;">
                                                    {{number_format($special_data->extra_bed??0.00,$defaultSetting['currency_decimal_place'],'.',',')  }}
                                                </td>
                                                <td  id="base_occupancy_high{{$roomType->id}}App-SpecialPeriod"  style="padding: 5px !important; border: 1px solid #D5DBDB  !important;">
                                                    {{number_format($special_data->base_occupancy_high??0.00,$defaultSetting['currency_decimal_place'],'.',',')  }}
                                                </td>
                                                <td  id="extra_person_high{{$roomType->id}}App-SpecialPeriod" style="padding: 5px !important; border: 1px solid #D5DBDB  !important;">
                                                    {{number_format($special_data->extra_person_high??0.00,$defaultSetting['currency_decimal_place'],'.',',')  }}
                                                </td>
                                                <td id="extra_bed_high{{$roomType->id}}App-SpecialPeriod" style="padding: 5px !important; border: 1px solid #D5DBDB  !important;">
                                                    {{number_format($special_data->extra_bed_high??0.00,$defaultSetting['currency_decimal_place'],'.',',')  }}
                                                </td>
                                                <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; text-align: center;">
                                                <input    id="web{{$roomType->id}}App-SpecialPeriod" disabled  style="opacity:1; pointer-events: all; position: relative;" name="web[]"  value="1" type="checkbox" {{$special_data->web??0 == 1? 'checked': ''}}>
                                                </td>
                                                <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important;  text-align: center;">
                                                    <input id="corp{{$roomType->id}}App-SpecialPeriod" disabled  style="opacity:1; pointer-events: all;  position: relative;"   name="corp[]" value="1"  type="checkbox" {{$special_data->corp??0 == 1? 'checked': ''}}>
                                                </td>
                                                <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; text-align: center;">
                                                <input    id="agent{{$roomType->id}}App-SpecialPeriod" disabled style="opacity:1; pointer-events: all;  position: relative;"  name="agent[]"  value="1"  type="checkbox" {{$special_data->agent??0 == 1? 'checked': ''}}>
                                                </td>
                                                <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; text-align: center;">
                                                    <a onclick="otherPolicies('{{$roomType->id??0}}', 'App-SpecialPeriod', '{{$specialPeriod->id}}', 'add', 'cancel')"  href="javascript:void(0)">Add</a>/<br>
                                                    <a onclick="otherPolicies('{{$roomType->id??0}}', 'App-SpecialPeriod', '{{$specialPeriod->id}}', 'view', 'cancel')"  href="javascript:void(0)">View</a>
                                                </td>
                                                <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; text-align: center;">
                                                    <a onclick="otherPolicies('{{$roomType->id??0}}', 'App-SpecialPeriod', '{{$specialPeriod->id}}', 'add', 'booking')" href="javascript:void(0)">Add</a>/<br>
                                                    <a onclick="otherPolicies('{{$roomType->id??0}}', 'App-SpecialPeriod', '{{$specialPeriod->id}}', 'view', 'booking')" href="javascript:void(0)">View</a>
                                                </td>
                                                <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; text-align: center;">
                                                <a onclick="policyWeb('{{$roomType->id??0}}', 'App-SpecialPeriod', '{{$specialPeriod->id}}')" class="test" href="javascript:void(0)">Add</a>/<br>
                                                <a onclick="policyWeb('{{$roomType->id??0}}', 'App-SpecialPeriod', '{{$specialPeriod->id}}')" href="javascript:void(0)">View</a>
                                                </td>
                                                <td  style="padding: 5px !important; border: 1px solid #D5DBDB  !important; text-align: center;">
                                                    <div class="invoice-action" style="display: flex;">
                                                        <a href="javascript:void(0)"  onclick="displayUpdate('{{$roomType->id??0}}', 'App-SpecialPeriod','{{$specialPeriod->id??0}}' )" class="invoice-action-view mr-2"> <i class="material-icons" style="font-size: 20px">edit</i> </a>
                                                        <a href="{{route('room-price.history', [$roomType->id, 'App-SpecialPeriod', $specialPeriod->id])}}"   class="invoice-action-edit mr-2" > <i class="material-icons" style="font-size: 20px">history</i> </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <!-- Last Min Rate -->
                                        <tr>
                                            @php
                                                $lastmin = $roomType->last_min_rate();
                                            @endphp
                                            <td id="ratename{{$roomType->id}}LastMin" style="padding: 5px !important; border: 1px solid #D5DBDB  !important;">
                                                Last Min Rate <br>( Since {{ date('d/m/Y', strtotime($lastmin->created_at??date('Y-m-d'))) }})
                                            </td>
                                            <td id="base_occupancy{{$roomType->id}}LastMin"  style="padding: 5px !important; border: 1px solid #D5DBDB  !important;">
                                                {{number_format($lastmin->base_occupancy??0.00,$defaultSetting['currency_decimal_place'],'.',',')  }}
                                            </td>
                                            <td id="extra_person{{$roomType->id}}LastMin"  style="padding: 5px !important; border: 1px solid #D5DBDB  !important;">
                                                {{number_format($lastmin->extra_person??0.00,$defaultSetting['currency_decimal_place'],'.',',')  }}
                                            </td>
                                            <td id="extra_bed{{$roomType->id}}LastMin" style="padding: 5px !important; border: 1px solid #D5DBDB  !important;">
                                                {{number_format($lastmin->extra_bed??0.00,$defaultSetting['currency_decimal_place'],'.',',')  }}
                                            </td>
                                            <td id="base_occupancy_high{{$roomType->id}}LastMin"  style="padding: 5px !important; border: 1px solid #D5DBDB  !important;">
                                                {{number_format($lastmin->base_occupancy_high??0.00,$defaultSetting['currency_decimal_place'],'.',',')  }}
                                            </td>
                                            <td  id="extra_person_high{{$roomType->id}}LastMin" style="padding: 5px !important; border: 1px solid #D5DBDB  !important;">
                                                {{number_format($lastmin->extra_person_high??0.00,$defaultSetting['currency_decimal_place'],'.',',')  }}
                                            </td>
                                            <td  id="extra_bed_high{{$roomType->id}}LastMin"  style="padding: 5px !important; border: 1px solid #D5DBDB  !important;">
                                                {{number_format($lastmin->extra_bed_high??0.00,$defaultSetting['currency_decimal_place'],'.',',')  }}
                                            </td>
                                            <td colspan="3" style="padding: 5px !important; border: 1px solid #D5DBDB  !important; text-align: center;">
                                              <span>Default rates published on web.</span>
                                            </td>

                                             <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; text-align: center;">
                                                <a onclick="otherPolicies('{{$roomType->id??0}}', 'LastMin', 1, 'add', 'cancel')"  href="javascript:void(0)">Add</a>/<br>
                                                <a onclick="otherPolicies('{{$roomType->id??0}}', 'LastMin', 1, 'view', 'cancel')"  href="javascript:void(0)">View</a>
                                             </td>
                                            <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; text-align: center;">
                                                <a onclick="otherPolicies('{{$roomType->id??0}}', 'LastMin', 1, 'add', 'booking')" href="javascript:void(0)">Add</a>/<br>
                                                <a onclick="otherPolicies('{{$roomType->id??0}}', 'LastMin', 1, 'view', 'booking')" href="javascript:void(0)">View</a>
                                             </td>
                                             <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; text-align: center;">
                                                <a onclick="policyWeb('{{$roomType->id??0}}', 'LastMin')" href="javascript:void(0)">Add</a>/<br>
                                                <a onclick="policyWeb('{{$roomType->id??0}}', 'LastMin')" href="javascript:void(0)">View</a>
                                             </td>
                                             <td  style="padding: 5px !important; border: 1px solid #D5DBDB  !important; text-align: center;">
                                                <div class="invoice-action" style="display: flex;">
                                                <a href="javascript:void(0)" onclick="displayUpdate('{{$roomType->id??0}}', 'LastMin')" class="invoice-action-view mr-2"> <i class="material-icons" style="font-size: 20px">edit</i> </a>
                                                <a href="{{route('room-price.history', [$roomType->id, 'LastMin', 1])}}"  class="invoice-action-edit mr-2" > <i class="material-icons" style="font-size: 20px">history</i> </a>
                                                </div>
                                             </td>
                                        </tr>
                                        <!-- Web Rate -->
                                        <tr>
                                            @php
                                                $web = $roomType->web_rate();
                                            @endphp
                                            <td  id="ratename{{$roomType->id}}Web" style="padding: 5px !important; border: 1px solid #D5DBDB  !important;">
                                                Web Rate <br>( Since {{ date('d/m/Y', strtotime($web->created_at??date('Y-m-d'))) }})
                                            </td>
                                            <td id="base_occupancy{{$roomType->id}}Web"  style="padding: 5px !important; border: 1px solid #D5DBDB  !important;">
                                                {{number_format($web->base_occupancy??0.00,$defaultSetting['currency_decimal_place'],'.',',')  }}
                                            </td>
                                            <td  id="extra_person{{$roomType->id}}Web"  style="padding: 5px !important; border: 1px solid #D5DBDB  !important;">
                                                {{number_format($web->extra_person??0.00,$defaultSetting['currency_decimal_place'],'.',',')  }}
                                            </td>
                                            <td  id="extra_bed{{$roomType->id}}Web"  style="padding: 5px !important; border: 1px solid #D5DBDB  !important;">
                                                {{number_format($web->extra_bed??0.00,$defaultSetting['currency_decimal_place'],'.',',')  }}
                                            </td>
                                            <td id="base_occupancy_high{{$roomType->id}}Web"  style="padding: 5px !important; border: 1px solid #D5DBDB  !important;">
                                                {{number_format($web->base_occupancy_high??0.00,$defaultSetting['currency_decimal_place'],'.',',')  }}
                                            </td>
                                            <td id="extra_person_high{{$roomType->id}}Web" s style="padding: 5px !important; border: 1px solid #D5DBDB  !important;">
                                                {{number_format($web->extra_person_high??0.00,$defaultSetting['currency_decimal_place'],'.',',')  }}
                                            </td>
                                            <td  id="extra_bed_high{{$roomType->id}}Web"  tyle="padding: 5px !important; border: 1px solid #D5DBDB  !important;">
                                                {{number_format($web->extra_bed_high??0.00,$defaultSetting['currency_decimal_place'],'.',',')  }}
                                            </td>
                                            <td colspan="3" style="padding: 5px !important; border: 1px solid #D5DBDB  !important; text-align: center;">
                                              <span>Default rates published on web.</span>
                                            </td>

                                             <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; text-align: center;">
                                                <a onclick="otherPolicies('{{$roomType->id??0}}', 'Web', 1, 'add', 'cancel')"  href="javascript:void(0)">Add</a>/<br>
                                                <a onclick="otherPolicies('{{$roomType->id??0}}', 'Web', 1, 'view', 'cancel')"  href="javascript:void(0)">View</a>
                                             </td>
                                            <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; text-align: center;">
                                                <a onclick="otherPolicies('{{$roomType->id??0}}', 'Web', 1, 'add', 'booking')"  href="javascript:void(0)">Add</a>/<br>
                                                <a onclick="otherPolicies('{{$roomType->id??0}}', 'Web', 1, 'view', 'booking')"  href="javascript:void(0)">View</a>
                                             </td>
                                             <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; text-align: center;">
                                                <a onclick="policyWeb('{{$roomType->id??0}}', 'Web')" href="javascript:void(0)">Add</a>/<br>
                                                <a onclick="policyWeb('{{$roomType->id??0}}', 'Web')" href="javascript:void(0)">View</a>
                                             </td>
                                             <td  style="padding: 5px !important; border: 1px solid #D5DBDB  !important; text-align: center;">
                                                <div class="invoice-action" style="display: flex;">
                                                    <a href="javascript:void(0)" onclick="displayUpdate('{{$roomType->id??0}}', 'Web')"  class="invoice-action-view mr-2"> <i class="material-icons" style="font-size: 20px">edit</i> </a>
                                                    <a href="{{route('room-price.history', [$roomType->id, 'Web', 1])}}"   class="invoice-action-edit mr-2" > <i class="material-icons" style="font-size: 20px">history</i> </a>
                                                </div>
                                             </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
         </div>

      </div>
    </div>
  </div>
</div>
@include('pages.roomprice.webpolicy')
@include('pages.roomprice.updaterate')
@include('pages.roomprice.otherpolicy')
@endsection

{{-- vendor script --}}
@section('vendor-script')
<script src="{{asset('vendors/jquery-validation/jquery.validate.min.js')}}"></script>
<script src="{{asset('vendors/select2/select2.full.min.js')}}"></script>
<script src="{{asset('vendors/sweetalert/sweetalert.min.js')}}"></script>
@endsection

{{-- page script --}}
@section('page-script')
<script src="{{asset('js/scripts/form-validation.js')}}"></script>
<script src="{{asset('js/scripts/ui-alerts.js')}}"></script>
<script src="{{asset('js/scripts/form-select2.js')}}"></script>
<script src="{{asset('js/scripts/hoteratus.js')}}"></script>
<script>

   var contactComposeSidebar = $(".contact-compose-sidebar.web")
   var rateComposeSidebar = $(".contact-compose-sidebar.rate")
    var otherComposeSidebar = $(".contact-compose-sidebar.other")
   $(".contact-sidebar-trigger").on("click", function () {
      contactComposeSidebar.addClass("show");
   });
   $(".closemodal").on("click", function () {
      contactComposeSidebar.removeClass("show");
      rateComposeSidebar.removeClass("show");
      otherComposeSidebar.removeClass("show");
   });
    $("#web_policy_type_id").on("charge", function () {
   });

   function saveOther(){
        $(".loader").show();
        $.ajax({
            type: "post",
            url: "{{ url('room-prices/saveroompricepolicies')}}",
            data: $('#otherdata').serialize(),
            success: function (response) {
                if(response.success){
                    message(response.message, ($('#othertype').val()+$('#otherid').val()) );
                    otherComposeSidebar.removeClass("show");
                    console.log(response);
                }else{
                    swal(response.message, {
                        title: 'Room Type',
                        icon: "error",
                    });
                }
                 $(".loader").hide();

            },
            error: function (errors) {
                $(".loader").hide();
            }
        });

   }
   function removePolicy(id){
        $(".loader").show();
        $.ajax({
            type: "post",
            url: "{{ url('room-prices/deleteroompricepolicies')}}",
            data: $('#otherdata').serialize()+"&policyid="+id,
            success: function (response) {
                console.log(response)
                if(response.success){
                    swal(response.message, {
                    title: 'Room Type',
                    icon: "success",
                    });
                    $('#policyid'+id).remove();
                }
                $(".loader").hide();
            },
            error: function (errors) {
                $(".loader").hide();
            }
        });

   }
   function otherPolicies(roomId, category, categoryid, option, type){
        $('#othercategory').val(category);
        $('#othercategoryid').val(categoryid);
        $('#otherroomtypeid').val(roomId);
        $('#otheroption').val(option);
        $('#othertype').val(type);
        $('#otherid').val(0);
        $('#policies tbody').html('');
        $(".loader").show();
        $.ajax({
            type: "post",
            url: "{{ url('room-prices/roompricepolicies')}}",
            data: $('#otherdata').serialize(),
            success: function (response) {
                if(response.success){
                    $('#otherid').val(response.data.id);
                    $('#Titleother').html(response.data.rateheader);
                    response.data.policies.forEach(element => {
                        if(option == 'add'){
                            $('#policies tbody').append('<tr><td><input style="opacity:1; pointer-events: all;  position: relative;"  name="policyid[]"  value="'+element.id+'"  type="checkbox" ></td><td>'+element.name+'</td><td>'+element.description+'</td></tr>');
                        }else{
                            $('#policies tbody').append('<tr id="policyid'+element.id+'"><td></td><td>'+element.name+'</td><td>'+element.description+'</td><td><a onclick="removePolicy('+element.id+')"  href="javascript:void(0)" ><i class="material-icons" style="font-size: 20px">delete</i></a></td></tr>');
                        }
                    });
                    if(option == 'add'){
                        $("#savebutton").show();
                        $(".action").hide();

                    }else{
                        $("#savebutton").hide();
                        $(".action").show();
                    }

                    otherComposeSidebar.addClass("show");
                }else{
                    swal(response.message, {
                    title: 'Room Type',
                    icon: "error",
                    });
                }
                $(".loader").hide();
            },
            error: function (errors) {
                $(".loader").hide();
            }
        });
   }
   function displayUpdate(id,type, categoryid=0){
        $(".loader").show();
        $.ajax({
            type: "post",
            url: "{{ url('roomprice')}}",
            data: {id: id, _token: $("input[name*='token']").val(), type: type, categoryid: categoryid},
            success: function (response) {
                if(response.success ){
                    if(response.data){
                        $("#base_occupancy").val(response.data.base_occupancy);
                        $("#extra_person").val(response.data.extra_person);
                        $("#extra_bed").val(response.data.extra_bed);
                        $("#base_occupancy_high").val(response.data.base_occupancy_high);
                        $("#extra_person_high").val(response.data.extra_person_high);
                        $("#extra_bed_high").val(response.data.extra_bed_high);
                        $("#web").attr('checked', response.data.web==1);
                        $("#agent").attr('checked', response.data.agent==1);
                        $("#corp").attr('checked', response.data.corp==1);
                    }else{
                        $("#base_occupancy").val(0);
                        $("#extra_person").val(0);
                        $("#extra_bed").val(0);
                        $("#base_occupancy_high").val(0);
                        $("#extra_person_high").val(0);
                        $("#extra_bed_high").val(0);
                        $("#web").attr('checked', false);
                        $("#agent").attr('checked', false);
                        $("#corp").attr('checked', false);
                    }
                    $("#headertitle").html($("#ratename"+id+type).html());
                    $("#category").val( type);
                    $("#RateTypeId").val( id);
                    $("#categoryid").val( categoryid);
                    console.log(type,categoryid,id );

                    if(type=='LastMin' || type=='Web' ){
                        $(".publishon").hide();
                    }else{
                        $(".publishon").show();
                    }
                    rateComposeSidebar.addClass("show");
                }
                $(".loader").hide();
            },
            error: function (errors) {

                console.log(errors)
                 $(".loader").hide();
            }
        });
   }
   function optional(){

          if($("#web_policy_type_id").val() == '1'){
            $(".optional").show();
            $("#deposit_type1").attr('checked', 'checked');
        }else{
            $(".optional").hide();
        }
   }
   function depositType(type) {
        if (type == 1){
            $(".deposit").show();
        }  else{
              $(".deposit").hide();
        }
   }
   function policyWeb(id, type, categoryid =0){
       $("#deposit_amount").val(0);
        $(".loader").show();
        $.ajax({
            type: "post",
            url: "{{ url('roomprice')}}",
            data: {id: id, _token: $("input[name*='token']").val(), type: type, categoryid: categoryid},
            success: function (response) {
                console.log(response)
                if(response.success ){

                    if(response.data){
                        $("#web_policy_type_id").val(response.data.web_policy_type_id.toString());
                        if(response.data.web_policy_type_id == 1){
                            $(".optional").show();
                            depositType(response.data.deposit_type);
                            $("#deposit_type"+response.data.deposit_type).attr('checked', 'checked');
                            $("#value_type"+response.data.deposit_type).attr('checked', 'checked');
                            $("#deposit_amount").val(response.data.deposit_amount)
                        }else{
                            $(".optional").hide();
                        }
                        $("#webid").val(response.data.id)
                    }else{
                        $("#web_policy_type_id").val(1);
                            $(".optional").show();
                            depositType(1);
                             $("#deposit_type1").attr('checked', 'checked');
                            $("#value_type1").attr('checked', 'checked');
                    }



                    contactComposeSidebar.addClass("show");
                }
                $(".loader").hide();
            },
            error: function (errors) {

                console.log(errors)
                 $(".loader").hide();
            }
        })

   }
   function saveWeb(){
       $(".loader").show();
       $.ajax({
           type: "post",
           url: "{{ url('saveroomtypeweb')}}",
           data: $("#webdata").serialize(),
           success: function (response) {
                contactComposeSidebar.removeClass("show");
                if(response.success){
                    swal("Web policy has been updated!", {
                        icon: "success",
                    });
                }else{
                    swal(response.message, {
                        icon: "error",
                    });
                }
                $(".loader").hide();
           },
           error: function (params) {
                $(".loader").hide();
           }
       });
   }
   function saveRate(){
    var id = $("#RateTypeId").val();
    var sufix = $("#category").val();
    $(".loader").show();
       $.ajax({
           type: "post",
           url: "{{ url('saveroomprice')}}",
           data: $("#updaterate").serialize(),
           success: function (response) {
              console.log(response);
              if(response.success){

                $("#ratename"+id+sufix).html(response.data.ratename);
                $("#base_occupancy"+id+sufix).html(response.data.base_occupancy);
                $("#extra_person"+id+sufix).html(response.data.extra_person);
                $("#extra_bed"+id+sufix).html(response.data.extra_bed);
                $("#base_occupancy_high"+id+sufix).html(response.data.base_occupancy_high);
                $("#extra_person_high"+id+sufix).html(response.data.extra_person_high);
                $("#extra_bed_high"+id+sufix).html(response.data.extra_bed_high);
                $("#web"+id+sufix).attr('checked', response.data.web==1);
                $("#agent"+id+sufix).attr('checked', response.data.agent==1);
                $("#corp"+id+sufix).attr('checked', response.data.corp==1);
                 rateComposeSidebar.removeClass("show");
              }
                $(".loader").hide();

           },
           error: function (params) {
                $(".loader").hide();
           }
       });
   }

   function message(text,id){
       $("#messages").append('<div id="message'+id+'" class="card-alert card gradient-45deg-green-teal">' +
                                '<div class="card-content white-text">' +
                                    '<p>'+text+'</p>'+
                                '</div>'+
                                '<button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">'+
                                '<span aria-hidden="true">×</span>'+
                                '</button>'+
                            '</div>');
        setTimeout(() => {
            $('#message'+id).remove()
        }, 5000);
   }
</script>
@endsection

