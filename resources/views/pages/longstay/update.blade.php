@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Update Long Stay')
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
                        <h5 class="center-align" style="font-weight: 900;">Long Stay</h5>
                        <p>{{$discountLongStay->name}}</p>
                    </div>
                </div>
            </div>

            <form  class="formValidate" action="{{ route('long-stay-discount.update',$discountLongStay) }}" style="margin-bottom: 20px;" id="formSubmit" method="POST">
                @csrf
                @method('PUT')
                <div class="row"></div>
                <div id="details">
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="name">Long Stay Discount Name*</label>
                            <input name="name" type="text" value="{{old('name',$discountLongStay->name)}}" required>
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
                            <input onkeypress="return isNumberKey(event)"  name="min_stay" type="text" value="{{old('min_stay',$discountLongStay->min_stay)}}" required>
                            @error('min_stay')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                        <div class="input-field col s2"><br><span>Night(s)</span></div>
                    </div>
                    <div class="row">
                        <div class="input-field col s2"><br><span id="type_id">*{{old('discount_type',$discountLongStay->discount_type) ==1? 'Get next':'Get'}}</span></div>
                        <div class="input-field col s2">

                            <input onkeypress="return isNumberKey(event)"  name="value" type="text"
                            value="{{old('discount_type',$discountLongStay->discount_type) ==1?number_format(old('value',$discountLongStay->value),0) :number_format(old('value',$discountLongStay->value),2) }}" required>
                            @error('value')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                        <div class="input-field col s4">
                            <select onchange="discount()" name="discount_type" id="discount_type" value="{{old('discount_type',$discountLongStay->discount_type)}}">
                                <option {{old('discount_type',$discountLongStay->discount_type) ==1? 'selected':''}} value="1">Night(s) Free</option>
                                <option {{old('discount_type',$discountLongStay->discount_type) ==2? 'selected':''}} value="2">Percent Discount</option>
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
                    <button type="submit" class="mb-6 btn waves-effect waves-light gradient-45deg-green-teal" >Update </button>
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
