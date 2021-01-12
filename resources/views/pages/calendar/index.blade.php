{{-- extend Layout --}}
@extends('layouts.calendarLayou')

{{-- page title --}}
@section('title','Calendar')

{{-- page styles --}}
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
  integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/CalendarJnS/css/bootstrap.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/CalendarJnS/css/app-calendar.css')}}">

{{-- page script --}}
@section('page-script')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
  class Restaurant {
    async loadProducts(ID) {
        let data = {
            "TO": "Restaurant",
            "FOR": "loadProducts",
            "ACTION": "view",
            "id": ID
        }
        let datos = await GetInformation(data);
    }
    static holdProduct(ITEM) {
        let idProduct = $(ITEM).attr("data-id");
        let productName = $(ITEM).find(".name-product").text();
        let priceProduct = $(ITEM).find(".price-product").attr("data-price");
        let ifexist = $("#restaurant .products #table-products tbody").find(`tr[data-id='${idProduct}']`);
        let quantity = "";
        let total = 0;
        let row =
            `<tr data-id='${idProduct}'>
                <td>${productName}</td>
                <td>${idProduct}</td>
                <td class="text-success font-weight-bold price" data-price='${priceProduct}'>$${priceProduct}</td>
                <td class="d-flex">
                    <input type="number" id="quantity" class="form-control w-75" value='1'>
                    <button id="remove-product" class="btn btn-outline-primary btn-sm w-25" data-id='${idProduct}'><i class="fas fa-trash"></i></button>
                </td>
            </tr>`;
        if (ifexist.length != 0) {
            quantity = parseInt($(ifexist).find("#quantity").val());
            $(ifexist).find("#quantity").val(quantity + 1)
        }
        else {
            $("#restaurant .products #table-products tbody").append(row);
        }
        $("#restaurant .products #table-products tbody tr").each(function () {
            let price = parseFloat($(this).find('.price').attr("data-price"));
            let quantityP = parseFloat($(this).find("#quantity").val());
            total += price * quantityP;
        });
        total = parseToDecimal(total);
        $("#restaurant .products #table-products tfoot #totalPrice span").text(total);
    }
    static onChangeAmount(){
        
        let discount = 0;
        let subTotal = 0;
        let total = 0;
        $("#newOrder1 #tableTotalAmount tbody tr").each(function(){
            var price = parseFloat($(this).find('#totalPrice input').val());
            var quantityP = $(this).find("#quantity input").val();
            var discount = parseFloat($(this).find("#discount").attr("data-discount"));
            subTotal += price - discount;
            total += price;
        });
        
        console.log(total+"-"+subTotal);
        $("#newOrder1 #tablePrices #subTotal span").text(subTotal);
        $("#newOrder1 #tablePrices #amount span").text(total);
        $("#newOrder1 #tablePrices #totalAmount span").text(total)
    }
}


$(document).ready(function () {

    $("#restaurant").on("click", ".category-product #products-category", function () {
        new Restaurant().loadProducts($(this).attr("data-id"));
    });
    $("#restaurant").on("click", ".products .list-products .item-product", function () {
        Restaurant.holdProduct(this);
    });

    //Operaciones
    $("#restaurant #table-products tbody").on("click change keyup", "tr #quantity", function () {
        let total = 0;
        $("#restaurant .products #table-products tbody tr").each(function () {
            let price = parseFloat($(this).find('.price').attr("data-price"));
            let quantityP = parseFloat($(this).find("#quantity").val());
            total += price * quantityP;
        });
        total = parseToDecimal(total);
        $("#restaurant .products #table-products tfoot #totalPrice span").text(total);
    });
    $("#restaurant #table-products").on("click", "tr #remove-product", function () {
        $(this).closest("tr").remove();
        let total = 0;
        $("#restaurant .products #table-products tbody tr").each(function () {
            let price = parseFloat($(this).find('.price').attr("data-price"));
            let quantityP = parseFloat($(this).find("#quantity").val());
            total += price * quantityP;
        });
        total = parseToDecimal(total);
        $("#restaurant .products #table-products tfoot #totalPrice span").text(total);
    });

    //Table Amount
    //agregar el producto desde el BOX al table TotalAmount
    $("#restaurant").on("click", ".dropdown-menu .list-group-item", function () {
        let id = $(this).attr("data-id");
        let nameProduct = $(this).find("#nameProduct").text();
        let codeProduct = $(this).find("#codeProduct").text();
        let priceProduct = $(this).find("#priceProduct").attr("data-price");
        $(this).closest("tr").attr("data-id", id);
        $(`#restaurant #newOrder1 #tableTotalAmount tfoot #dropdownNameProduct`).val(nameProduct);
        $(`#restaurant #newOrder1 #tableTotalAmount tfoot #price span`).text(priceProduct);
        $(`#restaurant #newOrder1 #tableTotalAmount tfoot #price`).attr("data-price", priceProduct);
    });
    
    $("#restaurant #addNewProduct").on("click", "#add-product", function () {
        let id = $("#restaurant #newOrder1 #tableTotalAmount tfoot #addNewProduct").attr("data-id");
        let nameProduct = $(`#restaurant #newOrder1 #tableTotalAmount tfoot #dropdownNameProduct`).val();
        let priceProduct = $(`#restaurant #newOrder1 #tableTotalAmount tfoot #price`).attr("data-price");
        let quantity = $(`#restaurant #newOrder1 #tableTotalAmount tfoot #units input`).val();
        let ifexist = $("#restaurant #newOrder1 #tableTotalAmount tbody").find(`tr[data-id='${id}']`);
        let totalPrice = quantity * priceProduct;
        parseToDecimal(totalPrice);
        if (ifexist.length == 0) {
            if (nameProduct.length > 0 && priceProduct.length > 0) {
                row =
                    `<tr data-id='${id}'>
                        <td id="name">${nameProduct}</td>
                        <td id="price" data-price='${priceProduct}'>$<span>${priceProduct}</span></td>
                        <td id="quantity"><input type="number" class="form-control" value="${quantity}"></td>
                        <td id="discount" class="cursor-pointer text-primary" data-discount="0.00">Discount</td>
                        <td id="totalPrice" class="d-flex text-primary">$ <input type="text" class="border-0" value="${totalPrice}"></td>
                        <td><button id="remove-product" class="btn btn-outline-primary"><i class="fas fa-trash"></i></button></td>
                    </tr>`;
                $("#restaurant #newOrder1 #tableTotalAmount tbody").append(row);

                $(`#restaurant #newOrder1 #tableTotalAmount tfoot #dropdownNameProduct`).val("");
                $(`#restaurant #newOrder1 #tableTotalAmount tfoot #price span`).text("--");
                $(`#restaurant #newOrder1 #tableTotalAmount tfoot #units input`).val("");
                $("#restaurant #newOrder1 #tableTotalAmount tfoot #addNewProduct").removeAttr("data-id");
                Restaurant.onChangeAmount();
            }
        }
        else{
            $("#restaurant #newOrder1 #tableTotalAmount tfoot #alertProduct").animate({
                display: "toggle",
                opacity: "toggle",
                display : "toggle"
              }, 2000);
        }
    });
    $("#restaurant #tableTotalAmount tbody").on("click change keyup", "tr #quantity", function () {
        let total = 0;
        $($(this).closest("tr")).each(function () {
            let price = parseFloat($(this).find('#price').attr("data-price"));
            let quantityP = parseFloat($(this).find("#quantity input").val());
            total += price * quantityP;
        });
        total = parseToDecimal(total);
        $(this).closest("tr").find("#totalPrice input").val(total);
        Restaurant.onChangeAmount();
        console.log(clientIdActive)
    });
});

</script>

{{-- page content --}}
@section('content')
<div class="col-md-12">
  <div class="row">
    @foreach ($roomStatus as $status)
        <div class="col">
          <span class="badge p-2 w-100 text-white" style="">{{$status->name}}</span>
        </div>
    @endforeach
      </div>
