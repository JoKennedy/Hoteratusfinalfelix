<?php

namespace App\Http\Controllers;
use App\Country;
use App\Salutation;
use App\Room;
use App\RoomType;
use App\MeasurementUnit;
use App\Product;
use App\ProductCategory;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestaurantController extends Controller
{
    public function index(Request $request){
        $hotel_id = $request->session()->get("hotel_id");
        $product = Product::where("hotel_id",$hotel_id);
        $productCategory = ProductCategory::where("hotel_id",$hotel_id)->get();
        return view('pages.restaurant.index',compact('product','productCategory'));
    }
    public function getInformation(Request $request){
        $hotel_id = $request->session()->get("hotel_id");
        if(isset($request->ACTION)){
            if($request->TO =="SUBMENU"){
                if($request->view =="products"){
                    return response()->json($this->loadProduct($request));
                }
                elseif($request->view == "transaction"){
                    return response()->json($this->transactionList($request));
                }
                elseif ($request->view == "refund") {
                    return response()->json($this->refundList($request));
                }
                elseif($request->view == "allocationQuantity"){
                    return response()->json($this->allocationQuantity($request));
                }
                elseif($request->view == "allocationDetails"){
                    return response()->json($this->allocationDetails($request));
                }
                elseif($request->view == "orders"){
                    return response()->json($this->orderList($request));
                }
                elseif($request->view == "fPendingBalance"){
                    return response()->json($this->folioPendingBalance($request));
                }
                elseif($request->view == "aStatement"){
                    return response()->json($this->accountStatement($request));
                }
                else{
                    $datos = array(
                        "status"=>"resouce no found"
                    );
                    return response()->json($datos);
                }
            }
            else if($request->TO == "Restaurant"){
                if($request->FOR == "loadProducts"){
                    return response()->json($this->loadProductForCategory($request));
                }
            }
            else if($request->TO == "listProducts"){
                return response()->json($this->listProducts($request));
            }
            else if($request->TO =="InvoiceOnHold"){
                return response()->json($this->invoiceOnHold($request));
            }
            else if($request->TO == "FolioRefund"){
                return response()->json($this->folioRefund($request));
            }
            else if($request->TO == "Restaurant_payment"){
                if($request->FOR == "ConfirmOrder"){
                    return response()->json($this->confirmOrder($request));
                }
            }
            else{
                $datos = array(
                    "status"=>"resouce no found",
                    "request"=> $request->all()
                );
                return response()->json($datos);
            }
        }
    }
    protected function confirmOrder(Request $request){
        $hotel_id = $request->session()->get("hotel_id");

        //despues de guardar la factura devolvera el id y este se consultara y devolvera
        $request->merge(["orderNo"=>"001"]);
        return $this->invoiceOnHold($request);
    }
    protected function folioRefund(Request $request){
        $hotel_id = $request->session()->get("hotel_id");
        $folioNumber = $request->folioNumber;

        $navTab = 
        "<li class='nav-item' data-remove='folioNo$folioNumber'>
            <a href='#folioNo$folioNumber' data-id='folioNo$folioNumber' id='folioNo$folioNumber-tab' class='nav-link'
                data-toggle='tab' role='tab' aria-controls='folioNo$folioNumber' aria-selected='true'>Folio #$folioNumber
                <button type='button' data-id='folioNo$folioNumber' id='tabClose' class='close ml-1'
                    aria-label='Close'>
                    <span aria-hidden='true'>×</span>
                </button>
            </a>
        </li>";
        $content = 
        "<div id='folioNo$folioNumber' class='tab-pane' role='tabpanel' aria-labelledby='folioNo$folioNumber-tab'>
            <div class='col-md-12 pt-3'>
                <h3 class='font-weight-bold text-center text-uppercase text-muted'>Folio #$folioNumber</h3>
            </div>
            <div class='row px-3'>
                <div class='custom-control custom-checkbox'>
                    <input type='checkbox' id='complementaryFolio$folioNumber' class='custom-control-input'
                        autocomplete='off'>
                    <label for='complementaryFolio$folioNumber' class='custom-control-label'>Complementary</label>
                </div>
            </div>
            <div class='row mt-3'>
                <div class='table-responsive'>
                    <table id='tableTotalAmount' class='table'>
                        <thead class='bg-primary text-white'>
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
                            <tr data-id='1'>
                                <td id='name'>Soup tomato</td>
                                <td id='price' data-price='8.00'>$<span>8.00</span></td>
                                <td id='quantity'><input type='number' class='form-control' value='3'></td>
                                <td id='discount' class='cursor-pointer text-primary' data-discount='0.00'>
                                    Discount</td>
                                <td id='totalPrice' class='d-flex text-primary'>$ <input type='text'
                                        class='border-0' value='23.28' style='max-width: 60px;'></td>
                                <td>
                                    <button id='remove-product' class='btn btn-outline-primary'>
                                        <i class='fas fa-trash'></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class='row'>
                <div class='col-md-6'>
                    
                </div>
                <div class='col-md-6'>
                    <table id='tableBalance' class='table text-right'>
                        <tbody>
                            <tr>
                                <th>Sub Total</th>
                                <th id='subTotal' data-subTotoal=''>$ <span>0.00</span></th>
                            </tr>
                            <tr>
                                <td>Folio Discount</td>
                                <td id='fDiscount' data-fDiscount=''>$ <span>0.00</span></td>
                            </tr>
                            <tr>
                                <td>Package/Corporate Discount</td>
                                <td id='packageOrCorporate' data-packageOrCorporate=''>$ <span>0.00</span></td>
                            </tr>
                            <tr>
                                <th>Amount</th>
                                <th id='amount' data-amount=''>$ <span>0.00</span></th>
                            </tr>
                            <tr>
                                <td>Tax(es)</td>
                                <td id='taxes' data-taxes=''>$ <span>0.00</span></td>
                            </tr>
                            <tr class='bg-info text-white'>
                                <th>Total Amount <br>
                                    <i style='font-size: 14px;'>Total Paid</i>
                                </th>
                                <td id='totalAmount' data-value='0.00' data-currency='DOP'>
                                    $ <span>0.00</span> <br>
                                    <i id='totalPaid'style='font-size: 14px;'>$ 0.00</i>
                                </td>
                            </tr>
                            <tr class='bg-lightblue'>
                                <th>Balance</th>
                                <th id='balance' data-balance=''>$ <span>0.00</span></th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class='payment-details'>
                <div class='row bg-lightblue'>
                    <div class='table-responsive'>
                        <table class='table'>
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
            <div class='row mt-3'>
                <div class='col-md-3 px-1'>
                    <button id='startNew' class='btn btn-success btn-lg w-100'>Start New</button>
                </div>
                <div class='col-md-5 px-1'>
                    <button id='tClose' class='btn btn-danger btn-lg w-100'>Transaction Close</button>
                </div>
                <div class='col-md-2 px-1'>
                    <button id='print' class='btn btn-primary btn-lg w-100'>Print</button>
                </div>
                <div id='refund' class='col-md-2 px-1'>
                    <button class='btn btn-info btn-lg w-100'>Refund</button>
                </div>
            </div>
        </div>";
        $datos = array(
            "navTab"=>$navTab,
            "tab-content"=>$content
        );
        return $datos;
    }
    protected function invoiceOnHold(Request $request){
        $hotel_id = $request->session()->get("hotel_id");
        $products = Product::with("product_subcategory","product_subcategory.product_category")->where('hotel_id',$hotel_id)->where('active',1)->get();
        $orderNo = $request->orderNo;
        $listProducts = "";
        foreach($products as $product){
            $listProducts .= 
            "<li class='list-group-item list-group-item-action d-flex align-content-between align-items-center' data-id='$product[id]'>
                <span class='w-50' id='nameProduct'>$product[name]</span>
                <span class='w-25 px-1 mx-1 border-left border-right text-dark'
                    id='codeProduct'>$product[id]</span>
                <span class='w-25 text-success' id='priceProduct'
                    data-price='15.00'>$15.00</span>
            </li>";
        }
        $navTab = 
        "<li class='nav-item' data-remove='orderNo$orderNo'>
            <a href='#orderNo$orderNo' id='orderNo$orderNo-tab' data-id='orderNo$orderNo' class='nav-link' data-toggle='tab' role='tab'
                aria-controls='orderNo$orderNo' aria-selected='true'>Order #$orderNo
                <button type='button' data-id='orderNo$orderNo' id='tabClose' class='close ml-1' aria-label='Close'>
                    <span aria-hidden='true'>×</span>
                </button>
            </a>
        </li>";
        $content = 
        "<div id='orderNo$orderNo' class='tab-pane' role='tabpanel' aria-labelledby='orderNo$orderNo-tab'>
            <div class='row py-2'>
                <div class='col-md-3'>
                    <label for='name'>Name</label>
                    <input type='text' id='name' class='form-control'>
                </div>
                <div class='col-md-3'>
                    <label for='lastName'>Last Name</label>
                    <input type='text' id='lastName' class='form-control'>
                </div>
                <div class='col-md-3'>
                    <label for='roomHasReserved'>Room #</label>
                    <select id='roomHasReserved' class='custom-select'></select>
                </div>
                <div class='col-md-3'>
                    <label for='guestName'>Guest Name</label>
                    <select id='guestName' class='custom-select'></select>
                </div>
            </div>
            <div class='row p-3'>
                <div class='custom-control custom-checkbox'>
                    <input type='checkbox' id='complementaryOrder1' class='custom-control-input'
                        autocomplete='off'>
                    <label for='complementaryOrder1' class='custom-control-label'>Complementary</label>
                </div>
            </div>
            <div class='row mt-3'>
                <div class='table-responsive-phone w-100'>
                    <table id='tableTotalAmount' class='table'>
                        <thead class='bg-primary text-white'>
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
                            <tr data-id='1'>
                                <td id='name'>Soup tomato</td>
                                <td id='price' data-price='8.00'>$<span>8.00</span></td>
                                <td id='quantity'><input type='number' class='form-control' value='3'></td>
                                <td id='discount' class='cursor-pointer text-primary' data-discount='0.00'>
                                    Discount</td>
                                <td id='totalPrice' class='d-flex text-primary'>$ <input type='text'
                                        class='border-0' value='23.28' style='max-width: 60px;'></td>
                                <td>
                                    <button id='remove-product' class='btn btn-outline-primary'>
                                        <i class='fas fa-trash'></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr id='alertProduct' class='alert alert-danger' style='display: none;'>
                                <td colspan='6'>This product exist</td>
                            </tr>
                            <tr id='addNewProduct'>
                                <td id='name'>
                                    <div class='dropdown w-100 mielda'>
                                        <input class='form-control filter dropdown-toggle' type='text'
                                            id='dropdownNameProduct' placeholder='Product Name'
                                            data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'
                                            autocomplete='off'>
                                        <div class='dropdown-menu w-100' aria-labelledby='dropdownNameProduct'
                                            style='position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 70px, 0px);'
                                            x-placement='bottom-start'>
                                            <ul class='list-group list-group-flush overflow-auto cursor-pointer text-center' style='max-height:265px'>
                                                ".$listProducts."
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                                <td id='price'>$<span>--</span></td>
                                <td id='units'><input type='number' class='form-control' value='1'
                                        autocomplete='off'></td>
                                <td id='discount'>--</td>
                                <td id='totalPrice' class='d-flex text-primary'>$--</td>
                                <td><button id='add-product' class='btn btn-outline-primary'><i
                                            class='fas fa-plus'></i></button></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class='row'>
                <div class='col-md-6'>
                    <div class='row'>
                        <button id='addCustomCharge' class='btn btn-primary'>Add Custom Charge</button>
                    </div>
                    <div class='row my-3'>
                        <div class='col-sm-12 col-md-6 p-1'>
                            <button class='btn btn-lg btn-primary w-100 text-uppercase font-weight-bold'>Update Order</button>
                        </div>
                        <div class='col-sm-12 col-md-6 p-1'>
                            <button class='btn btn-lg btn-outline-danger w-100 text-uppercase font-weight-bold'>Cancel Order</button>
                        </div>
                    </div>
                    <div class='row mt-3'>
                        <label for='remark'>Remark</label>
                        <textarea id='remark' class='form-control'></textarea>
                    </div>
                </div>
                <div class='col-md-6'>
                    <table id='tableBalance' class='table text-right'>
                        <tbody>
                            <tr>
                                <th>Sub Total</th>
                                <th id='subTotal' data-subTotoal=''>$ <span>0.00</span></th>
                            </tr>
                            <tr>
                                <td>Folio Discount</td>
                                <td id='fDiscount' data-fDiscount=''>$ <span>0.00</span></td>
                            </tr>
                            <tr>
                                <td>Package/Corporate Discount</td>
                                <td id='packageOrCorporate' data-packageOrCorporate=''>$ <span>0.00</span></td>
                            </tr>
                            <tr>
                                <th>Amount</th>
                                <th id='amount' data-amount=''>$ <span>0.00</span></th>
                            </tr>
                            <tr>
                                <td>Tax(es)</td>
                                <td id='taxes' data-taxes=''>$ <span>0.00</span></td>
                            </tr>
                            <tr class='bg-info text-white'>
                                <th>Total Amount <br>
                                    <i style='font-size: 14px;'>Total Paid</i>
                                </th>
                                <td id='totalAmount' data-value='0.00' data-currency='DOP'>
                                    $ <span>0.00</span> <br>
                                    <i id='totalPaid'style='font-size: 14px;'>$ 0.00</i>
                                </td>
                            </tr>
                            <tr class='bg-lightblue'>
                                <th>Balance</th>
                                <th id='balance' data-balance=''>$ <span>0.00</span></th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class='payment-details'>
                <div id='payment' class='row'>
                    <div class='col-sm-2 p-2 text-center bg-lightblue'>
                        <h4>Payment</h4>
                    </div>
                    <div class='col-sm-10 p-2'>
                        <span class='text-danger'>Payment Gateway is no integrated. Credit Card will not be
                            charged</span>
                    </div>
                </div>
                <div class='row p-3 bg-lightblue'>
                    <div class='col-md-2 px-1'>
                        <label for='modePaid'>Mode</label>
                        <select id='modePaid' class='custom-select'></select>
                    </div>
                    <div class='col-md-2 px-1'>
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
                </div>
                <div class='row bg-lightblue btn-group-space'>
                    <div class='col-md-3 px-1'>
                        <button id='paidNow' class='btn btn-success w-100'>Pay Now</button>
                    </div>
                    <div class='col-md-3 px-1'>
                        <button id='currencyConverter' class='btn btn-primary w-100'><i
                                class='fas fa-dollar-sign'></i> Converter</button>
                    </div>
                    <div class='col-md-3 px-1'>
                        <button id='transferToRoom' class='btn btn-outline-dark w-100'><i class='fas fa-exchange-alt'></i> Transfer
                            to Room</button>
                    </div>
                    <div class='col-md-3 px-1'>
                        <button id='transferCityLedger' class='btn btn-outline-danger w-100'><i class='fas fa-exchange-alt'></i> Transfer to
                            City Ledger</button>
                    </div>
                </div>
            </div>
            <div class='row mt-3 btn-group-space'>
                <div class='col-md-3 px-1'>
                    <button id=''startNew class='btn btn-success btn-lg w-100'>Start New</button>
                </div>
                <div class='col-md-5 px-1'>
                    <button id='tClose' class='btn btn-danger btn-lg w-100'>Transaction Close</button>
                </div>
                <div class='col-md-2 px-1'>
                    <button id='print' class='btn btn-primary btn-lg w-100'>Print</button>
                </div>
                <div class='col-md-2 px-1'>
                    <button id='refund' class='btn btn-info btn-lg w-100'>Refund</button>
                </div>
            </div>
        </div>";
        $datos = array(
            "navTab"=>$navTab,
            "tab-content"=>$content,
            "orderNo"=>$request->orderNo
        );
        return $datos;
    }
    protected function listProducts(Request $request){
        $hotel_id  = $request->session()->get("hotel_id");
        $products = Product::with('product_subcategory', 'product_subcategory.product_category')->where('hotel_id', $hotel_id)->where("active",1)->get();
        $datos = array(
            "products"=>$products
        );
        return $datos;
    }
    protected function loadProductForCategory(Request $request){
        $hotel_id  = $request->session()->get("hotel_id");
        $products = Product::with('product_subcategory', 'product_subcategory.product_category')->where('hotel_id', $hotel_id)->where("product_subcategory_id",$request->id)->where("active",1)->get();
        $content = "";
        foreach($products as $product){
            $content .= 
            "<div class='col item-product' data-id='$product[id]'>
                <i class='fas fa-utensils' style='color: #f98d02;font-size: 20px;padding: 0 5px;'></i>
                <span class='name-product'>$product[name]</span>
                <span data-price='30.20' class='price-product'>$60.00</span>
            </div>";
        }
        $datos = array(
            "content"=>$content
        );
        return $datos;
    }
    protected function loadProduct(Request $request){
        $hotel_id = $request->session()->get("hotel_id");
        $products = Product::with('product_subcategory', 'product_subcategory.product_category')->where('hotel_id', $hotel_id)->where("active",1)->get();
        $rows ="";
        foreach($products as $product){
            $rows .= 
            "<tr>
                <td>".$product->product_subcategory->product_category["name"]."</td>
                <td>$product[name]</td>
                <td>$product[code]</td>
                <td>$ 10.00</td>
                <td>
                    <span class='d-block'>VAT@7%(7.00%)</span>
                    <b class='d-block'>Total Tax(es)</b>
                </td>
                <td>
                    <span class='d-block'>$ 0.70)</span>
                    <b class='d-block'>$ 0.70</b>
                </td>
                <td>$ 10.70</td>
            </tr>";   
        }
        $navTab = 
        "<li class='nav-item' data-remove='products'>
            <a href='#products' id='products-tab' data-id='products' class='nav-link'  data-toggle='tab' role='tab' aria-controls='products'
                aria-selected='true'>Products
                <button type='button' data-id='products' id='tabClose' class='close ml-1' aria-label='Close'>
                    <span aria-hidden='true'>×</span>
                </button>
            </a>
        </li>";
        $content = 
        "<div id='products' class='tab-pane' role='tabpanel' aria-labelledby='products-tab'>
            <div class='row bg-lightblue filter p-3'>
                <div class='col-md-5'>
                    <label for='productCategory'>Product Category</label>
                    <select id='productCategory' class='custom-select'></select>
                </div>
                <div class='col-md-5'>
                    <label for='productNameOrCode'>Product Name/Code</label>
                    <input type='text' id='productNameOrCode' class='form-control'>
                </div>
                <div class='col-md-2 align-self-end'>
                    <button class='btn btn-primary w-100'><i class='fas fa-search'></i> Search</button>
                </div>
            </div>
            <div class='row'>
                <div class='table-responsive'>
                    <table class='table table-striped text-center dataTable'>
                        <thead class='bg-primary text-white'>
                            <tr>
                                <th>Category</th>
                                <th>Product Name</th>
                                <th>Product Code</th>
                                <th>Price</th>
                                <th>Tax(es)</th>
                                <th>Tax Amount</th>
                                <th>Total Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            ".$rows."
                        </tbody>
                    </table>
                </div>
            </div>
            <div class='row p-1 bg-lightblue d-block text-center'>
                <button class='btn btn-primary'><i class='fas fa-print'></i> Print</button>
            </div>
        </div>";
        $datos = array(
            "navTab" => $navTab,
            "tab-content" => $content,
            "p"=> $product
        );
        return $datos;
    }
    protected function transactionList(Request $request){
        $navTab = 
        "<li class='nav-item' data-remove='transaction'>
            <a href='#transaction' id='transaction-tab' data-id='transaction' class='nav-link' data-toggle='tab' role='tab'
                aria-controls='transaction' aria-selected='true'>Transaction List
                <button type='button' data-id='transaction' id='tabClose' class='close ml-1' aria-label='Close'>
                    <span aria-hidden='true'>×</span>
                </button>
            </a>
        </li>";
        $content = 
        "<div id='transaction' class='tab-pane' role='tabpanel' aria-labelledby='transaction-tab'>
            <div class='row bg-lightblue filter p-3'>
                <div class='col-md-3'>
                    <label for='from'>Started From</label>
                    <input type='date' id='from' class='form-control inputCalendar'>
                </div>
                <div class='col-md-3'>
                    <label for='to'>To</label>
                    <input type='date' id='to' class='form-control inputCalendar'>
                </div>
                <div class='col-md-4 p-0'>
                    <label for='transactionType'>Transaction Type</label>
                    <div class='input-group'>
                        <select id='transactionType' class='custom-select'></select>
                        <div class='input-group-prepend'>
                            <div class='input-group-text'>
                                <div class='custom-control custom-checkbox'>
                                    <input type='checkbox' id='transaction-complementary' class='custom-control-input' value='off' autocomplete='off'>
                                    <label for='transaction-complementary' class='custom-control-label'>Complementary</label>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
                <div class='col-md-2 align-self-end'>
                    <button class='btn btn-primary w-100'><i class='fas fa-search'></i> Search</button>
                </div>
            </div>
            <div class='row'>
                <div class='table-responsive'>
                    <table class='table table-striped table-hover text-center dataTable'>
                        <thead class='bg-primary text-white'>
                            <tr>
                                <th>Payment Type</th>
                                <th>Amount Paid</th>
                                <th>Balance</th>
                                <th>Credit Card#/Cheque#</th>
                                <th>Folio #</th>
                                <th>Date</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Cash</td>
                                <td>$ 21.30</td>
                                <td>Paid</td>
                                <td>--</td>
                                <td>1</td>
                                <td>Mon, Oct 05,2020</td>
                                <td>22:10:29</td>
                            </tr>
                            <tr>
                            <td>Credit Card</td>
                            <td>$ 31.60</td>
                            <td>Paid</td>
                            <td>--</td>
                            <td>1</td>
                            <td>Mon, Oct 05,2020</td>
                            <td>18:10:29</td>
                        </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Total</th>
                                <th>$<b>52.90</b></th>
                                <th colspan='5'></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class='row p-1 bg-lightblue d-block text-center'>
                <div class='input-group col-4 d-inline-flex'>
                    <select id='exportTo' class='custom-select'></select>
                    <div class='input-group-prepend'>
                        <button class='btn btn-primary rounded-right'>Export</button>
                    </div>
                </div>
            </div>
        </div>";
        $datos = array(
            "navTab"=> $navTab,
            "tab-content" => $content
        );
        return $datos;
    }
    protected function refundList(Request $request){
        $navTab = 
        "<li class='nav-item' data-remove='refund'>
            <a href='#refund' id='refund-tab' data-id='refund' class='nav-link' data-toggle='tab' role='tab'
                aria-controls='refund' aria-selected='true'>Refund List
                <button type='button' data-id='refund' id='tabClose' class='close ml-1' aria-label='Close'>
                    <span aria-hidden='true'>×</span>
                </button>
            </a>
        </li>";
        $content = 
        "<div id='refund' class='tab-pane' role='tabpanel' aria-labelledby='refund-tab'>
            <div class='row bg-lightblue filter p-3'>
                <div class='col-md-5'>
                    <label for='from'>Started From</label>
                    <input type='date' id='from' class='form-control inputCalendar'>
                </div>
                <div class='col-md-5'>
                    <label for='to'>To</label>
                    <input type='date' id='to' class='form-control inputCalendar'>
                </div>
                <div class='col-md-2 align-self-end'>
                    <button class='btn btn-primary w-100'><i class='fas fa-search'></i> Search</button>
                </div>
            </div>
            <div class='row'>
                <div class='table-responsive'>
                    <table class='table table-striped table-hover text-center dataTable'>
                        <thead class='bg-primary text-white'>
                            <tr>
                                <th>Payment Type</th>
                                <th>Amount Paid</th>
                                <th>Balance</th>
                                <th>Credit Card#/Cheque#</th>
                                <th>Folio #</th>
                                <th>Date</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Cash</td>
                                <td>$ 21.30</td>
                                <td>Paid</td>
                                <td>--</td>
                                <td>1</td>
                                <td>Mon, Oct 05,2020</td>
                                <td>22:10:29</td>
                            </tr>
                            <tr>
                            <td>Credit Card</td>
                            <td>$ 31.60</td>
                            <td>Paid</td>
                            <td>--</td>
                            <td>1</td>
                            <td>Mon, Oct 05,2020</td>
                            <td>18:10:29</td>
                        </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Total</th>
                                <th>$<b>52.90</b></th>
                                <th colspan='5'></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>";
        $datos = array(
            "navTab"=> $navTab,
            "tab-content" => $content
        );
        return $datos;
    }
    protected function allocationQuantity(Request $request){
        $navTab = 
        "<li class='nav-item' data-remove='allocationQuantity'>
            <a href='#allocationQuantity' data-id='allocationQuantity' id='allocationQuantity-tab' class='nav-link' data-toggle='tab' role='tab'
                aria-controls='allocationQuantity' aria-selected='true'>AllocationQuantity
                <button type='button' data-id='allocationQuantity' id='tabClose' class='close ml-1' aria-label='Close'>
                    <span aria-hidden='true'>×</span>
                </button>
            </a>
        </li>";
        $content = 
        "<div id='allocationQuantity' class='tab-pane' role='tabpanel' aria-labelledby='allocationQuantity-tab'>
            <div class='row bg-lightblue filter p-3'>
                <div class='col-md-5'>
                    <label for='from'>Started From</label>
                    <input type='date' id='from' class='form-control inputCalendar'>
                </div>
                <div class='col-md-2 align-self-end'>
                    <button id='btnSearch' class='btn btn-primary w-100'><i class='fas fa-search'></i> Search</button>
                </div>
            </div>
            <div class='row'>
                <div class='table-responsive'>
                    <table id='tableAllocationQuantity' class='table table-striped table-hover text-center dataTable'>
                        <thead class='bg-primary text-white'>
                            <tr>
                                <th>Product Name</th>
                                <th>Quantity(Adult)</th>
                                <th>Quantity(Child)</th>
                                <th>Quantity(Room)</th>
                                <th>Total Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr data-id='1'>
                                <td>Breakfast Buffet</td>
                                <td>9</td>
                                <td>0</td>
                                <td>0</td>
                                <td>9</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Total</th>
                                <th>9</th>
                                <th>0</th>
                                <th>0</th>
                                <th>9</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>";
        $datos = array(
            "navTab"=>$navTab,
            "tab-content"=>$content
        );
        return $datos;
    }
    protected function allocationDetails(Request $request){
        $navTab = 
        "<li class='nav-item' data-remove='allocationDetails'>
            <a href='#allocationDetails' data-id='allocationDetails' id='allocationDetails-tab' class='nav-link' data-toggle='tab' role='tab'
                aria-controls='allocationDetails' aria-selected='true'>Allocation Details
                <button type='button' data-id='allocationDetails' id='tabClose' class='close ml-1' aria-label='Close'>
                    <span aria-hidden='true'>×</span>
                </button>
            </a>
        </li>";
        $content = 
        "<div id='allocationDetails' class='tab-pane' role='tabpanel' aria-labelledby='aStatement-tab'>
            <div class='row bg-lightblue filter p-3'>
                <p class='m-0'>
                    <b>Product: </b><span>Breakfast Buffet</span>
                    <b>Date: </b><span>Oct 10,2020</span>
                </p>
            </div>
            <div class='row'>
                <div class='table-responsive'>
                    <table id='tableaStatement' class='table table-striped text-center dataTable'>
                        <thead class='bg-primary text-white'>
                            <tr>
                                <th>Res#</th>
                                <th>Guest Name</th>
                                <th>Room Type/Room#</th>
                                <th>Pax</th>
                                <th>Qty(Adult)</th>
                                <th>Qty(Child)</th>
                                <th>Qty(Room)</th>
                                <th>Total Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>100632</td>
                                <td>Richard Gere,Marius Snyman, Janet Fonda</td>
                                <td>Superior Room</td>
                                <td>3(A)</td>
                                <td>3</td>
                                <td>0</td>
                                <td>0</td>
                                <td>3</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan='3'></th>
                                <th>Total</th>
                                <th>3</th>
                                <th>0</th>
                                <th>0</th>
                                <th>3</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class='row p-1 bg-lightblue d-block text-center'>
                <button id='btnPrint' class='btn btn-primary'><i class='fas fa-print'></i> Print</button>
            </div>
        </div>";
        $datos = array(
            "navTab"=>$navTab,
            "tab-content"=>$content
        );
        return $datos;
    }
    protected function orderList(Request $request){
        $navTab = 
        "<li class='nav-item' data-remove='orders'>
            <a href='#orders' data-id='orders' id='orders-tab' class='nav-link' data-toggle='tab' role='tab'
                aria-controls='orders' aria-selected='true'>Orders List
                <button type='button' data-id='orders' id='tabClose' class='close ml-1' aria-label='Close'>
                    <span aria-hidden='true'>×</span>
                </button>
            </a>
        </li>";
        $content = 
        "<div id='orders' class='tab-pane' role='tabpanel' aria-labelledby='orders-tab'>
            <div class='row bg-lightblue filter p-3'>
                <div class='col-md-2'>
                    <label for='orderNo'>Order No:</label>
                    <input type='text' id='orderNo' class='form-control'>
                </div>
                <div class='col-md-3'>
                    <label for='from'>Started From</label>
                    <input type='date' id='from' class='form-control inputCalendar'>
                </div>
                <div class='col-md-3'>
                    <label for='to'>To</label>
                    <input type='date' id='to' class='form-control inputCalendar'>
                </div>
                <div class='col-md-2'>
                    <label for='orderStatus'>Order Status</label>
                    <select id='' class='custom-select'></select>
                </div>
                <div class='col-md-2 align-self-end'>
                    <button id='btnSearch' class='btn btn-primary w-100'><i class='fas fa-search'></i>
                        Search</button>
                </div>
            </div>
            <div class='row'>
                <div class='table-responsive'>
                    <table class='table table-striped table-hover text-center dataTable'>
                        <thead class='bg-primary text-white'>
                            <tr>
                                <th>Order#</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Status</th>
                                <th>Cancelled On</th>
                                <th>Cancelled By</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>11978819</td>
                                <td>$ 27.12</td>
                                <td>Mon, Oct 05</td>
                                <td>20:42:14</td>
                                <td>Cancel</td>
                                <td>Mon, Oct 05 20:46:36</td>
                                <td>Jonas Cueva</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class='row p-1 bg-lightblue d-block text-center'>
                <div class='input-group col-4 d-inline-flex'>
                    <select id='exportTo' class='custom-select'></select>
                    <div class='input-group-prepend'>
                        <button class='btn btn-primary rounded-right'>Export</button>
                    </div>
                </div>
            </div>
        </div>";
        $datos = array(
            "navTab"=>$navTab,
            "tab-content"=>$content
        );
        return $datos;
    }
    protected function folioPendingBalance(Request $request){
        $navTab = 
        "<li class='nav-item' data-remove='fPendingBalance'>
            <a href='#fPendingBalance' data-id='fPendingBalance' id='fPendingBalance-tab' class='nav-link' data-toggle='tab' role='tab'
                aria-controls='fPendingBalance' aria-selected='true'>Folio Pending Balance
                <button type='button' data-id='fPendingBalance' id='tabClose' class='close ml-1' aria-label='Close'>
                    <span aria-hidden='true'>×</span>
                </button>
            </a>
        </li>";
        $content = 
        "<div id='fPendingBalance' class='tab-pane' role='tabpanel' aria-labelledby='fPendingBalance-tab'>
            <div class='row bg-lightblue filter p-3'>
                <div class='col-md-3'>
                    <label for='from'>Started From</label>
                    <input type='date' id='from' class='form-control inputCalendar'>
                </div>
                <div class='col-md-3'>
                    <label for='to'>To</label>
                    <input type='date' id='to' class='form-control inputCalendar'>
                </div>
                <div class='col-md-2 align-self-end'>
                    <button id='btnSearch' class='btn btn-primary w-100'><i class='fas fa-search'></i>
                        Search</button>
                </div>
            </div>
            <div class='row'>
                <div class='table-responsive'>
                    <table class='table table-striped table-hover text-center dataTable'>
                        <thead class='bg-primary text-white'>
                            <tr>
                                <th>Payment Type</th>
                                <th>Amount Paid</th>
                                <th>Balance</th>
                                <th>Credit Card# / Cheque#</th>
                                <th>Folio#</th>
                                <th>Date</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>";
        $datos = array(
            "navTab"=>$navTab,
            "tab-content"=>$content
        );
        return $datos;
    }
    protected function accountStatement(Request $request){
        $navTab = 
        "<li class='nav-item' data-remove='aStatement'>
            <a href='#aStatement' data-id='aStatement' id='aStatement-tab' class='nav-link' data-toggle='tab' role='tab'
                aria-controls='aStatement' aria-selected='true'>Account Statement
                <button type='button' data-id='aStatement' id='tabClose' class='close ml-1' aria-label='Close'>
                    <span aria-hidden='true'>×</span>
                </button>
            </a>
        </li>";
        $content = 
        "<div id='aStatement' class='tab-pane' role='tabpanel' aria-labelledby='aStatement-tab'>
            <div class='row bg-lightblue filter p-3'>
                <div class='col-md-3'>
                    <label for='date'>Date</label>
                    <input type='date' id='date' class='form-control inputCalendar'>
                </div>
                <div class='col-md-2 align-self-end'>
                    <button id='btnSearch' class='btn btn-primary w-100'><i class='fas fa-search'></i>
                        Search</button>
                </div>
            </div>
            <div class='row'>
                <div class='table-responsive'>
                    <table id='tableaStatement' class='table table-striped table-hover text-center dataTable'>
                        <thead class='bg-primary text-white'>
                            <tr>
                                <th>Product Name</th>
                                <th>POS Quantity</th>
                                <th>Frontdesk Quantity</th>
                                <th>POS Price/Qty.</th>
                                <th>Frontdesk Price/Qty.</th>
                                <th>Profit</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>";
        $datos = array(
            "navTab"=>$navTab,
            "tab-content"=>$content
        );
        return $datos;
    }
}
