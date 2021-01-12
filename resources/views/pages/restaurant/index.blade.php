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
<div class="row calendar housekeeping" id="restaurant">
    <div class="col-md-3 px-0 bg-white border-dashed-right">
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
                <tbody>
                </tbody>
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
    </div>
    <div class="col-md-9 p-0">
        <ul class="nav nav-tabs border-0 pl-3" role="tablist">
            <li class="nav-item">
                <a href="#pointRestaurant" id="pointRestaurant-tab" class="nav-link" data-toggle="tab" role="tab"
                    aria-controls="pointRestaurant" aria-selected="true">Restaurant</a>
            </li>
            <li class="nav-item" data-remove="p21">
                <a href="#newOrder1" class="nav-link active" data-toggle="tab" role="tab" aria-controls="newOrder1"
                    aria-selected="true">Products
                    <button type="button" data-id="p21" id="tabClose" class="close ml-1" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </a>
            </li>
        </ul>
        <div class="main  bg-white">
            <div id="tab-content" class="tab-content">
                <div id="pointRestaurant" class="tab-pane" role="tabpanel" aria-labelledby="pointRestaurant-tab">
                    <p class="bg-primary text-white p-2">Featured Products</p>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="card w-100 shadow">
                                <div class="card-body products p-0">
                                    <div class="row">
                                        <div class="col-3 p-0">
                                            <div class="list-group category-product" id="list-tab" role="tablist">
                                                <a class="list-group-item list-group-item-action" id="products-category"
                                                    data-id="1" data-toggle="list" href="#list-products">Breakfast</a>
                                                <a class="list-group-item list-group-item-action" id="products-category"
                                                    data-id="2" data-toggle="list" href="#list-products">Salads</a>
                                                <a class="list-group-item list-group-item-action" id="products-category"
                                                    data-id="3" data-toggle="list" href="#list-products">Soup</a>
                                                <a class="list-group-item list-group-item-action" id="products-category"
                                                    data-id="4" data-toggle="list" href="#list-products">Starters</a>
                                                <a class="list-group-item list-group-item-action" id="products-category"
                                                    data-id="5" data-toggle="list" href="#list-products">Main
                                                    Courses</a>
                                                <a class="list-group-item list-group-item-action" id="products-category"
                                                    data-id="6" data-toggle="list" href="#list-products">Dessert</a>
                                            </div>
                                        </div>
                                        <div class="col-9 p-0">
                                            <div class="tab-content" id="nav-tabContent">
                                                <h5
                                                    class="text-center title bg-primary text-white p-1 text-uppercase font-weight-light">
                                                    Products
                                                </h5>
                                                <div class="tab-pane fade show" id="list-products" role="tabpanel"
                                                    aria-labelledby="list-products-list">
                                                    <div class="row mt-3 list-products">
                                                        <div class="col item-product" data-id="1">
                                                            <span class="name-product">Continental Breakfast</span>
                                                            <span data-price='30.20' class="price-product">$30.20</span>
                                                        </div>
                                                        <div class="col item-product" data-id="2">
                                                            <span class="name-product">English Breakfast </span>
                                                            <span data-price='30.20' class="price-product">$60.00</span>
                                                        </div>
                                                        <div class="col item-product" data-id="3">
                                                            <span class="name-product">American Breakfast</span>
                                                            <span data-price='30.20' class="price-product">$40.90</span>
                                                        </div>
                                                        <div class="col item-product" data-id="4">
                                                            <span class="name-product">Inidian Breakfast</span>
                                                            <span data-price='30.20' class="price-product">$30.70</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-center">
                                    <button class="btn btn-primary ml-auto"><i class="fas fa-sync-alt"></i> Generate
                                        Order</button>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="table-responsive">
                                <h4 class="text-center">Transaction List</h4>
                                <table class="table table-striped text-center">
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
                                        <tr>
                                            <td>Transfer To Group</td>
                                            <td>$ 77.04</td>
                                            <td>Sheldon Cooper(P16)</td>
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
                <div id="newOrder1" class="tab-pane active" role="tabpanel" aria-labelledby="newOrder1-tab">
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
                                        <td id="discount" class="cursor-pointer text-primary" data-discount="0.00">Discount</td>
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
                                                <input class="form-control dropdown-toggle" type="text"
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
                                <label for="remark">Remark</label>
                                <textarea id="remark" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <table id="tablePrices" class="table text-right">
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
                                    <tr>
                                        <th>Total Amount</th>
                                        <th id="totalAmount">$ <span>0.00</span></th>
                                    </tr>
                                    <tr>
                                        <td>Paid</td>
                                        <td id="paid">$ <span>0.00</span></td>
                                    </tr>
                                    <tr class="bg-lightblue">
                                        <th>Balance</th>
                                        <th id="balance">$ <span>0.00</span></th>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <button class="btn btn-primary btn-lg w-100">Confirm Order</button>
                                        </td>
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
            </div>
        </div>
    </div>
</div>
@endsection