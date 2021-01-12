@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', "Department [$department->name]")
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
                        <h5 class="center-align" style="font-weight: 900;">Department</h5>
                        {{$department->name}}
                    </div>

                </div>
            </div>
            <div  style="margin-bottom: 20px;" >
                <div class="row"></div>
                <div id="details">
                    <div class="row">
                        <div class="input-field col s8">
                            <label for="name">Department Name*</label>
                            <input type="text" value="{{old('name',$department->name)}}" readonly>
                        </div>
                        <div class="input-field col s3">
                            <label for="code">Code*</label>
                            <input type="text" value="{{old('code',$department->code)}}" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="description">Description*</label>
                            <textarea readonly class="materialize-textarea"  type="text" >{{old('description',$department->description)}}</textarea>
                        </div>
                    </div>

                </div>
                <div class="row s12 right">
                    <a href="{{ route('departments.index') }}" class="mb-6 btn waves-effect waves-light gradient-45deg-purple-deep-orange">Return</a>
                </div>
            </div>
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
