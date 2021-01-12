@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Sort Rooms')
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

      <div id="validations" class="card card-tabs" >

        <div class="card-content" style="padding: 0px !important;">
            <div class="card-title">
                <div class="row center">
                    <div class="col s12">
                        <h5 class="center-align" style="font-weight: 900;">Sort Rooms</h5>
                    </div>

                </div>
            </div>
        </div>
         <form enctype="multipart/form-data"  class="formValidate" action="{{ route('sort-rooms.store') }}" style="margin-bottom: 20px; padding:0px 15px;" id="formSubmit" method="POST">
            @csrf
            <div class="row right">
                    <button type="submit" class="mb-6 btn waves-effect waves-light gradient-45deg-green-teal" >Update </button>
                    <a href="{{ route('room-types.index') }}" class="mb-6 btn waves-effect waves-light gradient-45deg-purple-deep-orange">Cancel</a>
            </div>
            @php
                $roomType ='';
            @endphp

            <table class="table">
                @foreach ($rooms as $room)
                    @if ($roomType != $room->room_type->name)
                        @php $roomType =$room->room_type->name @endphp
                        <thead style="background-color: #7DCEA0 ; display: table-header-group; vertical-align: middle; border-color: inherit; color:black;">
                            <tr><th style="padding: 10px 5px !important;">{{$roomType}}</th><th style="padding: 10px 5px !important;">Sort Order</th></tr>
                        </thead>
                    @endif
                    <tr >
                        <td style="padding: 0px 10px !important; width: 80%;">{{$room->name}}</td>
                        <td style="padding: 0px 10px !important;"><input name="sort[{{$room->id}}]" class="col s4 text-center" type="number" value="{{$room->sort_order}}" /></td>
                    </tr>
                @endforeach
            </table>
                <div style="bottom: 50px; right: 19px;" class="fixed-action-btn direction-top"><a class="btn-floating btn-large gradient-45deg-green-teal gradient-shadow"><i class="material-icons">settings_applications</i></a>
                    <ul>
                        <li><button type="submit" class="btn-floating blue" style="opacity: 0; transform: scale(0.4) translateY(40px) translateX(0px);"><i class="material-icons">save</i></button>
                        </li>
                    </ul>
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
<script src="{{asset('vendors/select2/select2.full.min.js')}}"></script>
@endsection

{{-- page script --}}
@section('page-script')
<script src="{{asset('js/scripts/form-validation.js')}}"></script>
<script src="{{asset('js/scripts/ui-alerts.js')}}"></script>
<script src="{{asset('js/scripts/form-select2.js')}}"></script>
<script src="{{asset('js/scripts/hoteratus.js')}}"></script>

@endsection

