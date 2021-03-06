@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Phone Extension')
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
                        <h5 class="center-align" style="font-weight: 900;">Phone Extension</h5>
                        <p>{{$phoneExtension->extension_number}}</p>
                    </div>

                </div>
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
            <form  class="formValidate" style="margin-bottom: 20px;" id="formSubmit" method="POST">

                <div class="row s12 right">
                    <a href="{{ route('phone-extensions.index') }}" class="mb-6 btn waves-effect waves-light gradient-45deg-purple-deep-orange">Phone Extension List</a>
                </div>
                <div class="row"></div>
                <div id="details">
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="extension_number">Phone Extension*</label>
                            <input name="extension_number" type="text" value="{{old('extension_number', $phoneExtension->extension_number)}}" readonly>
                            @error('extension_number')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                    </div>
                     <div class="row">
                        <div class="col s6">
                            <label for="room_id">Room</label>
                            <div class="input-field">
                                <select  name="room_id" value="{{old('room_id', $phoneExtension->room_id)}}"  >
                                    @foreach ($rooms as $room)
                                        @if ($room->id == $phoneExtension->room_id)
                                            <option >{{$room->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col s6">
                            <label for="property_department_id">Department</label>
                            <div class="input-field">
                                <select  >
                                    @foreach ($property_departments as $department)
                                        @if ($department->id ==  $phoneExtension->property_department_id)
                                            <option >{{$department->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="title">Title</label>
                            <textarea class="materialize-textarea" readonly name="title" type="text" >{{ $phoneExtension->title}}</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="comments">Commets</label>
                            <textarea class="materialize-textarea" readonly name="comments" type="text" >{{$phoneExtension->comments}}</textarea>

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
