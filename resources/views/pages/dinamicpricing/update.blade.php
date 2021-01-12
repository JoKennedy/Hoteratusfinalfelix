@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Update Dynamic Pricing ')
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
                        <h5 class="center-align" style="font-weight: 900;">Dynamic Pricing </h5>
                        <p>{{$dicountDynamicPricing->name}}</p>
                    </div>
                </div>
            </div>

            <form  class="formValidate" action="{{ route('dynamic-pricing.update', $dicountDynamicPricing) }}" style="margin-bottom: 20px;" id="formSubmit" method="POST">
                @csrf
                @method('PUT')
                <div class="row"></div>
                <div id="details">
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="name">dynamic-pricing Discount Name*</label>
                            <input name="name" type="text" value="{{old('name', $dicountDynamicPricing->name)}}" required>
                            @error('name')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <span>Discounts*</span>
                    </div>
                    <table id="discountlist">
                        <thead>
                            <tr>
                                <th colspan="2" style="text-align:center; padding: 5px; color:black; font-weight: 900;">Occupancy</th>
                                <th style="text-align:center; padding: 5px;"></th>
                                <th colspan="2" style="text-align:center; padding: 5px; color:black; font-weight: 900;">Discount applied %</th>
                                <th></th>
                            </tr>
                            <tr>
                                <th style="text-align:center; padding: 5px; color:black; font-weight: 900;">From</th>
                                <th style="text-align:center; padding: 5px; color:black; font-weight: 900;">To</th>
                                <th style="text-align:center; padding: 5px;"></th>
                                <th style="text-align:center; padding: 5px; color:black; font-weight: 900;">From</th>
                                <th style="text-align:center; padding: 5px; color:black; font-weight: 900;">To</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dicountDynamicPricing->discount_dynamic_pricing_details as $key => $item )
                                <tr>
                                    <td style="text-align:center; padding: 5px;"><input  value="{{$item->start_occupancy}}" style="text-align: center;"  onkeypress="return isNumberKey(event)"  name="start_occupancy[]" type="text"  required> </td>
                                    <td style="text-align:center; padding: 5px;"><input  value="{{$item->end_occupancy}}" style="text-align: center;" onkeypress="return isNumberKey(event)"  name="end_occupancy[]" type="text"  required> </td>
                                    <td style="text-align:center; padding: 5px;"></td>
                                    <td style="text-align:center; padding: 5px;"><input value="{{$item->start_percentage}}" style="text-align: center;"  onkeypress="return isNumberKey(event)"  name="start_percentage[]" type="text"  required> </td>
                                    <td style="text-align:center; padding: 5px;"><input value="{{$item->end_percentage}}"  style="text-align: center;" onkeypress="return isNumberKey(event)"  name="end_percentage[]" type="text"  required> </td>
                                    <td>
                                        @if ($key >0)
                                            <a onclick="DeleteLine(this)" href="javascript:void(0)"><i class="material-icons">delete_forever</i></a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="row right">
                        <a onclick="AddLine()" href="javascript:void(0)">Add More</a>
                    </div>
                    <br> <br>
                </div>
                <div class="row s12 right">
                    <button type="submit" class="mb-6 btn waves-effect waves-light gradient-45deg-green-teal" >Update </button>
                    <a href="{{ route('dynamic-pricing.index') }}" class="mb-6 btn waves-effect waves-light gradient-45deg-purple-deep-orange">Cancel</a>
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

    function AddLine(){
        var tr =  '<tr>'
            tr += '<td style="text-align:center; padding: 5px;"><input style="text-align: center;"  onkeypress="return isNumberKey(event)"  name="start_occupancy[]" type="text"  required> </td>';
            tr += '<td style="text-align:center; padding: 5px;"><input  style="text-align: center;" onkeypress="return isNumberKey(event)"  name="end_occupancy[]" type="text"  required> </td>';
            tr += '<td style="text-align:center; padding: 5px;"></td>';
            tr += '<td style="text-align:center; padding: 5px;"><input style="text-align: center;"  onkeypress="return isNumberKey(event)"  name="start_percentage[]" type="text"  required> </td>';
            tr += '<td style="text-align:center; padding: 5px;"><input  style="text-align: center;" onkeypress="return isNumberKey(event)"  name="end_percentage[]" type="text"  required> </td>';
            tr += '<td> <a onclick="DeleteLine(this)" href="javascript:void(0)"><i class="material-icons">delete_forever</i></a></td>';
            tr += '</tr>'
        $("#discountlist tbody").append(tr);
    }
    function DeleteLine(obj){
        $(obj).parent().parent().remove();
    }
</script>
@endsection