</div>
<div class="calendar" id="calendar">

  <div class="col-md-12 px-0 navbar-left">
    <div id="navbar-list-group" class="list-group bg-white collapse">
      <h4 class="title">Room Operations</h4>
      <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-checkIn-list" role="tab"><i
          class="fas fa-list"></i> Check in list</a>
      <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-checkOut-list" role="tab"><i
          class="fas fa-list-ol"></i> Check out list</a>
      <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-reservation-list" role="tab"><i
          class="fas fa-list-ol"></i> Reservation list</a>
      <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-temp-room-list" role="tab"><i
          class="fas fa-list"></i> Temp room list</a>
      <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-no-show-list" role="tab"><i
          class="fas fa-list"></i> No show list</a>
      <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-cancellation-list" role="tab"><i
          class="fas fa-list"></i> Cancelled reservation list</a>
      <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-checkout-pending-list"
        role="tab"><i class="fas fa-list"></i> Check out pending list</a>
      <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-pending-folio" role="tab"><i
          class="fas fa-folder-open"></i> Pending folio(s)</a>
      <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-booking-deposit" role="tab"><i
          class="fas fa-cash-register"></i> Booking deposits tracker</a>
      <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-payment-tracker" role="tab"><i
          class="fas fa-search-dollar"></i> Payment tracker</a>
      <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-guest-in-house-list"
        role="tab"><i class="fas fa-list"></i> Guest in house list</a>
      <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-party-reservation-list"
        role="tab"><i class="fas fa-gifts"></i> 3rd party reservation list</a>
      <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-alertAndNotifications"
        role="tab"><i class="fas fa-bell"></i> Alerts & notifications</a>
      <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-dnr-house-report" role="tab"><i
          class="fas fa-bug"></i> DNR/House report</a>
      <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-rate-posting-report"
        role="tab"><i class="fas fa-bug"></i> Rate posting report</a>
      <br>
      <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-dashboard" role="tab"><i
          class="fas fa-sliders-h"></i> Managment Dashboard</a>
      <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-guest-lookUp" role="tab"><i
          class="fas fa-search"></i> Guest look-up</a>
      <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-house-status" role="tab"><i
          class="fas fa-info-circle"></i> House status</a>
      <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-tariff-chart" role="tab"><i
          class="fas fa-chart-pie"></i> Tariff chart</a>
      <a class="list-group-item list-group-item-action" data-toggle="list" href="" role="tab"><i
          class="fas fa-users"></i> Accounts</a>
      <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-settings" role="tab"><i
          class="fas fa-user-cog"></i> Manage Reviews</a>
      <br>
      <h4><a class="list-group-item list-group-item-action bg-info text-white" data-toggle="list" href="#list-settings"
          role="tab"><i class="far fa-play-circle"></i> HELP VIDEOS</a></h4>
      <br>

      <a class="list-group-item list-group-item-action" data-toggle="list" href="#list-settings" role="tab"><i
          class="fas fa-list"></i> Task list</a>

      <a class="list-group-item list-item-collapse list-group-item-action" data-toggle="collapse"
        data-target="#list-legends" href="#list-legends" role="tab"><i class="fas fa-history"></i> Room legends</a>
      <div id="list-legends" class="collapse">
        <ul class="list">
          @foreach ($roomStatus as $status)
          <li><span class="badge">&nbsp;&nbsp;&nbsp;</span> {{$status->name}}</li>
          @endforeach
        </ul>
      </div>

      <a class="list-group-item list-item-collapse list-group-item-action" data-toggle="collapse"
        data-target="#list-housekeeping-legends" href="#list-housekeeping-legends" role="tab"><i
          class="fas fa-history"></i> Housekeeping legends</a>
      <div id="list-housekeeping-legends" class="collapse">
        <ul class="list">
          @foreach($housekeepingStatus as $housekeeping)
          <!-- modificacion hotel_room_status_color -->
          <li><span class="badge" style="">&nbsp;&nbsp;&nbsp;</span> {{$housekeeping->name}}</li>
          @endforeach
        </ul>
      </div>
    </div>
    <div class="panel-collapse">
      <button class="btn btn-primary btn-lg rounded-0 angle-left" data-toggle="collapse"
        data-target="##navbar-list-group"><i class="fas fa-angle-right"></i></button>
    </div>
    <div class="subpanel-content full-width collapse" id="subpanel-content">
      <div class="subpanel-header">
        <h2 id="title" class="d-inline pl-3 font-weight-bold"></h2>
        <button type="button" class="close" data-toggle="collapse" data-target="#subpanel-content" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="tab-content pb-3 nav-subTabContent" id="nav-subTabContent">
        <div class="tab-pane fade" id="list-checkIn-list" role="tabpanel" aria-labelledby="list-check-list">
          <div id="filtre" class="col-md-12 p-0 pt-3 filtre">
            <div class="row px-3">
              <div class="col-md-2 px-1">
                <label for="nameOrId">Name/Group ID/Rest ID</label>
                <input type="text" id="nameOrId" class="form-control">
              </div>
              <div class="col-md-1 px-1 align-self-center">
                <label class="label-control-inline m-auto"><input type="radio" name="basedOn" value="createdOn">Created
                  on</label>
                <label class="label-control-inline m-auto"><input type="radio" name="basedOn" value="basedOn">Check
                  in</label>
              </div>
              <div class="col px-1">
                <label for="from">From</label>
                <input type="date" id="from" class="form-control inputCalendar" value="{{date("Y-m-d")}}">
              </div>
              <div class="col px-1">
                <label for="to">To</label>
                <input type="date" id="to" class="form-control inputCalendar" value="{{date("Y-m-d")}}">
              </div>
              <div class="col-md-1 px-1">
                <label for="allNotes">All Notes</label>
                <select id="allNotes" class="custom-select">
                  <option value=""></option>
                </select>
              </div>
              <div class="col-md-1 px-1">
                <label for="status">Status</label>
                <select id="status" class="custom-select"></select>
              </div>
              <div class="col-md-2 px-1">
                <label for="filterBy">Filter By</label>
                <div class="input-group">
                  <select id="filterBy" class="custom-select"></select>
                  <input type="text" id="textFilterBy" class="form-control">
                </div>
              </div>
              <div class="col-md-1 px-1">
                <label for="sortBy"> Sort By</label>
                <select id="sortBy" class="custom-select"></select>
              </div>
            </div>
            <div class="row px-3 mt-3">
              <button id="btnSearchCheckIn" class="btn btn-primary w-25 m-auto"><i class="fas fa-search"></i>
                Search</button>
            </div>
            <hr>
            <div class="row p-3">
              <div class="col-md-4">
                <select id="typeReservation" class="custom-select">
                  <option value="">All</option>
                  <option value="">Group</option>
                  <option value="">Single</option>
                </select>
              </div>
              <div class="col-md-8 align-self-center">
                <div class="custom-control custom-checkbox custom-control-inline">
                  <input type="checkbox" id="in-excludeComp" class="custom-control-input" value="off">
                  <label class="custom-control-label" for="in-excludeComp">Exclude Comp.</label>
                </div>

                <div class="custom-control custom-checkbox custom-control-inline">
                  <input type="checkbox" id="in-thirdResId" class="custom-control-input" value="off">
                  <label class="custom-control-label" for="in-thirdResId">3rd Party ResID</label>
                </div>

                <div class="custom-control custom-checkbox custom-control-inline">
                  <input type="checkbox" id="in-dayUseRes" class="custom-control-input" value="off">
                  <label class="custom-control-label" for="in-dayUseRes">Show Day Use Only</label>
                </div>

                <div class="custom-control custom-checkbox custom-control-inline">
                  <input type="checkbox" id="in-rmsummary" class="custom-control-input" value="off">
                  <label class="custom-control-label" for="in-rmsummary">Show Summary</label>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="table-responsive">
              <table id="tableCheckIn" class="table table-striped table-hover table-sm text-center dataTable">
                <thead class="bg-primary text-white">
                  <tr>
                    <th>Group ID</th>
                    <th>Res ID</th>
                    <th>Guest Name</th>
                    <th>StayDuration</th>
                    <th>Room#/Type/Block/Floor</th>
                    <th>Pax</th>
                    <th>Status</th>
                    <th>Amount</th>
                    <th>Prefereces/Notes</th>
                    <th>Check in Card</th>
                  </tr>
                </thead>
                <tbody class="cursor-pointer">
                  <tr>
                    <td></td>
                    <td>081830</td>
                    <td>Anastacia Grey</td>
                    <td>18 Aug - 24 Aug(6)</td>
                    <td>N/A /Standard Room / N/A / N/A</td>
                    <td>2(A)0(C)</td>
                    <td>Reserve</td>
                    <td class="text-right px-0">$ 1035.00</td>
                    <td></td>
                    <td>
                      <button class="btn btn-primary btn-sm"><i class="fas fa-print"></i></button>
                      <button class="btn btn-danger btn-sm"><i class="fas fa-envelope-open-text"></i></button>
                    </td>
                  </tr>
                  <tr>
                    <td></td>
                    <td>081830</td>
                    <td>Maria Grey</td>
                    <td>18 Aug - 24 Aug(6)</td>
                    <td>N/A /Standard Room / N/A / N/A</td>
                    <td>2(A)0(C)</td>
                    <td>Reserve</td>
                    <td class="text-right px-0">$ 1035.00</td>
                    <td></td>
                    <td>
                      <button class="btn btn-primary btn-sm"><i class="fas fa-print"></i></button>
                      <button class="btn btn-danger btn-sm"><i class="fas fa-envelope-open-text"></i></button>
                    </td>
                  </tr>
                  <tr>
                    <td></td>
                    <td>081830</td>
                    <td>Jose Grey</td>
                    <td>18 Aug - 24 Aug(6)</td>
                    <td>N/A /Standard Room / N/A / N/A</td>
                    <td>2(A)0(C)</td>
                    <td>Reserve</td>
                    <td class="text-right px-0">$ 1035.00</td>
                    <td></td>
                    <td>
                      <button class="btn btn-primary btn-sm"><i class="fas fa-print"></i></button>
                      <button class="btn btn-danger btn-sm"><i class="fas fa-envelope-open-text"></i></button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="row p-1 bg-primary align-items-center">
              <div class="col-8">
                <button id="addNewGroup" class="btn btn-light m-1"><i class="fas fa-plus"></i> Add to new group</button>
                <button id="removeFromGroup" class="btn btn-light m-1"><i class="fas fa-times-circle"></i> Remove from
                  group</button>
                <button id="addToGroup" class="btn btn-light m-1"><i class="fas fa-user-friends"></i> Add to
                  group</button>
                <button id="print" class="btn btn-light m-1"><i class="fas fa-print"></i> Print</button>
              </div>
              <div class="col-4">
                <div class="input-group">
                  <select id="exportTo" class="custom-select"></select>
                  <div class="input-group-prepend">
                    <button id="btnExport" class="btn btn-light"><i class="fas fa-file-export"></i> Export</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="list-checkOut-list" role="tabpanel" aria-labelledby="list-checkOut-list">
          <div class="col-md-12 p-0 pt-3 filtre">
            <div class="row px-3">
              <div class="col-md-2 px-1">
                <label for="nameOrId">Name/Group ID/Rest ID</label>
                <input type="text" id="nameOrId" class="form-control">
              </div>
              <div class="col-md-1 px-1 align-self-center">
                <label class="label-control-inline m-auto"><input type="radio" name="basedOn">Created on</label>
                <label class="label-control-inline m-auto"><input type="radio" name="basedOn">Check out</label>
              </div>
              <div class="col px-1">
                <label for="from">From</label>
                <input type="date" id="from" class="form-control inputCalendar">
              </div>
              <div class="col px-1">
                <label for="to">To</label>
                <input type="date" id="to" class="form-control inputCalendar">
              </div>
              <div class="col-md-1 px-1">
                <label for="allNotes">All Notes</label>
                <select id="allNotes" class="custom-select">
                  <option value=""></option>
                </select>
              </div>
              <div class="col-md-1 px-1">
                <label for="status">Status</label>
                <select id="status" class="custom-select"></select>
              </div>
              <div class="col-md-2 px-1">
                <label for="filterBy">Filter By</label>
                <div class="input-group">
                  <select id="filterBy" class="custom-select"></select>
                  <input type="text" id="textFilterBy" class="form-control">
                </div>
              </div>
              <div class="col-md-1 px-1">
                <label for="sortBy"> Sort By</label>
                <select id="sortBy" class="custom-select"></select>
              </div>
            </div>
            <div class="row px-3 mt-3">
              <button id="btnSearchCheckOut" class="btn btn-primary w-25 m-auto"><i class="fas fa-search"></i>
                Search</button>
            </div>
            <hr>
            <div class="row p-3">
              <div class="col-md-4">
                <select id="typeReservation" class="custom-select">
                  <option value="">All</option>
                  <option value="">Group</option>
                  <option value="">Single</option>
                </select>
              </div>
              <div class="col-md-8 align-self-center">

                <div class="custom-control custom-checkbox custom-control-inline">
                  <input type="checkbox" id="out-thirdResId" class="custom-control-input" value="off">
                  <label class="custom-control-label" for="out-thirdResId">3rd Party ResID</label>
                </div>

                <div class="custom-control custom-checkbox custom-control-inline">
                  <input type="checkbox" id="out-dayUseRes" class="custom-control-input" value="off">
                  <label class="custom-control-label" for="out-dayUseRes">Show Day Use Only</label>
                </div>

                <div class="custom-control custom-checkbox custom-control-inline">
                  <input type="checkbox" id="out-rmsummary" class="custom-control-input" value="off">
                  <label class="custom-control-label" for="out-rmsummary">Show Summary</label>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped table-hover table-sm text-center dataTable">
                <thead class="bg-primary text-white">
                  <tr>
                    <th>Group ID</th>
                    <th>Res ID</th>
                    <th>Guest Name</th>
                    <th>StayDuration</th>
                    <th>Room#/Type/Block/Floor</th>
                    <th>Pax</th>
                    <th>Status</th>
                    <th>Amount</th>
                    <th>Prefereces/Notes</th>
                    <th>Check in Card</th>
                  </tr>
                </thead>
                <tbody class="cursor-pointer">
                  <tr>
                    <td></td>
                    <td>081830</td>
                    <td>Anastacia Grey</td>
                    <td>18 Aug - 24 Aug(6)</td>
                    <td>N/A /Standard Room / N/A / N/A</td>
                    <td>2(A)0(C)</td>
                    <td>Reserve</td>
                    <td class="text-right px-0">$ 1035.00</td>
                    <td></td>
                    <td>
                      <button class="btn btn-primary btn-sm"><i class="fas fa-print"></i></button>
                      <button class="btn btn-danger btn-sm"><i class="fas fa-envelope-open-text"></i></button>
                    </td>
                  </tr>
                  <tr>
                    <td></td>
                    <td>081830</td>
                    <td>Maria Grey</td>
                    <td>18 Aug - 24 Aug(6)</td>
                    <td>N/A /Standard Room / N/A / N/A</td>
                    <td>2(A)0(C)</td>
                    <td>Reserve</td>
                    <td class="text-right px-0">$ 1035.00</td>
                    <td></td>
                    <td>
                      <button class="btn btn-primary btn-sm"><i class="fas fa-print"></i></button>
                      <button class="btn btn-danger btn-sm"><i class="fas fa-envelope-open-text"></i></button>
                    </td>
                  </tr>
                  <tr>
                    <td></td>
                    <td>081830</td>
                    <td>Jose Grey</td>
                    <td>18 Aug - 24 Aug(6)</td>
                    <td>N/A /Standard Room / N/A / N/A</td>
                    <td>2(A)0(C)</td>
                    <td>Reserve</td>
                    <td class="text-right px-0">$ 1035.00</td>
                    <td></td>
                    <td>
                      <button class="btn btn-primary btn-sm"><i class="fas fa-print"></i></button>
                      <button class="btn btn-danger btn-sm"><i class="fas fa-envelope-open-text"></i></button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="row p-1 bg-primary align-items-center">
              <div class="col-12 text-center">
                <button class="btn btn-light m-1"><i class="fas fa-print"></i> Print</button>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="list-reservation-list" role="tabpanel" aria-labelledby="list-reservation-list">
          <div class="col-md-12 p-0 pt-3 filtre">
            <div class="row px-3">
              <div class="col-md-2 px-1">
                <label for="nameOrId">Name/Group ID/Rest ID</label>
                <input type="text" id="nameOrId" class="form-control">
              </div>
              <div class="col-md-1 px-1 align-self-center">
                <label class="label-control-inline m-auto"><input type="radio" name="basedOn">Created on</label>
                <label class="label-control-inline m-auto"><input type="radio" name="basedOn">Res</label>
              </div>
              <div class="col px-1">
                <label for="from">From</label>
                <input type="date" id="from" class="form-control inputCalendar">
              </div>
              <div class="col px-1">
                <label for="to">To</label>
                <input type="date" id="to" class="form-control inputCalendar">
              </div>
              <div class="col-md-2 px-1">
                <label for="allNotes">All Notes</label>
                <select id="allNotes" class="custom-select">
                  <option value=""></option>
                </select>
              </div>
              <div class="col-md-2 px-1">
                <label for="filterBy">Filter By</label>
                <div class="input-group">
                  <select id="filterBy" class="custom-select"></select>
                  <input type="text" id="textFilterBy" class="form-control">
                </div>
              </div>
              <div class="col-md-1 px-1">
                <label for="sortBy"> Sort By</label>
                <select id="sortBy" class="custom-select"></select>
              </div>
            </div>
            <div class="row px-3 mt-3">
              <button id="btnSearchReservation" class="btn btn-primary w-25 m-auto"><i class="fas fa-search"></i>
                Search</button>
            </div>
            <hr>
            <div class="row p-3">
              <div class="col-md-2 px-1">
                <label for="">&nbsp;</label>
                <select id="" class="custom-select">
                  <option value="">All</option>
                  <option value="">Group</option>
                  <option value="">Single</option>
                </select>
              </div>
              <div class="col-md-2 px-1">
                <label for="">Source</label>
                <select id="" class="custom-select">
                  <option value=""></option>
                </select>
              </div>
              <div class="col-md-2 px-1">
                <label for="">Status</label>
                <select id="" class="custom-select"></select>
              </div>
              <div class="col-md-6 align-self-end">

                <div class="custom-control custom-checkbox custom-control-inline">
                  <input type="checkbox" id="rl-expludeComp" class="custom-control-input" value="off">
                  <label class="custom-control-label" for="rl-expludeComp">Exclude Comp.</label>
                </div>

                <div class="custom-control custom-checkbox custom-control-inline">
                  <input type="checkbox" id="rl-thirdResId" class="custom-control-input" value="off">
                  <label class="custom-control-label" for="rl-thirdResId">3rd Party ResID</label>
                </div>

                <div class="custom-control custom-checkbox custom-control-inline">
                  <input type="checkbox" id="rl-dayUseRes" class="custom-control-input" value="off">
                  <label class="custom-control-label" for="rl-dayUseRes">Show Day Use Only</label>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="table-responsive">
              <table id="tableReservation" class="table table-striped table-hover table-sm text-center dataTable">
                <thead class="bg-primary text-white">
                  <tr>
                    <th>Group ID</th>
                    <th>Res ID</th>
                    <th>Guest Name</th>
                    <th>StayDuration</th>
                    <th>Room#/Type/Block/Floor</th>
                    <th>Pax</th>
                    <th>Status</th>
                    <th>Amount</th>
                    <th>Prefereces/Notes</th>
                    <th>Check in Card</th>
                  </tr>
                </thead>
                <tbody class="cursor-pointer">
                  <tr>
                    <td></td>
                    <td>081830</td>
                    <td>Anastacia Grey</td>
                    <td>18 Aug - 24 Aug(6)</td>
                    <td>N/A /Standard Room / N/A / N/A</td>
                    <td>2(A)0(C)</td>
                    <td>Reserve</td>
                    <td class="text-right px-0">$ 1035.00</td>
                    <td></td>
                    <td>
                      <button class="btn btn-primary btn-sm"><i class="fas fa-print"></i></button>
                      <button class="btn btn-danger btn-sm"><i class="fas fa-envelope-open-text"></i></button>
                    </td>
                  </tr>
                  <tr>
                    <td></td>
                    <td>081830</td>
                    <td>Maria Grey</td>
                    <td>18 Aug - 24 Aug(6)</td>
                    <td>N/A /Standard Room / N/A / N/A</td>
                    <td>2(A)0(C)</td>
                    <td>Reserve</td>
                    <td class="text-right px-0">$ 1035.00</td>
                    <td></td>
                    <td>
                      <button class="btn btn-primary btn-sm"><i class="fas fa-print"></i></button>
                      <button class="btn btn-danger btn-sm"><i class="fas fa-envelope-open-text"></i></button>
                    </td>
                  </tr>
                  <tr>
                    <td></td>
                    <td>081830</td>
                    <td>Jose Grey</td>
                    <td>18 Aug - 24 Aug(6)</td>
                    <td>N/A /Standard Room / N/A / N/A</td>
                    <td>2(A)0(C)</td>
                    <td>Reserve</td>
                    <td class="text-right px-0">$ 1035.00</td>
                    <td></td>
                    <td>
                      <button class="btn btn-primary btn-sm"><i class="fas fa-print"></i></button>
                      <button class="btn btn-danger btn-sm"><i class="fas fa-envelope-open-text"></i></button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="row p-1 bg-primary align-items-center">
              <div class="col-12 text-center">
                <button class="btn btn-light m-1"><i class="fas fa-print"></i> Print</button>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="list-temp-room-list" role="tabpanel" aria-labelledby="list-temp-room-list">
          <div class="col-md-12 p-0 pt-3 filtre">
            <div class="row px-3">
              <div class="col-md-2 px-1">
                <label for="nameOrId">Name/Group ID/Rest ID</label>
                <input type="text" id="nameOrId" class="form-control">
              </div>
              <div class="col-md-2 px-1 align-self-center">
                <label class="label-control-inline m-auto"><input type="radio" name="basedOn" value=""> Release
                  date</label>
                <label class="label-control-inline m-auto"><input type="radio" name="basedOn" value=""> Created
                  on</label>
                <label class="label-control-inline m-auto"><input type="radio" name="basedOn" value=""> Block</label>
              </div>
              <div class="col px-1">
                <label for="from">From</label>
                <input type="date" id="from" class="form-control inputCalendar">
              </div>
              <div class="col px-1">
                <label for="to">To</label>
                <input type="date" id="to" class="form-control inputCalendar">
              </div>
              <div class="col-md-2 px-1">
                <label for="allNotes">All Notes</label>
                <select id="allNotes" class="custom-select">
                  <option value=""></option>
                </select>
              </div>
              <div class="col-md-1 px-1">
                <label for="filterBy">Filter By</label>
                <select id="filterBy" class="custom-select"></select>
              </div>
              <div class="col-md-1 px-1">
                <label for="sortBy"> Sort By</label>
                <select id="sortBy" class="custom-select"></select>
              </div>
            </div>
            <div class="row px-3 mt-3">
              <button id="btnSearchReservation" class="btn btn-primary w-25 m-auto"><i class="fas fa-search"></i>
                Search</button>
            </div>
            <hr>
            <div class="row p-3">
              <div class="col-md-2 px-1">
                <label for="">&nbsp;</label>
                <select id="typeReservation" class="custom-select">
                  <option value="">All</option>
                  <option value="">Group</option>
                  <option value="">Single</option>
                </select>
              </div>
              <div class="col-md-6 align-self-end">
                <div class="custom-control custom-checkbox custom-control-inline">
                  <input type="checkbox" id="trl-dayUseRes" class="custom-control-input" value="off">
                  <label class="custom-control-label" for="trl-dayUseRes">Show Day Use Only</label>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="table-responsive">
              <table id="tableTempRoom" class="table table-striped table-hover table-sm text-center dataTable">
                <thead class="bg-primary text-white">
                  <tr>
                    <th>Group ID</th>
                    <th>Res ID</th>
                    <th>Guest Name</th>
                    <th>Phone/Mobile</th>
                    <th>Email</th>
                    <th>Rease date</th>
                    <th>Booker details</th>
                    <th>Stay duration</th>
                    <th>Room# / Type/Notes</th>
                    <th>Pax</th>
                    <th>Preferences/Notes</th>
                    <th>Amount</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody class="cursor-pointer">
                  <tr>
                    <td></td>
                    <td>081830</td>
                    <td>Anastacia Grey</td>
                    <td>18 Aug - 24 Aug(6)</td>
                    <td>N/A /Standard Room / N/A / N/A</td>
                    <td>2(A)0(C)</td>
                    <td>Reserve</td>
                    <td class="text-right px-0">$ 1035.00</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                      <button class="btn btn-primary btn-sm"><i class="fas fa-print"></i></button>
                      <button class="btn btn-danger btn-sm"><i class="fas fa-envelope-open-text"></i></button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="row p-1 bg-primary align-items-center">
              <div class="col-8">
                <button class="btn btn-light m-1"><i class="fas fa-stopwatch"></i> Hold Till</button>
                <button class="btn btn-light m-1"><i class="fas fa-print"></i> Print</button>
              </div>

              <div class="col-4">
                <div class="input-group">
                  <select id="" class="custom-select"></select>
                  <div class="input-group-prepend">
                    <button class="btn btn-light"><i class="fas fa-file-export"></i> Export</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="list-no-show-list" role="tabpanel" aria-labelledby="list-no-show-list">
          <div class="col-md-12 p-0 pt-3 filtre">
            <div class="row px-3">
              <div class="col-md-2 px-1">
                <label for="nameOrId">Name/Group ID/Rest ID</label>
                <input type="text" id="nameOrId" class="form-control">
              </div>
              <div class="col-md-2 px-1 align-self-center">
                <label class="label-control-inline m-auto"><input type="radio" name="basedOn" value=""> Created
                  on</label>
                <label class="label-control-inline m-auto"><input type="radio" name="basedOn" value=""> Check in</label>
              </div>
              <div class="col px-1">
                <label for="from">From</label>
                <input type="date" id="from" class="form-control inputCalendar">
              </div>
              <div class="col px-1">
                <label for="to">To</label>
                <input type="date" id="to" class="form-control inputCalendar">
              </div>
              <div class="col-md-2 px-1">
                <label for="allNotes">All Notes</label>
                <select id="allNotes" class="custom-select">
                  <option value=""></option>
                </select>
              </div>
            </div>
            <div class="row px-3 mt-3">
              <button class="btn btn-primary w-25 m-auto"><i class="fas fa-search"></i> Search</button>
            </div>
            <hr>
            <div class="row p-3">
              <div class="col-md-2 px-1">
                <label for="TypeReservation">Type Reservation</label>
                <select id="typeReservation" class="custom-select">
                  <option value="">All</option>
                  <option value="">Group</option>
                  <option value="">Single</option>
                </select>
              </div>
              <div class="col-md-6 align-self-end">
                <div class="custom-control custom-checkbox custom-control-inline">
                  <input type="checkbox" id="nsl-dayUseRes" class="custom-control-input" value="off">
                  <label class="custom-control-label" for="nsl-dayUseRes">Show Day Use Only</label>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="table-responsive">
              <table id="tableNoShowList" class="table table-striped table-hover table-sm text-center dataTable">
                <thead class="bg-primary text-white">
                  <tr>
                    <th>Group ID</th>
                    <th>Res ID</th>
                    <th>Guest Name</th>
                    <th>Stay Duration</th>
                    <th>Room# / Type</th>
                    <th>Pax</th>
                    <th>Status</th>
                    <th>Amount</th>
                    <th>Charge</th>
                    <th>Preferences/Notes</th>
                  </tr>
                </thead>
                <tbody class="cursor-pointer">
                </tbody>
              </table>
            </div>
            <div class="row p-1 bg-primary align-items-center">
              <div class="col-12 text-center">
                <button class="btn btn-light m-1"><i class="fas fa-print"></i> Print</button>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="list-cancellation-list" role="tabpanel" aria-labelledby="list-cancellation-list">
          <div class="col-md-12 p-0 pt-3 filtre">
            <div class="row px-3">
              <div class="col-md-2 px-1">
                <label for="nameOrId">Name/Group ID/Rest ID</label>
                <input type="text" id="nameOrId" class="form-control">
              </div>
              <div class="col-md-3 px-1 align-self-end">
                <label class="label-control-inline m-auto"><input type="radio" name="basedOn" value=""> Created
                  on</label>
                <label class="label-control-inline m-auto"><input type="radio" name="basedOn" value=""> Check in</label>
              </div>
              <div class="col px-1">
                <label for="from">From</label>
                <input type="date" id="from" class="form-control inputCalendar">
              </div>
              <div class="col px-1">
                <label for="to">To</label>
                <input type="date" id="to" class="form-control inputCalendar">
              </div>
            </div>
            <div class="row px-3 mt-3">
              <button class="btn btn-primary w-25 m-auto"><i class="fas fa-search"></i> Search</button>
            </div>
            <hr>
            <div class="row p-3">
              <div class="col-md-2 px-1">
                <label for="">&nbsp;</label>
                <select id="typeReservation" class="custom-select">
                  <option value="">All</option>
                  <option value="">Group</option>
                  <option value="">Single</option>
                </select>
              </div>
              <div class="col-md-10 align-self-end">
                <div class="custom-control custom-checkbox custom-control-inline">
                  <input type="checkbox" id="cancellationList-exclude" class="custom-control-input" value="off">
                  <label class="custom-control-label" for="cancellationList-exclude">Exclude 3rd party res ID</label>
                </div>
                <div class="custom-control custom-checkbox custom-control-inline">
                  <input type="checkbox" id="cancellationList-dayUseRes" class="custom-control-input" value="off">
                  <label class="custom-control-label" for="cancellationList-dayUseRes">Show Day Use Only</label>
                </div>
                <div class="custom-control custom-checkbox custom-control-inline">
                  <input type="checkbox" id="cancellationList-exludeNoShow" class="custom-control-input" value="off">
                  <label class="custom-control-label" for="cancellationList-exludeNoShow">Exclude No Show</label>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="table-responsive">
              <table id="tableCancellationList" class="table table-striped table-hover table-sm dataTable text-center">
                <thead class="bg-primary text-white">
                  <tr>
                    <th>Group ID</th>
                    <th>Res ID</th>
                    <th>Guest Name</th>
                    <th>Stay Duration</th>
                    <th>Room# / Type</th>
                    <th>Pax</th>
                    <th>Status</th>
                    <th>Amount</th>
                    <th>Charge</th>
                    <th>Reason</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody class="cursor-pointer">
                </tbody>
              </table>
            </div>
            <div class="row p-1 bg-primary align-items-center">
              <div class="col-12 text-center">
                <button class="btn btn-light m-1"><i class="fas fa-print"></i> Print</button>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="list-checkout-pending-list" role="tabpanel"
          aria-labelledby="list-checkout-pending-list">
          <div class="col-md-12 p-0 pt-3 filtre">
            <div class="row px-3">
              <div class="col-md-2 px-1">
                <label for="nameOrId">Name/Group ID/Rest ID</label>
                <input type="text" id="naeOrId" class="form-control">
              </div>
              <div class="col-md-1 px-1 align-self-center">
                <label class="label-control-inline m-auto"><input type="radio" name="basedOn">Created on</label>
                <label class="label-control-inline m-auto"><input type="radio" name="basedOn">Check Out</label>
              </div>
              <div class="col px-1">
                <label for="from">From</label>
                <input type="date" id="from" class="form-control inputCalendar">
              </div>
              <div class="col px-1">
                <label for="to">To</label>
                <input type="date" id="to" class="form-control inputCalendar">
              </div>
              <div class="col-md-2 px-1">
                <label for="allNotes">All Notes</label>
                <select id="allNotes" class="custom-select">
                  <option value=""></option>
                </select>
              </div>
              <div class="col-md-2 px-1">
                <label for="filterBy">Filter By</label>
                <div class="input-group">
                  <select id="filterBy" class="custom-select"></select>
                  <input type="text" class="form-control">
                </div>
              </div>
              <div class="col-md-1 px-1">
                <label for="sortBy"> Sort By</label>
                <select id="sortBy" class="custom-select"></select>
              </div>
            </div>
            <div class="row px-3 mt-3">
              <button class="btn btn-primary w-25 m-auto"><i class="fas fa-search"></i> Search</button>
            </div>
            <hr>
            <div class="row p-3">
              <div class="col-md-2 px-1">
                <label for="typeReservation">Type Reservation</label>
                <select id="typeReservation" class="custom-select">
                  <option value="">All</option>
                  <option value="">Group</option>
                  <option value="">Single</option>
                </select>
              </div>
              <div class="col-md-6 align-self-end">
                <div class="custom-control custom-checkbox custom-control-inline">
                  <input type="checkbox" id="checkOoutPending-list-dayUseRes" class="custom-control-input" value="off">
                  <label class="custom-control-label" for="checkOoutPending-list-dayUseRes">Show Day Use Only</label>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="table-responsive">
              <table id="tableCheckOutPendingList"
                class="table table-striped table-hover table-sm dataTable text-center">
                <thead class="bg-primary text-white">
                  <tr>
                    <th>Group ID</th>
                    <th>Res ID</th>
                    <th>Guest Name</th>
                    <th>StayDuration</th>
                    <th>Room#/Type/Block/Floor</th>
                    <th>Pax</th>
                    <th>Status</th>
                    <th>Amount</th>
                    <th>Prefereces/Notes</th>
                  </tr>
                </thead>
                <tbody class="cursor-pointer">
                  <tr>
                    <td></td>
                    <td>081830</td>
                    <td>Anastacia Grey</td>
                    <td>18 Aug - 24 Aug(6)</td>
                    <td>N/A /Standard Room / N/A / N/A</td>
                    <td>2(A)0(C)</td>
                    <td>Reserve</td>
                    <td class="text-right px-0">$ 1035.00</td>
                    <td></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="row p-1 bg-primary align-items-center">
              <div class="col-12 text-center">
                <button class="btn btn-light m-1"><i class="fas fa-print"></i> Print</button>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="list-pending-folio" role="tabpanel" aria-labelledby="list-pending-folio">
          <div class="col-md-12 p-0 pt-3 filtre">
            <div class="row px-3">
              <div class="col-md-2 px-1 align-self-end">
                <span>Pending folio(s) check-in between</span>
              </div>
              <div class="col px-1">
                <label for="from">From</label>
                <input type="date" id="from" class="form-control inputCalendar">
              </div>
              <div class="col px-1">
                <label for="to">To</label>
                <input type="date" id="to" class="form-control inputCalendar">
              </div>
              <div class="col-md-2 px-1 align-self-center">
                <label class="label-control-inline m-auto"><input type="radio" name="basedOn">Created on</label>
                <label class="label-control-inline m-auto"><input type="radio" name="basedOn">Check In</label>
              </div>
              <div class="col-md-3 align-self-center px-2">
                <div class="custom-control custom-checkbox custom-control-inline">
                  <input type="checkbox" id="pendingFolio-show-refundable" class="custom-control-input" value="off">
                  <label class="custom-control-label" for="pendingFolio-show-refundable">Show refundable</label>
                </div>
              </div>
            </div>
            <div class="row px-3 mt-3">
              <button class="btn btn-primary w-25 m-auto"><i class="fas fa-search"></i> Search</button>
            </div>
            <hr>
            <div class="row p-3">
              <div class="col-md-2 px-1">
                <label for="typeReservation">Type Reservation</label>
                <select id="typeReservation" class="custom-select">
                  <option value="">All</option>
                  <option value="">Group</option>
                  <option value="">Single</option>
                </select>
              </div>
              <div class="col-md-6 align-self-end">
                <div class="custom-control custom-checkbox custom-control-inline">
                  <input type="checkbox" id="pendingFolio-dayUseRes" class="custom-control-input" value="off">
                  <label class="custom-control-label" for="pendingFolio-showDayUseOnly">Show Day Use Only</label>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="table-responsive">
              <table id="tablePendingFolio" class="table table-striped table-hover table-sm dataTable text-center">
                <thead class="bg-primary text-white">
                  <tr>
                    <th>Group ID</th>
                    <th>Res ID</th>
                    <th>Booking Type/Source</th>
                    <th>Guest Name</th>
                    <th>Stay Details</th>
                    <th>Folio</th>
                    <th>Amount</th>
                    <th>Paid</th>
                    <th>Balance</th>
                  </tr>
                </thead>
                <tbody class="cursor-pointer">
                </tbody>
              </table>
            </div>
            <div class="row p-1 bg-primary align-items-center">
              <div class="col-12 text-center">
                <button class="btn btn-light m-1"><i class="fas fa-print"></i> Print</button>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="list-booking-deposit" role="tabpanel" aria-labelledby="list-booking-deposit">
          <div class="col-md-12 p-0 pt-3 filtre">
            <div class="row px-3">
              <div class="col px-1">
                <label for="date">Booking Deposits</label>
                <input type="date" id="date" class="form-control inputCalendar">
              </div>
            </div>
            <div class="row px-3 mt-3">
              <button class="btn btn-primary w-25 m-auto"><i class="fas fa-search"></i> Search</button>
            </div>
            <hr>
            <div class="row p-3">
              <div class="col-md-2 px-1">
                <label for="typeReservation">Type Reservation</label>
                <select id="typeReservation" class="custom-select">
                  <option value="">All</option>
                  <option value="">Group</option>
                  <option value="">Single</option>
                </select>
              </div>
              <div class="col-md-2 px-1">
                <label for="deposits">Deposits</label>
                <select id="deposit" class="custom-select">
                  <option value="">All</option>
                  <option value="">Pending</option>
                  <option value="">Overdue</option>
                </select>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="table-responsive">
              <h3>Pending Booking Deposits</h3>
              <table id="tablegBookingDeposits" class="table table-striped table-hover table-sm dataTable text-center">
                <thead class="bg-primary text-white">
                  <tr>
                    <th>Group ID</th>
                    <th>Res ID</th>
                    <th>Booking Type/Source</th>
                    <th>Guest Name</th>
                    <th>Stay Details</th>
                    <th>Booking Amount</th>
                    <th>Deposit</th>
                    <th>Balance</th>
                    <th>Due Date</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody class="cursor-pointer">
                </tbody>
              </table>
              <hr>
              <h3>Overdue Booking Deposits</h3>
              <table id="tableOverDueBookingDeposits"
                class="table table-striped table-hover table-sm dataTable text-center">
                <thead class="bg-primary text-white">
                  <tr>
                    <th>Group ID</th>
                    <th>Res ID</th>
                    <th>Booking Type/Source</th>
                    <th>Guest Name</th>
                    <th>Stay Details</th>
                    <th>Booking Amount</th>
                    <th>Deposit</th>
                    <th>Balance</th>
                    <th>Due Date</th>
                    <th>Action</th>
                    <th>Cxl Charge</th>
                  </tr>
                </thead>
                <tbody class="cursor-pointer">
                </tbody>
                <tfoot>
                  <tr>
                    <td class="bg-primary p-1" colspan="11">
                      <button class="btn btn-light btn-sm">Release Booking(s)</button>
                    </td>
                  </tr>
                </tfoot>
              </table>
            </div>
            <div class="row p-1 bg-primary align-items-center">
              <div class="col-12 text-center">
                <button class="btn btn-light m-1"><i class="fas fa-print"></i> Print</button>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="list-payment-tracker" role="tabpanel" aria-labelledby="list-payment-tracker">
          <div class="col-md-12 p-0 pt-3 filtre">
            <div class="row px-3">
              <h5 class="w-100">Payment Tracker</h5>
              <div class="col px-1">
                <label for="from">From</label>
                <input type="date" id="from" class="form-control inputCalendar">
              </div>
              <div class="col px-1">
                <label for="to">To</label>
                <input type="date" id="to" class="form-control inputCalendar">
              </div>
              <div class="col-md-4 px-1">
                <label for="due">Due</label>
                <div class="input-group">
                  <select id="due" class="custom-select">
                    <option value="<=">
                      <= </option>
                    <option value=">=">>=</option>
                  </select>
                  <input type="text" id="dueValue" class="form-control">
                </div>
              </div>
            </div>
            <div class="row px-3 mt-3">
              <button id="btnPaymentTracker" class="btn btn-primary w-25 m-auto"><i class="fas fa-search"></i>
                Search</button>
            </div>
            <hr>
            <div class="row p-3">
              <div class="col-md-2 px-1">
                <label for="typeReservation">Type Reservation</label>
                <select id="typeReservation" class="custom-select">
                  <option value="">All</option>
                  <option value="">Group</option>
                  <option value="">Single</option>
                </select>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="table-responsive">
              <table id="tablePaymentTracker" class="table table-striped table-hover table-sm dataTable text-center">
                <thead class="bg-primary text-white">
                  <tr>
                    <th>Res ID/Group ID</th>
                    <th>Guest Name</th>
                    <th>Stay Details</th>
                    <th>Paid</th>
                    <th>Due Till Now</th>
                  </tr>
                </thead>
                <tbody class="cursor-pointer">
                </tbody>
              </table>
            </div>
            <div class="row p-1 bg-primary align-items-center">
              <div class="col-12 text-center">
                <button class="btn btn-light m-1"><i class="fas fa-print"></i> Print</button>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="list-guest-in-house-list" role="tabpanel"
          aria-labelledby="list-guest-in-house-list">
          <div class="col-md-12 p-0 pt-3 filtre">
            <div class="row px-3">
              <div class="col-md-2 px-1">
                <label for="nameOrId">Name/Group ID/Rest ID</label>
                <input type="text" id="nameOrId" class="form-control">
              </div>
              <div class="col px-1">
                <label for="stayFrom">Guest Stay From</label>
                <input type="date" id="stayFrom" class="form-control inputCalendar">
              </div>
              <div class="col px-1">
                <label for="stayTo">Guest Stay To</label>
                <input type="date" id="stayTo" class="form-control inputCalendar">
              </div>
              <div class="col-md-1 px-1">
                <label for="guestStatus">Guest Status</label>
                <select id="guestStatus" class="custom-select"></select>
              </div>
              <div class="col-md-2">
                <label for="typeReservation">Type Reservation</label>
                <select id="typeReservation" class="custom-select">
                  <option value="">All</option>
                  <option value="">Group</option>
                  <option value="">Single</option>
                </select>
              </div>
              <div class="col-md-2 px-1">
                <label for="filterByType">Filter By</label>
                <div class="input-group">
                  <select id="filterByType" class="custom-select"></select>
                  <input type="text" id="filterByDescription" class="form-control">
                </div>
              </div>
              <div class="col-md-1 px-1">
                <label for="roomType">Room Type</label>
                <select id="roomType" class="custom-select"></select>
              </div>
            </div>
            <div class="row px-3 mt-3">
              <button id="btnGuestInHouse" class="btn btn-primary w-25 m-auto"><i class="fas fa-search"></i>
                Search</button>
            </div>
            <hr>
            <div class="row p-3">
              <div class="col-md-8 align-self-center">
                <div class="custom-control custom-checkbox custom-control-inline">
                  <input type="checkbox" id="gihl-paxDetails" class="custom-control-input" value="off">
                  <label class="custom-control-label" for="gihl-paxDetails">Pax Details</label>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="table-responsive">
              <table id="tableGuestInHouse" class="table table-striped table-hover table-sm dataTable text-center">
                <thead class="bg-primary text-white">
                  <tr>
                    <th>Res ID</th>
                    <th>Group ID</th>
                    <th>Guest Name</th>
                    <th id="columnPaxDetails">Pax Details</th>
                    <th>Guest Check In</th>
                    <th>Guest Check Out</th>
                    <th>Guest Status</th>
                    <th>Reservation Stay Duration</th>
                    <th>Room Type/Room/Block/Floor</th>
                  </tr>
                </thead>
                <tbody class="cursor-pointer">
                </tbody>
              </table>
            </div>
            <div class="row p-1 bg-primary align-items-center">
              <div class="col-8">
                <button class="btn btn-light m-1"><i class="fas fa-print"></i> Print</button>
              </div>
              <div class="col-4">
                <div class="input-group">
                  <select id="" class="custom-select"></select>
                  <div class="input-group-prepend">
                    <button class="btn btn-light"><i class="fas fa-file-export"></i> Export</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="list-party-reservation-list" role="tabpanel"
          aria-labelledby="list-party-reservation-list">
          <div class="col-md-12 p-0 pt-3 filtre">
            <div class="row px-3">
              <div class="col-md-2 px-2">
                <label for="searchTypeChk">Search Type</label>
                <select id="searchTypeChk" class="custom-select"></select>
              </div>
              <div class="col px-1">
                <label for="stayFrom">Guest Stay From</label>
                <input type="date" id="stayFrom" class="form-control inputCalendar">
              </div>
              <div class="col px-1">
                <label for="stayTo">Guest Stay To</label>
                <input type="date" id="stayTo" class="form-control inputCalendar">
              </div>
            </div>
            <div class="row px-3 mt-3">
              <button id="btnPartyReservation" class="btn btn-primary w-25 m-auto"><i class="fas fa-search"></i>
                Search</button>
            </div>
            <hr>
            <div class="row p-3">
              <div class="col-md-1 px-1">
                <label for="msgStatus">Search Msg Status</label>
                <select id="msgStatus" class="custom-select"></select>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="table-responsive">
              <table id="tablePartyReservation" class="table table-striped table-hover table-sm dataTable text-center">
                <thead class="bg-primary text-white">
                  <tr>
                    <th>Ref#</th>
                    <th>Chanel</th>
                    <th>HLX Received On (GMT)</th>
                    <th>HLX Created/Cancelled On (GMT)</th>
                    <th>Group ID</th>
                    <th>Room Type</th>
                    <th>Rate Plan Code</th>
                    <th>No Of Rooms</th>
                    <th>Pax</th>
                    <th>Check-In Date</th>
                    <th>Check-Out Date</th>
                    <th>Res Staus Channnel</th>
                    <th>Time Taken[HLX-CM]</th>
                    <th>Status</th>
                    <th>Message</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody class="cursor-pointer">
                </tbody>
              </table>
            </div>
            <div class="row p-1 bg-primary align-items-center">
              <div class="col-8">
                <button class="btn btn-light m-1"><i class="fas fa-print"></i> Print</button>
              </div>
              <div class="col-4">
                <div class="input-group">
                  <select id="convertTo" class="custom-select"></select>
                  <div class="input-group-prepend">
                    <button class="btn btn-light"><i class="fas fa-file-export"></i> Export</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="list-alertAndNotifications" role="tabpanel"
          aria-labelledby="list-alertAndNotification">
          <div class="col-md-12 p-0 py-3 filtre">
            <div class="row px-3">
              <div class="col px-1">
                <label for="stayFrom">Event Sent From</label>
                <input type="date" id="stayFrom" class="form-control inputCalendar">
              </div>
              <div class="col px-1">
                <label for="stayTo">Event Sent To</label>
                <input type="date" id="stayTo" class="form-control inputCalendar">
              </div>
              <div class="col-md-2 px-1">
                <label for="msgStatus">Search Msg Status</label>
                <select id="msgStatus" class="custom-select"></select>
              </div>
            </div>
            <div class="row px-3 mt-3">
              <button class="btn btn-primary w-25 m-auto"><i class="fas fa-search"></i> Search</button>
            </div>
          </div>
          <div class="col-md-12">
            <div class="table-responsive">
              <table id="tableAlertAndNotification" class="table table-striped table-hover dataTable text-center">
                <thead class="bg-primary text-white">
                  <tr>
                    <th>Event</th>
                    <th>Notify To</th>
                    <th>Delivery #</th>
                    <th>Sent On</th>
                    <th>Event Details</th>
                  </tr>
                </thead>
                <tbody class="cursor-pointer">
                </tbody>
              </table>
            </div>
            <div class="row p-1 bg-primary align-items-center">
              <div class="col-12 text-center">
                <button class="btn btn-light m-1"><i class="fas fa-print"></i> Print</button>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="list-dnr-house-report" role="tabpanel" aria-labelledby="list-dnr-house-report">
          <div class="col-md-12 p-0 pt-3 filtre">
            <div class="row px-3">
              <div class="col-md-2 px-1 align-self-center">
                <label class="label-control-inline m-auto"><input type="radio" id="dnrCreate" name="dnrOption"
                    value="created On"> Created on</label>
                <label class="label-control-inline m-auto"><input type="radio" id="dnrDate" name="dnrOption"
                    value="DNR/House use date"> DNR/House use date</label>
              </div>
              <div class="col px-1">
                <label for="stayFrom">From</label>
                <input type="date" id="stayFrom" class="form-control inputCalendar">
              </div>
              <div class="col px-1">
                <label for="typeRoom">To</label>
                <input type="date" id="stayTo" class="form-control inputCalendar">
              </div>
            </div>
            <div class="row px-3 mt-3">
              <button id="btnDnrHouseReport" class="btn btn-primary w-25 m-auto"><i class="fas fa-search"></i>
                Search</button>
            </div>
            <hr>
            <div class="row p-3">
              <div class="col-md-2 px-1">
                <label for="reportType">Report Type</label>
                <select id="reportType" class="custom-select"></select>
              </div>
              <div class="col-md-2 px-1">
                <label for="roomType">Room Type</label>
                <select id="roomType" class="custom-select"></select>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="table-responsive">
              <table id="tableDNRHouseReport" class="table table-striped table-hover dataTable text-center">
                <thead class="bg-primary text-white">
                  <tr>
                    <th>Room Type</th>
                    <th>Room</th>
                    <th>From Date</th>
                    <th>To Date</th>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Created On</th>
                    <th>Created By</th>
                  </tr>
                </thead>
                <tbody class="cursor-pointer">
                </tbody>
              </table>
            </div>
            <div class="row p-1 bg-primary align-items-center">
              <div class="col-8">
                <button class="btn btn-light m-1"><i class="fas fa-print"></i> Print</button>
              </div>
              <div class="col-4">
                <div class="input-group">
                  <select id="" class="custom-select"></select>
                  <div class="input-group-prepend">
                    <button class="btn btn-light"><i class="fas fa-file-export"></i> Export</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="list-rate-posting-report" role="tabpanel"
          aria-labelledby="list-rate-posting-report">
          <div class="col-md-12 p-0 py-3 filtre">
            <div class="row px-3">
              <div class="col-2 px-2">
                <label for="reportDate">Report Date</label>
                <input type="date" id="reportDate" class="form-control inputCalendar">
              </div>
              <div class="col-md-2 px-1">
                <label for="filterBy">Filter By</label>
                <div class="input-group">
                  <select id="filterByType" class="custom-select"></select>
                  <input type="text" id="filterByDescription" class="form-control">
                </div>
              </div>
              <div class="col-md-2 px-1 align-self-end">
                <div class="custom-control custom-checkbox custom-control-inline">
                  <input type="checkbox" id="ratePR-showPN" class="custom-control-input" autocomplete="off" checked
                    value="on">
                  <label class="custom-control-label" for="ratePR-showPN" data-toggle="collapse"
                    data-target="#rateRP-notes">Show Preference / Notes</label>
                </div>
              </div>
              <div id="rateRP-notes" class="col-md-3 px-1 collapse show">
                <label for="notes">Notes</label>
                <select id="notes" class="custom-select">
                  <option value="">--All Notes Title--</option>
                </select>
              </div>
              <div class="col px-1 align-self-end">
                <div class="custom-control custom-checkbox custom-control-inline">
                  <input type="checkbox" id="ratePR-includeNoShowsC" class="custom-control-input" value="off">
                  <label class="custom-control-label" for="ratePR-includeNoShowsC">Include No-Shows /
                    Cancellations</label>
                </div>
              </div>
            </div>
            <div class="row px-3 mt-3">
              <button id="btnRatePostingReport" class="btn btn-primary w-25 m-auto"><i class="fas fa-search"></i>
                Search</button>
            </div>
          </div>
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped table-hover table-sm text-center table-bordered-0">
                <thead class="bg-primary text-white">
                  <tr>
                    <th>Res ID</th>
                    <th>Pax</th>
                    <th>Guest Name</th>
                    <th>Company</th>
                    <th>Room Type</th>
                    <th>Room</th>
                    <th>Rate Plan</th>
                    <th>Rack Rate</th>
                    <th>Rate</th>
                    <th>Variance</th>
                    <th>Single Preferences/Notes</th>
                    <th>Group Preferences/Notes</th>
                    <th class="p-0" colspan="2">
                      <div class="col-12 p-1 border-bottom">Tax</div>
                      <div class="col-12 d-flex p-0">
                        <div style="align-self: center;" class="col p-1 border-right">Vat</div>
                        <div class="col p-1">Service Charge</div>
                      </div>
                    </th>
                  </tr>
                </thead>
                <tbody class="cursor-pointer">
                  <tr>
                    <td>081816</td>
                    <td>2</td>
                    <td>Alice Swift</td>
                    <td></td>
                    <td>Superior Room</td>
                    <td>SUP-131</td>
                    <td>Honeymoon packed</td>
                    <td>200.00</td>
                    <td>200.00</td>
                    <td>0.00</td>
                    <td></td>
                    <td></td>
                    <td>20.00</td>
                    <td>10.00</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="row p-1 bg-primary align-items-center">
              <div class="col-12 text-center">
                <button class="btn btn-light m-1"><i class="fas fa-print"></i> Print</button>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="list-guest-lookUp" role="tabpanel" aria-labelledby="list-guest-lookUp">
          <div class="col-md-12 p-0 py-3 filtre">
            <div class="row">
              <p class="bg-primary p-1 w-100 text-white">Please enter any of the information below to screen the guest
                list:</p>
            </div>
            <div class="row">
              <div class="col-md-4 border-dashed-right">
                <div class="row">
                  <div class="col-6">
                    <label for="guestId">Guest ID</label>
                    <input type="text" id="guestId" class="form-control">
                  </div>
                  <div class="col-6">
                    <label for="vip">VIP #</label>
                    <input type="text" id="vip" class="form-control">
                  </div>
                  <div class="col-12">
                    <label for="room">Room</label>
                    <input type="text" id="room" class="form-control">
                  </div>
                  <div class="col-12">
                    <label for="partialName">Partial Name</label>
                    <input type="text" id="partialName" class="form-control">
                  </div>
                  <div class="col-12">
                    <label for="firstName">First Name</label>
                    <input type="text" id="firstName" class="form-control">
                  </div>
                  <div class="col-12">
                    <label for="lastName">Last Name</label>
                    <input type="text" id="lastName" class="form-control">
                  </div>
                  <div class="col-6">
                    <label for="IDType">ID Type</label>
                    <select id="IDType" class="custom-select"></select>
                  </div>
                  <div class="col-6">
                    <label for="ID">ID #</label>
                    <input type="text" id="ID" class="form-control">
                  </div>
                  <div class="col-6">
                    <label for="searchType">Search Type</label>
                    <select id="typeReservation" class="custom-select"></select>
                  </div>
                  <div class="col-6">
                    <label for="noSearchType">#</label>
                    <input type="text" id="noSearchType" class="form-control">
                  </div>
                </div>
              </div>
              <div class="col-md-4 border-dashed-right">
                <div class="row">
                  <div class="col-12">
                    <label for="address">Address</label>
                    <input type="text" id="address" class="form-control">
                  </div>
                  <div class="col-12">
                    <label for="city">City</label>
                    <input type="text" id="city" class="form-control">
                  </div>
                  <div class="col-12">
                    <label for="country">Country</label>
                    <select id="country" class="custom-select"></select>
                  </div>
                  <div class="col-12">
                    <label for="state">State</label>
                    <select id="state" class="custom-select"></select>
                  </div>
                  <div class="col-12">
                    <label for="zipCode">Zip Code</label>
                    <input type="text" id="zipCode" class="form-control">
                  </div>
                  <div class="col-12">
                    <label for="sourceOfBusiness"> Source of Business</label>
                    <select id="sourceOfBusiness" class="custom-select"></select>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="col-12">
                  <label for="guestStatus">Guest Status</label>
                  <select id="guestStatus" class="custom-select"></select>
                </div>
                <div class="col-12">
                  <label for="accompanying">Accompanying</label>
                  <input type="text" id="accompanying" class="form-control">
                </div>
                <div class="col-12">
                  <label for="checkIn">Check In</label>
                  <input type="date" id="checkIn" class="form-control inputCalendar">
                </div>
                <div class="col-12">
                  <label for="checkOut">Check Out</label>
                  <input type="date" id="checkOut" class="form-control inputCalendar">
                </div>
                <div class="col-12">
                  <label for="guestOrganization">Guest Organization</label>
                  <input type="text" id="guestOrganization" class="form-control">
                </div>
                <div class="col-12">
                  <label for="emailId">Email ID</label>
                  <input type="text" id="emailId" class="form-control">
                </div>
                <div class="col-12">
                  <div class="custom-control custom-checkbox mt-3">
                    <input type="checkbox" id="guestLookUp-includeC" class="custom-control-input" autocomplete="off"
                      checked="" value="on">
                    <label class="custom-control-label" for="guestLookUp-includeC">Include Cancellations</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="row border-dashed-top mt-3 p-2">
              <button id="btnSearchGuestLookUp" class="btn btn-primary w-25 m-auto"><i class="fas fa-search"></i>
                Search</button>
            </div>
          </div>
          <div class="col-md-12">
            <div class="table-responsive">
              <table id="tableGuestLookUp"
                class="table table-striped table-hover table-sm dataTable text-center table-bordered-0">
                <thead class="bg-primary text-white">
                  <!--<tr>
                    <th>Guest ID</th>
                    <th>Guest Name</th>
                    <th>Address</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Mobile No.</th>
                    <th>ID Type /#</th>
                    <th>Company</th>
                    <th>Visits</th>
                    <th>Last Check In</th>
                  </tr>-->
                </thead>
                <!-- <tbody class="cursor-pointer">
                  <tr>
                    <td>p31</td>
                    <td>Mss. Ana Grey</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>809-776-6633</td>
                    <td></td>
                    <td></td>
                    <td>1</td>
                    <td>Sep 05.2020</td>
                  </tr>
                </tbody>-->
              </table>
            </div>
            <div class="row p-1 bg-primary align-items-center">
              <div class="col-8">
                <button id="btnPrint" class="btn btn-light m-1"><i class="fas fa-print"></i> Print</button>
                <button id="btnAddGuest" class="btn btn-light m-1"><i class="fas fa-plus"></i> Add Guest</button>
              </div>
              <div class="col-4">
                <div class="input-group">
                  <select id="" class="custom-select"></select>
                  <div class="input-group-prepend">
                    <button class="btn btn-light"><i class="fas fa-file-export"></i> Export</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="list-house-status" role="tabpanel" aria-labelledby="list-house-status">
          <div class="row">
            <div class="col-md-6 border-dashed-right px-0">
              <div class="row">
                <div class="table-responsive pb-3">
                  <table id="tableONe" class="verticalTable table-striped">
                    <tbody>
                      <tr>
                        <th>Total rooms</th>
                        <td>40</td>
                      </tr>
                      <tr>
                        <th>DNR room</th>
                        <td>0</td>
                      </tr>
                      <tr>
                        <th>Repair rooms</th>
                        <td></td>
                      </tr>
                      <tr>
                        <th>House use rooms</th>
                        <td>0</td>
                      </tr>
                      <tr>
                        <th>Rooms to sell</th>
                        <td>40</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="table-responsive pt-3 border-dashed-top">
                  <table id="tableTwo" class="verticalTable table-striped ">
                    <tbody>
                      <tr>
                        <th></th>
                        <th>Rms</th>
                        <th>Prs</th>
                        <th>VIP</th>
                      </tr>
                      <tr>
                        <th>Rooms available</td>
                        <td>27</td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <th>Room occupied</th>
                        <td>17</td>
                        <td>32</td>
                        <td>0</td>
                      </tr>
                      <tr>
                        <th>Occ %-DNR/House use room</th>
                        <td>42.50%</td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <th>Individual Rooms</th>
                        <td>6</td>
                        <td>12</td>
                        <td>0</td>
                      </tr>
                      <tr>
                        <th>Group rooms</th>
                        <td>11</td>
                        <td>20</td>
                        <td>0</td>
                      </tr>
                      <tr>
                        <th>Block rooms</th>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                      </tr>
                      <tr>
                        <th>House use rooms</th>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                      </tr>
                      <tr>
                        <th>Complimentary rooms</th>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <div class="col-md-6 px-0">
              <div class="row">
                <div class="table-responsive pb-3">
                  <table id="tableThree" class="verticalTable table-striped">
                    <tbody>
                      <tr>
                        <th></th>
                        <th>Rms</th>
                        <th>Prs</th>
                        <th>VIP</th>
                      </tr>
                      <tr>
                        <th>Departures expected</th>
                        <td>4</td>
                        <td>6</td>
                        <td>0</td>
                      </tr>
                      <tr>
                        <th>Departures actuals</th>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                      </tr>
                      <tr>
                        <th>Arrivals expected</th>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                      </tr>
                      <tr>
                        <th>Arrivals actuals</th>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                      </tr>
                      <tr>
                        <th>Early departures</th>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                      </tr>
                      <tr>
                        <th>Day use rooms</th>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                      </tr>
                      <tr>
                        <th>Walk-in rooms</th>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="table-responsive  pt-3 border-dashed-top">
                  <table id="tableFour" class="verticalTable table-striped">
                    <tbody>
                      <tr>
                        <th></th>
                        <th>Occ</th>
                        <th>Vac</th>
                      </tr>
                      <tr>
                        <th>Dirty rooms</th>
                        <td>17</td>
                        <td>0</td>
                      </tr>
                      <tr>
                        <th>Touch up rooms</th>
                        <td>0</td>
                        <td>23</td>
                      </tr>
                      <tr>
                        <th>Clean rooms</th>
                        <td>0</td>
                        <td>0</td>
                      </tr>
                      <tr>
                        <th>Inspected rooms</th>
                        <td>0</td>
                        <td>0</td>
                      </tr>
                      <tr>
                        <th>Repair room</th>
                        <td>0</td>
                        <td>0</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="row py-3 border-dashed-top">
            <button id="btnPrint" class="btn btn-primary m-auto w-25"><i class="fas fa-print"></i> Print</button>
          </div>
        </div>
        <div class="tab-pane fade" id="list-tariff-chart" role="tabpanel" aria-labelledby="list-tariff-chart">
          <div class="col-md-12 p-0 py-3 filtre">
            <div class="row px-3">
              <div class="col px-1">
                <label for="from">From</label>
                <input type="date" id="from" class="form-control inputCalendar">
              </div>
              <div class="col px-1">
                <label for="to">To</label>
                <input type="date" id="to" class="form-control inputCalendar">
              </div>
            </div>
            <div class="row"></div>
            <div class="row px-3 mt-3">
              <button id="btnSearchTarfiffChart" class="btn btn-primary w-25 m-auto"><i class="fas fa-search"></i>
                Search</button>
            </div>
            <hr>
            <div class="row px-3">
              <div class="col-md-3 px-1">
                <label for="selMode">Type</label>
                <select id="selMode" class="custom-select"></select>
              </div>
              <div class="col-3 align-self-end">
                <div class="custom-control custom-checkbox custom-control-inline">
                  <input type="checkbox" id="tariffChart-show-negRates" class="custom-control-input" value="off">
                  <label class="custom-control-label" for="tariffChart-show-negRates" data-toggle="collapse"
                    data-target="#panelTariffChart-selCorp">Show Neg. Rates</label>
                </div>
              </div>
              <div id="panelTariffChart-selCorp" class="col-md-3 px-1 collapse">
                <label for="tariffChart-selCorp">&nbsp;</label>
                <select id="tariffChart-selCorp" class="custom-select"></select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="row">
                <div class="table-responsive">
                  <table id="seasonalRate" class="table table-sm table-striped table-bordered-0">
                    <thead>
                      <tr>
                        <th colspan="3">Seasonal Rate</th>
                        <th colspan="5" class="text-right">CORP/TA</th>
                      </tr>
                      <tr class="bg-primary text-white">
                        <td colspan="4">Room Types</td>
                        <td colspan="5">Package Price based on Adult Occupancy</td>
                      </tr>
                    </thead>
                    <tbody>
                      <tr style="background:#D5D5D5">
                        <td class="py-4" colspan="4"></td>
                        <td class="py-4">Single ($)</td>
                        <td class="py-4">Double ($)</td>
                        <td class="py-4">Triple ($)</td>
                        <td class="py-4">Four ($)</td>
                      </tr>
                    </tbody>
                    <tbody id="bodyContent">
                      <tr>
                        <td>
                        <td>Standar Room</td>
                        <td>
                          <p>Base:</p>
                          <p>Max:</p>
                        </td>
                        <td>
                          <p>1 Persons</p>
                          <p>4 Persons</p>
                        </td>
                        <td>
                          <p class="action">2700.00</p>
                          <p class="action">1 Child $1350.00</p>
                        </td>
                        <td>
                          <p class="action">4050.00</p>
                          <p class="action">1 Child $1350.00</p>
                        </td>
                        <td>
                          <p class="action">5400.00</p>
                          <p class="action">1 Child $1350.00</p>
                        </td>
                        <td>
                          <p class="action">6750.00</p>
                        </td>
                      </tr>
                      <tr>
                        <td>
                        <td>Deluxe Room</td>
                        <td>
                          <p>Base:</p>
                          <p>Max:</p>
                        </td>
                        <td>
                          <p>1 Persons</p>
                          <p>4 Persons</p>
                        </td>
                        <td>
                          <p class="action">2700.00</p>
                          <p class="action">1 Child $1350.00</p>
                        </td>
                        <td>
                          <p class="action">4050.00</p>
                          <p class="action">1 Child $1350.00</p>
                        </td>
                        <td>
                          <p class="action">5400.00</p>
                          <p class="action">1 Child $1350.00</p>
                        </td>
                        <td>
                          <p class="action">6750.00</p>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>

                <div class="table-responsive">
                  <table id="tableRackRate" class="table table-sm table-striped table-bordered-0 mt-3">
                    <thead>
                      <tr>
                        <th colspan="3">Rack Rate</th>
                        <th colspan="5" class="text-right">CORP/TA</th>
                      </tr>
                      <tr class="bg-primary text-white">
                        <td colspan="4">Room Types</td>
                        <td colspan="5">Package Price based on Adult Occupancy</td>
                      </tr>
                    </thead>
                    <tbody>
                      <tr style="background:#D5D5D5">
                        <td class="py-4" colspan="4"></td>
                        <td class="py-4">Single ($)</td>
                        <td class="py-4">Double ($)</td>
                        <td class="py-4">Triple ($)</td>
                        <td class="py-4">Four ($)</td>
                      </tr>
                    </tbody>
                    <tbody id="bodyContent">
                      <tr>
                        <td>
                        <td>Standar Room</td>
                        <td>
                          <p>Base:</p>
                          <p>Max:</p>
                        </td>
                        <td>
                          <p>1 Persons</p>
                          <p>4 Persons</p>
                        </td>
                        <td>
                          <p class="action">2700.00</p>
                          <p class="action">1 Child $1350.00</p>
                        </td>
                        <td>
                          <p class="action">4050.00</p>
                          <p class="action">1 Child $1350.00</p>
                        </td>
                        <td>
                          <p class="action">5400.00</p>
                          <p class="action">1 Child $1350.00</p>
                        </td>
                        <td>
                          <p class="action">6750.00</p>
                        </td>
                      </tr>
                      <tr>
                        <td>
                        <td>Deluxe Room</td>
                        <td>
                          <p>Base:</p>
                          <p>Max:</p>
                        </td>
                        <td>
                          <p>1 Persons</p>
                          <p>4 Persons</p>
                        </td>
                        <td>
                          <p class="action">2700.00</p>
                          <p class="action">1 Child $1350.00</p>
                        </td>
                        <td>
                          <p class="action">4050.00</p>
                          <p class="action">1 Child $1350.00</p>
                        </td>
                        <td>
                          <p class="action">5400.00</p>
                          <p class="action">1 Child $1350.00</p>
                        </td>
                        <td>
                          <p class="action">6750.00</p>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>

                <div class="table-responsive">
                  <table id="tableFullBoard" class="table table-sm table-striped table-bordered-0 mt-3">
                    <thead>
                      <tr>
                        <th colspan="3">Full Board <span class="font-weight-normal font-italic"> Includes Breakfast,
                            Lunch, Dinner</span></th>
                        <th colspan="5" class="text-right"></th>
                      </tr>
                      <tr class="bg-primary text-white">
                        <td colspan="4">Room Types</td>
                        <td colspan="5">Package Price based on Adult Occupancy</td>
                      </tr>
                    </thead>
                    <tbody>
                      <tr style="background:#D5D5D5">
                        <td class="py-4" colspan="4"></td>
                        <td class="py-4">Single ($)</td>
                        <td class="py-4">Double ($)</td>
                        <td class="py-4">Triple ($)</td>
                        <td class="py-4">Four ($)</td>
                      </tr>
                    </tbody>
                    <tbody id="bodyContent">
                      <tr>
                        <td>
                        <td>Standar Room</td>
                        <td>
                          <p>Base:</p>
                          <p>Max:</p>
                        </td>
                        <td>
                          <p>1 Persons</p>
                          <p>4 Persons</p>
                        </td>
                        <td>
                          <p class="action">2700.00</p>
                          <p class="action">1 Child $1350.00</p>
                        </td>
                        <td>
                          <p class="action">4050.00</p>
                          <p class="action">1 Child $1350.00</p>
                        </td>
                        <td>
                          <p class="action">5400.00</p>
                          <p class="action">1 Child $1350.00</p>
                        </td>
                        <td>
                          <p class="action">6750.00</p>
                        </td>
                      </tr>
                      <tr>
                        <td>
                        <td>Deluxe Room</td>
                        <td>
                          <p>Base:</p>
                          <p>Max:</p>
                        </td>
                        <td>
                          <p>1 Persons</p>
                          <p>4 Persons</p>
                        </td>
                        <td>
                          <p class="action">2700.00</p>
                          <p class="action">1 Child $1350.00</p>
                        </td>
                        <td>
                          <p class="action">4050.00</p>
                          <p class="action">1 Child $1350.00</p>
                        </td>
                        <td>
                          <p class="action">5400.00</p>
                          <p class="action">1 Child $1350.00</p>
                        </td>
                        <td>
                          <p class="action">6750.00</p>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>

                <div class="table-responsive">
                  <table id="tableHoneyMoon" class="table table-sm table-striped table-bordered-0 mt-3">
                    <thead>
                      <tr>
                        <th colspan="3">Honeymoon Packed</th>
                        <th colspan="5" class="text-right"></th>
                      </tr>
                      <tr class="bg-primary text-white">
                        <td colspan="4">Room Types</td>
                        <td colspan="5">Package Price based on Adult Occupancy</td>
                      </tr>
                    </thead>
                    <tbody>
                      <tr style="background:#D5D5D5">
                        <td class="py-4" colspan="4"></td>
                        <td class="py-4">Single ($)</td>
                        <td class="py-4">Double ($)</td>
                        <td class="py-4">Triple ($)</td>
                        <td class="py-4">Four ($)</td>
                      </tr>
                    </tbody>
                    <tbody id="bodyContent">
                      <tr>
                        <td>
                        <td>Standar Room</td>
                        <td>
                          <p>Base:</p>
                          <p>Max:</p>
                        </td>
                        <td>
                          <p>1 Persons</p>
                          <p>4 Persons</p>
                        </td>
                        <td>
                          <p class="action">2700.00</p>
                          <p class="action">1 Child $1350.00</p>
                        </td>
                        <td>
                          <p class="action">4050.00</p>
                          <p class="action">1 Child $1350.00</p>
                        </td>
                        <td>
                          <p class="action">5400.00</p>
                          <p class="action">1 Child $1350.00</p>
                        </td>
                        <td>
                          <p class="action">6750.00</p>
                        </td>
                      </tr>
                      <tr>
                        <td>
                        <td>Deluxe Room</td>
                        <td>
                          <p>Base:</p>
                          <p>Max:</p>
                        </td>
                        <td>
                          <p>1 Persons</p>
                          <p>4 Persons</p>
                        </td>
                        <td>
                          <p class="action">2700.00</p>
                          <p class="action">1 Child $1350.00</p>
                        </td>
                        <td>
                          <p class="action">4050.00</p>
                          <p class="action">1 Child $1350.00</p>
                        </td>
                        <td>
                          <p class="action">5400.00</p>
                          <p class="action">1 Child $1350.00</p>
                        </td>
                        <td>
                          <p class="action">6750.00</p>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>

                <div class="table-responsive">
                  <table id="tableBreakfast" class="table table-sm table-striped table-bordered-0 mt-3">
                    <thead>
                      <tr>
                        <th colspan="3">Bed & Breakfast <span class="font-weight-normal font-italic"> Includes
                            Breakfast</span></th>
                        <th colspan="5" class="text-right"></th>
                      </tr>
                      <tr class="bg-primary text-white">
                        <td colspan="4">Room Types</td>
                        <td colspan="5">Package Price based on Adult Occupancy</td>
                      </tr>
                    </thead>
                    <tbody>
                      <tr style="background:#D5D5D5">
                        <td class="py-4" colspan="4"></td>
                        <td class="py-4">Single ($)</td>
                        <td class="py-4">Double ($)</td>
                        <td class="py-4">Triple ($)</td>
                        <td class="py-4">Four ($)</td>
                      </tr>
                    </tbody>
                    <tbody id="bodyContent">
                      <tr>
                        <td>
                        <td>Standar Room</td>
                        <td>
                          <p>Base:</p>
                          <p>Max:</p>
                        </td>
                        <td>
                          <p>1 Persons</p>
                          <p>4 Persons</p>
                        </td>
                        <td>
                          <p class="action">2700.00</p>
                          <p class="action">1 Child $1350.00</p>
                        </td>
                        <td>
                          <p class="action">4050.00</p>
                          <p class="action">1 Child $1350.00</p>
                        </td>
                        <td>
                          <p class="action">5400.00</p>
                          <p class="action">1 Child $1350.00</p>
                        </td>
                        <td>
                          <p class="action">6750.00</p>
                        </td>
                      </tr>
                      <tr>
                        <td>
                        <td>Deluxe Room</td>
                        <td>
                          <p>Base:</p>
                          <p>Max:</p>
                        </td>
                        <td>
                          <p>1 Persons</p>
                          <p>4 Persons</p>
                        </td>
                        <td>
                          <p class="action">2700.00</p>
                          <p class="action">1 Child $1350.00</p>
                        </td>
                        <td>
                          <p class="action">4050.00</p>
                          <p class="action">1 Child $1350.00</p>
                        </td>
                        <td>
                          <p class="action">5400.00</p>
                          <p class="action">1 Child $1350.00</p>
                        </td>
                        <td>
                          <p class="action">6750.00</p>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>

                <div class="table-responsive">
                  <table id="tableHalfBoard" class="table table-sm table-striped table-bordered-0 mt-3">
                    <thead>
                      <tr>
                        <th colspan="3">Half Board <span class="font-weight-normal font-italic"> Includes Breakfast,
                            Dinner</span></th>
                        <th colspan="5" class="text-right"></th>
                      </tr>
                      <tr class="bg-primary text-white">
                        <td colspan="4">Room Types</td>
                        <td colspan="5">Package Price based on Adult Occupancy</td>
                      </tr>
                    </thead>
                    <tbody>
                      <tr style="background:#D5D5D5">
                        <td class="py-4" colspan="4"></td>
                        <td class="py-4">Single ($)</td>
                        <td class="py-4">Double ($)</td>
                        <td class="py-4">Triple ($)</td>
                        <td class="py-4">Four ($)</td>
                      </tr>
                    </tbody>
                    <tbody id="bodyContent">
                      <tr>
                        <td></td>
                        <td>Standar Room</td>
                        <td>
                          <p>Base:</p>
                          <p>Max:</p>
                        </td>
                        <td>
                          <p>1 Persons</p>
                          <p>4 Persons</p>
                        </td>
                        <td>
                          <p class="action">2700.00</p>
                          <p class="action">1 Child $1350.00</p>
                        </td>
                        <td>
                          <p class="action">4050.00</p>
                          <p class="action">1 Child $1350.00</p>
                        </td>
                        <td>
                          <p class="action">5400.00</p>
                          <p class="action">1 Child $1350.00</p>
                        </td>
                        <td>
                          <p class="action">6750.00</p>
                        </td>
                      </tr>
                      <tr>
                        <td>
                        <td>Deluxe Room</td>
                        <td>
                          <p>Base:</p>
                          <p>Max:</p>
                        </td>
                        <td>
                          <p>1 Persons</p>
                          <p>4 Persons</p>
                        </td>
                        <td>
                          <p class="action">2700.00</p>
                          <p class="action">1 Child $1350.00</p>
                        </td>
                        <td>
                          <p class="action">4050.00</p>
                          <p class="action">1 Child $1350.00</p>
                        </td>
                        <td>
                          <p class="action">5400.00</p>
                          <p class="action">1 Child $1350.00</p>
                        </td>
                        <td>
                          <p class="action">6750.00</p>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>

              </div>
            </div>
          </div>
          <div class="row p-1 bg-primary align-items-center">
            <div class="col-12 text-center">
              <button id="btnPrint" class="btn btn-light"><i class="fas fa-print"></i> Print</button>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="list-dashboard" role="tabpanel" aria-labelledby="list-dashboard">

          <div class="row p-3">
            <div class="card card-chart card-chart-sm p-0 m-2 text-center shadow">
              <div class="card-header">
                <h5 class="m-0">ARR</h5>
              </div>
              <div class="card-body">
                <h2 class="">250.74</h2>
                <hr>
                <h5 class="m-2">Last Year</h5>
                <p>0%</p>
              </div>
            </div>
            <div class="card card-chart card-chart-sm p-0 m-2 text-center shadow">
              <div class="card-header">
                <h5 class="m-0">REVPAR</h5>
              </div>
              <div class="card-body">
                <h2 class="">30.44</h2>
                <hr>
                <h5 class="m-2">Last Year</h5>
                <p>0%</p>
              </div>
            </div>
            <div class="card card-chart card-chart-sm p-0 m-2 text-center shadow">
              <div class="card-header">
                <h5 class="m-0">OCC</h5>
              </div>
              <div class="card-body">
                <h2 class="">12.14</h2>
                <hr>
                <h5 class="m-2">Last Year</h5>
                <p>10%</p>
              </div>
            </div>
            <div class="card card-chart card-chart-sm p-0 m-2 text-center shadow">
              <div class="card-header">
                <h5 class="m-0">OCC</h5>
              </div>
              <div class="card-body p-0">
                <p style="font-size: 12px;" class="text-info m-0 text-left p-1">Date filter does not apply here</p>
                <table class="table table-striped table-sm">
                  <tbody>
                    <tr>
                      <th>Total Room</th>
                      <td>40</td>
                    </tr>
                    <tr>
                      <th>Ocupied</th>
                      <td>20</td>
                    </tr>
                    <tr>
                      <th>Expected Arrivals</th>
                      <td>0</td>
                    </tr>
                    <tr>
                      <th>Expected Departure</th>
                      <td>40</td>
                    </tr>
                    <tr>
                      <th>Complementary</th>
                      <td>0</td>
                    </tr>
                    <tr>
                      <th>House use</th>
                      <td>0</td>
                    </tr>
                    <tr>
                      <th>DNR</th>
                      <td>0</td>
                    </tr>
                    <tr>
                      <th>Room To Sell</th>
                      <td>0</td>
                    </tr>
                    <tr>
                      <th>EOD Proyection</th>
                      <td>13</td>
                    </tr>
                    <tr>
                      <th>Total VIP</th>
                      <td>0</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="row p-3">
            <div class="card card-chart card-chart-md">
              <div class="card-header">
                <h5 class="m-0">Renue Analysis</h5>
              </div>
              <div class="card-body"></div>
            </div>
            <div class="card card-chart card-chart-md">
              <div class="card-header">
                <h5 class="m-0">BoB</h5>
              </div>
              <div class="card-body p-0">
                <table class="table table-striped table-sm">
                  <thead>
                    <tr>
                      <th>Date</th>
                      <th>Room Night</th>
                      <th>Revenue</th>
                      <th>Occupancy</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>19 Aug</td>
                      <td>13</td>
                      <td>4225.00</td>
                      <td>32.50%</td>
                    </tr>
                    <tr>
                      <td>19 Aug</td>
                      <td>13</td>
                      <td>4225.00</td>
                      <td>32.50%</td>
                    </tr>
                    <tr>
                      <td>19 Aug</td>
                      <td>13</td>
                      <td>4225.00</td>
                      <td>32.50%</td>
                    </tr>
                    <tr>
                      <td>12 Sept</td>
                      <td>13</td>
                      <td>4225.00</td>
                      <td>32.50%</td>
                    </tr>
                    <tr>
                      <td>9 Aug</td>
                      <td>13</td>
                      <td>4225.00</td>
                      <td>32.50%</td>
                    </tr>
                    <tr>
                      <td>22 Aug</td>
                      <td>13</td>
                      <td>4225.00</td>
                      <td>32.50%</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="row p-3">
            <div class="card card-chart card-chart-md">
              <div class="card-header">
                <h5 class="m-0">Occupancy Analysis</h5>
              </div>
              <div class="card-body">

              </div>
            </div>
            <div class="card card-chart card-chart-md">
              <div class="card-header">
                <h5 class="m-0">Top 5 OTA Performance
                  <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" id="carPerformance-dashboard" class="custom-control-input" value="off">
                    <label class="custom-control-label text-info" for="carPerformance-dashboard">Include Offline</label>
                  </div>
                </h5>
              </div>
              <div class="card-body">

              </div>
            </div>
          </div>
          <div class="row p-3">
            <div class="card card-chart card-chart-md">
              <div class="card-header">
                <h5 class="m-0">Source</h5>
              </div>
              <div class="card-body"></div>
            </div>
            <div class="card card-chart card-chart-md">
              <div class="card-header">
                <h5 class="m-0">Market Segment Analysis </h5>
              </div>
              <div class="card-body"></div>
            </div>
          </div>
          <div class="row p-3">
            <div class="card card-chart card-chart-lg">
              <div class="card-header">
                <h5 class="m-0">Availability Analysis</h5>
              </div>
              <div class="card-body">
                <table class="verticalTable table-striped">
                  <tbody>
                    <tr>
                      <th>Room Type</th>
                      <td>19 Aug</td>
                      <td>20 Aug</td>
                      <td>21 Aug</td>
                      <td>22 Aug</td>
                      <td>23 Aug</td>
                      <td>24 Aug</td>
                      <td>25 Aug</td>
                    </tr>
                    <tr>
                      <td>Standar Room</td>
                      <td>5</td>
                      <td>8</td>
                      <td>13</td>
                      <td>13</td>
                      <td>14</td>
                      <td>15</td>
                      <td>12</td>
                    </tr>
                    <tr>
                      <td>Deluxe Room</td>
                      <td>5</td>
                      <td>8</td>
                      <td>13</td>
                      <td>13</td>
                      <td>14</td>
                      <td>15</td>
                      <td>12</td>
                    </tr>
                    <tr>
                      <td>Superior Room</td>
                      <td>5</td>
                      <td>8</td>
                      <td>13</td>
                      <td>13</td>
                      <td>14</td>
                      <td>15</td>
                      <td>12</td>
                    </tr>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>Room to Sell</th>
                      <th>27</th>
                      <th>30</th>
                      <th>36</th>
                      <th>37</th>
                      <th>39</th>
                      <th>40</th>
                      <th>37</th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-12 px-0">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" id="myTabCalendar" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="frontDesk-tab" data-toggle="tab" href="#frontDesk" role="tab" aria-controls="frontDesk"
          aria-selected="false">Front Desk</a>
      </li>
    <!--   <li class="nav-item" data-remove="p21">
        <a class="nav-link active" id="p21-tab" data-id="p21" data-toggle="tab" href="#p21" role="tab"
          aria-controls="p21" aria-selected="true">Anastacia Grey <button type="button" data-id="p21" id="tabClose"
            class="close ml-1" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button></a>
      </li> -->
      <li class="nav-item" data-remove="groupReservation">
        <a class="nav-link" id="groupReservation-tab" data-id="groupReservation" data-toggle="tab" href="#groupReservation" role="tab"
          aria-controls="groupReservation" aria-selected="true">Group Reservation <button type="button" data-id="groupReservation"
            id="tabClose" class="close ml-1" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button></a>
      </li>
      <li class="nav-item" data-remove="clientP20Pro">
        <a class="nav-link" id="clientP20pro-tab" data-id="P20Pro" data-toggle="tab" href="#clientP20Pro" role="tab"
          aria-controls="P20Pro" aria-selected="true">Jose Polanco <button type="button" data-id="cliientP20Pro"
            id="tabClose" class="close ml-1" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button></a>
      </li>
    </ul>
    <!-- Tab panes -->
    <div id="tab-content" class="tab-content">
      <div class="tab-pane" id="frontDesk" role="tabpanel" aria-labelledby="frontDesk-tab">
        <div class="main-calendar">
          <div class="calendar__info">
            <div class="date-info">
              <h2 class="calendar__month" id="month"></h2>
              <h2 class="calendar__year" id="year"></h2>
            </div>
            <div id="date-change" class="date-change">
              <div class="btn-group">
                <button class="btn btn-warning" id="prev"><i class="fas fa-angle-left"></i></button>
                <button type="button" class="btn btn-primary active" id="month">Month</button>
                <button type="button" class="btn btn-primary" id="week">Week</button>
                <button type="button" class="btn btn-primary" id="fiveteenDays">15 Days</button>
                <button class="btn btn-warning" id="next"><i class="fas fa-angle-right"></i></button>
              </div>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table calendar__dates" id="calendar__dates">
              <thead class="calendar__week" id="calendar__week">
                <tr id="daysWeek">
                </tr>
              </thead>
              <tbody>
                <tr id="dates"></tr>
              <tbody id="rooms" class="table-bordered"></tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <!-- /Main Calendar -->

      <!-- aqui va anastacia garcia -->
   
   
      <div class="tab-pane" id="groupReservation" role="tabpanel" aria-labelledby="groupReservation-tab">
        <div id="createGroupReservation" class='col-md-12 p-0'>
          <div class='row p-3' id='headerClientDetails'>
            <div class='col-md-3'>
            </div>
            <div class='col-md-5'>
            </div>
            <div class='col-md-2' style='align-self: center;'>
              <span>Status: <b>RESERV</b></span>
            </div>
            <div class='col-md-2' style='align-self: center;'>
              <span> <b></b></span>
            </div>
          </div>
          <div class='row' id='ContentClientDetails'>
            <!-- Column1 -->
            <div class='col-md-6 pt-3'>
              <section id='personalInformation'>
                <div class="row">
                  <label for="groupOwner">Group Owner</label>
                  <select id="groupOwner" class="custom-select" autocomplete="off">
                    <option value="travel_agent">Travel Agent</option>
                    <option value="corporate">Corporate</option>
                    <option value="other">Other</option>
                  </select>
                </div>
                <div id="contentTypeClient" class="col-12 px-0 mt-2">

                  <div id="agentReservation" class="d-none">
                    <div class="row mt-2">
                      <div class="dropdown w-100">
                        <label for="travelAgent">Travel Agent</label>
                        <input class="form-control dropdown-toggle" type="text" id="dropdownMenuButton"
                          data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton">
                          <ul class="list-group list-group-flush cursor-pointer">
                            <li class="list-group-item list-group-item-action">J&B Performance</li>
                            <li class="list-group-item list-group-item-action">Avaya System</li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="row mt-2">
                      <h5><b>Travel Agent Details</b></h5>
                      <br>
                      <div class="col-md-12 px-1">
                        <label for="companyName">Company Name<i class="text-danger">*</i></label>
                        <input type="text" id="companyName" class="form-control">
                      </div>
                    </div>
                    <div class="row mt-2">
                      <div class="col-md-2 px-1">
                        <label for="title">Title<i class="text-danger">*</i></label>
                        <select id="title" class="custom-select">
                          @foreach ($salutations as $item)
                          <option value="{{$item->id}}"
                            {{$item->id == old('contact.salutation_id') ? 'selected' : '' }}>
                            {{$item->name}} </option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-md-3 px-1">
                        <label for="firstName">First Name<i class="text-danger">*</i></label>
                        <input type="text" id="firstName" class="form-control">
                      </div>
                      <div class="col-md-3 px-1">
                        <label for="lastName">Last Name<i class="text-danger">*</i></label>
                        <input type="text" id="lastName" class="form-control">
                      </div>
                      <div class="col-md-4 px-1">
                        <label for="email">Email<i class="text-danger">*</i></label>
                        <input type="text" id="email" class="form-control">
                      </div>
                    </div>
                  </div>
                  <div id="corporateReservation" class="">
                    <div class="row mt-2">
                      <div class="dropdown w-100">
                        <label for="corporate">Corporate</label>
                        <input class="form-control dropdown-toggle" type="text" id="dropdownMenuButton"
                          data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton">
                          <ul class="list-group list-group-flush cursor-pointer">
                            <li class="list-group-item list-group-item-action">J&B Performance</li>
                            <li class="list-group-item list-group-item-action">Avaya System</li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="row mt-2">
                      <h5><b>Corporate Details</b></h5>
                      <br>
                      <div class="col-md-12 px-1">
                        <label for="companyName">Company Name<i class="text-danger">*</i></label>
                        <input type="text" id="companyName" class="form-control">
                      </div>
                    </div>
                    <div class="row mt-2">
                      <div class="col-md-2 px-1">
                        <label for="title">Title<i class="text-danger">*</i></label>
                        <select id="title" class="custom-select">
                          @foreach ($salutations as $item)
                          <option value="{{$item->id}}"
                            {{$item->id == old('contact.salutation_id') ? 'selected' : '' }}>
                            {{$item->name}} </option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-md-3 px-1">
                        <label for="firstName">First Name<i class="text-danger">*</i></label>
                        <input type="text" id="firstName" class="form-control">
                      </div>
                      <div class="col-md-3 px-1">
                        <label for="lastName">Last Name<i class="text-danger">*</i></label>
                        <input type="text" id="lastName" class="form-control">
                      </div>
                      <div class="col-md-4 px-1">
                        <label for="email">Email<i class="text-danger">*</i></label>
                        <input type="text" id="email" class="form-control">
                      </div>
                    </div>
                    <div class="row my-2">
                      <button id="eligibleForDiscount" class="btn btn-outline-primary ml-auto"><i
                          class="fas fa-percent"></i> Eligible for Discount</button>
                    </div>
                  </div>
                  <div id="otherReservation d-none">
                    <div class="row mt-2">
                      <div class="dropdown w-100">
                        <label for="other">Other</label>
                        <input class="form-control dropdown-toggle" type="text" id="dropdownMenuButton"
                          data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton">
                          <ul class="list-group list-group-flush cursor-pointer">
                            <li class="list-group-item list-group-item-action">J&B Performance</li>
                            <li class="list-group-item list-group-item-action">Avaya System</li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="row mt-2">
                      <h5 class="w-100"><b>Guest Information</b></h5>
                      <br>
                      <div class="col-md-2 px-1">
                        <label for="title">Title<i class="text-danger">*</i></label>
                        <select id="title" class="custom-select">
                          @foreach ($salutations as $item)
                          <option value="{{$item->id}}"
                            {{$item->id == old('contact.salutation_id') ? 'selected' : '' }}>
                            {{$item->name}} </option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-md-3 px-1">
                        <label for="firstName">First Name<i class="text-danger">*</i></label>
                        <input type="text" id="firstName" class="form-control">
                      </div>
                      <div class="col-md-3 px-1">
                        <label for="lastName">Last Name<i class="text-danger">*</i></label>
                        <input type="text" id="lastName" class="form-control">
                      </div>
                      <div class="col-md-4 px-1">
                        <label for="nationality">Nationality<i class="text-danger">*</i></label>
                        <select id="nationality" class="custom-select">
                          @foreach($countries as $country)
                          <option value="{{$country->id}}">{{$country->country_name}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="row mt-2">
                      <div class="col-md-2 px-1">
                        <label for="gender">Gender</label>
                        <select id="gender" class="custom-select"></select>
                      </div>
                      <div class="col-md-3 px-1">
                        <label for="birthDay">Date of Birthday</label>
                        <input type="date" id="birthDay" class="form-control inputCalendar">
                      </div>
                      <div class="col-md-7 px-1">
                        <label for="email">Email</label>
                        <input type="email" id="email" class="form-control">
                      </div>
                    </div>
                  </div>

                </div>
                <div class="row mt-2">
                  <h5><b>Address And Contact Details</b></h5>
                  <br>
                  <div class="col-md-8 px-1">
                    <label for="addressLine">Address Line</label>
                    <input type="text" class="form-control">
                  </div>
                  <div class="col-md-4 px-1">
                    <label for="city">City</label>
                    <input type="text" class="form-control">
                  </div>
                </div>
                <div class="row mt-2">
                  <div class="col-md-4 px-1">
                    <label for="country">Country</label>
                    <select id="country" class="custom-select">
                      @foreach ($countries as $country)
                      <option value="{{$country->id}}">{{$country->country_name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-md-4 px-1">
                    <label for="state">State</label>
                    <select id="state" class="custom-select"></select>
                  </div>
                  <div class="col-md-4 px-1">
                    <label for="zipCode">Zip Code</label>
                    <input type="text" id="zipCode" class="form-control">
                  </div>
                </div>
                <div class="row mt-2">
                  <div class="col-md-4 px-1">
                    <label for="Phone">Phone</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <span><i class="fas fa-phone"></i></span>
                        </div>
                      </div>
                      <input type="number" id="phone" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-4 px-1">
                    <label for="mobile">Mobile</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <span><i class="fas fa-mobile-alt"></i></span>
                        </div>
                      </div>
                      <input type="number" id="mobile" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-4 px-1">
                    <label for="fax">Fax</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="fas fa-fax"></i>
                        </div>
                      </div>
                      <input type="text" id="fax" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="row mt-2">
                  <button class="btn btn-outline-primary ml-auto" data-toggle="modal" data-target=""><i
                      class="fas fa-save"></i> Save & Add More</button>
                </div>
              </section>
              <hr>
              <div class='custom-control custom-checkbox'>
                <input type='checkbox' class='custom-control-input' sendMailConfirmation='' value='off'
                  id='sendMailConfirmation{$data[' id']}'>
                <label class='custom-control-label' for='sendMailConfirmation{$data[' id']}'>Send confirmation Email
                </label>
              </div>
              <div class='row'>
                <div class='col-md-12 mt-3'>
                  <textarea name='' id='' class='form-control' rows='6'></textarea>
                </div>
                <div id='notes' class='notes col-md-12 mt-3'>
                  <div class=''>
                    <table class='table table-striped w-100'>
                      <thead>
                        <th>NOTES</th>
                        <th class='text-right'>
                          <button class='btn btn-primary btn-sm pull-right' data-toggle='modal'
                            data-target='#addNewNote'><i class='fas fa-plus-circle'></i> Add Notes</button>
                        </th>
                      </thead>
                      <tbody>
                        <tr>
                          <td class='col-sm-9'><b>Fincance: </b>Cobrar restante.</td>
                          <td class='col-sm-3 text-center'>
                            <button class='btn btn-outline-primary btn-sm'><i class='fas fa-pencil-alt'></i></button>
                            <button class='btn btn-outline-danger btn-sm removeItem' data-message='note'><i
                                class='fas fa-trash-alt'></i></button>
                          </td>
                        </tr>
                        <tr>
                          <td class='col-sm-9'><b>Fincance: </b>Cobrar restante.</td>
                          <td class='col-sm-3 text-center'>
                            <button class='btn btn-outline-primary btn-sm'><i class='fas fa-pencil-alt'></i></button>
                            <button class='btn btn-outline-danger btn-sm removeItem' data-message='note'><i
                                class='fas fa-trash-alt'></i></button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class='col-md-6 p-0'>
              <div class='row'>
                <!-- Column2 -->
                <div id='content-StayDetails' class='col-md-6 p-3 px-4 content-StayDetails'>
                  <h5><b>Stay details</b> </h5>
                  <div class='row mt-3'>
                    <div class='col-md-6 p-0 pr-1'>
                      <label for='checkIn'>Check-in</label>
                      <input type='date' id='checkIn' class='form-control px-2'>
                    </div>
                    <div class='col-md-6 p-0 pl-1'>
                      <label for='checkOut'>Check-out</label>
                      <input type='date' id='checkOut' class='form-control px-2'>
                    </div>
                  </div>

                  <div class='row mt-3'>
                    <label for='purpose'>Purpose</label>
                    <input type='text' id='purpose' class='form-control' id='purpose'>
                  </div>
                  <div class='row mt-3'>
                    <label for='sources'>Sources</label>
                    <select id='sources' class='custom-select '></select>
                  </div>
                  <div class='row mt-3'>
                    <label for='type'>Type</label>
                    <select id='type' class='custom-select '></select>
                  </div>
                  <div class='row mt-3'>
                    <label for='mktSmgt'>Mkt Smgt</label>
                    <select id='mktSmgt' class='custom-select '></select>
                  </div>
                  <div class='row mt-3'>
                    <label for='salesPerson'>Sales person</label>
                    <select id='salesPerson' class='custom-select '></select>
                  </div>

                  <div class='section-ArrivalOrDeparture'>
                    <div class='row mt-3'>
                      <div class='list-group flex-row text-center w-100' id='list-tab' role='tablist'>
                        <a class='list-group-item list-group-item-action active' id='list-arrival-list'
                          data-toggle='list' href='#list-arrival{$data[' id']}' role='tab'
                          aria-controls='arrival'>Arrival</a>
                        <a class='list-group-item list-group-item-action' id='list-departure-list' data-toggle='list'
                          href='#list-departure{$data[' id']}' role='tab' aria-controls='departure'>Departure</a>
                      </div>
                    </div>

                    <div class='tab-content mt-3' id='nav-tabContent' style='background: none'>
                      <div class='tab-pane fade active show' id='list-arrival{$data[' id']}' role='tabpanel'
                        aria-labelledby='list-arrival-list'>
                        <div id='contentsArrival'>
                          <div class='row mt-3'>
                            <label for='info'>Select mode</label>
                            <select name='' id='' class='custom-select'></select>
                          </div>
                          <div class='row mt-3'>
                            <label for='arrivalFlight'>Arrival/Flight #</label>
                            <input type='text' class='form-control' id='arrivalFlight'>
                          </div>
                          <div class='row mt-3'>
                            <label for='arrival Time'>Arrival Time</label>
                            <input type='time' class='form-control' id='arrivalTime'>
                          </div>
                        </div>
                      </div>

                      <div class='tab-pane fade' id='list-departure{$data[' id']}' role='tabpanel'
                        aria-labelledby='list-departure-list'>
                        <div id='contentsDeparture'>
                          <div class='row mt-3'>
                            <label for='info'>Select mode</label>
                            <select id='departureMode' class='custom-select'></select>
                          </div>
                          <div class='row mt-3'>
                            <label for='arrivalFlight'>Departure/Flight #</label>
                            <input type='text' class='form-control' id='departureFlight'>
                          </div>
                          <div class='row mt-3'>
                            <label for='arrival Time'>Departure Time</label>
                            <input type='time' class='form-control' id='departureTime'>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class='row mt-3'>
                    <div class='col p-1 align-self-center'>
                      <div class='custom-control custom-checkbox custom-control-inline'>
                        <input type='checkbox' class='custom-control-input' id='assignTask{$data[' id']}'>
                        <label class='custom-control-label' for='assignTask{$data[' id']}' data-toggle='collapse'
                          data-target='#selectAssignTask{$data[' id']}'>Assign Task</label>
                      </div>
                    </div>
                    <div class='col p-1'>
                      <select id='selectAssignTask{$data[' id']}' selectAssignTask='' class='custom-select collapse'>
                        <option value='' selected disabled>Select POS</option>
                      </select>
                    </div>
                  </div>
                  <div class='row mt-4 p-1'>
                    <div class='custom-control custom-checkbox custom-control-inline'>
                      <input type='checkbox' class='custom-control-input' sendMail='' id='sendMail{$data[' id']}' />
                      <label class='custom-control-label' for='sendMail{$data[' id']}'>Send Mail</span>
                    </div>
                  </div>
                </div>
                <!-- Column3 -->
                <div id='content-RoomDetails' class='col-md-6 pt-3 border-dashed-left content-RoomDetails'>
                  <h5><b>Room Details</b></h5>
                  <table class='table'>
                    <tbody>
                      <tr>
                        <td class='text-info'>Number of Rooms</td>
                        <td id='numberOfRooms' class='text-right'>3</td>
                      </tr>
                      <tr>
                        <td class='text-info'>Adults</td>
                        <td id='numberOfAdults' class='text-right'>2</td>
                      </tr>
                      <tr>
                        <td class='text-info'>Children</b></td>
                        <td id='numberofChildrens' class='text-right'>0</td>
                      </tr>
                      <tr>
                      <tr class='bg-info text-white'>
                        <td><b>Total Guests</b></td>
                        <td id='totalGuests' class='text-right'>$<b>5</b></td>
                      </tr>
                      <tr>
                    </tbody>
                  </table>
                  <hr>
                  <div class='container-fluid p-0 mt-5'>
                    <h5><b>Credit Card Details</b></h5>
                    <div class='row mt-3'>
                      <label for='carNumber'>Card Number</label>
                      <input type='text' class='form-control' id='cardNumber' placeholder='#### #### #### ####'>
                    </div>
                    <div class='row mt-3'>
                      <label for='cardType'>Card type</label>
                      <select class='custom-select' name='' id=''></select>
                    </div>
                    <div class='row mt-3'>
                      <label for='expire' class='d-block w-100'>Expire</label>
                      <div class='col'><input type='text' class='form-control' placeholder='MM'></div><b
                        style='align-self: center;'>/</b>
                      <div class='col'><input type='text' class='form-control' placeholder='YYYY'></div><b
                        style='align-self: center;'>/</b>
                      <div class='col'><input type='text' class='form-control' placeholder='CVC'></div><b
                        style='align-self: center;'></b>
                    </div>
                    <div class='row mt-3'>
                      <button class='btn btn-outline-primary w-100' data-toggle='modal'
                        data-target='#ModalAddCreditCard'><i class='fas fa-credit-card'></i> Add Credit
                        Card</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Pay Term -->
              <div id="payTerm" class="col-md-12 py-1" style="background: #E4F0FE;">
                <div class="row">
                  <select id="" class="custom-select custom-select-user">
                    <option value="">Balance To be Paid by Group Owner</option>
                  </select>
                </div>
                <div class="row px-3">
                  <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input" id="otherCharges-payTerm{$data['id']}">
                    <label class="custom-control-label" for="otherCharges-payTerm{$data['id']}">Including Other
                      Charges</label>
                  </div>
                  <button class="btn btn-outline-primary btn-sm ml-auto list-item-collapse" data-toggle="collapse"
                    data-target="#setLimit">Set Limit&nbsp;</button>
                </div>
                <div id="setLimit" class="row px-3 py-2 collapse">
                  <div class="custom-control custom-checkbox custom-control-inline  ml-auto ">
                    <input type="checkbox" class="custom-control-input" id="inclusiveTax-payTerm{$data['id']}">
                    <label class="custom-control-label" for="inclusiveTax-payTerm{$data['id']}">Inclusive of
                      Tax</label>
                  </div>
                  <button class="btn btn-outline-primary btn-sm ml-2 list-item-collapse" data-toggle="collapse"
                    data-target="#editLimits">Edit Details&nbsp;</button>
                </div>
                <div id="setLimit" class="row py-2 collapse">
                  <div class="col d-flex">
                    $<input type="text" class="form-control form-control-sm">
                  </div>
                  <div class="col">
                    <select id="per?" class="custom-select custom-select-sm">
                      <option value="">Per Room</option>
                    </select>
                  </div>
                  <div class="col align-self-center">
                    <div class="custom-control custom-checkbox custom-control-inline  ml-auto ">
                      <input type="checkbox" class="custom-control-input" id="perNight-payTerm{$data['id']}">
                      <label class="custom-control-label" for="perNight-payTerm{$data['id']}">Per Night</label>
                    </div>
                  </div>
                </div>
                <div id="editLimits" class="col-md-12 py-2 collapse">
                  <hr>
                  <div id="customRoomTariff" class="row">
                    <div class="col-md-4">
                      <label for="roomFieldRoomTariffTariff">Room Tariff</label>
                      <input type="text" id="FieldRoomTariff" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-4 align-self-end">
                      <div class="custom-control custom-checkbox custom-control-inline  ml-auto ">
                        <input type="checkbox" class="custom-control-input" id="TariffPerNight-payTerm{$data['id']}">
                        <label class="custom-control-label" for="TariffPerNight-payTerm{$data['id']}">Per
                          Night</label>
                      </div>
                    </div>
                    <div class="col-md-4 align-self-end">
                      <div class="custom-control custom-checkbox custom-control-inline  ml-auto ">
                        <input type="checkbox" class="custom-control-input" id="TariffPerPerson-payTerm{$data['id']}">
                        <label class="custom-control-label" for="TariffPerPerson-payTerm{$data['id']}">Per
                          Person</label>
                      </div>
                    </div>
                  </div>
                  <div id="addonsTariff" class="row">
                    <div class="col-md-4">
                      <label for="FieldAddonsTariff">Add-ons Tariff</label>
                      <input type="text" id="FieldAddonsTariff" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-4 align-self-end">
                      <div class="custom-control custom-checkbox custom-control-inline  ml-auto ">
                        <input type="checkbox" class="custom-control-input" id="addonsPerNight-payTerm{$data['id']}">
                        <label class="custom-control-label" for="addonsPerNight-payTerm{$data['id']}">Per
                          Night</label>
                      </div>
                    </div>
                    <div class="col-md-4 align-self-end">
                      <div class="custom-control custom-checkbox custom-control-inline  ml-auto ">
                        <input type="checkbox" class="custom-control-input" id="addonsPerPerson-payTerm{$data['id']}">
                        <label class="custom-control-label" for="addonsPerPerson-payTerm{$data['id']}">Per
                          Person</label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!--Table Rates/Packages-->
              <div id='ratesPackages' class='col-md-12 p-0 mt-4'>
                <div class="table-responsive">
                  <table id="tableDiscount" class="table">
                    <thead class="text-center text-white" style="background: #138c9f;">
                      <tr>
                        <th colspan=" 2">Rates/Packes</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="pl-0">
                        </td>
                        <td class="pr-0">
                          <button class="btn btn-info btn-sm w-100" data-toggle="modal" data-target="#modalPromoCode"><i
                              class="fas fa-barcode"></i> Promo Code</button>
                        </td>
                      </tr>
                      <tr>
                        <td id="specialDiscount"></td>
                        <td id="promoCode"></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="table-responsive">
                  <table id='tableRatesPackes' class='table text-center tableRatesPackes'>
                    <thead class='bg-info'>
                      <tr>
                        <th>Rate Type</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Nights</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>
                          <select class='custom-select custom-select-user' id='changeRateType'>
                            <option value=''>Seasonal Rate</option>
                          </select>
                        </td>
                        <td>
                          <span>03 Aug - </span>
                          <button class='btn'>06 Aug</button>
                        </td>
                        <td>$ 200.00</td>
                        <td>3</td>
                      </tr>
                      <tr>
                        <td>
                          <button class='btn btn-outline-primary w-100' data-toggle='modal'
                            data-target='#modalInclusionsAddons'><i class='fas fa-puzzle-piece'></i>
                            Inclusions/Add-ons</button>
                        </td>
                        <td id='inclusions-Addons' class='text-dark inclusions-Addons' colspan='3'> <i>Airport</i>
                          <i>Pickup</i> <i>Half Board: Breakfast</i> <i>Dinner</i> </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="ContentClientPayment w-100 pt-3 border-dashed-top">
              <div class="row">
                <div class="table-responsive">
                  <table class="table" id="tableAttachGuests">
                    <thead class="bg-info text-white">
                      <tr>
                        <th>
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" id="selectClient" class="custom-control-input">
                            <label for="selectClient" class="custom-control-label"></label>
                          </div>
                        </th>
                        <th>Res #</th>
                        <th>Room Type</th>
                        <th>Room</th>
                        <th>Guest Name</th>
                        <th>Phone</th>
                        <th>Adult</th>
                        <th>Child</th>
                        <th>Check-In - Check-Out</th>
                        <th>Status</th>
                        <th>Action</th>
                        <th>Price</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>
                          <div class="custom-control custom-checkbox">
                            <input type="checkbox" id="selectClient1" class="custom-control-input">
                            <label for="selectClient" class="custom-control-label"></label>
                          </div>
                        </td>
                        <td>800021</td>
                        <td>
                          <select id="roomType" class="custom-select custom-select-user">
                            <option value="">Standar Room</option>
                            <option value="">Deluxe Room</option>
                            <option value="">Superior Room</option>
                          </select>
                        </td>
                        <td>
                          <select id="rooms" class="custom-select custom-select-user">
                            <option value="" selected disabled>Assign</option>
                          </select>
                        </td>
                        <td id="guestName">Jose Polanco</td>
                        <td>809-663-3315</td>
                        <td>
                          <select id="numberOfAdult" class="custom-select"></select>
                        </td>
                        <td>
                          <select id="numberOfChild" class="custom-select"></select>
                        </td>
                        <td>
                          Aug 25 - 31 Aug
                        </td>
                        <td>Reserved</td>
                        <td></td>
                        <td>$350.00</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="row mt-2">
                <div class="col-md-8">
                  <div class="row">
                    <button class="btn btn-outline-primary mx-1"><i class="fas fa-list"></i> Guest List</button>
                    <button class="btn btn-outline-primary mx-1"><i class="fas fa-check-circle"></i> Auto Asssign
                      Selected Room(s)</button>
                    <button class="btn btn-outline-primary mx-1"><i class="fas fa-user"></i> Manage Occupancy</button>
                    <button class="btn btn-outline-primary mx-1"><i class="fas fa-hand-holding-usd"></i> Tax
                      Exempt</button>
                  </div>
                  <div class="row mt-4">
                    <button class="btn btn-primary mx-1"><i class="fas fa-plus"></i> Add New Room(s)</button>
                    <button class="btn btn-danger mx-1"><i class="fas fa-times"></i> Cancel selected</button>
                  </div>
                </div>
                <div class="col-md-4">
                  <table class="table text-right">
                    <tbody>
                      <tr>
                        <th>Total</th>
                        <th>$1,200.00</th>
                      </tr>
                      <tr>
                        <td>Additional Group Owner Charges</td>
                        <td>$ 0.00</td>
                      </tr>
                      <tr>
                        <td>Taxes</td>
                        <td>180.00</td>
                      </tr>
                      <tr>
                        <td>Discount</td>
                        <td>$ 0.00</td>
                      </tr>
                      <tr class="bg-info text-white">
                        <th>Total Amount</th>
                        <td>$ 1380.00</td>
                      </tr>
                      <tr class="bg-info text-white">
                        <td>Paid</td>
                        <td>0.00</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="row tab-pane-footer">
            <div class="col-md-12">
              <button id="reserve" class="btn btn-light mx-1">Reserve</button>
              <button id="holdTill" class="btn btn-light mx-1">Hold Till</button>
              <button id="groupPaidBill" class="btn btn-light mx-1">Temp Reserv</button>
              Group Payment
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane" id="clientP20Pro" data-id='P20Pro' role="tabpanel" aria-labelledby="clientP20Pro-tab">
       <div class="col-md-12 p-0">
          <div class="col-md-6">
            <input type="text" class="inputCalendar">
          </div>

          <div class="card" id="miniCalendar">
            
          </div>
       </div>
       
        <div class='tab-pane' id='client{$data[' id']}' data-id='{$data[' id']}' role='tabpanel'
          aria-labelledby='client{$data[' id']}-tab'>

          <div class='col-md-12 p-0 d-none'>
            <div class='row p-3' id='headerClientDetails'>
              <div class='col-md-3'>
              </div>
              <div class='col-md-5'>
              </div>
              <div class='col-md-2' style='align-self: center;'>
                <span>Status: <b>RESERV</b></span>
              </div>
              <div class='col-md-2' style='align-self: center;'>
                <span>reserv#: <b>0001</b></span>
              </div>
            </div>
            <div class='row' id='ContentClientDetails'>
              <!-- Column1 -->
              <div class='col-md-6 pt-3'>
                <section id='personalInformation'>
                  <table class='verticalTable w-100' id='guestInformation'>
                    <tbody>
                      <tr>
                        <th id='GguestID'>Guest ID: <span>{$data['id']}</span></th>
                        <th id='Gid'>ID:
                          <span>
                            <button class='btn btn-sm btn-secondary mr-1' id='ViewIDS' data-toggle='modal'
                              data-target='#ModalViewID' data-type='passport'>passpport</button>
                            <button class='btn btn-sm btn-secondary mr-1' id='ViewIDS' data-toggle='modal'
                              data-target='#ModalViewID' data-type='Voter ID'>Voter ID</button>
                          </span>
                        </th>
                      </tr>
                    <!--   <tr>
                        <th id='GguestDetails'>Name: <span>Anastacia Grey</span></th>
                        <th></th>
                      </tr> -->
                      <tr>
                        <th id='Gaddress' colspan='2'>Adress: <span>Lirio #3</span></th>
                      </tr>
                      <tr>
                        <th id='Gcity'>City: <span>Sto Dgo</span></th>
                        <th id='Gstate'>State: <span>Sto Dgo</span></th>
                      </tr>
                      <tr>
                        <th id='Gcountry'>Country: <span>Rep. Dom</span></th>
                        <th id='Gzipcode'>Zip Code: <span></span></th>
                      </tr>
                      <tr>
                        <th id='Gnationality'>Nationality: <span>Dominican</span></th>
                        <th id='Gemail'>Email: <span></span></th>
                      </tr>
                      <tr>
                        <th id='Gphone'>Phone: <span></span></th>
                        <th>Mobile: <span></span> </th>
                      </tr>
                    </tbody>
                  </table>
                  <div class='row'>
                    <button class='btn btn-primary w-100' data-toggle='collapse' data-target='#moreInfoOfPerson'
                      aria-expanded='true' aria-controls='collapseOne'>More</button>
                  </div>
                  <div class='collapse' id='moreInfoOfPerson'>
                    <hr>
                    <table class='verticalTable w-100' id='workInformation'>
                      <tbody>
                        <tr>
                          <th id='Worganization' colspan='2'>Organization: <span></span></th>
                        </tr>
                        <tr>
                          <th id='Waddress' colspan='2'>Adress: <span>Lirio #3</span></th>
                        </tr>
                        <tr>
                          <th id='Wcity'>City: <span>Sto Dgo</span></th>
                          <th id='Wstate'>State: <span>Sto Dgo</span></th>
                        </tr>
                        <tr>
                          <th id='Wcountry'>Country: <span>Rep. Dom</span></th>
                          <th id='Wzipcode'>Zip Code: <span></span></th>
                        </tr>
                        <tr>
                          <th id='Wphone'>Phone: <span></span></th>
                          <th id='Wmobile'>Mobile: <span></span> </th>
                        </tr>
                      </tbody>
                    </table>
                    <hr>
                    <table class='verticalTable w-100' id='guestPrecerences'>
                      <tbody>
                        <tr>
                          <th class='font-weight-bold'>Guest Preferences:</th>
                        </tr>
                        <tr>
                          <td id='GPpreferences'><span>Platano</span></td>
                        </tr>
                      </tbody>
                    </table>
                    <hr>
                    <table class='verticalTable w-100' id='otherDetails'>
                      <tbody>
                        <tr>
                          <th class='font-weight-bold'>Other Details:</th>
                        </tr>
                        <tr>
                          <th id='OspouseName'>Spouse Name: <span></span></td>
                          <th id='ODOB'>DOB: <span></span></th>
                        </tr>
                        <tr>
                          <th id='Oaniversary'>Aniversary: <span></span></th>
                        </tr>
                      </tbody>
                    </table>
                  </div>

                  <div class='group text-center'>
                    <button class='btn btn-danger btn-sm m-2 removeItem' data-message='guest'><i
                        class='fas fa-times'></i>
                      Remove guest</button>
                    <div class='btn-group'>
                      <button class='btn btn-success btn-sm' data-toggle='modal' data-target='#addOrEditGuestDetails'><i
                          class='fas fa-plus'></i> Add</button>
                      <button class='btn btn-primary btn-sm' data-toggle='modal' data-target='#addOrEditGuestDetails'><i
                          class='fas fa-edit'></i> Edit details</button>
                    </div>
                  </div>
                </section>
                <hr>
                <div class='custom-control custom-checkbox'>
                  <input type='checkbox' class='custom-control-input' sendMailConfirmation='' value='off'
                    id='sendMailConfirmation{$data[' id']}'>
                  <label class='custom-control-label' for='sendMailConfirmation{$data[' id']}'>Send confirmation Email
                  </label>
                </div>
                <div class='row'>
                  <div class='col-md-12 mt-3'>
                    <textarea name='' id='' class='form-control' rows='6'></textarea>
                  </div>
                  <div id='notes' class='notes col-md-12 mt-3'>
                    <div class=''>
                      <table class='table table-striped w-100'>
                        <thead>
                          <th>NOTES</th>
                          <th class='text-right'>
                            <button class='btn btn-primary btn-sm pull-right' data-toggle='modal'
                              data-target='#addNewNote'><i class='fas fa-plus-circle'></i> Add Notes</button>
                          </th>
                        </thead>
                        <tbody>
                          <tr>
                            <td class='col-sm-9'><b>Fincance: </b>Cobrar restante.</td>
                            <td class='col-sm-3 text-center'>
                              <button class='btn btn-outline-primary btn-sm'><i class='fas fa-pencil-alt'></i></button>
                              <button class='btn btn-outline-danger btn-sm removeItem' data-message='note'><i
                                  class='fas fa-trash-alt'></i></button>
                            </td>
                          </tr>
                          <tr>
                            <td class='col-sm-9'><b>Fincance: </b>Cobrar restante.</td>
                            <td class='col-sm-3 text-center'>
                              <button class='btn btn-outline-primary btn-sm'><i class='fas fa-pencil-alt'></i></button>
                              <button class='btn btn-outline-danger btn-sm removeItem' data-message='note'><i
                                  class='fas fa-trash-alt'></i></button>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class='col-md-6 p-0'>
                <div class='row'>
                  <!-- Column2 -->
                  <div id='content-StayDetails' class='col-md-6 p-3 px-4 content-StayDetails'>
                    <h5><b>Stay details</b> </h5>
                    <div class='row mt-3'>
                      <div class='col-md-6 p-0 pr-1'>
                        <label for='checkIn'>Check-in</label>
                        <input type='date' id='checkIn' class='form-control px-2'>
                      </div>
                      <div class='col-md-6 p-0 pl-1'>
                        <label for='checkOut'>Check-out</label>
                        <input type='date' id='checkOut' class='form-control px-2'>
                      </div>
                    </div>

                    <div class='row mt-3'>
                      <label for='purpose'>Purpose</label>
                      <input type='text' id='purpose' class='form-control' id='purpose'>
                    </div>
                    <div class='row mt-3'>
                      <label for='sources'>Sources</label>
                      <select id='sources' class='custom-select '></select>
                    </div>
                    <div class='row mt-3'>
                      <label for='type'>Type</label>
                      <select id='type' class='custom-select '></select>
                    </div>
                    <div class='row mt-3'>
                      <label for='mktSmgt'>Mkt Smgt</label>
                      <select id='mktSmgt' class='custom-select '></select>
                    </div>
                    <div class='row mt-3'>
                      <label for='salesPerson'>Sales person</label>
                      <select id='salesPerson' class='custom-select '></select>
                    </div>

                    <div class='section-ArrivalOrDeparture'>
                      <div class='row mt-3'>
                        <div class='list-group flex-row text-center w-100' id='list-tab' role='tablist'>
                          <a class='list-group-item list-group-item-action active' id='list-arrival-list'
                            data-toggle='list' href='#list-arrival{$data[' id']}' role='tab'
                            aria-controls='arrival'>Arrival</a>
                          <a class='list-group-item list-group-item-action' id='list-departure-list' data-toggle='list'
                            href='#list-departure{$data[' id']}' role='tab' aria-controls='departure'>Departure</a>
                        </div>
                      </div>

                      <div class='tab-content mt-3' id='nav-tabContent' style='background: none'>
                        <div class='tab-pane fade active show' id='list-arrival{$data[' id']}' role='tabpanel'
                          aria-labelledby='list-arrival-list'>
                          <div id='contentsArrival'>
                            <div class='row mt-3'>
                              <label for='info'>Select mode</label>
                              <select name='' id='' class='custom-select'></select>
                            </div>
                            <div class='row mt-3'>
                              <label for='arrivalFlight'>Arrival/Flight #</label>
                              <input type='text' class='form-control' id='arrivalFlight'>
                            </div>
                            <div class='row mt-3'>
                              <label for='arrival Time'>Arrival Time</label>
                              <input type='time' class='form-control' id='arrivalTime'>
                            </div>
                          </div>
                        </div>

                        <div class='tab-pane fade' id='list-departure{$data[' id']}' role='tabpanel'
                          aria-labelledby='list-departure-list'>
                          <div id='contentsDeparture'>
                            <div class='row mt-3'>
                              <label for='info'>Select mode</label>
                              <select id='departureMode' class='custom-select'></select>
                            </div>
                            <div class='row mt-3'>
                              <label for='arrivalFlight'>Departure/Flight #</label>
                              <input type='text' class='form-control' id='departureFlight'>
                            </div>
                            <div class='row mt-3'>
                              <label for='arrival Time'>Departure Time</label>
                              <input type='time' class='form-control' id='departureTime'>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class='row mt-3'>
                      <div class='col p-1 align-self-center'>
                        <div class='custom-control custom-checkbox custom-control-inline'>
                          <input type='checkbox' class='custom-control-input' id='assignTask{$data[' id']}'>
                          <label class='custom-control-label' for='assignTask{$data[' id']}' data-toggle='collapse'
                            data-target='#selectAssignTask{$data[' id']}'>Assign Task</label>
                        </div>
                      </div>
                      <div class='col p-1'>
                        <select id='selectAssignTask{$data[' id']}' selectAssignTask='' class='custom-select collapse'>
                          <option value='' selected disabled>Select POS</option>
                        </select>
                      </div>
                    </div>
                    <div class='row mt-4 p-1'>
                      <div class='custom-control custom-checkbox custom-control-inline'>
                        <input type='checkbox' class='custom-control-input' sendMail='' id='sendMail{$data[' id']}' />
                        <label class='custom-control-label' for='sendMail{$data[' id']}'>Send Mail</span>
                      </div>
                    </div>
                  </div>
                  <!-- Column3 -->
                  <div id='content-RoomDetails' class='col-md-6 pt-3 border-dashed-left content-RoomDetails'>
                    <h5><b>Room Details</b></h5>
                    <table class='table'>
                      <tbody>
                        <tr>
                          <td class='text-info'>Number of Rooms</td>
                          <td id='numberOfRooms' class='text-right'>3</td>
                        </tr>
                        <tr>
                          <td class='text-info'>Adults</td>
                          <td id='numberOfAdults' class='text-right'>2</td>
                        </tr>
                        <tr>
                          <td class='text-info'>Children</b></td>
                          <td id='numberofChildrens' class='text-right'>0</td>
                        </tr>
                        <tr>
                        <tr class='bg-info text-white'>
                          <td><b>Total Guests</b></td>
                          <td id='totalGuests' class='text-right'>$<b>5</b></td>
                        </tr>
                        <tr>
                      </tbody>
                    </table>
                    <hr>
                    <div class='container-fluid p-0 mt-5'>
                      <h5><b>Credit Card Details</b></h5>
                      <div class='row mt-3'>
                        <label for='carNumber'>Card Number</label>
                        <input type='text' class='form-control' id='cardNumber' placeholder='#### #### #### ####'>
                      </div>
                      <div class='row mt-3'>
                        <label for='cardType'>Card type</label>
                        <select class='custom-select' name='' id=''></select>
                      </div>
                      <div class='row mt-3'>
                        <label for='expire' class='d-block w-100'>Expire</label>
                        <div class='col'><input type='text' class='form-control' placeholder='MM'></div><b
                          style='align-self: center;'>/</b>
                        <div class='col'><input type='text' class='form-control' placeholder='YYYY'></div><b
                          style='align-self: center;'>/</b>
                        <div class='col'><input type='text' class='form-control' placeholder='CVC'></div><b
                          style='align-self: center;'></b>
                      </div>
                      <div class='row mt-3'>
                        <button class='btn btn-outline-primary w-100' data-toggle='modal'
                          data-target='#ModalAddCreditCard'><i class='fas fa-credit-card'></i> Add Credit
                          Card</button>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Pay Term -->
                <div id="payTerm" class="col-md-12 py-1" style="background: #E4F0FE;">
                  <div class="row">
                    <select id="" class="custom-select custom-select-user">
                      <option value="">Balance To be Paid by Group Owner</option>
                    </select>
                  </div>
                  <div class="row px-3">
                    <div class="custom-control custom-checkbox custom-control-inline">
                      <input type="checkbox" class="custom-control-input" id="otherCharges-payTerm{$data['id']}">
                      <label class="custom-control-label" for="otherCharges-payTerm{$data['id']}">Including Other
                        Charges</label>
                    </div>
                    <button class="btn btn-outline-primary btn-sm ml-auto list-item-collapse" data-toggle="collapse"
                      data-target="#setLimit">Set Limit&nbsp;</button>
                  </div>
                  <div id="setLimit" class="row px-3 py-2 collapse">
                    <div class="custom-control custom-checkbox custom-control-inline  ml-auto ">
                      <input type="checkbox" class="custom-control-input" id="inclusiveTax-payTerm{$data['id']}">
                      <label class="custom-control-label" for="inclusiveTax-payTerm{$data['id']}">Inclusive of
                        Tax</label>
                    </div>
                    <button class="btn btn-outline-primary btn-sm ml-2 list-item-collapse" data-toggle="collapse"
                      data-target="#editLimits">Edit Details&nbsp;</button>
                  </div>
                  <div id="setLimit" class="row py-2 collapse">
                    <div class="col d-flex">
                      $<input type="text" class="form-control form-control-sm">
                    </div>
                    <div class="col">
                      <select id="per?" class="custom-select custom-select-sm">
                        <option value="">Per Room</option>
                      </select>
                    </div>
                    <div class="col align-self-center">
                      <div class="custom-control custom-checkbox custom-control-inline  ml-auto ">
                        <input type="checkbox" class="custom-control-input" id="perNight-payTerm{$data['id']}">
                        <label class="custom-control-label" for="perNight-payTerm{$data['id']}">Per Night</label>
                      </div>
                    </div>
                  </div>
                  <div id="editLimits" class="col-md-12 py-2 collapse">
                    <hr>
                    <div id="customRoomTariff" class="row">
                      <div class="col-md-4">
                        <label for="roomFieldRoomTariffTariff">Room Tariff</label>
                        <input type="text" id="FieldRoomTariff" class="form-control form-control-sm">
                      </div>
                      <div class="col-md-4 align-self-end">
                        <div class="custom-control custom-checkbox custom-control-inline  ml-auto ">
                          <input type="checkbox" class="custom-control-input" id="TariffPerNight-payTerm{$data['id']}">
                          <label class="custom-control-label" for="TariffPerNight-payTerm{$data['id']}">Per
                            Night</label>
                        </div>
                      </div>
                      <div class="col-md-4 align-self-end">
                        <div class="custom-control custom-checkbox custom-control-inline  ml-auto ">
                          <input type="checkbox" class="custom-control-input" id="TariffPerPerson-payTerm{$data['id']}">
                          <label class="custom-control-label" for="TariffPerPerson-payTerm{$data['id']}">Per
                            Person</label>
                        </div>
                      </div>
                    </div>
                    <div id="addonsTariff" class="row">
                      <div class="col-md-4">
                        <label for="FieldAddonsTariff">Add-ons Tariff</label>
                        <input type="text" id="FieldAddonsTariff" class="form-control form-control-sm">
                      </div>
                      <div class="col-md-4 align-self-end">
                        <div class="custom-control custom-checkbox custom-control-inline  ml-auto ">
                          <input type="checkbox" class="custom-control-input" id="addonsPerNight-payTerm{$data['id']}">
                          <label class="custom-control-label" for="addonsPerNight-payTerm{$data['id']}">Per
                            Night</label>
                        </div>
                      </div>
                      <div class="col-md-4 align-self-end">
                        <div class="custom-control custom-checkbox custom-control-inline  ml-auto ">
                          <input type="checkbox" class="custom-control-input" id="addonsPerPerson-payTerm{$data['id']}">
                          <label class="custom-control-label" for="addonsPerPerson-payTerm{$data['id']}">Per
                            Person</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!--Table Rates/Packages-->
                <div id='ratesPackages' class='col-md-12 p-0 mt-4'>
                  <div class="table-responsive">
                    <table id="tableDiscount" class="table">
                      <thead class="text-center text-white" style="background: #138c9f;">
                        <tr>
                          <th colspan=" 2">Rates/Packes</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td class="pl-0">
                          </td>
                          <td class="pr-0">
                            <button class="btn btn-info btn-sm w-100" data-toggle="modal"
                              data-target="#modalPromoCode"><i class="fas fa-barcode"></i> Promo Code</button>
                          </td>
                        </tr>
                        <tr>
                          <td id="specialDiscount"></td>
                          <td id="promoCode"></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="table-responsive">
                    <table id='tableRatesPackes' class='table text-center tableRatesPackes'>
                      <thead class='bg-info'>
                        <tr>
                          <th>Rate Type</th>
                          <th>Date</th>
                          <th>Amount</th>
                          <th>Nights</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                            <select class='custom-select custom-select-user' id='changeRateType'>
                              <option value=''>Seasonal Rate</option>
                            </select>
                          </td>
                          <td>
                            <span>03 Aug - </span>
                            <button class='btn'>06 Aug</button>
                          </td>
                          <td>$ 200.00</td>
                          <td>3</td>
                        </tr>
                        <tr>
                          <td>
                            <button class='btn btn-outline-primary w-100' data-toggle='modal'
                              data-target='#modalInclusionsAddons'><i class='fas fa-puzzle-piece'></i>
                              Inclusions/Add-ons</button>
                          </td>
                          <td id='inclusions-Addons' class='text-dark inclusions-Addons' colspan='3'> <i>Airport</i>
                            <i>Pickup</i> <i>Half Board: Breakfast</i> <i>Dinner</i> </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="ContentClientPayment w-100 pt-3 border-dashed-top">
                <div class="row">
                  <div class="table-responsive">
                    <table class="table" id="tableAttachGuests">
                      <thead class="bg-info text-white">
                        <tr>
                          <th>
                            <div class="custom-control custom-checkbox">
                              <input type="checkbox" id="selectClient" class="custom-control-input">
                              <label for="selectClient" class="custom-control-label"></label>
                            </div>
                          </th>
                          <th>Res #</th>
                          <th>Room Type</th>
                          <th>Room</th>
                          <th>Guest Name</th>
                          <th>Phone</th>
                          <th>Adult</th>
                          <th>Child</th>
                          <th>Check-In - Check-Out</th>
                          <th>Status</th>
                          <th>Action</th>
                          <th>Price</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                            <div class="custom-control custom-checkbox">
                              <input type="checkbox" id="selectClient1" class="custom-control-input">
                              <label for="selectClient" class="custom-control-label"></label>
                            </div>
                          </td>
                          <td>800021</td>
                          <td>
                            <select id="roomType" class="custom-select custom-select-user">
                              <option value="">Standar Room</option>
                              <option value="">Deluxe Room</option>
                              <option value="">Superior Room</option>
                            </select>
                          </td>
                          <td>
                            <select id="rooms" class="custom-select custom-select-user">
                              <option value="" selected disabled>Assign</option>
                            </select>
                          </td>
                          <td id="guestName">Jose Polanco</td>
                          <td>809-663-3315</td>
                          <td>
                            <select id="numberOfAdult" class="custom-select"></select>
                          </td>
                          <td>
                            <select id="numberOfChild" class="custom-select"></select>
                          </td>
                          <td>
                            Aug 25 - 31 Aug
                          </td>
                          <td>Reserved</td>
                          <td></td>
                          <td>$350.00</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="row mt-2">
                  <div class="col-md-8">
                    <div class="row">
                      <button class="btn btn-outline-primary mx-1"><i class="fas fa-list"></i> Guest List</button>
                      <button class="btn btn-outline-primary mx-1"><i class="fas fa-check-circle"></i> Auto Asssign
                        Selected Room(s)</button>
                      <button class="btn btn-outline-primary mx-1"><i class="fas fa-user"></i> Manage Occupancy</button>
                      <button class="btn btn-outline-primary mx-1"><i class="fas fa-hand-holding-usd"></i> Tax
                        Exempt</button>
                    </div>
                    <div class="row mt-4">
                      <button class="btn btn-primary mx-1"><i class="fas fa-plus"></i> Add New Room(s)</button>
                      <button class="btn btn-danger mx-1"><i class="fas fa-times"></i> Cancel selected</button>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <table class="table text-right">
                      <tbody>
                        <tr>
                          <th>Total</th>
                          <th>$1,200.00</th>
                        </tr>
                        <tr>
                          <td>Additional Group Owner Charges</td>
                          <td>$ 0.00</td>
                        </tr>
                        <tr>
                          <td>Taxes</td>
                          <td>180.00</td>
                        </tr>
                        <tr>
                          <td>Discount</td>
                          <td>$ 0.00</td>
                        </tr>
                        <tr class="bg-info text-white">
                          <th>Total Amount</th>
                          <td>$ 1380.00</td>
                        </tr>
                        <tr class="bg-info text-white">
                          <td>Paid</td>
                          <td>0.00</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="row tab-pane-footer">
              <div class="col-md-12">
                <button class="btn btn-light mx-1">Group Cancel</button>
                <button id="groupPaidBill" class="btn btn-light mx-1">Group Payment</button>
              </div>
            </div>
          </div>
          <div id='paybill' class='col-md-12 p-0 d-none'>
            <div class="paymentDetails">
              <div class='row p-3'>
                <div class='col-md-6'>
                  <div class='card shadow'>
                    <div class='card-header'>
                      <h5 class='m-0'>BOOKING DETAILS</h5>
                    </div>
                    <div class='card-body p-0'>
                      <table class='verticalTable'>
                        <colgroup>
                          <col class='col-7'>
                          <col class='col-5'>
                        </colgroup>
                        <tbody>
                          <tr>
                            <th>Company Name: <span style='font-size: 1.3rem;font-weight: 700;'>DexPlode</span></th>
                            <th>ID (Voter ID) #: <span>402-1369831-1</span></th>
                          </tr>
                          <tr>
                            <th>Guest Name: <span style='font-size: 1.3rem;font-weight: 700;'>Dr. JOnas Cueva <span
                                  class='text-danger'>(P25)</span></span></th>
                            <th>Telefono: <span>809-666-333</span></th>
                          </tr>
                          <tr>
                            <th>Address: <span>C/ Lirio Paseo Del Norte #3, Santo Domingo
                                Distrito Nacional - 20211
                                Dominican Republic</span>
                            </th>
                            <th>Email: <span>jskm@gmail.com</span></th>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class='card-footer px-1'>
                      <div class='table-responsive'>
                        <table class='text-center w-100' style='font-size: 15px;'>
                          <thead>
                            <tr>
                              <th>Created On</th>
                              <th>Stay Details</th>
                              <th>Room(s)Person(s)</th>
                              <th>Amount</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>Aug 18, 2020</td>
                              <td>Standar Room(STD-103)<br>
                                Aug 30, 2020 - Sept 05, 2020(6 Night)<br>
                                <i class='text-muted'>Honeymoon Package</i>
                              </td>
                              <td>Room(s)2 - (2 Adults)</td>
                              <td>$ 765.00<br> <i class='text-muted'>879.75 with tax $ 114.75</i></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
                <div class='col-md-6'>
                  <div id='folioList' class='card shadow'>
                    <div class='card-header'>
                      <h5 class='m-0'>FOLIO LIST</h5>
                    </div>
                    <div class='card-body p-0'>
                      <span class='folded-corner folded-corner-sm'></span>
                      <div class='row'>
                        <div class='table-responsive'>
                          <table id='tableFolios' class='table table-striped table-hover table-sm'>
                            <thead class='bg-primary text-white'>
                              <tr>
                                <th>
                                  <div class='custom-control custom-checkbox'>
                                    <input type='checkbox' id='folioList{$data[' id']}' class='custom-control-input'>
                                    <label for='folioList{$data[' id']}' class='custom-control-label'></label>
                                  </div>
                                </th>
                                <th colspan='2'>Guest</th>
                                <th>Amount($)</th>
                                <th>Paid</th>
                                <th>Balance</th>
                              </tr>
                              <tr class='bg-light-gray text-dark'>
                                <td colspan='6'>
                                  <b>Room Type(Room): </b><span class='text-info'>Superior Room
                                    (SUP-131)</span>
                                </td>
                              </tr>
                            </thead>
                            <tbody>
                              <tr data-id='{$data[' id']}'>
                                <td>
                                  <div class='custom-control custom-checkbox'>
                                    <input type='checkbox' id='folioList{$data[' id']}' class='custom-control-input'>
                                    <label for='folioList{$data[' id']}' class='custom-control-label'></label>
                                  </div>
                                </td>
                                <td>
                                  <p class='action'>INV1</p>
                                </td>
                                <td>April Monique</td>
                                <td>460.00</td>
                                <td>460.00</td>
                                <td><i class='fas fa-lock'></i></td>
                              </tr>
                            </tbody>
                            <tfoot>
                              <tr>
                                <th colspan="2"></th>
                                <th>Total</th>
                                <th>$ 460.00</th>
                                <th>$460.00</th>
                                <th>-</th>
                              </tr>
                            </tfoot>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class='card-footer px-3'>
                      <button class='btn btn-primary mx-1'><i class='fas fa-envelope-open'></i> Email</button>
                      <button class='btn btn-danger mx-1'><i class='fas fa-trash'></i> Delete</button>
                      <button class='btn btn-danger mx-1'><i class='fas fa-times-circle'></i> Close</button>
                      <button class='btn btn-primary mx-1'><i class='fas fa-print'></i> Print</button>
                      <div class='noFolio d-none'>
                        <span>No folio generated
                          <button class='btn btn-outline-primary btn-sm'>Generate Now</button>
                        </span>
                        <div class='custom-control custom-checkbox mr-3'>
                          <input type='checkbox' id='generatedFOC{$data[' id']}' class='custom-control-input'>
                          <label for='generatedFOC{$data[' id']}' class='custom-control-label'>Generate separate Folio
                            for
                            other charges</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class='row'>
                <div class='table-responsive'>
                  <h4 class='text-center'>ACCOUNT STATEMENT</h4>
                  <div class="table-responsive">
                    <table id='tableAccountStatement' class='table table-striped table-sm'>
                      <thead class='bg-primary text-white'>
                        <tr>
                          <th>
                            <div class='custom-control custom-checkbox'>
                              <input type='checkbox' id='CCStatement{$data[' id']}' autocomplete='off'
                                class='custom-control-input' value='off'>
                              <label for='CCStatement{$data[' id']}' class='custom-control-label'></label>
                            </div>
                          </th>
                          <th>Date</th>
                          <th>Description/References</th>
                          <th>Folio #</th>
                          <th>Disc/Allwnce</th>
                          <th>Charges</th>
                          <th>Tax</th>
                          <th>Payment</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                            <div class='custom-control custom-checkbox'>
                              <input type='checkbox' id='A324' class='custom-control-input' disabled value='off'>
                              <label for='A324' class='custom-control-label'></label>
                            </div>
                          </td>
                          <td>Aug 31, 2020</td>
                          <td>Rack Rate Room Superior Room/SUP-131</td>
                          <td>INV1</td>
                          <td></td>
                          <td>$ 200.00</td>
                          <td>$ 30.00</td>
                          <td></td>
                        </tr>
                        <tr>
                          <td>
                            <div class='custom-control custom-checkbox'>
                              <input type='checkbox' id='A325' class='custom-control-input' value='off'>
                              <label for='A325' class='custom-control-label'></label>
                            </div>
                          </td>
                          <td>Aug 31, 2020</td>
                          <td>Rack Rate Room Superior Room/SUP-131</td>
                          <td>INV1</td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td>$ 119.00</td>
                        </tr>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan='4'>
                            <button class='btn btn-primary btn-sm'><i class='fas fa-redo'></i> Refund</button>
                            <button class='btn btn-primary btn-sm'><i class='fas fa-redo'></i> Route charges</button>
                            <button class='btn btn-primary btn-sm'><i class='fas fa-redo'></i> Route new folio</button>
                            <button class='btn btn-primary btn-sm'><i class='fas fa-redo'></i> Route payment</button>
                          </td>

                          <th>Total</th>
                          <th>$ 0.00</th>
                          <th>$ 0.00</th>
                          <th>$ 0.00</th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
              <div class='row'>
                <div class='col-md-9'>
                  <div class='row p-4 bg-light-gray'>
                    <button class='btn btn-primary mx-2'><i class='fas fa-folder-open'></i> Generate Folio</button>
                    <button class='btn btn-primary mx-2'><i class='fas fa-user'></i> Consolidate Account</button>
                    <button id="btnOtherCharges" data-toggle="modal" data-target="#modalOtherCharges"
                      class='btn btn-primary mx-2'>Other Charges</button>
                    <button class='btn btn-primary mx-2'><i class='fas fa-hand-holding-usd'></i> Custom
                      Charge/Allowance</button>
                  </div>
                </div>
                <div class='col-md-3'>
                  <table id='tableBalance' class='table text-right'>
                    <tbody>
                      <tr>
                        <th>Booking Total</th>
                        <td>$ 780.00</td>
                      </tr>
                      <tr>
                        <th>Other Charges</th>
                        <td>$ 0.00</td>
                      </tr>
                      <tr>
                        <th>Total Tax</th>
                        <td>$ 114.75</td>
                      </tr>
                      <tr>
                        <th>Total Disc/Allw</th>
                        <td>$ -135.00</td>
                      </tr>
                      <tr class='bg-info text-white'>
                        <th>Total Amount <br>
                          <i style='font-size: 14px;'>Total Paid</i>
                        </th>
                        <td id='totalAmount' data-value='879.75' data-currency='DOP'>$ 879.75 <br>
                          <i style='font-size: 14px;'>$ 0.00</i>
                        </td>
                      </tr>
                      <tr>
                        <th>Balance</th>
                        <td>$ 879.75</td>
                      </tr>
                      <tr>
                        <td colspan='2'>
                          <button id='currencyConverter' class='btn btn-success w-100'><i
                              class='fas fa-dollar-sign'></i>
                            Currency
                            Converter</button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div id="contentFolio" class='col-md-12 p-5 d-none'>
              <div class='card shadow'>
                <span class='folded-corner'></span>
                <div class='card-header'>
                  <h3 class='m-0 text-center text-muted font-weight-bold'>Folio #INV1</h3>
                </div>
                <div class='card-body'>
                  <div class='row'>
                    <div class='col-md-6 pr-3'>
                      <h3 class='text-muted font-weight-bold mb-3 w-100'>Guest Details</h3>
                      <div class='row mb-3'>
                        <div class='col-sm-4 pl-0'>
                          <b>Guest Name:</b>
                        </div>
                        <div class='col-sm-8'>
                          <h4 class='text-info font-weight-bold m-0'>Anastacia Grey<i class='text-danger'>(P20)</i>
                          </h4>
                        </div>
                      </div>
                      <div class='row mb-3'>
                        <div class='col-sm-4 pl-0'>
                          <b>Address:</b>
                        </div>
                        <div class='col-sm-8'>
                          <span>C/Lirio #122 Santo Domingo</span>
                        </div>
                      </div>
                      <div class='row mb-3'>
                        <div class='col-sm-4 pl-0'>
                          <b>Phone:</b>
                        </div>
                        <div class='col-sm-8'>
                          <span>809-333-6666</span>
                        </div>
                      </div>
                      <div class='row mb-3'>
                        <div class='col-sm-4 pl-0'>
                          <b>Email:</b>
                        </div>
                        <div class='col-sm-8'>
                          <span>guest@gmail.com</span>
                        </div>
                      </div>
                    </div>
                    <div class='col-md-6'>
                      <h3 class='text-muted font-weight-bold mb-3 w-100'>Reservation Details</h3>
                      <div class='row mb-3'>
                        <div class='col-sm-4 pl-0'>
                          <b>Create On:</b>
                        </div>
                        <div class='col-sm-8'>
                          <span>Sep 04,2020</span>
                        </div>
                      </div>
                      <div class='row mb-3'>
                        <div class='col-sm-4 pl-0'>
                          <b>Stay Details:</b>
                        </div>
                        <div class='col-sm-8'>
                          <span>
                            Superior Room(SUP-131)<br>
                            Aug 31-Sep 02(2 Nights)<br>
                            <i class='text-muted'>Rack Rate</i>
                          </span>
                        </div>
                      </div>
                      <div class='row mb-3'>
                        <div class='col-sm-4 pl-0'>
                          <b>Room(s) / Person(s):</b>
                        </div>
                        <div class='col-sm-8'>
                          <span>1 Room(s)/1 (1 Adults)</span>
                        </div>
                      </div>
                      <div class='row mb-3'>
                        <div class='col-sm-4 pl-0'>
                          <b class='mr-5'>Amount:</b>
                        </div>
                        <div class='col-sm-8'>
                          <span>
                            $ 400.00<br>
                            <i class='text-muted'>($ 460.00 with tax $60.00)</i>
                          </span>
                        </div>

                      </div>
                    </div>
                  </div>
                  <div class='table-responsive'>
                    <table id='tableFolio' class='table table-striped table-sm table-checkList'>
                      <thead class='bg-primary text-white'>
                        <tr>
                          <th>
                            <div class='custom-control custom-checkbox'>
                              <input type='checkbox' id='Tfolio{$data[' id']}' autocomplete='off'
                                class='custom-control-input' value='off'>
                              <label for='Tfolio{$data[' id']}' class='custom-control-label'></label>
                            </div>
                          </th>
                          <th>Date</th>
                          <th>Description/References</th>
                          <th>Disc/Allwnce</th>
                          <th>Amount</th>
                          <th>Tax</th>
                          <th>Payment</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                            <div class='custom-control custom-checkbox'>
                              <input type='checkbox' id='TItemFlio{$data[' id']}' class='custom-control-input' disabled
                                value='off'>
                              <label for='TItemFlio{$data[' id']}' class='custom-control-label'></label>
                            </div>
                          </td>
                          <td>Aug 31, 2020</td>
                          <td>Rack Rate Room Superior Room/SUP-131</td>
                          <td></td>
                          <td>$ 200.00</td>
                          <td>$ 30.00</td>
                          <td></td>
                        </tr>
                        <tr>
                          <td>
                            <div class='custom-control custom-checkbox'>
                              <input type='checkbox' id='TItemFlio{$data[' id']}' class='custom-control-input'
                                value='off'>
                              <label for='TItemFlio{$data[' id']}' class='custom-control-label'></label>
                            </div>
                          </td>
                          <td>Aug 31, 2020</td>
                          <td>Rack Rate Room Superior Room/SUP-131</td>
                          <td></td>
                          <td></td>
                          <td></td>
                          <td>$ 119.00</td>
                        </tr>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan='2'></td>
                          <th>Total</th>
                          <th>-</th>
                          <th>$ 0.00</th>
                          <th>$ 0.00</th>
                          <th>$ 0.00</th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                  <div class='row'>
                    <div class='col-md-9'>
                      <div class='row p-4 bg-light-gray'>
                        <button id='backToAcc' class='btn btn-success m-1'><i class='fas fa-angle-left'></i> Back To
                          Account Statement</button>
                        <button id='taxExempt' class='btn btn-primary m-1'>Tax Exempt</button>
                        <button id='rCharges' class='btn btn-primary m-1'>Route Charges</button>
                        <button id='rToNewFolio' class='btn btn-primary m-1'>Route To New Folio</button>
                        <button id='rPayment' class='btn btn-primary m-1'>Route Payment</button>
                        <button id='fSummary' class='btn btn-primary m-1'>Folio Summary</button>
                      </div>
                    </div>
                    <div class='col-md-3'>
                      <table id='tableFolioBalance' class='table text-right'>
                        <tbody>
                          <tr>
                            <th>Total</th>
                            <td>$ 400.00</td>
                          </tr>
                          <tr>
                            <th>Occupancy Tax</th>
                            <td>$ 60.00</td>
                          </tr>
                          <tr>
                            <th>VAT</th>
                            <td>$ 0.00</td>
                          </tr>
                          <tr class='bg-light-gray'>
                            <th><b>Total Amount</b><br>
                              <i style='font-size: 14px;'>Includes Disc/Allw</i><br>
                              <i style='font-size: 14px;'>Total Paid</i>
                            </th>
                            <td id='totalAmount' data-value='460.00' data-currency='DOP'>$ 460.00 <br>
                              <i style='font-size: 14px;'>$ 0.00</i><br>
                              <i style='font-size: 14px;'>$ 460.00</i>
                            </td>
                          </tr>
                          <tr>
                            <th>Balance</th>
                            <td>$ 0.00</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <hr>
            </div>

            <div id='payment' class='row'>
              <div class='col-sm-2 p-2 text-center bg-lightblue'>
                <h4>Payment</h4>
              </div>
              <div class='col-sm-10 p-2'>
                <span class='text-danger'>Payment Gateway is no integrated. Credit Card will not be charged</span>
              </div>
            </div>
            <div class='row p-3 bg-lightblue'>
              <div class='col-md-1 px-1'>
                <label for='modePaid'>Mode</label>
                <select id='modePaid' class='custom-select'></select>
              </div>
              <div class='col-md-1 px-1'>
                <label for='type'>Type</label>
                <select id='type' class='custom-select'></select>
              </div>
              <div class='col-md-1 px-1'>
                <label for='amount'>Amount</label>
                <input type='text' id='amount' class='form-control'>
              </div>
              <div class='col-md-2 px-1'>
                <label for='cc-chechequeNo'>CC/Cheque No.</label>
                <input type='text' id='cc-chequeNo' class='form-control'>
              </div>
              <div class='col-md-2 px-1'>
                <label for='receip'>Receip</label>
                <input type='text' id='receip' class='form-control'>
              </div>
              <div class='col-md-3 px-1'>
                <label for='description'>Description</label>
                <input type='text' id='description' class='form-control'>
              </div>
              <div class='col-md-1 px-1 align-self-end'>
                <button class='btn btn-success w-100'>Pay Now</button>
              </div>
              <div class='col-md-1 px-1 align-self-end'>
                <button id='currencyConverter' class='btn btn-primary w-100'>Converter</button>
              </div>
            </div>
            <div class='row tab-pane-footer'>
              <div class='col-md-12'>
                <button class='btn btn-light mx-1'>Back</button>
                <button class='btn btn-light mx-1'>Delete Proforma Invoices</button>
                <button class='btn btn-light mx-1'>Print</button>
              </div>
              <div class='col-md-12 mt-1'>
                <div class='custom-control custom-checkbox'>
                  <input type='checkbox' id='suscRevEmail' class='custom-control-input' autocomplete='off'
                    value='off'>
                  <label for='suscRevEmail' class='custom-control-label text-white'>Suscribe Reviewexpress email</label>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <!-- Modal Details Reservation -->
  <div class="modal fade" id="ModalDetailsReservation" tabindex="-1" role="dialog" aria-labelledby=""
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h6 class="modal-title" id="typeReservation"></h6>
          <h6 class="modal-title ml-auto">RESERVATION ID #<b id="IdReservation"></b></h6>
          <h6 class="modal-title" id="gropId"></h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="col-md-12 d-flex p-0">
            <div class="col-md-4 p-0">
              <span><b id="nicename"></b></span>
            </div>
            <div class="col-md-4 p-0">
              <span><b id="reservationStatus"></b></span>
            </div>
            <div class="col-md-4 p-0">
              <span>Room type: <b id="roomType"></b></span>
            </div>
          </div>
          <hr>
          <table>
            <tbody>
              <tr>
                <td class="col-md-8" valign="top">
                  <p class="mb-4"><span class="text-info">Guest ID: </span><span id="guestID"></span></p>
                  <p><span class="text-info">Guest Name: </span><span id="guestName"></span></p>
                  <p><span class="text-info">Address: </span><span id="address"></span> - <span id="zipCode"></span></p>
                  <p><span class="text-info">country: </span><span id="country"></span></p>
                  <p><span class="text-info">Phone: </span><span id="phone"></span></p>
                  <p><span class="text-info">Email: </span><a href=""><span id="email"></span></a></p>
                  <p class="mt-4"><span class="text-info">Rate type: </span><span id="rateType"></span></p>
                </td>
                <td class="col-md-4">
                  <p><span class="text-info"><b>Stay details</b></span><br>
                    <span class="text-info">Check in date: </span><span id="checkInDate"></span><br>
                    <span class="text-info">Check out date: </span><span id="checkOutDate"></span><br>
                    <span class="text-info">Room Night: </span><span id="roomNight"></span><br>
                    <span class="text-info">Adults: </span><span id="adults">2</span><br>
                    <span class="text-info">Arrival Time: </span><span id="arrivalTime"></span><br>
                    <span class="text-info">Departure Time: </span><span id="departureTime"></span><br>
                  <div class="d-flex" id="totalSingleReserv">
                    <div class="mr-4">
                      <span class="text-danger"><b>Total Amount : </b></span><br>
                      <span class="text-success"><b>Paid : </span></b><br>
                      <span class="text-info"><b>Balance : </span></b><br>
                    </div>
                    <div class="">
                      <b id="totalAmount"></b><br>
                      <b id="paid"></b><br>
                      <b id="balance"></b><br>
                    </div>
                  </div>
                  <div class="d-flex mt-3" id="totalGroupReserv" style="display: none !important;">
                    <div class="mr-4">
                      <span class="text-danger"><b>Group Total : </b></span><br>
                      <span class="text-success"><b>Group deposit : </span></b><br>
                    </div>
                    <div class="">
                      <b id="groupTotal">200.00</b><br>
                      <b id="groupDeposit">0.00</b><br>
                    </div>
                  </div>
                  </p>
                </td>
              </tr>
            </tbody>
          </table>
          <!--END MODAL BODY-->
        </div>
        <div class="modal-footer d-block">
          <div class="group-buttton text-center">
            <button class="btn btn-primary"><i class="fas fa-print"></i> Print Reservation Card</button>
            <button class="btn btn-primary" data-toggle="modal" data-target="#ModalSendMail"><i
                class="fas fa-envelope-open-text"></i> Send Email</button>
            <button class="btn btn-primary" data-toggle="modal" data-target="#sendMail"><i class="fas fa-mail-bulk"></i>
              Send Group Email</button>
            <button class="btn btn-primary" id="viewDetailsReserv"><i class="fas fa-eye"></i> View</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal Reservation -->
  <div class="modal fade" id="ModalReservation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="exampleModalLabel">Add Quick Reservation</h5>
          <h5 class="modal-title ml-auto">Room Type: <b id="RoomType">Clasic</b></h5>
          <label class="ml-auto" for="info"><input type="checkbox"> Assign</label>
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="">
            <div class="row mb-2">
              <div class="col-md-2">
                <label for="info">Desde</label>
                <input type="date" disabled id="from" class="form-control inputCalendar">
              </div>
              <div class="col-md-2">
                <label for="info">Hasta</label>
                <input type="date" id="to" class="form-control inputCalendar">
              </div>
              <div class="col-md-1">
                <label for="info">Adult</label>
                <select name="adult" id="adult" class="custom-select">
                     <?php for ($i = 1; $i <= 24; $i++) : ?>
                      <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                   <?php endfor; ?>
                </select>
              </div>
              <div class="col-md-1">
                <label for="info">Child</label>
                <select name="child" id="child" class="custom-select">
                   <option>0</option>
                   <?php for ($i = 1; $i <= 24; $i++) : ?>
                      <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                   <?php endfor; ?>
                </select>
              </div>
              <div class="col-md-5">
                <label for="info">Rate Type</label>
                <select name="rateType" id="rateType" class="custom-select">
                  <option value="">Select a Room</option>
                                    @foreach ($roomTypeId as $country)
                                        <option value="{{$country->id}}">{{$country->name}}</option>
                                    @endforeach
                </select>
              </div>
              <div class="col-md-1">
                <label for="info">Rooms</label>
                <select name="CRooms" id="CRooms" class="custom-select">
                   <?php for ($i = 1; $i <= 24; $i++) : ?>
                      <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                   <?php endfor; ?>
                </select>
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-md-2">
                <label for="info">Title</label>
                <select name="" id="" class="custom-select">
                  <option>Mr.</option>
                  <option>Dr.</option>
                  <option>Mrs.</option>
                  <option>Ms.</option>
                </select>
              </div>
              <div class="col-md-3">
                <label for="info">First name</label>
                <input type="text" class="form-control">
              </div>
              <div class="col-md-3">
                <label for="info">Last name</label>
                <input type="text" class="form-control">
              </div>
              <div class="col-md-4">
                <label for="info">Phone</label>
                <div class="input-group">
                  <input type="number" class="form-control">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <input type="radio" name="cel" value="cel">&nbsp;
                      <i class="fas fa-mobile-alt"></i>
                    </div>
                  </div>
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <input type="radio" name="cel" value="phone">&nbsp;
                      <i class="fas fa-phone"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row mb-2">
              <div class="col-md-3">
                <label for="email">Email</label>
                <input type="email" class="form-control">
              </div>
              <div class="col-md-4">
                <label for="">Tipo de pago</label>
                <div class="group-button">
                  <button class="btn btn-success" type="button" data-toggle="collapse"
                    data-target="#method-credidCard"><i class="fas fa-credit-card"></i> Credit Card Guarantee</button>
                  <button class="btn btn-success" type="button" data-toggle="collapse" id="unn"
                    data-target="#method-deposit"><i class="fas fa-money-bill-wave"></i> Deposit</button>
                </div>
              </div>
            </div>
            <div class="row m-2 p-4 shadow collapse" id="method-credidCard">
              <div class="col-md-3">
                <label for="info">No. Credit Card</label>
                <input type="number" class="form-control">
              </div>
              <div class="col-md-2">
                <label for="info">Card type</label>
                <select name="" id="" class="custom-select">
                  <option value=""></option>
                </select>
              </div>
              <div class="col-md-7">
                <label for="info">Expiry</label>
                <div class="input-group">
                  <input type="number" class="form-control" placeholder="MM"> /
                  <input type="number" class="form-control" placeholder="yyyyy"> /
                  <input type="number" class="form-control" placeholder="CVC">
                </div>
              </div>
            </div>
            <div class="row collapse" id="method-deposit">
              <div class="col-md-4 mr-auto ml-auto m-2 p-4 bg-primary shadow">
                <label for="info">Deposit Amount:</label>
                <input type="number" class="form-control">
              </div>
            </div>
            <hr>
            <div class="row p-3 bg-lightblue text-success">
              <span style="font-size: 20px;">Price:$ <b>   
                @foreach ($roomTypeId as $country)
                                        {{$country->base_price}}
                @endforeach</b> | <b>($ 100)</b></span>
            </div>
          </form>
          <!--END MODAL BODY-->
        </div>
        <div class="modal-footer d-block">
          <div class="row">
            <div class="col-md-6">
              <label for="info"><input type="checkbox"> Hold Til</label>
              <button type="button" class="btn btn-primary">Temp reserv</button>
              <button type="button" class="btn btn-primary">Reserv</button>
              <button type="button" class="btn btn-primary">Check-in</button>
            </div>
            <div class="col-md-6 text-right">
              <button id="btnSingleReservation" class="btn btn-warning" disabled data-type-reservation="single">Single</button>
              <button id="btnGroupReservation" class="btn btn-warning" data-type-reservation="other">Group</button>
              <button id="btnAgentOrCorporateReservation" class="btn btn-warning" data-type-reservation="travel_agent">Agent / Corporate</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal Send Mail-->
  <div class="modal fade" id="ModalSendMail" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header bg-dark text-white">
          <h6 class="modal-title">Send E-mail</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="custom-field">
                <input type="email" class="form-control mb-3" id="emailClient">
                <label for="EmailClient">Email</label>
              </div>
              <div class="custom-field">
                <label for="message">Message</label>
                <textarea name="" id="" class="form-control" id="message" rows="3"></textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> Preview Mail</button>
          <button class="btn btn-primary btn-sm"><i class="fas fa-envelope-open-text"></i> Send Mail</button>
          <button class="btn btn-primary btn-sm" data-dismiss="modal" aria-label="Close"><i
              class="fas fa-times"></i>Cancel</button>
        </div>
      </div>
    </div>
  </div>

  <!--===============================
              Modals Details 
    ================================-->

  <!-- Modal addOrEditGuestDetails -->
  <div class="modal fade" id="addOrEditGuestDetails" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h6 class="modal-title">Guest information</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row my-2 py-2">
            <!-- CONTENT 1 -->
            <div class="col-md-6 border-dashed-right" id="guestDetails">
              <p class="mb-3 font-weight-bold text-center">Guest Details</p>
              <div class="row mb-3">
                <div class="col-md-12 px-1">
                  <p class="text-info">Guest ID: <b>00001</b></p>
                </div>
                <div class="col-md-12 px-1">
                  <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input" id="noShareInfo">
                    <label class="custom-control-label" for="noShareInfo">Do not share info</label>
                  </div>
                  <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input" id="markVIP">
                    <label class="custom-control-label" for="markVIP">Mark as VIP</label>
                  </div>
                  <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input" id="markBlackList">
                    <label class="custom-control-label" for="markBlackList">Mark as Black</label>
                  </div>
                </div>
              </div>
              <div class="row mt-1">
                <div class="col-md-2 px-1">
                  <label for="title">Title</label>
                  <select class="custom-select" name="" id="title">
                    @foreach ($salutations as $item)
                    <option value="{{$item->id}}" {{$item->id == old('contact.salutation_id') ? 'selected' : '' }}>
                      {{$item->name}} </option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-4 px-1">
                  <label for="name">Name</label>
                  <input type="text" id="name" class="form-control">
                </div>
                <div class="col-md-4 px-1">
                  <label for="lastName">Last name</label>
                  <input type="text" id="lastName" class="form-control">
                </div>
                <div class="col-md-2 px-1">
                  <label for="gender">Gender</label>
                  <select name="" id="" class="custom-select">
                    <option value="1">M</option>
                    <option value="2">F</option>
                  </select>
                </div>
              </div>
              <div class="row mt-1">
                <div class="col-md-3 px-1">
                  <button class="btn btn-outline-primary w-100"><i class="fas fa-id-card"></i> Add Ids</button>
                </div>
                <div class="col-md-5 px-1">
                  <div class="input-group mb-3">
                    <div class="custom-file text-left">
                      <input type="file" class="custom-file-input" id="fileID">
                      <label class="custom-file-label" for="fileID">Upload your ID</label>
                    </div>
                  </div>
                </div>
                <div class="col-md-4 px-1">
                  <div class="custom-file text-left">
                    <input type="file" class="custom-file-input" id="moreInfo">
                    <label class="custom-file-label" for="moreInfo">More info</label>
                  </div>
                </div>
              </div>
              <div class="row mt-1">
                <label for="note">Note</label>
                <textarea name="" id="note" rows="2" class="form-control"></textarea>
              </div>
              <div class="row mt-1">
                <div class="col-md-8 px-1">
                  <label for="nationality">Nationality</label>
                  <select id="nationality" class="custom-select">
                    @foreach ($countries as $country)
                    <option value="{{$country->id}}">{{$country->country_name}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-4 px-1">
                  <label for="dateOBD">Date of birthday</label>
                  <input type="date" id="dateOBD" class="form-control inputCalendar">
                </div>
              </div>
              <div class="row mt-1">
                <div class="col-md-6 px-1">
                  <label for="phone">Phone</label>
                  <input type="number" id="phone" class="form-control">
                </div>
                <div class="col-md-6 px-1">
                  <label for="mobile">Mobile</label>
                  <input type="number" id="mobile" class="form-control">
                </div>
              </div>
              <div class="row mt-1">
                <div class="col-md-6 px-1">
                  <label for="email">Email</label>
                  <input type="email" id="email" class="form-control">
                </div>
                <div class="col-md-6 px-1">
                  <label for="fax">Fax</label>
                  <input type="text" id="fax" class="form-control">
                </div>
              </div>
            </div>
            <!-- CONTENT 2 -->
            <div class="col-md-6" id="workDetails">
              <p class="mb-3 font-weight-bold text-center">Work Details</p>
              <div class="row mb-3">
                <div class="col-md-6 px-1">
                  <label for="organization">Organization</label>
                  <input type="text" class="form-control" id="organization">
                </div>
                <div class="col-md-6 px-1">
                  <label for="designation">Designation</label>
                  <input type="text" class="form-control" id="designation">
                </div>
              </div>
              <div class="row mt-1">
                <div class="col-md-12 px-1">
                  <label for="address">Address</label>
                  <input type="text" class="form-control" id="address">
                </div>
              </div>
              <div class="row mt-1">
                <div class="col-md-6 px-1">
                  <label for="country">Country</label>
                  <select id="country" class="custom-select">
                    @foreach ($countries as $country)
                    <option value="{{$country->id}}">{{$country->country_name}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-6 px-1">
                  <label for="state">State</label>
                  <input type="text" id="state" class="form-control">
                </div>
              </div>
              <div class="row mt-1">
                <div class="col-md-6 px-1">
                  <label for="city">City</label>
                  <input type="text" class="form-control" id="city">
                </div>
                <div class="col-md-6 px-1">
                  <label for="zipCode">Zip Code</label>
                  <input type="text" class="form-control" id="zipCode">
                </div>
              </div>
              <div class="row mt-1">
                <div class="col-md-6 px-1">
                  <label for="workPhone1">Phone 1 #</label>
                  <input type="text" class="form-control" id="workPhone1">
                </div>
                <div class="col-md-6 px-1">
                  <label for="workPhone2">Phone 2 #</label>
                  <input type="text" class="form-control" id="workPhone2">
                </div>
              </div>

            </div>
          </div>

          <div class="row my-2 py-3 border-dashed-top">
            <!-- CONTENT 3 -->
            <div class="col-md-6 border-dashed-right" id="homeAddress">
              <p class="mb-3 font-weight-bold text-center">Home Address</p>
              <div class="row mt-1">
                <div class="col-md-12 px-1">
                  <label for="address">Address</label>
                  <input type="text" class="form-control" id="address">
                </div>
              </div>
              <div class="row mt-1">
                <div class="col-md-6 px-1">
                  <label for="country">Country</label>
                  <select id="country" class="custom-select">
                    @foreach ($countries as $country)
                    <option value="{{$country->id}}">{{$country->country_name}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-6 px-1">
                  <label for="state">State</label>
                  <input type="text" id="state" class="form-control">
                </div>
              </div>
              <div class="row mt-1">
                <div class="col-md-6 px-1">
                  <label for="city">City</label>
                  <input type="text" class="form-control" id="city">
                </div>
                <div class="col-md-6 px-1">
                  <label for="zipCode">Zip Code</label>
                  <input type="text" class="form-control" id="zipCode">
                </div>
              </div>
              <div class="row mt-1">
                <div class="col-md-6 px-1">
                  <label for="workPhone1">Phone 1 #</label>
                  <input type="text" class="form-control" id="workPhone1">
                </div>
                <div class="col-md-6 px-1">
                  <label for="workPhone2">Phone 2 #</label>
                  <input type="text" class="form-control" id="workPhone2">
                </div>
              </div>
            </div>
            <!-- CONTENT 4 -->
            <div id="guestPreferences" class="col-md-6">
              <div class="row">
                <label for="guestPreference">Guest Preferences</label>
                <textarea id="guestPreference" rows="3" class="form-control"></textarea>
              </div>
              <div id="otherDetails" class="row mt-3">
                <p class="mb-2 w-100 font-weight-bold text-center">Other Details</p>
                <div class="col-md-2 px-1">
                  <label for="title">Title</label>
                  <select id="title" class="custom-select">
                    @foreach ($salutations as $item)
                    <option value="{{$item->id}}" {{$item->id == old('contact.salutation_id') ? 'selected' : '' }}>
                      {{$item->name}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-5 px-1">
                  <label for="name">Name</label>
                  <input type="text" class="form-control" id="name">
                </div>
                <div class="col-md-5 px-1">
                  <label for="lastName">Last name</label>
                  <input type="text" class="form-control" id="lastName">
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
            <button class="btn btn-primary"><i class="fas fa-tripadvisor"></i> TripAdvisor Reviews</button>
            <button class="btn btn-danger" data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i>
              Cancel</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal ModalViewID -->
  <div class="modal fade" id="ModalViewID" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header bg-dark text-white">
          <h6 class="modal-title">Passport</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <table class="verticalTable">
            <tbody>
              <tr>
                <th>ID Number</th>
                <td><input type="text" id="MVIid" required class="form-control"></td>
              </tr>
              <tr>
                <th>Name</th>
                <td><input type="text" id="MVIname" required class="form-control"></td>
              </tr>
              <tr>
                <th>Place of Issue</th>
                <td><input type="text" class="form-control" id="MVIplaceInsue"></td>
              </tr>
              <tr>
                <th>Insue on</th>
                <td><input type="date" required id="MVIinsueOn" class="form-control inputCalendar"></td>
              </tr>
              <tr>
                <th>Expire on</th>
                <td><input type="date" required id="MVIexpireOn" class="form-control inputCalendar"></td>
              </tr>
              <tr>
                <th>Address</th>
                <td><input type="text" id="MVIaddress" class="form-control"></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button id="saveIDS" class="btn btn-primary" data-action="set"><i class="fas fa-save"></i> Done</button>
          <button class="btn btn-danger" data-dismiss="modal" aria-label="Close">
            <i class="fas fa-times"></i> Cancel</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal remove -->
  <div class="modal fade" id="ModalRemoveItem" style="z-index:1051;" tabindex="-1" role="dialog" aria-labelledby=""
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" style="max-width: 330px;"
      role="document">
      <div class="modal-content shadow">
        <div class="modal-header bg-danger text-white">
          <h6 class="modal-title">Remove Item</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p class="text-uppercase pt-3">Do you wish to delete this <span id="messageRemove" class="text-danger"></span>
          </p>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary"><i class="fas fa-save"></i> OK</button>
          <button class="btn btn-danger" data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i>
            Cancel</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal manager sharers -->
  <div class="modal fade" id="managerSharers" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h6 class="modal-title">Manager Sharer(s)</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row p-3">
            <div class="col px-1">
              <label for="title">Title</label>
              <select id="title" class="custom-select">
                @foreach ($salutations as $item)
                <option value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
              </select>
            </div>
            <div class="col px-1">
              <label for="firtName">First name</label>
              <input type="text" id="firtName" class="form-control">
            </div>
            <div class="col px-1">
              <label for="lastName">Last name</label>
              <input type="text" id="lastName" class="form-control">
            </div>
            <div class="col px-1">
              <label for="phone">Phone</label>
              <input type="number" id="phone" class="form-control">
            </div>
            <div class="col px-1">
              <label for="date">Date</label>
              <input type="date" id="date" class="form-control inputCalendar">
            </div>
            <div class="col px-1">
              <label for="guestID">Guest ID</label>
              <p class="text-center">---</p>
            </div>
            <div class="col px-1">
              <label for="shareCharge">Share Charge</label>
              <div class="custom-control custom-checkbox text-center">
                <input type="checkbox" checked="" id="shareSharge" class="custom-control-input">
                <label for="shareSharge" class="custom-control-label"></label>
              </div>
            </div>
            <div class="col px-1">
              <label for="title">Type</label>
              <select id="typeHuman" class="custom-select">
                <option value="">Adult</option>
              </select>
            </div>
            <div class="col px-1">
              <label for="save">&nbsp;</label>
              <button id="save" class="btn btn-primary w-100" data-action="set"><i class="fas fa-save"></i>
                Save</button>
            </div>
          </div>
          <table id="tableManageSharers" class="table text-center">
            <thead>
              <tr>
                <th>#</th>
                <th>Sharer name</th>
                <th>Phone</th>
                <th>Date</th>
                <th>Guest ID</th>
                <th>Share Charge</th>
                <th>Type</th>
              </tr>
            </thead>
            <tbody>
              <!--<tr>
                  <td>1.</td>
                  <td>Anastacia Grey</td>
                  <td>809-333-0000</td>
                  <td>2020/07/10</td>
                  <td>P25</td>
                  <td>
                    <div class="custom-control custom-checkbox text-center">
                      <input type="checkbox" id="p25" checked="checked" class="custom-control-input">
                      <label for="p25" class="custom-control-label"></label>
                    </div>
                  </td>
                  <td>
                    <select id="" class="custom-select">
                      <option value="">Adult</option>
                    </select>
                  </td>
                </tr>-->
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button class="btn btn-danger" data-dismiss="modal" aria-label="Close">
            <i class="fas fa-times"></i> Cancel</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal MessagesAndTasks -->
  <div class="modal fade" id="MessagesAndTasks" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h6 class="modal-title">Message/Tasks</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body bg-f2">
          <ul class="nav nav-tabs" id="tabMessageTasks" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="message-tab" data-toggle="tab" href="#tabMessage" role="tab"
                aria-controls="tabMessage" aria-selected="true"><i class="fas fa-envelope"></i> Message</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="tasks-tab" data-toggle="tab" href="#tabTasks" role="tab" aria-controls="tabTasks"
                aria-selected="false"><i class="fas fa-tasks"></i> Tasks</a>
            </li>
          </ul>
          <!-- Tab panes -->
          <div id="tab-content" class="tab-content bg-white p-3">
            <div class="tab-pane active" id="tabMessage" role="tabpanel" aria-labelledby="message-tab">
              <div class="row mt-3">
                <label for="info">For</label>
                <select id="messageFor" class="custom-select">
                  <option value="">Room</option>
                </select>
              </div>
              <div class="row">
                <label for="contentMessage">Message</label>
                <textarea id="contentMessage" class="form-control"></textarea>
              </div>
              <div class="row mt-3">
                <div class="text-right ml-auto">
                  <button id="addMessage" class="btn btn-success mx-1" data-action="set"><i
                      class="fas fa-plus-circle"></i> Add</button>
                  <button id="cancelMessage" class="btn btn-danger mx-1"><i class="fas fa-times"></i> Cancel</button>
                </div>
              </div>
              <hr>
              <table id="tableMessage" class="table text-center">
                <thead class="table-dark">
                  <tr>
                    <th>Messages</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <!--<tr>
                      <td>
                        <span>For Room</span><br>
                        <span>Limpia</span><br>
                        <span>Aug,07 2020 at 12:04 PM</span>
                      </td>
                      <td>
                        <select id="" class="custom-select">
                          <option value="">Delivered</option>
                          <option value="">Pending</option>
                        </select>
                      </td>
                      <td>
                        <button class="btn btn-outline-primary btn-sm ml-1"><i class="fas fa-pencil-alt"></i></button>
                        <button class="btn btn-outline-danger btn-sm ml-1 removeItem"><i
                            class="fas fa-trash-alt"></i></button>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <span>For Room</span><br>
                        <span>Limpia</span><br>
                        <span>Aug,07 2020 at 12:04 PM</span>
                      </td>
                      <td>
                        <select id="" class="custom-select">
                          <option value="">Delivered</option>
                          <option value="">Pending</option>
                        </select>
                      </td>
                      <td>
                        <button class="btn btn-outline-primary btn-sm ml-1"><i class="fas fa-pencil-alt"></i></button>
                        <button class="btn btn-outline-danger btn-sm ml-1 removeItem"><i
                            class="fas fa-trash-alt"></i></button>
                      </td>
                    </tr>-->
                </tbody>
              </table>

            </div>
            <!-- TASKS -->
            <div class="tab-pane" id="tabTasks" role="tabpanel" aria-labelledby="tasks-tab">
              <div class="row mt-3">
                <label for="info">For</label>
                <select id="taskFor" class="custom-select">
                  <option value="">Room</option>
                </select>
              </div>
              <div class="row mt-2">
                <label for="contentTaskMessage">Tasks</label>
                <textarea id="" class="form-control"></textarea>
              </div>
              <div class="row mt-2">
                <div class="col-sm-6 px-0">
                  <input type="date" id="taskDate" class="form-control inputCalendar">
                </div>
                <div class="col-sm-6 d-flex">
                  <input type="time" id="taskTime" class="form-control">
                </div>
              </div>
              <div class="row mt-3">
                <div class="text-right ml-auto">
                  <button class="btn btn-success mx-1" id="addTask" data-action="set"><i class="fas fa-plus-circle"></i>
                    Add</button>
                  <button class="btn btn-danger mx-1" id="cancelTask"><i class="fas fa-times"></i> Cancel</button>
                </div>
              </div>
              <hr>
              <div class="table-responsive">
                <table id="tableTask" class="table text-center">
                  <thead>
                    <tr>
                      <th>Task/Alert</th>
                      <th>Due Date</th>
                      <th>Alert</th>
                      <th>Job</th>
                      <th>Assignee</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <!--<tr>
                        <td>
                          For: BAR
                          Licors
                          Aug 07, 2020 at 1:28:11 PM
                        </td>
                        <td>
                          Aug 07, 2020 at 1:30:00 PM
                        </td>
                        <td></td>
                        <td>NA</td>
                        <td>NA</td>
                        <td>
                          <select id="" class="custom-select p-0" style="height: 30px;">
                            <option value=""></option>
                          </select>
                        </td>
                        <td>
                          <button class="btn btn-outline-primary btn-sm ml-1"><i class="fas fa-pencil-alt"></i></button>
                          <button class="btn btn-outline-danger btn-sm ml-1 removeItem"><i
                              class="fas fa-trash-alt"></i></button>
                        </td>
                      </tr>-->
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div><!-- Fin Modal body -->
      </div>
    </div>
  </div>

  <!-- Modal AddNewNote -->
  <div class="modal fade" id="addNewNote" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h6 class="modal-title">Add Notes</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body bg-f2">
          <div class="form">
            <div class="row">
              <label for="titleNote">Title</label>
              <select id="titleNote" class="custom-select">
                @foreach ($salutations as $item)
                <option value="{{$item->id}}">{{$item->name}}</option>
                @endforeach
              </select>
            </div>
            <div class="row mt-1">
              <label for="descriptionNote">Description</label>
              <textarea id="descriptionNote" class="form-control"></textarea>
            </div>
            <div class="row mt-2">
              <div class="ml-auto">
                <button class="btn btn-primary" data-action="set"><i class="fas fa-save"></i> Save</button>
                <button class="btn btn-primary btn-md" data-dismiss="modal" aria-label="Close"><i
                    class="fas fa-times"></i>Close</button>
              </div>
            </div>
          </div>
        </div><!-- Fin Modal body -->
      </div>
    </div>
  </div>

  <!-- Modal ExtraBed -->
  <div class="modal fade" id="modalExtraBed" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h6 class="modal-title">Extra Beds</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body bg-f2">
          <div class="form">
            <div class="row">
              <div class="col">
                <label for="from">from</label>
                <input id="from" type="date" class="form-control inputCalendar">
              </div>
              <div class="col">
                <label for="to">To</label>
                <input id="to" type="date" class="form-control inputCalendar">
              </div>
              <div class="col">
                <label for="beds">Beds</label>
                <select id="beds" class="custom-select">
                  <option value="">1</option>
                </select>
              </div>
            </div>
            <div class="row my-2">
              <div class="px-3 ml-auto">
                <button class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
                <button class="btn btn-primary btn-md" data-dismiss="modal" aria-label="Close"><i
                    class="fas fa-times"></i>Close</button>
              </div>
            </div>
          </div>
          <table id="tableExtraBed" class="table text-center">
            <thead>
              <tr>
                <th>#</th>
                <th>Date Range</th>
                <th>Beds</th>
                <th>Days</th>
                <th>Rate</th>
                <th>Total</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <!--<tr>
                  <td>1</td>
                  <td>Aug 06, 2020 - Aug 08, 2020</td>
                  <td>1</td>
                  <td>2</td>
                  <td>$50.00</td>
                  <td>$100.00</td>
                  <td><button class="btn btn-outline-danger btn-sm removeItem" data-message="bed"><i class="fas fa-trash"></i></button>
                  </td>
                </tr>-->
            </tbody>
          </table>
        </div><!-- Fin Modal body -->
      </div>
    </div>
  </div>

  <!-- Modal Room Taxes -->
  <div class="modal fade" id="modalRoomTaxes" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h6 class="modal-title">Room Tax(es)</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-8">
              <table id="tableTaxes" class="table">
                <thead>
                  <tr>
                    <th>Tax name</th>
                    <th></th>
                    <th>Exempt</th>
                  </tr>
                </thead>
                <tbody>
                  <tr id="1">
                    <th id="taxName">VAT</th>
                    <td id="taxDiscount">10.00%</td>
                    <td id="actionTax">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" id="taxVat" data-id="1" class="custom-control-input" value="off">
                        <label for="taxVat" class="custom-control-label"></label>
                      </div>
                    </td>
                  </tr>
                  <tr id="2">
                    <th id="taxName">Service charge</th>
                    <td id="taxDiscount">5.00%</td>
                    <td id="actionTax">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" id="serviceCharge" data-id="2" class="custom-control-input" value="off">
                        <label for="serviceCharge" class="custom-control-label"></label>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="col-md-4">
              <div class="row">
                <label for="">Reason</label>
                <select id="reason" class="custom-select">
                  <option selected disabled>-- Select Reason --</option>
                </select>
              </div>
              <div class="row mt-2">
                <label for="descriptionReason">Description</label>
                <textarea id="descriptionReason" class="form-control"></textarea>
              </div>
            </div>
          </div>
        </div><!-- Fin Modal body -->
        <div class="modal-footer">
          <button id="saveIDS" class="btn btn-primary" data-action="set">
            <i class="fas fa-save"></i> Save
          </button>
          <button class="btn btn-danger" data-dismiss="modal" aria-label="Close">
            <i class="fas fa-times"></i> Close
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Other Room Taxes -->
  <div class="modal fade" id="modalOtherRoomTaxes" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h6 class="modal-title">Other Tax(es)</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-8">
              <table class="table">
                <thead>
                  <tr>
                    <th>Tax name</th>
                    <th></th>
                    <th>Exempt</th>
                  </tr>
                </thead>
                <tbody>
                  <!--<tr>
                    <th>VAT</th>
                    <td>10.00%</td>
                    <td>
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" id="taxVat" class="custom-control-input" value="off">
                        <label for="taxVat" class="custom-control-label"></label>
                      </div>
                    </td>
                  </tr>-->
                </tbody>
              </table>
            </div>
            <div class="col-md-4">
              <div class="row">
                <label for="">Reason</label>
                <select id="reason" class="custom-select">
                  <option selected disabled>-- Select Reason --</option>
                </select>
              </div>
              <div class="row mt-2">
                <label for="descriptionReason">Description</label>
                <textarea id="descriptionReason" class="form-control"></textarea>
              </div>
            </div>
          </div>
        </div><!-- Fin Modal body -->
        <div class="modal-footer">
          <button id="saveIDS" class="btn btn-primary" data-action="set">
            <i class="fas fa-save"></i> Save
          </button>
          <button class="btn btn-danger" data-dismiss="modal" aria-label="Close">
            <i class="fas fa-times"></i> Close
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal add-ons Charges -->
  <div class="modal fade" id="modalAddOnsCharges" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h6 class="modal-title">Add-ons Charges</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <table id="tableAddOns" class="table">
                <thead>
                  <tr>
                    <th>Date(s)</th>
                    <th>Add-ons</th>
                    <th>Allocation Qty</th>
                    <th>Amount</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Aug 30, 2020 - Sep 05, 2020 </td>
                    <td>Lunch Everyday but Check-out Per Person.</td>
                    <td>12</td>
                    <td>$ 600.00</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div><!-- Fin Modal body -->
        <div class="modal-footer">
          <div class="col-md-4">
            <p>
              <span><b>Total: </b></span>
              <span id="total" class="float-right">$ 0.00</span>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Total -->
  <div class="modal fade" id="modalTotal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h6 class="modal-title">Room details</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12 p-0">
              <table id="tableTotal" class="table table-striped">
                <thead class="thead-dark">
                  <tr>
                    <th>Date(s)</th>
                    <th>Description</th>
                    <th>References</th>
                    <th>Amount</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td> Aug 19 - Aug 23</td>
                    <td>Seasonal rate</td>
                    <td></td>
                    <td>$ 510.00</td>
                  </tr>
                  <tr>
                    <td> Aug 19 - Aug 23</td>
                    <td>Seasonal rate</td>
                    <td></td>
                    <td>$ 510.00</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-5 ml-auto p-0">
              <table class="table-striped w-100">
                <tbody class="text-right">
                  <tr>
                    <td><b>Total without Tax</b></td>
                    <td id="TotalWithoutTax"><b>$ 410.00</b></td>
                  </tr>
                  <tr>
                    <td>Tax</td>
                    <td id="tax">$ 0.00</td>
                  </tr>
                  <tr>
                    <td>Discount</td>
                    <td id="discount">$ 70.00</td>
                  </tr>
                  <tr>
                    <td>Total With tax (USD)</td>
                    <td id="TotalWithTax">$ 410.00</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div><!-- Fin Modal body -->
      </div>
    </div>
  </div>

  <!-- Modal Discount details -->
  <div class="modal fade" id="modalDiscountDetails" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h6 class="modal-title">Discount details</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <table id="tableDiscount" class="table">
                <thead>
                  <tr>
                    <th>Date(s)</th>
                    <th>Description</th>
                    <th>Discount Qty</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Aug 30 - Sep 05, 2020</td>
                    <td>Seasonal Rate</td>
                    <td>$ 4.35</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div><!-- Fin Modal body -->
        <div class="modal-footer">
          <div class="col-md-4">
            <p>
              <span><b>Total Discount: </b></span>
              <span id="totalDiscount" class="float-right">$ 0.00</span>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Other Discount -->
  <div class="modal fade" id="modalOtherDiscount" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h6 class="modal-title">Other discount</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <table id="tableOtherDiscount" class="table">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Discount</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Aug 30 - Sep 05, 2020</td>
                    <td>Seasonal Rate</td>
                    <td>$ 4.35</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div><!-- Fin Modal body -->
        <div class="modal-footer">
          <div class="col-md-4">
            <p>
              <span><b>Total Discount: </b></span>
              <span id="totalDiscount" class="float-right">$ 0.00</span>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Add Credit Card -->
  <div class="modal fade" id="ModalAddCreditCard" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h6 class="modal-title">Add credit card</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <label>Sharer</label>
              <select id="sharer" class="custom-select">
                <option value=""></option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="nameSharer">Name on card</label>
              <input type="text" id="nameSharer" class="form-control">
            </div>
          </div>
          <div class="row mt-1">
            <div class="col-md-6">
              <div class="row mt-1">
                <div class="col-md-8 p-1">
                  <label>Credit card No</label>
                  <input type="number" id="cardNo" class="form-control">
                </div>
                <div class="col-md-4 p-1">
                  <label>Card type</label>
                  <select id="cardType" class="custom-select">
                    <option></option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="row mt-1">
                <label for="expire" class="d-block w-100">Expire</label>
                <div class="col"><input type="text" id="mm" class="form-control" placeholder="MM"></div><b
                  style="align-self: center;">/</b>
                <div class="col"><input type="text" id="yyyy" class="form-control" placeholder="YYYY"></div><b
                  style="align-self: center;">/</b>
                <div class="col"><input type="text" id="cvc" class="form-control" placeholder="CVC"></div><b
                  style="align-self: center;"></b>
              </div>
            </div>
          </div>
          <div class="row mt-1">
            <div class="col-md-9">
              <label for="billingAddress">Billing Address</label>
              <input type="text" id="billingAddress" class="form-control">
            </div>
            <div class="col-md-3">
              <label for="state">State</label>
              <input type="text" id="state" class="form-control">
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <label for="country">Country</label>
              <select id="country" class="custom-select"></select>
            </div>
            <div class="col-md-4">
              <label for="city">City</label>
              <input type="text" id="city" class="form-control">
            </div>
            <div class="col-md-4">
              <label for="zipCode">Zip Code</label>
              <input type="text" id="zipCode" class="form-control">
            </div>
          </div>
          <div class="row my-4">
            <div class="px-3 ml-auto">
              <button class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
              <button class="btn btn-danger  btn-md" type="reset" data-dismiss="modal" aria-label="Close"><i
                  class="fas fa-times"></i> Close</button>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-12">
              <table id="tableCard" class="table text-center">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Card Number</th>
                    <th>Type</th>
                    <th>Expiry</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Anastacia</td>
                    <td>XXXXXXXXXXXX3333</td>
                    <td>VISA</td>
                    <td>06/2024</td>
                    <td><button class="btn btn-outline-danger btn-sm removeItem" data-message="card information"><i
                          class="fas fa-trash"></i></button>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div><!-- Fin Modal body -->
      </div>
    </div>
  </div>

  <!-- Modal Special Discount -->
  <div class="modal fade" id="modalSpecialDiscount" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h6 class="modal-title">Apply special discount</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col">
              <label for="discount">Discount</label>
              <select id="discount" class="custom-select"></select>
            </div>
            <div class="col">
              <label for="typeIdentification">Requirement</label>
              <select id="typeIdentification" class="custom-select"></select>
            </div>
            <div class="col">
              <label for="numberRequirement">Number requirement</label>
              <input type="text" id="numberRequirement" class="form-control">
            </div>
          </div>
        </div><!-- Fin Modal body -->
        <div class="modal-footer">
          <button id="saveIDS" class="btn btn-primary" data-action="set"><i class="fas fa-save"></i> Done</button>
          <button class="btn btn-danger" data-dismiss="modal" aria-label="Close">
            <i class="fas fa-times"></i> Cancel</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Promo code -->
  <div class="modal fade" id="modalPromoCode" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h6 class="modal-title">Apply Promo code</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <label for="promoCode">Promo Code</label>
            <input type="text" id="promoCode" class="form-control">
          </div>
        </div><!-- Fin Modal body -->
        <div class="modal-footer">
          <button id="saveIDS" class="btn btn-primary" data-action="set"><i class="fas fa-save"></i> Done</button>
          <button class="btn btn-danger" data-dismiss="modal" aria-label="Close">
            <i class="fas fa-times"></i> Cancel</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Add  split Reservation -->
  <div class="modal fade" id="modalAddSplitReservation" tabindex="-1" role="dialog" aria-labelledby=""
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h6 class="modal-title">Add Split Reservation</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col">
              <label for="from">From</label>
              <input type="date" id="from" class="form-control inputCalendar">
            </div>
            <div class="col">
              <label for="to">To</label>
              <input type="date" id="to" class="form-control inputCalendar">
            </div>
          </div>
          <div class="row mt-1">
            <div class="col">
              <label for="roomType">Room Type</label>
              <select id="roomType" data-action="rooms" class="custom-select">
                <option value="1">Deluxe</option>
                <option value="2">Standar</option>
              </select>
            </div>
            <div class="col">
              <label for="rooms">Select Room</label>
              <select id="rooms" class="custom-select"></select>
            </div>
          </div>
          <hr>
          <div class="container">
            <p id="currentRooms" class="text-center"><b>Current Rooms: </b><span class="text-info">Standard
                Room(STD-103,STD-103)</span></p>
          </div>
        </div><!-- Fin Modal body -->
        <div class="modal-footer">
          <button id="saveIDS" class="btn btn-primary" data-action="set"><i class="fas fa-save"></i> Split</button>
          <button class="btn btn-danger" data-dismiss="modal" aria-label="Close">
            <i class="fas fa-times"></i> Cancel</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Extend Split Reservation -->
  <div class="modal fade" id="modalExtendSplitReservation" tabindex="-1" role="dialog" aria-labelledby=""
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h6 class="modal-title">Extend Split Reservation</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col">
              <label for="from">From</label>
              <input type="date" id="From" class="form-control inputCalendar">
            </div>
            <div class="col">
              <label for="to">To</label>
              <input type="date" id="to" class="form-control inputCalendar">
            </div>
          </div>
          <div class="row mt-1">
            <div class="col">
              <label for="roomType">Room Type</label>
              <select id="roomType" data-action="rooms" class="custom-select">
                <option value="1">Deluxe</option>
                <option value="2">Standar</option>
              </select>
            </div>
            <div class="col">
              <label for="rooms">Select Room</label>
              <select id="rooms" class="custom-select"></select>
            </div>
          </div>
          <hr>
          <div class="container">
            <p id="currentRooms" class="text-center"><b>Current Rooms: </b><span class="text-info">Standard
                Room(STD-103,STD-103)</span></p>
          </div>
        </div><!-- Fin Modal body -->
        <div class="modal-footer">
          <button id="saveIDS" class="btn btn-primary" data-action="set"><i class="fas fa-save"></i> Split</button>
          <button class="btn btn-danger" data-dismiss="modal" aria-label="Close">
            <i class="fas fa-times"></i> Cancel</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal InclusionsAddons -->
  <div class="modal fade" id="modalInclusionsAddons" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h6 class="modal-title">Select Add-ons</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div id="list-checkbox" class="list-checkbox">

                <div class="custom-control custom-checkbox item-checkbox">
                  <input type="checkbox" class="custom-control-input" id="item1" data-id="1" value="off">
                  <label for="item1" class="custom-control-label">
                    Airport Drop - ($30.00) <br>
                    <span class="subtext">Charge One</span>
                  </label>
                </div>

                <div class="custom-control custom-checkbox item-checkbox">
                  <input type="checkbox" class="custom-control-input" id="item2" data-id="2" value="off">
                  <label for="item2" class="custom-control-label">
                    Breakfast - ($ 50.00) <br>
                    <span class="subtext">Per Person Everyday but Check-in</span>
                  </label>
                </div>

              </div>
            </div>

          </div>
        </div><!-- Fin Modal body -->
        <div class="modal-footer">
          <button id="saveIDS" class="btn btn-primary" data-action="set"><i class="fas fa-save"></i> Split</button>
          <button class="btn btn-danger" data-dismiss="modal" aria-label="Close">
            <i class="fas fa-times"></i> Cancel</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Converter Currency -->
  <div class="modal fade" id="modalConverterCurrency" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h6 class="modal-title">Currency Converter</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <label for="amount">Amount</label>
              <input type="text" id="amount" class="form-control" value="879.77">
            </div>
            <div class="col-md-6">
              <label for="currency">Currency</label>
              <select id="currency" class="custom-select">
                <option value="USD">USD</option>
                <option value="DOP">DOP</option>
              </select>
            </div>
          </div>
          <div class="row mt-1">
            <div class="col-md-12">
              <label for="convertTo">Convert To</label>
              <select id="convertTo" class="custom-select">
                <option value="USD">USD</option>
                <option value="DOP">DOP</option>
              </select>
            </div>
          </div>
          <div class="row mt-2 px-3">
            <div class="col-md-12 p-2 bg-lightblue">
              <h4 id="convertedCurrency" class="m-0  font-weight-bold text-success">$0.00</h4>
            </div>
          </div>
          <div class="row mt-1">
            <div class="col-md-12">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" id="convertApplyToPaid" class="custom-control-input" value="off">
                <label for="convertApplyToPaid" class="custom-control-label">Convert and apply to payment</label>
              </div>
            </div>
          </div>
          <div class="row mt-1">
            <button id="btnConverterCurrency" class="btn btn-primary w-100">Converter</button>
          </div>
        </div><!-- Fin Modal body -->
      </div>
    </div>
  </div>

  <!-- Modal Other Charges-->
  <div class="modal fade" id="modalOtherCharges" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h6 class="modal-title">Other Charges</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-2">
              <label for="chargeTo">Charge To</label>
              <select id="chargeTo" class="custom-select"></select>
            </div>
            <div class="col-md-2">
              <label for="posPoint">POS Point</label>
              <select id="chargeTo" class="custom-select"></select>
            </div>
            <div class="col-md-2">
              <label for="product">Product</label>
              <select id="chargeTo" class="custom-select"></select>
            </div>
            <div class="col-md-2">
              <label class="float-left pl-2">Price</label>
              <label class="float-right pr-2">QTY</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <span>$10.00</span>
                  </div>
                </div>
                <input type="text" class="form-control" placeholder="QTY">
              </div>
            </div>
            <div class="col-md-2">
              <label for="">Dis</label>
              <div class="input-group">
                <input type="text" class="form-control">
                <div class="input-group-prepend">
                  <div class="input-group">
                    <select id="dis" class="custom-select">
                      <option value="$">$</option>
                      <option value="%">%</option>
                    </select>
                  </div>
                </div>
              </div>
              <!--
              <div class="input-group">
                <label for="">Dis</label>
                <div class="input-group-prepend">
                  <input type="text" class="form-control">
                  <div class="input-group-text">
                    <select id="porcentOrMoney" class="custom-select"></select>
                  </div>
                </div>
              </div>-->
            </div>
            <div class="col-md-2">
              <label for="amount">Amount</label>
              <h3 class="text-success"><b>$ 0.00</b></h3>
            </div>
          </div>
        </div><!-- Fin Modal body -->
        <div class="modal-footer">
          <button class="btn btn-primary ml-auto"><i class="fas fa-save"></i> Save</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Other Charges-->
  <div class="modal fade" id="modalOtherCharges" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h6 class="modal-title">Select Group Owner</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <label for="ownerType">Owner Type</label>
              <select id="ownerType" class="custom-select"></select>
            </div>
            <div class="col-md-6">
              <label for="companyName">Company Name</label>
              <input type="text" id="companyName" class="form-control">
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-md-2">
              <label for="title">Title</label>
              <select id="title" class="custom-select"></select>
            </div>
            <div class="col-md-3">
              <label for="firstName">First Name</label>
              <input type="text" id="firstName" class="form-control">
            </div>
            <div class="col-md-3">
              <label for="lastName">Last Name</label>
              <input type="text" id="lastName" class="form-control">
            </div>
            <div class="col-md-4">
              <label for="number">Phone</label>
              <div class="input-group">
                <input type="number" id="number" class="form-control">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <input type="radio" name="cel" value="cel">&nbsp;
                    <i class="fas fa-mobile-alt"></i>
                  </div>
                </div>
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <input type="radio" name="cel" value="phone">&nbsp;
                    <i class="fas fa-phone"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div><!-- Fin Modal body -->
        <div class="modal-footer">
          <button class="btn btn-primary ml-auto"><i class="fas fa-save"></i> Add To New Group</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Other Charges-->
  <div class="modal fade" id="modalUpdateRoom" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h6 class="modal-title">Update Room</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <label for="from">From</label>
              <input type="date" id="from" class="form-control inputCalendar">
            </div>
            <div class="col-md-6">
              <label for="to">To</label>
              <input type="date" id="to" class="form-control inputCalendar">
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <label for="roomtype">Room Type</label>
              <select id="roomType" class="custom-select"></select>
            </div>
            <div class="col-md-6">
              <label for="rooms">Room Number</label>
              <select id="rooms" class="custom-select"></select>
            </div>
          </div>
          <div class="row mt-2 p-3 bg-lightblue text-success">
            <span style="font-size: 20px;">Price:$ <b>100</b> | <b>($ 100)</b></span>
          </div>
        </div><!-- Fin Modal body -->
        <div class="modal-footer">
          <button id="btnUpdateRoom" class="btn btn-primary ml-auto"><i class="fas fa-save"></i> Update</button>
        </div>
      </div>
    </div>
  </div>

  <!-- ERROR MESSAGE -->
  <div class="toast fixed-bottom mb-4 w-50 ml-2 hide" style="max-width: 480px;" data-autohide="false">
    <div class="toast-header">
      <strong class="mr-auto text-primary">Toast Header</strong>
      <small class="text-muted">5 mins ago</small>
      <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
    </div>
    <div class="toast-body">
      Some text inside the toast body
    </div>
  </div>

</div>
@endsection


