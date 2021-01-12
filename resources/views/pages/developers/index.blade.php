{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Tasks List')

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



<!-- invoice list -->
<section class="invoice-list-wrapper section">
  
  <!-- create category button-->
  {{-- <div class="invoice-create-btn">
    <a href="{{ route('developers.create-category')}}" class="btn waves-effect waves-light invoice-create border-round z-depth-4">
      <i class="material-icons">add</i>
      <span class="hide-on-small-only">Create Category</span>
    </a>
  </div>
  <div class="invoice-create-btn">
    <a href="{{ route('developers.create-subcategory')}}" class="btn waves-effect waves-light invoice-create border-round z-depth-4">
      <i class="material-icons">add</i>
      <span class="hide-on-small-only">Create Sub Category</span>
    </a>
  </div> --}}
  <!-- create task button-->
  <div class="invoice-create-btn">
    <a href="{{ route('developers.create-task')}}" class="btn waves-effect waves-light invoice-create border-round z-depth-4">
      <i class="material-icons">add</i>
      <span class="hide-on-small-only">Create Task</span>
    </a>
  </div>
  {{-- <div class="filter-btn">
    <!-- Dropdown Trigger -->
    <a class='dropdown-trigger btn waves-effect waves-light purple darken-1 border-round' href='#'
      data-target='btn-filter'>
      <span class="hide-on-small-only">Filter Tasks</span>
      <i class="material-icons">keyboard_arrow_down</i>
    </a>
    <!-- Dropdown Structure -->
    <ul id='btn-filter' class='dropdown-content'>
      <li><a href="#!">Active</a></li>
      <li><a href="#!">Inactive</a></li>
      <li><a href="#!">All</a></li>
    </ul>
  </div> --}}
  <div class="responsive-table">
    <table class="table invoice-data-table white border-radius-4 pt-1">
      <thead>
        <tr>
            <th></th>
            <th><span>Subject</span></th>
            <th>Developer</th>
            <th>Status</th>
            <th></th>
            {{-- <th>Sub Category</th> --}}
            {{-- <th>Action</th> --}}
            {{-- <th>Status</th> --}}
        </tr>
      </thead>


    </table>
  </div>
</section>
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
<script src="{{asset('js/scripts/hoteratus.js')}}"></script>
<script >
    
    $(document).ready( function () {

        getTaks();

    } );

    function getTaks(){
      var dataListView = $(".invoice-data-table").DataTable({
          "processing": true,
          serverSide: true,
          bAutoWidth: false,
          aaSorting: [],
          "ajax": "{{ url('developers/task')}}",
          columns: [
              {data: 'id'},
              {data: 'subject'},
              {data: 'developer'},
              // {data: 'status_id'},
              {data: 'btnstatus'},
              {data: 'btnaction'}
          ],
          columnDefs: [
              {
                orderable: true,
                targets: 0,
                checkboxes: { selectRow: true }
              },
              { "orderable": false, "targets": 3 },
          ],
          order: [1, 'asc'],
          dom:
              '<"top display-flex  mb-2"<"action-filters"f><"actions action-btns display-flex align-items-center">><"clear">rt<"bottom"p>',
          language: {
              search: "",
              searchPlaceholder: "Search Taks"
          },
          select: {
              style: "multi",
              selector: "td:first-child>",
              items: "row"
          },
          responsive: {
              details: {
              type: "column",
              target: 0
              }
          }
        });
        // To append actions dropdown inside action-btn div
        var invoiceFilterAction = $(".invoice-filter-action");
        var invoiceCreateBtn = $(".invoice-create-btn");
        var filterButton = $(".filter-btn");
        $(".action-btns").append(invoiceFilterAction, invoiceCreateBtn);
        $(".dataTables_filter label").append(filterButton);
    }
</script>
@endsection
