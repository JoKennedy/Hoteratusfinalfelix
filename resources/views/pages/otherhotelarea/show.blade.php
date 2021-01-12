@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Other Hotel Area')
{{-- vendor style --}}
@section('vendor-style')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/flag-icon/css/flag-icon.min.css')}}">
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
                        <h5 class="center-align" style="font-weight: 900;">Other Hotel Area</h5>
                        <p>{{$otherHotelArea['name']}}</p>
                    </div>
                        @if(Session::has('message_success'))
                         <div >
                            <div class="card-alert card gradient-45deg-green-teal">
                                <div class="card-content white-text">
                                    <p>
                                    <i class="material-icons">check</i> {{Session::get('message_success') }}.
                                    </p>
                                </div>
                                <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                                </button>
                            </div>
                         </div>
                        @endif
                </div>
            </div>

            <form  class="formValidate"  style="margin-bottom: 20px;" id="formSubmit" method="POST">

                <div class="row s12 right">
                    <a href="{{ route('other-hotel-area.index') }}" class="mb-6 btn waves-effect waves-light gradient-45deg-purple-deep-orange">Other Hotel Area List</a>
                </div>
                <div class="row"></div>
                <div id="details">
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="name">Other Hotel Area Name*</label>
                            <input name="name" type="text" value="{{$otherHotelArea->name}}" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <label for="room_type_id">Floor</label>
                            <div class="input-field">
                                <select   name="floor_id" value="{{old('floor_id',$otherHotelArea->floor_id)}}"  >
                                    @foreach ($floors as $floor)
                                    @if ($floor->id == $otherHotelArea->floor_id)
                                        <option>{{$floor->name}}</option>
                                    @endif
                                    @endforeach
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <label for="room_type_id">Block</label>
                            <div class="input-field">
                                <select  name="block_id" value="{{old('block_id',$otherHotelArea->block_id)}}" >
                                    @foreach ($blocks as $block)
                                    @if ($block->id == $otherHotelArea->block_id)
                                        <option >{{$block->name}}</option>
                                    @endif

                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="description">Description*</label>
                            <textarea readonly class="materialize-textarea" name="description">{{ $otherHotelArea->description}}</textarea>
                        </div>
                    </div>
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
