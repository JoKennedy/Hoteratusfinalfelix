@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title',"block [$block->name]")
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
                        <h5 class="center-align" style="font-weight: 900;">Block</h5>
                        <p>{{$block['name']}}</p>
                    </div>
                </div>
            </div>

            <form  class="formValidate" style="margin-bottom: 20px;" id="formSubmit" method="POST">

                <div class="row s12 right">
                    <a href="{{ route('blocks.index') }}" class="mb-6 btn waves-effect waves-light gradient-45deg-purple-deep-orange">Block List</a>
                </div>
                <div class="row"></div>
                <div id="details">
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="name">Block Name</label>
                            <input name="name" type="text" value="{{old('name' , $block['name'])}}" required readonly>
                            @error('name')
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

