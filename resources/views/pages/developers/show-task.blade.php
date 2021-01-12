{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Tasks Detail')

{{-- vendor styles --}}
@section('vendor-style')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/jquery.dataTables.min.css')}}">
<link rel="stylesheet" type="text/css"
  href="{{asset('vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/dataTables.checkboxes.css')}}">
@endsection

{{-- page styles --}}
@section('page-style')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-invoice.css')}}">
@endsection

{{-- page content --}}
@section('content')

<div class="section">
  <div class="row">
    <div class="col s12">

      <div id="validations" class="card card-tabs">

        <div class="card-content">
            <div class="card-title">
                <div class="row center">
                    <div class="col s12">
                        <h5 class="center-align" style="font-weight: 900;">Task Information</h5>
                    </div>
                </div>

                @if($task)
                <div class="row card">
                  <div class="col s12">
                    <div class="card-content">
                      <b class="text-bold">Subject</b>
                      <p>{{ $task->subject }}</p>
                    </div>
                  </div>
                  <div class="col s12">
                    <div class="card-content">
                      <b class="text-bold">Status</b>
                      <p class="{{ $task->get_status($task->status_id)['color'] }}-text">{{ $task->get_status($task->status_id)['name'] }}</p>
                    </div>
                  </div>
                  <div class="col s12">
                    <div class="card-content">
                      <b class="text-bold">Developer</b>
                      <p >{{ $task->get_developer($task->developer_id) }}</p>
                    </div>
                  </div>
                  <div class="col s12">
                    <div class="card-content">
                      <b class="text-bold">Description</b>
                      <p>{{ $task->description }}</p>
                    </div>
                  </div>
                  <div class="col s12">
                    <div class="card-content">
                      <b class="text-bold">Note / Comment</b>
                      <p>{{ $task->usernote }}</p>
                    </div>
                  </div>

                </div>
                @endif

            </div>

        </div>
      </div>
    </div>
  </div>
</div>




@endsection

{{-- vendor scripts --}}
@section('vendor-script')
<script src="{{asset('vendors/data-tables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('vendors/data-tables/js/datatables.checkboxes.min.js')}}"></script>
<script src="{{asset('vendors/sweetalert/sweetalert.min.js')}}"></script>
@endsection

{{-- page scripts --}}
@section('page-script')