{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Phone Extension')

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

<div id="messages">
</div>
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
    <a href="{{ route('phone-extensions.create')}}" class="btn waves-effect waves-light invoice-create border-round z-depth-4">
      <i class="material-icons">add</i>
      <span class="hide-on-small-only">Create Phone Extension</span>
    </a>
  </div>

  <div class="filter-btn">
    <!-- Dropdown Trigger -->
    <a class='dropdown-trigger btn waves-effect waves-light purple darken-1 border-round' href='#'
      data-target='btn-filter'>
      <span class="hide-on-small-only">Filter  Phone Extension</span>
      <i class="material-icons">keyboard_arrow_down</i>
    </a>
    <!-- Dropdown Structure -->
    <ul id='btn-filter' class='dropdown-content'>
      <li><a href="javascript:void(0)" onclick="filter('1')">Active</a></li>
      <li><a href="javascript:void(0)" onclick="filter('0')">Inactive</a></li>
      <li><a href="javascript:void(0)" onclick="filter('')">All</a></li>
    </ul>
  </div>
  <div class="responsive-table">
    <table class="table invoice-data-table white border-radius-4 pt-1">
      <thead>
        <tr>

          <!-- data table checkbox -->
          <th></th>
          <th>
            <span>Phone Extension</span>
          </th>
          <th>Title</th>
          <th>Room</th>
          <th>Department</th>
          <th>Action</th>
          <th>Status</th>
        </tr>
      </thead>


    </table>
  </div>
  <input type="hidden" id="filter" />
  @csrf
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
<script src="{{asset('js/scripts/ui-alerts.js')}}"></script>
<script >

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
                        url: "{!!URL::to('phone-extensions/"+id+"' )!!}" ,
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
                        swal("Phone Extension  has been deactivated!", {
                            icon: "success",
                        });

                    }).fail(function(response){
                        console.log(response)
                    });



                } else {
                swal("Your Phone Extension is safe", {
                    title: 'Cancelled',
                    icon: "error",
                });
                }
            });
    }

    function filter(active){
        $('#filter').val(active);
        $('.invoice-data-table').DataTable().ajax.reload();
    }
    function fetch_data( active = '') {

        $('#filter').val(active);
        var dataListView = $(".invoice-data-table").DataTable({
            "processing": true,
            serverSide: true,
            bAutoWidth: false,
            aaSorting: [],
        "ajax": {
             "url":  "{{ url('phone-extensions')}}",
            "data": function( d ) {
                d.active=  $('#filter').val();
                }
        }  ,
        columns: [
            {data: 'id'},
            {data: 'extension_number'},
            {data: 'title'},
            {data: 'roomnumbers'},
            {data: 'departments'},
            {data: 'btn'},
            {data: 'status'},

        ],

        columnDefs: [

            {
            orderable: true,
            targets: 0,

            checkboxes: { selectRow: true }
            },

            { "orderable": false, "targets": [3,4,5 ]},


        ],
        order: [1, 'asc'],
        dom:
            '<"top display-flex  mb-2"<"action-filters"f><"actions action-btns display-flex align-items-center">><"clear">rt<"bottom"p>',
        language: {
            search: "",
            searchPlaceholder: "Search Phone Extension"
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

    function saveChange(obj){
        $.ajax({
            type: "post",
            url: "phone-extensions/save",
            data: {_token: $(obj).data('token'), name: $(obj).data('name'), id: $(obj).data('id'), value: obj.value },
            success: function (response) {
                $("#messages").append(' <div class="row" > '+
                    '<div id="'+$(obj).data('name')+$(obj).data('id')+'" class="card-alert card gradient-45deg-green-teal"> '+
                        '<div class="card-content white-text"> '+
                            '<p><i class="material-icons">check</i> '+ $(obj).data('campo') +' has been changed!!' +                         '</p> '+
                        '</div>'+
                        '<button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">'+
                            '<span aria-hidden="true">×</span>'+
                        '</button></div></div>');
                setTimeout(() => {
                    let id = '#'+$(obj).data('name')+$(obj).data('id')
                      $(id).remove();
                }, 3000);

            }
        });
    }
</script>
@endsection
