@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Create a new Category')
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
                        <h5 class="center-align" style="font-weight: 900;">Create a New Category</h5>
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

            <form enctype="multipart/form-data" class="formValidate" action="{{ route('developers.store-category') }}" style="margin-bottom: 20px;" id="formSubmit" method="POST">
                @csrf

                <div class="row"></div>
                <div id="details">
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="name">Name</label>
                            <input name="category[name]" type="text" value="{{old('category.name')}}" required>
                            @error('category.name')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <label for="description">Description</label>
                            <textarea class="materialize-textarea"  name="category[description]" type="text" required>{{old('category.description')}}</textarea>
                            @error('category.description')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                    </div>
                    
                </div>

                <div class="row s12 right">
                   <button type="submit" class="mb-6 btn waves-effect waves-light gradient-45deg-green-teal" >Save </button>
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
