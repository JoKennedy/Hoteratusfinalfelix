{{-- extend Layout --}}
@extends('layouts.calendarLayou')

{{-- page title --}}
@section('title','Restaurant')

{{-- page styles --}}

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
    integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/CalendarJnS/css/bootstrap.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/CalendarJnS/css/app-calendar.css')}}">
<style>
    body {
        background: #E1E5ED;
    }
</style>

{{-- page content --}}
@section('content')
<div class="row calendar restaurant" id="restaurant">
    <div id="subMenu" class="col-md-3 px-0 bg-white border-dashed-right">
        <div class="row products">
            <table id="table-products" class="table table-sm text-center table-striped table-bordered-0">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>Product</th>
                        <th>Id</th>
                        <th>Price</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot class="bg-success text-white">
                    <tr>
                        <th colspan="2">Total Amount</th>
                        <th colspan="2" id="totalPrice">$<span>0.00</span></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <hr>
        <div id="navbar-list-group" class="list-group bg-white" role="tablist">
            <a class="list-group-item list-group-item-action" role="tab" id="list-products-list" data-toggle="list"
                href="#list-products" role="tab" aria-controls="products">Products</a>
            <a class="list-group-item list-group-item-action" role="tab" id="list-transaction-list" data-toggle="list"
                href="#list-transaction" role="tab" aria-controls="transaction">Transaction List</a>
            <a class="list-group-item list-group-item-action" role="tab" id="list-refund-list" data-toggle="list"
                href="#list-refund" role="tab" aria-controls="refund">Refund List</a>
            <a class="list-group-item list-group-item-action" role="tab" id="list-allocationQuantity-list"
                data-toggle="list" href="#list-allocationQuantity" role="tab"
                aria-controls="allocationQuantity">Allocation Quantity</a>
            <a class="list-group-item list-group-item-action" role="tab" id="list-orders-list" data-toggle="list"
                href="#list-orders" role="tab" aria-controls="orders">Order List</a>
            <a class="list-group-item list-group-item-action" role="tab" id="list-fPendingBalance-list"
                data-toggle="list" href="#list-fPendingBalance" role="tab" aria-controls="fPendingBalance">Folios
                Pending Balance</a>
            <a class="list-group-item list-group-item-action" role="tab" id="list-aStatement-list" data-toggle="list"
                href="#list-aStatement" role="tab" aria-controls="aStatement">Account Statement</a>
        </div>
        <div id="folioForRefund" class="row py-3">
            <div class="col-md-12">
                <label for="fieldFolioRefund">Folio For Refund</label>
                <div class="input-group">
                    <input type="text" id="fieldFolioRefund" class="form-control">
                    <div class="input-group-prepend">
                        <button id="btnSearch" class="btn btn-primary rounded-right"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div id="invoiceOnHold" class="row">
            <span></span>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-sm">
                    <thead class="text-white bg-primary">
                        <tr>
                            <th>Order #</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr data-id="001">
                            <td>#001</td>
                            <td>$ 60.20</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-9 p-0">
        <ul id="myTabRestaurant" class="nav nav-tabs border-0 pl-3" role="tablist">
            <li class="nav-item">
                <a href="#pointRestaurant" id="pointRestaurant-tab" data-id="pointRestaurant" class="nav-link active"
                    data-toggle="tab" role="tab" aria-controls="pointRestaurant" aria-selected="true">Restaurant</a>
            </li>
            <!--<li class="nav-item" data-remove="orderNo1">
                <a href="#orderNo1" data-id="orderNo1" class="nav-link active" data-toggle="tab" role="tab"
                    aria-controls="orderNo1" aria-selected="true">Order #01
                    <button type="button" data-id="orderNo1" id="tabClose" class="close ml-1" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </a>
            </li>
            <li class="nav-item" data-remove="folioNo1">
                <a href="#folioNo1" data-id="folioNo1" id="folioNo1-tab" class="nav-link"
                    data-toggle="tab" role="tab" aria-controls="folioNo1" aria-selected="true">Folio #1
                    <button type="button" data-id="folioNo1" id="tabClose" class="close ml-1"
                        aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </a>
            </li>-->
        </ul>
        <div class="main  bg-white">
            <div id="tab-content-restaurant" class="tab-content active">
                <div id="pointRestaurant" class="tab-pane active" role="tabpanel" aria-labelledby="pointRestaurant-tab">
                    <p class="bg-primary text-white p-2">Featured Products</p>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="card w-100 shadow">
                                <div class="card-body products p-0">
                                    <div class="row">
                                        <div class="col-md-3 p-0">
                                            <div class="list-group category-product" id="list-tab" role="tablist">
                                                <h5 class="text-center title bg-primary text-white p-1 text-uppercase font-weight-500 mb-0 border-right border-bottom">Categories</h5>
                                                @foreach ($productCategory as $item)
                                                <a class="list-group-item list-group-item-action" id="products-category"
                                                    data-id="{{$item->id}}" data-toggle="list"
                                                    href="#list-products">{{$item->name}}</a>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-md-9 p-0">
                                            <div class="tab-content" id="nav-tabContent">
                                                <h5
                                                    class="text-center title bg-primary text-white p-1 text-uppercase font-weight-500">
                                                    Products
                                                </h5>
                                                <div class="tab-pane fade show" id="list-products" role="tabpanel"
                                                    aria-labelledby="list-products-list">
                                                    <div class="row mt-3 list-products">
                                                        <!---->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-center">
                                    <button id="generateOrder" class="btn btn-primary btn-lg col-sm-4 ml-auto">
                                        <i class="fas fa-sync-alt"></i> Generate Order
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="table-responsive">
                                <h4 class="text-center">Transaction List</h4>
                                <table id="tableFolios" class="table table-striped table-hover text-center">
                                    <thead>
                                        <tr>
                                            <th>Payment Type</th>
                                            <th>Amount Paid</th>
                                            <th>Balance</th>
                                            <th>Credit Card#/Cheque#</th>
                                            <th>Folio#</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr data-folioNumber="1">
                                            <td>Transfer To Group</td>
                                            <td>$ 77.04</td>
                                            <td>Sheldon Cooper(P16)</td>
                                            <td>--</td>
                                            <td>2</td>
                                            <td>Wed, Sep 23, 2020</td>
                                            <td>22:34:23</td>
                                        </tr>
                                        <tr data-folioNumber="2">
                                            <td>Transfer To Group</td>
                                            <td>$ 77.04</td>
                                            <td>Alicia Perez(P18)</td>
                                            <td>--</td>
                                            <td>2</td>
                                            <td>Wed, Sep 23, 2020</td>
                                            <td>22:34:23</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!--<div id="orderNo1" class="tab-pane" role="tabpanel" aria-labelledby="orderNo1-tab">
                    <div class="row py-2">
                        <div class="col-md-3">
                            <label for="name">Name</label>
                            <input type="text" id="name" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label for="lastName">Last Name</label>
                            <input type="text" id="lastName" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label for="roomHasReserved">Room #</label>
                            <select id="roomHasReserved" class="custom-select"></select>
                        </div>
                        <div class="col-md-3">
                            <label for="guestName">Guest Name</label>
                            <select id="guestName" class="custom-select"></select>
                        </div>
                    </div>
                    <div class="row p-3">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" id="complementaryOrder1" class="custom-control-input"
                                autocomplete="off">
                            <label for='complementaryOrder1' class="custom-control-label">Complementary</label>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="table-responsive">
                            <table id="tableTotalAmount" class="table">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th>Code/Product Name</th>
                                        <th>Unit Price</th>
                                        <th>Units</th>
                                        <th>Discount</th>
                                        <th>Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-id="1">
                                        <td id="name">Soup tomato</td>
                                        <td id="price" data-price='8.00'>$<span>8.00</span></td>
                                        <td id="quantity"><input type="number" class="form-control" value="3"></td>
                                        <td id="discount" class="cursor-pointer text-primary" data-discount="0.00">
                                            Discount</td>
                                        <td id="totalPrice" class="d-flex text-primary">$ <input type="text"
                                                class="border-0" value="23.28" style="max-width: 60px;"></td>
                                        <td>
                                            <button id="remove-product" class="btn btn-outline-primary">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr id="alertProduct" class="alert alert-danger" style="display: none;">
                                        <td colspan="6">This product exist</td>
                                    </tr>
                                    <tr id="addNewProduct">
                                        <td id="name">
                                            <div class="dropdown w-100 show">
                                                <input class="form-control filter dropdown-toggle" type="text"
                                                    id="dropdownNameProduct" placeholder="Product Name"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"
                                                    autocomplete="off">
                                                <div class="dropdown-menu w-100" aria-labelledby="dropdownNameProduct"
                                                    style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 70px, 0px);"
                                                    x-placement="bottom-start">
                                                    <ul class="list-group list-group-flush cursor-pointer">
                                                        <li class="list-group-item list-group-item-action" data-id="1">
                                                            <span class="w-50" id="nameProduct">Soup Tomato</span>
                                                            <span class="w-25 px-2 text-dark"
                                                                id="codeProduct">200439</span>
                                                            <span class="w-25 text-success" id="priceProduct"
                                                                data-price="15.00">$15.00</span>
                                                        </li>
                                                        <li class="list-group-item list-group-item-action" data-id="2">
                                                            <span class="w-50" id="nameProduct">Avaya System</span>
                                                            <span class="w-25 px-2 text-dark"
                                                                id="codeProduct">200439</span>
                                                            <span class="w-25  text-success" id="priceProduct"
                                                                data-price="30.06">$30.06</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                        <td id="price">$<span>--</span></td>
                                        <td id="units"><input type="number" class="form-control" value="1"
                                                autocomplete="off"></td>
                                        <td id="discount">--</td>
                                        <td id="totalPrice" class="d-flex text-primary">$--</td>
                                        <td><button id="add-product" class="btn btn-outline-primary"><i
                                                    class="fas fa-plus"></i></button></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <button class="btn btn-primary">Add Custom Charge</button>
                            </div>
                            <div class="row my-3">
                                <div class="col-sm-12 col-md-6 p-1">
                                    <button class="btn btn-lg btn-primary w-100 text-uppercase font-weight-bold">Update Order</button>
                                </div>
                                <div class="col-sm-12 col-md-6 p-1">
                                    <button class="btn btn-lg btn-outline-danger w-100 text-uppercase font-weight-bold">Cancel Order</button>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <label for="remark">Remark</label>
                                <textarea id="remark" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <table id="tableBalance" class="table text-right">
                                <tbody>
                                    <tr>
                                        <th>Sub Total</th>
                                        <th id="subTotal">$ <span>0.00</span></th>
                                    </tr>
                                    <tr>
                                        <td>Folio Discount</td>
                                        <td id="fDiscount">$ <span>0.00</span></td>
                                    </tr>
                                    <tr>
                                        <td>Package/Corporate Discount</td>
                                        <td id="packageOrCorporate">$ <span>0.00</span></td>
                                    </tr>
                                    <tr>
                                        <th>Amount</th>
                                        <th id="amount">$ <span>0.00</span></th>
                                    </tr>
                                    <tr>
                                        <td>Tax(es)</td>
                                        <td id="taxes">$ <span>0.00</span></td>
                                    </tr>
                                    <tr class="bg-info text-white">
                                        <th>Total Amount <br>
                                            <i style="font-size: 14px;">Total Paid</i>
                                        </th>
                                        <td id="totalAmount" data-value="0.00" data-currency="DOP">
                                            $ <span>0.00</span><br>
                                            <i id="totalPaid" style="font-size: 14px;">$ 0.00</i>
                                        </td>
                                    </tr>
                                    <tr class="bg-lightblue">
                                        <th>Balance</th>
                                        <th id="balance">$ <span>0.00</span></th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="payment-details">
                        <div id="payment" class="row">
                            <div class="col-sm-2 p-2 text-center bg-lightblue">
                                <h4>Payment</h4>
                            </div>
                            <div class="col-sm-10 p-2">
                                <span class="text-danger">Payment Gateway is no integrated. Credit Card will not be
                                    charged</span>
                            </div>
                        </div>
                        <div class="row p-3 bg-lightblue">
                            <div class="col-md-2 px-1">
                                <label for="modePaid">Mode</label>
                                <select id="modePaid" class="custom-select"></select>
                            </div>
                            <div class="col-md-2 px-1">
                                <label for="type">Type</label>
                                <select id="type" class="custom-select"></select>
                            </div>
                            <div class="col-md-1 px-1">
                                <label for="amount">Amount</label>
                                <input type="text" id="amount" class="form-control">
                            </div>
                            <div class="col-md-2 px-1">
                                <label for="cc-chechequeNo">CC/Cheque No.</label>
                                <input type="text" id="cc-chequeNo" class="form-control">
                            </div>
                            <div class="col-md-2 px-1">
                                <label for="receip">Receip</label>
                                <input type="text" id="receip" class="form-control">
                            </div>
                            <div class="col-md-3 px-1">
                                <label for="description">Description</label>
                                <input type="text" id="description" class="form-control">
                            </div>
                        </div>
                        <div class="row bg-lightblue">
                            <div class="col-md-3 px-1">
                                <button class="btn btn-success w-100">Pay Now</button>
                            </div>
                            <div class="col-md-3 px-1">
                                <button id="currencyConverter" class="btn btn-primary w-100"><i
                                        class="fas fa-dollar-sign"></i> Converter</button>
                            </div>
                            <div class="col-md-3 px-1">
                                <button class="btn btn-outline-dark w-100"><i class="fas fa-exchange-alt"></i> Transfer
                                    to Room</button>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-outline-danger"><i class="fas fa-exchange-alt"></i> Transfer to
                                    City Ledger</button>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-3 px-1">
                            <button class="btn btn-success btn-lg w-100">Start New</button>
                        </div>
                        <div class="col-md-5 px-1">
                            <button class="btn btn-danger btn-lg w-100">Transaction Close</button>
                        </div>
                        <div class="col-md-2 px-1">
                            <button class="btn btn-primary btn-lg w-100">Print</button>
                        </div>
                        <div class="col-md-2 px-1">
                            <button class="btn btn-info btn-lg w-100">Refund</button>
                        </div>
                    </div>
                </div>
                <div id="folioNo1" class="tab-pane" role="tabpanel" aria-labelledby="folioNo1-tab">
                    <div class="col-md-12 pt-3">
                        <h3 class="font-weight-bold text-center text-uppercase text-muted">Folio #1</h3>
                    </div>
                    <div class="row px-3">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" id="complementaryFolio1" class="custom-control-input"
                                autocomplete="off">
                            <label for='complementaryFolio1' class="custom-control-label">Complementary</label>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="table-responsive">
                            <table id="tableTotalAmount" class="table">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th>Code/Product Name</th>
                                        <th>Unit Price</th>
                                        <th>Units</th>
                                        <th>Discount</th>
                                        <th>Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-id="1">
                                        <td id="name">Soup tomato</td>
                                        <td id="price" data-price='8.00'>$<span>8.00</span></td>
                                        <td id="quantity"><input type="number" class="form-control" value="3"></td>
                                        <td id="discount" class="cursor-pointer text-primary" data-discount="0.00">
                                            Discount</td>
                                        <td id="totalPrice" class="d-flex text-primary">$ <input type="text"
                                                class="border-0" value="23.28" style="max-width: 60px;"></td>
                                        <td>
                                            <button id="remove-product" class="btn btn-outline-primary">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            
                        </div>
                        <div class="col-md-6">
                            <table id="tableBalance" class="table text-right">
                                <tbody>
                                    <tr>
                                        <th>Sub Total</th>
                                        <th id="subTotal">$ <span>0.00</span></th>
                                    </tr>
                                    <tr>
                                        <td>Folio Discount</td>
                                        <td id="fDiscount">$ <span>0.00</span></td>
                                    </tr>
                                    <tr>
                                        <td>Package/Corporate Discount</td>
                                        <td id="packageOrCorporate">$ <span>0.00</span></td>
                                    </tr>
                                    <tr>
                                        <th>Amount</th>
                                        <th id="amount">$ <span>0.00</span></th>
                                    </tr>
                                    <tr>
                                        <td>Tax(es)</td>
                                        <td id="taxes">$ <span>0.00</span></td>
                                    </tr>
                                    <tr class="bg-info text-white">
                                        <th>Total Amount <br>
                                            <i style="font-size: 14px;">Total Paid</i>
                                        </th>
                                        <td id="totalAmount" data-value="0.00" data-currency="DOP">
                                            $ <span>0.00</span><br>
                                            <i id="totalPaid" style="font-size: 14px;">$ 0.00</i>
                                        </td>
                                    </tr>
                                    <tr class="bg-lightblue">
                                        <th>Balance</th>
                                        <th id="balance">$ <span>0.00</span></th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="payment-details">
                        <div class="row bg-lightblue">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Payment Mode</th>
                                            <th>Payment Type</th>
                                            <th>Amount</th>
                                            <th>CC/Cheque No</th>
                                            <th>Receipt #</th>
                                            <th>Description</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Cash</td>
                                            <td>Cash</td>
                                            <td>$ 23.68</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>Mon, Oct 12, 2020</td>
                                            <td>12:00:04</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-3 px-1">
                            <button class="btn btn-success btn-lg w-100">Start New</button>
                        </div>
                        <div class="col-md-5 px-1">
                            <button class="btn btn-danger btn-lg w-100">Transaction Close</button>
                        </div>
                        <div class="col-md-2 px-1">
                            <button class="btn btn-primary btn-lg w-100">Print</button>
                        </div>
                        <div class="col-md-2 px-1">
                            <button class="btn btn-info btn-lg w-100">Refund</button>
                        </div>
                    </div>
                </div>-->

            </div>
        </div>
    </div>
    <!-- Modal Converter Currency -->
    <div class="modal fade" id="modalConverterCurrency" tabindex="-1" role="dialog" aria-labelledby=""
        aria-hidden="true">
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
                                <input type="checkbox" id="convertApplyToPaid" class="custom-control-input"
                                    autocomplete="off" value="off">
                                <label for="convertApplyToPaid" class="custom-control-label">Convert and apply to
                                    payment</label>
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
    <!-- Modal Discount -->
    <div class="modal fade" id="modalDiscount" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h6 class="modal-title">Discount</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="input-group">
                            <input type="text" class="form-control" id="discount" placeholder="Value">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-percentage mr-1"></i>
                                    <input type="radio" name="percentOrValue" id="percent">
                                </div>
                            </div>
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-dollar-sign mr-1"></i>
                                    <input type="radio" name="percentOrValue" id="value">&nbsp;
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label for="reason">Reason</label>
                        <textarea id="reason" class="form-control"></textarea>
                    </div>
                </div><!-- Fin Modal body -->
                <div class="modal-footer">
                    <button class="btn btn-primary" id="save"><i class="fas fa-percentage"></i> Apply</button>
                </div>
            </div>
        </div>
    </div>
        <!-- Modal Add Custom Charge -->
        <div class="modal fade" id="modalAddCustomCharge" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h6 class="modal-title">Add Custom Charge</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-3 px-1">
                                <label for="descriptionP">Description</label>
                                <input type="text" id="descriptionP" class="form-control">
                            </div>
                            <div class="col-md-2 px-1">
                                <label for="priceP">Price</label>
                                <input type="number" id="priceP" class="form-control">
                            </div>
                            <div class="col-md-2 px-1">
                                <label for="quantityP">Qty</label>
                                <input type="number" id="quantityP" class="form-control">
                            </div>
                            <div class="col-md-3 px-1">
                                <label for="discountP">Discount</label>
                                <div class="input-group">
                                    <input type="number" id="discountP" class="form-control">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-percentage mr-1"></i>
                                            <input type="radio" id="percent" checked name="typeDiscount">
                                        </div>
                                        <div class="input-group-text">
                                            <i class="fas fa-dollar-sign mr-1"></i>
                                            <input type="radio" id="value" name="typeDiscount">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1 px-1">
                                <label for="taxP">Tax</label>
                                <p>$ <span id="taxP" class="text-muted">0.00</span></p>
                            </div>
                            <div class="col-md-1 px-1">
                                <label for="amount">Amount</label>
                                <p>$ <span id="amountP" class="text-muted">0.00</span></p>
                            </div>
                        </div>
                    </div><!-- Fin Modal body -->
                    <div class="modal-footer">
                        <button class="btn btn-primary" id="save"><i class="fas fa-percentage"></i> Save</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalAlert" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-body m-0 alert" role="alert">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="top: -10px;position: inherit;left: 5px;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="alert-heading"></h4>
                        <p></p>
                    </div><!-- Fin Modal body -->
                </div>
            </div>
        </div>
</div>
@endsection
