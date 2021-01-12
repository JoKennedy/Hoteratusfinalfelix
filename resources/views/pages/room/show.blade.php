@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title',"Room $room->name")
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
                        <h5 class="center-align" style="font-weight: 900;">Room</h5>
                        <p>{{$room->name}}</p>
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
                    <a href="{{ route('rooms.index') }}" class="mb-6 btn waves-effect waves-light gradient-45deg-purple-deep-orange">Room List</a>
                </div>
                <div class="row"></div>
                <div id="details">
                    <div class="row">
                        <div class="input-field col s8">
                            <label for="name">Room Name*</label>
                            <input name="name" type="text" value="{{old('name', $room->name)}}" readonly>
                            @error('name')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                        <div class="input-field col s4">
                            <label for="code">Room Code*</label>
                            <input name="code" type="text" value="{{old('code', $room['code'])}}" readonly>
                            @error('code')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <label for="room_type_id">Room Type*</label>
                            <div class="input-field">
                                <select  name="room_type_id" value="{{old('room_type_id',$room['room_type_id']??'')}}" required >
                                    @foreach ($roomtypes as $roomtype)
                                    @if ($roomtype->id == $room['room_type_id'])
                                         <option selected >{{$roomtype->name}}</option>
                                    @endif

                                    @endforeach
                                </select>
                                @error('room_type_id')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <label for="room_type_id">Floor</label>
                            <div class="input-field">
                                <select   >
                                    @foreach ($floors as $floor)
                                    @if ($floor->id == $room['floor_id'])
                                          <option selected >{{$floor->name}}</option>
                                    @endif

                                    @endforeach
                                </select>
                                @error('floor_id')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <label for="room_type_id">Block</label>
                            <div class="input-field">
                                <select  >

                                    @foreach ($blocks as $block)
                                    @if ($block->id == $room['block_id'])
                                        <option selected>{{$block->name}}</option>

                                    @endif
                                    @endforeach
                                </select>
                                @error('block_id')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                            </div>
                        </div>
                    </div>
                      <div class="row">
                        <div class="input-field col s12">
                            <label for="description">Description</label>
                            <textarea readonly class="materialize-textarea" name="description">{{old('description', $room->description)}}</textarea>
                            @error('description')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
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
<script>
    function returnaqui(){
        $(".formValidate").append('<input name="return" value="1" />');
    }
</script>
@endsection
