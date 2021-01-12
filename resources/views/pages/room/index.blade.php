{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Room List')

{{-- vendor styles --}}
@section('vendor-style')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/jquery.dataTables.min.css')}}">
<link rel="stylesheet" type="text/css"
  href="{{asset('vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/dataTables.checkboxes.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-sidebar.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-contacts.css')}}">
@endsection

{{-- page styles --}}
@section('page-style')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-invoice.css')}}">
@endsection

{{-- page content --}}
@section('content')


<!-- invoice list -->
<section class="invoice-list-wrapper section">
  <!-- create invoice button-->
  <!-- Options and filter dropdown button-->
  <div class="invoice-filter-action mr-3">
    <a href="javascript:void(0)" class="btn waves-effect waves-light invoice-export border-round z-depth-4">
      <i class="material-icons">picture_as_pdf</i>
      <span class="hide-on-small-only">Export to PDF</span>
    </a>
  </div>
  <!-- create invoice button-->
  <div class="invoice-create-btn">
    <a href="{{ route('rooms.create')}}" class="btn waves-effect waves-light invoice-create border-round z-depth-4">
      <i class="material-icons">add</i>
      <span class="hide-on-small-only">Create Room</span>
    </a>
  </div>

  <div class="filter-btn">
    <!-- Dropdown Trigger -->
    <a id="showfilter" class='dropdown-trigger btn waves-effect waves-light purple darken-1 border-round' href='#'
      data-target='btn-filter'>
      <span class="hide-on-small-only">Filter Room</span>
      <i class="material-icons">filter_list</i>
    </a>
    <!-- Dropdown Structure -->
    <ul style="display: none;" id='btn-filter' class='dropdown-content'>

    </ul>
  </div>
  <div class="responsive-table">
    <table class="table invoice-data-table white border-radius-4 pt-1">
      <thead>
        <tr>

          <!-- data table checkbox -->
          <th></th>
          <th>
            <span>Room Names/Numbers</span>
          </th>
          <th>Room type</th>
          <th>Block</th>
          <th>Floor</th>
          <th>Action</th>
          <th>Status</th>
        </tr>
      </thead>


    </table>
  </div>
  <input type="hidden" id="filter" />
  @csrf
</section>
<div class="contact-compose-sidebar">
  <div class="card quill-wrapper">
    <div class="card-content pt-0">
      <div class="card-header display-flex pb-2">
        <h3 class="card-title contact-title-label">Filters Rooms</h3>
        <div class="close close-icon">
          <i  class="material-icons closeico">close</i>
        </div>
      </div>
      <div class="divider"></div>
      <!-- form start -->
      <form id="formaccountCode" class="edit-contact-item mb-5 mt-5" method="POST">
        <div class="row">
            <div class="col s12">
                <label for="room_type_id">Room Type</label>
                <div class="input-field">
                    <select id="room_type_id" name="room_type_id" value="{{old('room_type_id',$room['room_type_id']??'')}}"  >
                        <option value="">All</option>
                        @foreach ($roomtypes as $roomtype)
                            <option value="{{$roomtype->id}}" {{$roomtype->id == old('room_type_id',$room['room_type_id']??'')? 'selected' : '' }}>{{$roomtype->name}}</option>
                        @endforeach
                    </select>
                    @error('room_type_id')
                        <small class="red-text">
                            <p>{{ $message }}</p>
                        </small>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <label for="room_type_id">Floor</label>
                <div class="input-field">
                    <select id="floor_id"   name="floor_id" value="{{old('floor_id',$room['floor_id']??'')}}"  >
                        <option value="">All</option>
                        @foreach ($floors as $floor)
                            <option value="{{$floor->id}}" {{$floor->id == old('floor_id',$room['floor_id']??'')? 'selected' : '' }}>{{$floor->name}}</option>
                        @endforeach
                    </select>
                    @error('floor_id')
                        <small class="red-text">
                            <p>{{ $message }}</p>
                        </small>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <label for="room_type_id">Block</label>
                <div class="input-field">
                    <select id="block_id"  name="block_id" value="{{old('block_id',$room['block_id']??'')}}" >
                        <option value="">All</option>
                        @foreach ($blocks as $block)
                            <option value="{{$block->id}}" {{$block->id == old('block_id',$room['block_id']??'')? 'selected' : '' }}>{{$block->name}}</option>
                        @endforeach
                    </select>
                    @error('block_id')
                        <small class="red-text">
                            <p>{{ $message }}</p>
                        </small>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <label>
                    <input value="" id="active1" type="radio" name="active" checked />
                    <span>All</span>
                </label>
                <label>
                    <input value="1" id="active2" type="radio" name="active"  />
                    <span>Active</span>
                </label>
                <label>
                    <input value="0" id="active3" type="radio" name="active" />
                    <span>Deactive</span>
                </label>
            </div>
        </div>
        <br>
        <div class="row s12 center">
            <button type="button" onclick="filter()" class="mb-6 btn waves-effect waves-light gradient-45deg-green-teal" >Find </button>
            <a  class="mb-6 btn waves-effect waves-light gradient-45deg-purple-deep-orange closeico">Cancel</a>
        </div>
      </form>
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
<script src="{{asset('js/scripts/hoteratus.js')}}"></script>
<script src="{{asset('js/scripts/ui-alerts.js')}}"></script>
<script >


  var contactComposeSidebar = $(".contact-compose-sidebar")


    $('#showfilter').on('click', function () {
       contactComposeSidebar.addClass('show');
    });
    $('.closeico').on('click', function () {
       contactComposeSidebar.removeClass('show');
    });
    function deactive(id,obj){

         swal({
                title: "Are you sure?",
                text: "You can activate it, when you need it!",
                icon: 'warning',
                dangerMode: true,
                buttons: {
                cancel: 'No, Please!',
                delete: 'Yes, Deactivate It'
                }
            }).then(function (willDelete) {
                if (willDelete) {

                    $.ajax({
                        url: "{!!URL::to('rooms/"+id+"' )!!}" ,
                        method: 'DELETE',
                        data: { _token: $(obj).data("token") }

                    }).done( function(response){
                        if(response.active == 1){
                            $(obj).html('Active');
                             $(obj).removeClass(['red', 'red-text']);
                             $(obj).addClass(['green', 'green-text']);

                        }else{
                            $(obj).html('Deactivated');
                            $(obj).removeClass(['green', 'green-text']);
                            $(obj).addClass(['red', 'red-text']);

                        }
                        swal("Room  has been deactivated!", {
                            icon: "success",
                        });

                    }).fail(function(response){
                        console.log(response)
                    });



                } else {
                swal("Your Room is safe", {
                    title: 'Cancelled',
                    icon: "error",
                });
                }
            });
    }

    function filter(active){
        $('#filter').val(active);
        $('.invoice-data-table').DataTable().ajax.reload();
        contactComposeSidebar.removeClass('show');
    }
    function fetch_data( active = '') {

        $('#filter').val(active);
        var dataListView = $(".invoice-data-table").DataTable({
            "processing": true,
            serverSide: true,
            bAutoWidth: false,
            aaSorting: [],
        "ajax": {
             "url":  "{{ url('rooms')}}",
            "data": function( d ) {
                    d.room_type_id=  $('#room_type_id').val();
                    d.block_id=  $('#block_id').val();
                    d.floor_id=  $('#floor_id').val();
                    if ($('#active1').is(':checked')) {
                        d.active =  '';
                    }else if ($('#active2').is(':checked')){
                        d.active =  1;
                    } else{
                        d.active =  0;
                    }

                }
        }  ,
        columns: [
            {data: 'id'},
            {data: 'name'},
            {data: 'roomtype'},
            {data: 'block'},
            {data: 'floor'},
            {data: 'btn'},
            {data: 'status'},
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
            searchPlaceholder: "Search Room"
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
    $(document).ready( function () {
        fetch_data();
    } );
</script>
@endsection
