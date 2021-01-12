@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Room Price List')
{{-- vendor style --}}
@section('vendor-style')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/jquery.dataTables.min.css')}}">
<link rel="stylesheet" type="text/css"
  href="{{asset('vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/dataTables.checkboxes.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-sidebar.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-contacts.css')}}">

@endsection

@section('page-style')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-invoice.css')}}">
@endsection

{{-- page content --}}
@section('content')

<div class="section">
  <div class="row" >
    <div class="col s12">

      <div id="validations" class="card card-tabs" >
        @csrf
        <div class="card-content" style="padding: 0px !important;">
            <div class="card-title">
                <div class="row center">
                    <div class="col s9">
                        <h5 class="left-align" style="font-weight: 900;">{{$roomType->name}} Room Price List</h5>
                    </div>
                    <div class="col s3" style="margin-top: 10px !important;">
                        <a href="{{ route('room-prices.index') }}" class="right-align mb-6 btn waves-effect waves-light gradient-45deg-purple-deep-orange">Back</a>
                    </div>
                </div>

            </div>
            <div class="row ml-1">
                <h6 >{!!$ratename!!}</h6>
            </div>
        </div>
         <div id="roomlist" style="font-size: .7em;">
            <table class="table invoice-data-table" >
                <thead style="background-color: #F8F9F9; display: table-header-group; vertical-align: middle; border-color: inherit; color:black;">
                    <tr style="border: 1px solid #F4F6F6 ">
                        <th colspan="3" style="text-align: center; width: 25%; padding: 0px !important; border: 1px solid #D5DBDB  !important;">Low Weekdays</th>
                        <th colspan="3" style="text-align: center; width: 25%; padding: 0px !important; border: 1px solid #D5DBDB  !important;">High Weekdays</th>
                        <th colspan="8"  style="width: 35%; padding: 0px !important; border: 1px solid #D5DBDB  !important;"></th>
                    </tr>
                </thead>
                    <thead style="background-color: #AAB7B8; display: table-header-group; vertical-align: middle; border-color: inherit; color:black;">
                    <tr style="border: 1px solid #F4F6F6 ">
                        <th rowspan="2"  style="text-align: center;  padding: 0px !important; border: 1px solid #D5DBDB  !important;"> Base Occupancy</th>
                        <th rowspan="2" style="text-align: center;  padding: 0px !important; border: 1px solid #D5DBDB  !important;"> Extra Person</th>
                        <th rowspan="2"  style="text-align: center;  padding: 0px !important; border: 1px solid #D5DBDB  !important;"> Extra Bed </th>
                        <th rowspan="2"  style="text-align: center;  padding: 0px !important; border: 1px solid #D5DBDB  !important;"> Base Occupancy</th>
                        <th rowspan="2" style="text-align: center;  padding: 0px !important; border: 1px solid #D5DBDB  !important;"> Extra Person</th>
                        <th rowspan="2"  style="text-align: center;  padding: 0px !important; border: 1px solid #D5DBDB  !important;"> Extra Bed </th>
                        <th colspan="3"  style="text-align: center;  padding: 0px !important; border: 1px solid #D5DBDB  !important;"> Publish On</th>
                        <th rowspan="2" style="text-align: center;  padding: 0px !important; border: 1px solid #D5DBDB  !important;">Web Policy </th>
                        <th rowspan="2" style="text-align: center;  padding: 0px !important; border: 1px solid #D5DBDB  !important;"> Create by </th>
                        <th rowspan="2" style="text-align: center;  padding: 0px !important; border: 1px solid #D5DBDB  !important;"> Create on </th>
                    </tr>
                    <tr>
                        <th align="left" style="text-align: center;  padding: 0px !important; border: 1px solid #D5DBDB  !important;"> Cxncl </th>
                        <th align="left" style="text-align: center;  padding: 0px !important; border: 1px solid #D5DBDB  !important;"> Booking </th>
                        <th align="left" style="text-align: center;  padding: 0px !important; border: 1px solid #D5DBDB  !important;"> Web </th>
                    </tr>
                </thead>


            </table>
         </div>

      </div>
    </div>
  </div>
</div>

@endsection

{{-- vendor script --}}
@section('vendor-script')
<script src="{{asset('vendors/jquery-validation/jquery.validate.min.js')}}"></script>
<script src="{{asset('vendors/data-tables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('vendors/data-tables/js/datatables.checkboxes.min.js')}}"></script>
<script src="{{asset('vendors/select2/select2.full.min.js')}}"></script>
<script src="{{asset('vendors/sweetalert/sweetalert.min.js')}}"></script>
@endsection

{{-- page script --}}
@section('page-script')
<script src="{{asset('js/scripts/form-validation.js')}}"></script>
<script src="{{asset('js/scripts/ui-alerts.js')}}"></script>
<script src="{{asset('js/scripts/form-select2.js')}}"></script>
<script src="{{asset('js/scripts/hoteratus.js')}}"></script>
<script >

    function fetch_data( active = '') {

       $(".invoice-data-table").DataTable({
            "processing": true,
            serverSide: true,
            bAutoWidth: false,
            aaSorting: [],
        "ajax": {
            "url":  "{{ $url }}",
        },
        columns: [
            {data: 'base_occupancy'},
            {data: 'extra_person'},
            {data: 'extra_bed'},
            {data: 'base_occupancy_high'},
            {data: 'extra_person_high'},
            {data: 'extra_bed_high'},
            {data: 'web'},
            {data: 'corp'},
            {data: 'agent'},
            {data: 'webpolicy'},
            {data: 'createby'},
            {data: 'createon'},

        ],
        "searching": false,
         "bLengthChange": false,

        order: [1, 'asc'],

        responsive: {
            details: {
            type: "column",
            target: 0
            }
        }
        });
    }
    $(document).ready( function () {
        fetch_data();
    } );
</script>
@endsection

