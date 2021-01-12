@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Update Cancellation Policy')
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
                        <h5 class="center-align" style="font-weight: 900;">Cancellation Policy</h5>
                        <p>{{$cancellationPolicy->name}}</p>
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

            <form  class="formValidate" action="{{ route('cancellation-policy.update', $cancellationPolicy) }}" style="margin-bottom: 20px;" id="formSubmit" method="POST">
                @csrf
                @method('PUT')
                <div class="row s12 right">
                    <button type="submit" class="mb-6 btn waves-effect waves-light gradient-45deg-green-teal" >Update </button>
                    <a href="{{ route('cancellation-policy.index') }}" class="mb-6 btn waves-effect waves-light gradient-45deg-purple-deep-orange">Return</a>
                </div>
                <div class="row"></div>
                <div id="details">
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="name">Cancellation Policy Title*</label>
                            <input name="name" type="text" value="{{old('name', $cancellationPolicy->name)}}" required>
                            @error('name')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <h6 class="ml-1">Before check in </h6>
                        <div class="input-field col s1">
                            <input onkeypress="return isNumberKey(event)" value="{{old('before',$cancellationPolicy->before)}}" id="before" name="before"  type="text" >
                             @error('before')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                        <div class="input-field col s2">
                            <label>
                                <input   value="1" name="before_type" type="radio" {{old('before_type',$cancellationPolicy->before_type) == 1? 'checked': ''}}   />
                                <span>Day(s)</span>
                            </label>
                        </div>
                        <div class="input-field col s2">
                            <label>
                                <input value="2" name="before_type"  type="radio" {{old('before_type',$cancellationPolicy->before_type) == 2? 'checked' : ''}}   />
                                <span>Hour(s)</span>
                            </label>
                            @error('before_type[0]')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <h6 class="ml-1">Charge</h6>
                        <div class="input-field col s1">
                            <input value="{{old('charge',$cancellationPolicy->charge)}}"  onkeypress="return isNumberKey(event)" id="charge" name="charge"  type="text" required>
                             @error('charge')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                        <div class="input-field col s2">
                            <label>
                                <input  value="1" name="charge_type_id" type="radio" {{old('charge_type_id',$cancellationPolicy->charge_type_id) == 1? 'checked' : ''}}  />
                                <span>% of booking</span>
                            </label>
                        </div>
                        <div class="input-field col s1">
                            <label>
                                <input value="2" name="charge_type_id"  type="radio" {{old('charge_type_id',$cancellationPolicy->charge_type_id) == 2? 'checked' : ''}}  />
                                <span>$</span>
                            </label>
                        </div>
                        <div class="input-field col s2">
                            <label>
                                <input value="3" name="charge_type_id"  type="radio" {{old('charge_type_id',$cancellationPolicy->charge_type_id) == 3? 'checked' : ''}} />
                                <span>Room Night(s)</span>
                            </label>
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
<script src="{{asset('js/scripts/hoteratus.js')}}"></script>
@endsection
