@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Amenity')
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
                        <h5 class="center-align" style="font-weight: 900;">Amenity</h5>
                        <p>{{$amenity['name']}}</p>
                    </div>

                </div>
                 @if(Session::has('message_success'))
                    <div class="row">
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

            <form enctype="multipart/form-data" class="formValidate" style="margin-bottom: 20px;" id="formSubmit" method="POST">

                <div class="row s12 right">
                    <a href="{{ route('amenities.index') }}" class="mb-6 btn waves-effect waves-light gradient-45deg-purple-deep-orange">Amenity List</a>
                </div>
                <div class="row"></div>
                <div id="details">
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="name">Amenities*</label>
                            <input name="name" type="text" value="{{old('name', $amenity['name'])}}" readonly>
                            @error('name')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        @foreach ($amenity->images as $image )
                        <div class="row" class="file-path-wrapper">
                           <div class="col s9"><span> {{$image->url}} </span></div>
                           <div class="invoice-action col s3" style="display: flex;">
                           <a href="{{ $image->get_image }}" target="_blank" class="invoice-action-view mr-12"> <i class="material-icons">remove_red_eye</i> </a>
                           </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="description">Description</label>
                            <textarea class="materialize-textarea"  name="description" type="text" readonly>{{old('description', $amenity['description'])}}</textarea>
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
<script src="{{asset('vendors/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('vendors/jquery-validation/jquery.validate.min.js')}}"></script>
@endsection

