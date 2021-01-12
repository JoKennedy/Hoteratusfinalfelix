@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Create a new Special Period')
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
                        <h5 class="center-align" style="font-weight: 900;">Create a New Special Period</h5>
                    </div>

                </div>
            </div>

            @if(isset($message_error))
                <div >
                <div class="card-alert card red accent-4">
                    <div class="card-content white-text">
                        <p>
                        <i class="material-icons">error</i> {{$message_error}}.
                        </p>
                    </div>
                    <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                </div>
            @endif
            <form  class="formValidate" action="{{ route('special-periods.store') }}" style="margin-bottom: 20px;" id="formSubmit" method="POST">
                @csrf

                <div class="row s12 right">
                    <button type="submit" class="mb-6 btn waves-effect waves-light gradient-45deg-green-teal" >Save </button>
                    <a href="{{ route('special-periods.index') }}" class="mb-6 btn waves-effect waves-light gradient-45deg-purple-deep-orange">Cancel</a>
                </div>
                <div class="row"></div>
                <div id="details">
                    <div class="row">
                        <div class="input-field col s6">
                            <label for="name">Special Period Title*</label>
                            <input name="name" type="text" value="{{old('name', $specialPeriod['name']??'')}}" required>
                            @error('name')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>

                    </div>
                    <div class="row">
                         <div class="col s6">
                             <label for="season_attribute_id">Season Attribute*</label>
                            <div  class="input-field">
                                <select id="season_attribute_id" name="season_attribute_id" value="{{old('season_attribute_id',$specialPeriod['season_attribute_id']??'')}}" required >
                                    <option value="" >Select a Season Attribute</option>
                                    @foreach ($seasonAttribute as $item)
                                        <option value="{{$item->id}}" {{$item->id == old('season_attribute_id',$specialPeriod['season_attribute_id']??'' )? 'selected' : '' }}>{{$item->name}}</option>
                                    @endforeach
                                </select>
                                @error('season_attribute_id')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6">
                            <label for="start">Start Date*</label>
                            <input class="form-date datepicker" id="start" placeholder="31/01/2020" name="start" type="text" value="{{old('start',$specialPeriod['start']??'')}}" required>
                            @error('start')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                         <div class="input-field col s6">
                            <label for="start">End Date*</label>
                            <input class="form-date datepicker" id="end" placeholder="31/01/2020" name="end" type="text" value="{{old('end',$specialPeriod['end']??'')}}" required>
                            @error('end')
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

<script src="{{asset('vendors/formatter/jquery.formatter.min.js')}}"></script>
@endsection

{{-- page script --}}
@section('page-script')
<script src="{{asset('js/scripts/ui-alerts.js')}}"></script>
 <script src="{{asset('js/scripts/form-masks.js')}}"></script>

@endsection
