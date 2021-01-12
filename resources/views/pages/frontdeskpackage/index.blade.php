{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title',"Packages(Frontdesk) List")

{{-- vendor styles --}}
@section('vendor-style')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/jquery.dataTables.min.css')}}">
<link rel="stylesheet" type="text/css"
  href="{{asset('vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/dataTables.checkboxes.css')}}">
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
    <a href="javascript:void(0)" class="btn waves-effect waves-light invoice-export border-round z-depth-4 showpackage">
        <i class="material-icons">add_circle</i>
       <span class="hide-on-small-only">ATTACH A PACKAGE</span>
    </a>
  </div>
  <!-- create invoice button-->
  <div class="invoice-create-btn">
    <a class="btn waves-effect waves-light invoice-create border-round z-depth-4">
      <i class="material-icons">save</i>
    <span class="hide-on-small-only">SAVE SORT ORDER</span>
    </a>
  </div>

  <div class="filter-btn">
    <!-- Dropdown Trigger -->
    <a class='dropdown-trigger btn waves-effect waves-light purple darken-1 border-round' href='#'
      data-target='btn-filter'>
      <span class="hide-on-small-only">Filter Packages(Frontdesk) </span>
      <i class="material-icons">keyboard_arrow_down</i>
    </a>
    <!-- Dropdown Structure -->
    <ul id='btn-filter' class='dropdown-content'>
      <li><a href="javascript:void(0)" onclick="filter('1')">Active</a></li>
      <li><a href="javascript:void(0)" onclick="filter('0')">Inactive</a></li>
      <li><a href="javascript:void(0)" onclick="filter('')">All</a></li>
    </ul>
  </div>
  <div class="responsive-table" style="font-size: .85em">
    <table class="table invoice-data-table white border-radius-4 pt-1">
      <thead>
        <tr>

          <!-- data table checkbox -->
          <th></th>
          <th>Package</th>
          <th>
            Length of Stay
          </th>
          <th>Price List</th>
          <th>Activation</th>
          <th>Action</th>
          <th>Status</th>
          <th>Sort Order</th>
          <th>Featured</th>
        </tr>
      </thead>

    </table>
  </div>
  <input type="hidden" id="filter" />
  @csrf
    <div class="contact-compose-sidebar allpackage" style="width:85%;" >
        <div class="card quill-wrapper">
                <div class="card-content pt-0">
                    <div class="card-header display-flex ">
                        <h3 class="card-title contact-title-label" >Attach Packages</h3>
                        <div class="close close-icon">
                        <i  class="material-icons closeico">close</i>
                        </div>
                    </div>

                    <!-- form start -->
                    <form id="formPackage" class="edit-contact-item mb-5 " style="margin-right:50px" method="POST">
                        @csrf
                        <input type="hidden" id="upcharge_hidden">
                        <div class="row">
                            <table>
                                <tr>
                                    <td  style="padding: 5px !important; margin-left :5px; width: 15%">
                                        <label style="color: black; font-weight: 900;" for="package_type">Package Type</label>
                                    </td>
                                    <td  style="padding: 5px !important; margin-left :5px;">
                                        <select onchange="filterPackage()" class="browser-default" name="package_type" id="package_type">
                                            <option value="master" selected>Master</option>
                                            <option value="frontdesk" >Frontdesk</option>
                                            <option value="web" >Web</option>
                                            <option value="travel_agent" >Travel Agent</option>
                                            <option value="corporate" >Corporate</option>
                                            <option value="centralized_rate" >Centralized Rate</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>


                        </div>
                        <table id="all_package" class="table">
                            <thead style="padding: 0px !important;  display: table-header-group; vertical-align: middle; border-color: inherit; color:black;">

                                <tr>
                                    <th style="padding: 5px !important; margin-left :5px;  border: 1px solid #D5DBDB  !important; text-align: center; width:5%;">#</th>
                                    <th style="padding: 5px !important; margin-left :5px;  border: 1px solid #D5DBDB  !important; vertical-align: center; width:5%; box-align: center; ">
                                        <input style="opacity: 1; pointer-events: all; text-align: center;"  type="checkbox" id="checkall" >
                                    </th>
                                    <th style="padding: 5px !important; margin-left :5px;  border: 1px solid #D5DBDB  !important; text-align: center;">Package Type</th>
                                    <th style="padding: 5px !important; margin-left :5px;  border: 1px solid #D5DBDB  !important; text-align: center;">Title</th>
                                    <th style="padding: 5px !important; margin-left :5px;  border: 1px solid #D5DBDB  !important; text-align: center;">Description</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                        <br>
                        <div class="row s12 right mr-1"  >
                            <button type="button" onclick="savePackage()" class="mb-6 btn waves-effect waves-light gradient-45deg-green-teal" >Attach</button>
                            <button type="button"  class="mb-6 btn waves-effect waves-light gradient-45deg-green-teal" >Attach Relational</button>
                            <a class="mb-6 btn waves-effect waves-light gradient-45deg-purple-deep-orange closeico">Close</a>
                        </div>
                    </form>
                </div>
        </div>
    </div>
    <div class="contact-compose-sidebar activationdate"  style="width:50%;" >
        <div class="card quill-wrapper">
                <div class="card-content pt-0">
                    <div class="card-header display-flex ">
                        <h3 class="card-title contact-title-label" >Add Activation Date</h3>
                        <div class="close close-icon">
                        <i  class="material-icons closeico">close</i>
                        </div>
                    </div>

                    <!-- form start -->
                    <form id="formActivationDate" class="edit-contact-item mb-5 " style="margin-right:50px" method="POST">
                        @csrf
                        <input type="hidden" name="date_id" id="date_id">
                        <input type="hidden" name="id" id="id">
                        <table  class="table" style="font-size: .85em">
                            <thead>
                                <tr>
                                    <th>From date</th>
                                    <th>To date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th><input onchange="dateChange(2)" class="form-date datepicker" id="start" placeholder="01/01/2020" name="start" type="text"></th>
                                    <th><input onchange="dateChange(2)" class="form-date datepicker" id="end" placeholder="31/12/2020" name="end" type="text"></th>
                                    <th>  <label><input onclick="dateChange(1)"  type="checkbox" value="1" id="activated_forever" name="activated_forever" /><span>Activate Forever</span> </label> </th>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        <div class="row s12 right mr-1"  >
                            <button type="button" onclick="saveActivation()" class="mb-6 btn waves-effect waves-light gradient-45deg-green-teal" >Save</button>
                            <a class="mb-6 btn waves-effect waves-light gradient-45deg-purple-deep-orange closeico">Close</a>
                        </div>
                    </form>
                </div>
        </div>
    </div>
    @include('pages.frontdeskpackage.pricelist')
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
    var allpackageComposeSidebar = $(".contact-compose-sidebar.allpackage")
    var dateComposeSidebar = $(".contact-compose-sidebar.activationdate")
    var pricelistComposeSidebar = $(".contact-compose-sidebar.pricelist")

    $('.showpackage').on('click', function () {
        filterPackage();
        allpackageComposeSidebar.addClass('show');
    });
    $('.closeico').on('click', function () {
        allpackageComposeSidebar.removeClass('show');
        dateComposeSidebar.removeClass('show');
        pricelistComposeSidebar.removeClass('show');
    });
    $('#checkall').on('click', function () {
        $('.checkone').prop('checked', $('#checkall').prop('checked') )
    });

    function pricelist(name, id, obj){

        $("#priceList tbody").html('');
        $(".loader").show();
        var token = "{{ csrf_token() }}";
        $.ajax({
            type: "post",
            url: "{{route('frontdesk-packages.pricelist')}}",
            data: {_token: token, frontDeskPackageId: id},
            success: function (response) {
                console.log(response);
                if(response.success){
                    $("#priceList tbody").html(response.data)
                }
                $("#packagename").html(name);
                pricelistComposeSidebar.addClass('show')
                $(".loader").hide();
            }
        }).fail( () => {
            $(".loader").hide();
        });

    }

    function dateChange(type){
        if(type == 1){
            if($("#activated_forever").prop('checked') ){
                $("#start").val('');
                $("#end").val('');
            }
        }else{
            $("#activated_forever").prop('checked', false)
        }
    }
    function editActivated(obj, id, active, date_id='', start ="", end =""){
        $("#start").val(start);
        $("#end").val(end);
        $("#date_id").val(date_id);
        $("#id").val(id);
        $("#activated_forever").prop('checked', active==1 );

        dateComposeSidebar.addClass('show');
    }
    function deleteDate(date_id){

        swal({
                title: "Are you sure?",
                text: "Do you want to remove this activation date",
                icon: 'warning',
                dangerMode: true,
                buttons: {
                cancel: 'No, Please!',
                delete: 'Yes, delete It'
                }
            }).then(function (willDelete) {
                if (willDelete) {

                    $(".loader").show();
                    $("#date_id").val(date_id);
                    $.ajax({
                        type: "post",
                        url: "{{route('frontdesk-packages.deletedate')}}",
                        data: $("#formActivationDate").serialize(),
                        success: function (response) {

                            if(response.success){
                                swal("Date  has been delete!", {
                                icon: "success",
                                });
                                filter();
                            }


                            $(".loader").hide();
                        }
                    }).fail( () =>  $(".loader").hide() );


                } else {
                swal("This Date is safe", {
                    title: 'Cancelled',
                    icon: "error",
                });
                }
            });
    }
    function saveActivation(){

        if( $("#activated_forever").prop('checked') ){
             if ($("#start").val() || $("#end").val() ){
                  swal("The package will be activated forever", {
                        title: 'Warning',
                        icon: "warning",
                    });
             }
        }else{
            if($("#start").val() == ""){

                swal("Select a Date range or Check Active forever", {
                    title: 'Warning',
                    icon: "warning",
                });
                return;
            }
        }
        $(".loader").show();
        $.ajax({
            type: "post",
            url: "{{route('frontdesk-packages.activationdate')}}",
            data: $("#formActivationDate").serialize(),
            success: function (response) {
                console.log(response);
                if(response.success){
                    filter();
                    dateComposeSidebar.removeClass('show');
                }else{
                    swal(response.message, {
                        title: 'Warning',
                        icon: "error",
                    });
                }

                $(".loader").hide();
            }
        }).fail( () =>  $(".loader").hide() );
    }
    function savePackage(){
        $(".loader").show();
        $.ajax({
            type: "post",
            url: "{{route('frontdesk-packages.store')}}",
            data: $("#formPackage").serialize(),
            success: function (response) {
                 if(response.success){
                     filter();
                 }
                 $(".loader").hide();
                 allpackageComposeSidebar.removeClass('show');
            }
        }).fail( () => {
            $(".loader").hide();
        });

    }
    function changevalue(){
         $('#checkall').prop('checked', false)
    }

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
                        url: "{!!URL::to('frontdesk-packages/"+id+"' )!!}" ,
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
                        swal("Packages(Frontdesk)  has been deactivated!", {
                            icon: "success",
                        });

                    }).fail(function(response){
                        console.log(response)
                    });



                } else {
                swal("Your Packages(Frontdesk) is safe", {
                    title: 'Cancelled',
                    icon: "error",
                });
                }
            });
    }

    function filterPackage(){

        $("#all_package tbody").html('');
        $(".loader").show();
        $.ajax({
            type: "post",
            url: "{{url('packages-master/filterpackage')}}",
            data: $("#formPackage").serialize(),
            success: function (response) {
                var cont =0;
                if(response.success && response.data){

                    response.data.forEach(ele => {
                        cont++;
                        var tr = '<tr> <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important;">'+cont+'</td>';
                            tr += '<td style="padding: 5px !important; border: 1px solid #D5DBDB  !important;"> <input onclick="changevalue()" class="checkone" style="opacity: 1; pointer-events: all; text-align: center;"  type="checkbox" name="'+response.package_type+'['+ele.id+']" id="'+response.package_type+'_'+ele.id+'" ></td>';
                            tr += '<td style="padding: 5px !important; border: 1px solid #D5DBDB  !important;">'+response.type+'</td>';
                            tr += '<td style="padding: 5px !important; border: 1px solid #D5DBDB  !important;">'+ele.name+'</td>';
                            tr += '<td style="padding: 5px !important; border: 1px solid #D5DBDB  !important;">'+ele.description+'</td></tr>';
                            $("#all_package tbody").append(tr);
                    });


                }
                $(".loader").hide();


            }
        }).fail( () => {
             $(".loader").hide();
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
             "url":  "{{ route('frontdesk-packages.index')}}",
            "data": function( d ) {
                d.active=  $('#filter').val();
                }
        }  ,
        columns: [
            {data: 'id'},
            {data: 'name'},
            {data: 'staylength'},
            {data: 'pricelist'},
            {data: 'activation'},
            {data: 'btn'},
            {data: 'status'},
            {data: 'sortorder'},
            {data: 'featured'},
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
            searchPlaceholder: "Search Packages(Frontdesk)"
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
     function featured(id,obj){
        $(".loader").show();
        $.ajax({
            url: "{!!URL::to('frontdesk-packages/feature/"+id+"' )!!}" ,
            method: 'PUT',
            data: { _token: $(obj).data("token") }

        }).done( function(response){
            if(response.featured == 1){
                $(obj).html('<i class="material-icons">star</i>');
            }else{
                $(obj).html('<i class="material-icons">star_border</i>');
            }
            $(".loader").hide();

        }).fail(function(response){
            console.log(response)
            $(".loader").hide();
        });

    }
    $(document).ready( function () {
        fetch_data();
    } );
</script>
@endsection
