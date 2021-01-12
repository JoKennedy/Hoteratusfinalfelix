@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Create a new Long Stay')
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
                        <h5 class="center-align" style="font-weight: 900;">Create a New Long Stay</h5>
                    </div>
                </div>
            </div>

            <form  class="formValidate" action="{{ route('long-stay-discount.store') }}" style="margin-bottom: 20px;" id="formSubmit" method="POST">
                @csrf

                <div class="row"></div>
                <div id="details">
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="name">Long Stay Discount Name*</label>
                            <input name="name" type="text" value="{{old('name')}}" required>
                            @error('name')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s2">
                            <label for="name">For Stay of*</label>
                            <input onkeypress="return isNumberKey(event)"  name="min_stay" type="text" value="{{old('min_stay',0)}}" required>
                            @error('min_stay')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                        <div class="input-field col s2"><br><span>Night(s)</span></div>
                    </div>
                    <div class="row">
                        <div class="input-field col s2"><br><span id="type_id">*Get next</span></div>
                        <div class="input-field col s2">

                            <input onkeypress="return isNumberKey(event)"  name="value" type="text" value="{{old('value',0)}}" required>
                            @error('value')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                        <div class="input-field col s4">
                            <select onchange="discount()" name="discount_type" id="discount_type">
                                <option value="1">Night(s) Free</option>
                                <option value="2">Percent Discount</option>
                            </select>
                            @error('discount_type')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row s12 right">
                    <button type="submit" class="mb-6 btn waves-effect waves-light gradient-45deg-green-teal" >Save </button>
                    <a href="{{ route('long-stay-discount.index') }}" class="mb-6 btn waves-effect waves-light gradient-45deg-purple-deep-orange">Cancel</a>
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
<script>

    function discount(){

        if($("#discount_type").val() == 1){
            $("#type_id").html('*Get next')
        }else{
            $("#type_id").html('*Get')
        }
    }

</script>
@endsection
