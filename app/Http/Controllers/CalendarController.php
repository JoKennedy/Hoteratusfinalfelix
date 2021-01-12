<?php

namespace App\Http\Controllers;

use App\Country;
use App\Salutation;
use App\Room;
use App\RoomType;
use App\RoomStatus;
use App\RoomStatusColor;
use App\HousekeepingStatus;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    
    function index(Request $request){
        $hotel_id = $request->session()->get('hotel_id');
        $countries = Country::all();
        $salutations = Salutation::all();
        $housekeepingStatus = HousekeepingStatus::all();
        $roomStatus = RoomStatus::all();
        $roomTypeId = RoomType::all();
        //$roomPrice = $roomTypeId->where('id', 1)->first()->room_types($hotel_id)->base_price??'';
       // $colorReserva = $roomStatus->where('id',1)->first()->hotel_room_status_color($hotel_id)->color??'';
        return view('pages.calendar.index',compact('countries', 'salutations','roomStatus','housekeepingStatus','hotel_id', 'roomTypeId', 'roomPrice'));
    }

 

    function housekeeping(Request $request){
      $hotel_id = $request->session()->get('hotel_id');
      $roomType = RoomType::where('hotel_id', '=',  $hotel_id )->where('active', '1')->orderBy('sort_order', 'asc')->get();
      $housekeepingStatus = HousekeepingStatus::all();
      $roomStatus = RoomStatus::all();
      return view("pages.calendar.housekeeping",compact('hotel_id','roomType','roomStatus','housekeepingStatus', 'roomPrice'));
    }
    public function getInformation(Request $request ){
    
      if($request->has('ACTION')){
        $data = $request->all();

            if($data['TO']  == "tab-pane"){
              if($data['ACTION'] =="view"){
                return response()->json($this->ViewClientDetails($request,$data));
              }
            }
            else if($request->get('TO') == "ListRooms"){//for calendar
              return response()->json($this->ListRooms($request,$data['typeRoom']));
            }
            else if($request->get('TO') == "Rooms"){
              return response()->json($this->Rooms($request));
            }
            else if($data['TO'] == "PayBill"){
              if($data['FOR'] =="paybill"){
                return $this->ViewPayBill($data);
              }
              else if($data['FOR'] == "folio"){
              
                if($data['ACTION'] == "view"){
                  return response()->json($this->ViewFolio($data));
                }
              }
            }
            else if($data['TO'] == "GroupReservation"){
              
              if($data['FOR'] == "viewCreateReservation"){
                return response()->json($this->GroupReservation());
              }
              elseif($data['FOR'] == "CreateTypeReservation"){
                return response()->json($this->CreateTypeReservation($request->get('typeReservation')));
              }
            }
            else if($request->TO == "Housekeeping"){
              if($request->FOR == "WorkArea"){
                return response()->json($this->WorkArea($request));
              }
            }
            else{
              //echo json_encode($users);
              return response()->json($data);
            } 
      }
      else{
        $vehiculo = array(
          "marca" => "Mazda",
          "color" => "azul"
        );
        return response()->json($vehiculo);
      }
    }
    function fillCalendar(){

    }
    function addReserv(){

    }
    function update(){

    }
    protected function ListRooms(Request $request, $typeRoom){
      $hotel_id = $request->session()->get('hotel_id');

      //agregar un where para buscar a lista de habitaciones segun el tipo de habitacion 
      $rooms = Room::where('hotel_id',$hotel_id)->where('active','1')->where('room_type_id',$typeRoom)->get();
     
      $roomList = "";
      foreach($rooms as $item){
        $roomList .= "<option value='$item->id'>$item->name</option>";
      }
      $datos = array
      (
        "rooms" => $roomList
      );
      return $datos;
    }
    protected function Rooms(Request $request){
      $hotel_id = $request->session()->get('hotel_id');
      $roomType = RoomType::where('hotel_id', '=',  $hotel_id )
      ->where('active', '1')
      ->orderBy('sort_order', 'asc')
      ->get();
      $rooms = Room::where('hotel_id',$hotel_id)->get()
      ->where('active','1');
      $datos = array
      (
        "roomType" => $roomType,
        "rooms" => $rooms
      );
      return $datos;
    }
    protected function ViewPayBill($data){
      $countries = Country::all();
      $salutations = Salutation::all();
      $contentPayBill = 
        "<div id='paybill' class='col-md-12 p-0'>
            <div id='paymentDetails'>
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
                            <table id='tableFolios' class='table table-striped table-hover table-sm table-checkList'>
                              <thead class='bg-primary text-white'>
                                <tr>
                                  <th>
                                    <div class='custom-control custom-checkbox'>
                                      <input type='checkbox' id='folioList{$data['id']}' class='custom-control-input'>
                                      <label for='folioList{$data['id']}' class='custom-control-label'></label>
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
                                <tr data-id='{$data['id']}'>
                                  <td>
                                    <div class='custom-control custom-checkbox'>
                                      <input type='checkbox' id='folioList{$data['id']}-1' class='custom-control-input'>
                                      <label for='folioList{$data['id']}-1' class='custom-control-label'></label>
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
                                  <th colspan='2'></th>
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
                            <input type='checkbox' id='generatedFOC{$data['id']}' class='custom-control-input'>
                            <label for='generatedFOC{$data['id']}' class='custom-control-label'>Generate separate Folio
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
                    <table id='tableAccountStatement' class='table table-striped table-sm table-checkList'>
                      <thead class='bg-primary text-white'>
                        <tr>
                          <th>
                            <div class='custom-control custom-checkbox'>
                              <input type='checkbox' id='CCStatement{$data['id']}' autocomplete='false' class='custom-control-input'
                                value='off'>
                              <label for='CCStatement{$data['id']}' class='custom-control-label'></label>
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
              <div class='row'>
                  <div class='col-md-9'>
                    <div class='row p-4 bg-light-gray'>
                      <button class='btn btn-primary mx-2'><i class='fas fa-folder-open'></i> Generate Folio</button>
                      <button class='btn btn-primary mx-2'><i class='fas fa-user'></i> Consolidate Account</button>
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
                            <button id='currencyConverter' class='btn btn-success w-100'><i class='fas fa-dollar-sign'></i>
                              Currency
                              Converter</button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
              </div>
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
                    <button id='backToReserv' class='btn btn-light mx-1'>Back</button>
                    <button id='deleteProformaI' class='btn btn-light mx-1'>Delete Proforma Invoices</button>
                    <button id='print' class='btn btn-light mx-1'>Print</button>
                  </div>
                  <div class='col-md-12 mt-1'>
                    <div class='custom-control custom-checkbox'>
                      <input type='checkbox' id='suscRevEmail' class='custom-control-input' autocomplete='false'
                        value='off'>
                      <label for='suscRevEmail' class='custom-control-label text-white'>Suscribe Reviewexpress email</label>
                    </div>
                  </div>
            </div>
        </div>";
        $datos = array(
          'content' => $contentPayBill,
        );
        return $datos;
    }
    protected function ViewClientDetails(Request $request,$data){
      $countries = Country::all();
      $salutations = Salutation::all();
      $hotel_id = $request->session()->get('hotel_id');
      $roomType = RoomType::where('hotel_id', '=',  $hotel_id )->where('active', '1')->orderBy('sort_order', 'asc')->get();

      //variable temporal
      $roomTypeSelected = "3";//=Deluxe Room
      //agregar un where para buscar a lista de habitaciones segun el tipo de habitacion 
      $rooms = Room::where('hotel_id',$hotel_id)->where('active','1')->where('room_type_id',$roomTypeSelected)->get();
      
      $roomTypeList = "";
      $roomList = "";
      foreach($roomType as $item){
        if($item->id == $roomTypeSelected){
          $roomTypeList .= "<option value='$item->id' selected>$item->name</option>";
        }
        else{
          $roomTypeList .= "<option value='$item->id'>$item->name</option>";
        }
        
      }
      foreach($rooms as $item){
        $roomList .= "<option value='$item->id'>$item->name</option>";
      }

      $contentGroup = 
      "<div class='col-md-12 p-0'>
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
                  <tr>
                    <th id='GguestDetails'>Name: <span>Anastacia Grey</span></th>
                    <th></th>
                  </tr>
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
                id='sendMailConfirmation{$data['id']}'>
              <label class='custom-control-label' for='sendMailConfirmation{$data['id']}'>Send confirmation Email
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
                    <input type='date' id='checkIn' class='form-control inputCalendar px-2'>
                  </div>
                  <div class='col-md-6 p-0 pl-1'>
                    <label for='checkOut'>Check-out</label>
                    <input type='date' id='checkOut' class='form-control inputCalendar px-2'>
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
                        data-toggle='list' href='#list-arrival{$data['id']}' role='tab'
                        aria-controls='arrival'>Arrival</a>
                      <a class='list-group-item list-group-item-action' id='list-departure-list' data-toggle='list'
                        href='#list-departure{$data['id']}' role='tab' aria-controls='departure'>Departure</a>
                    </div>
                  </div>
    
                  <div class='tab-content mt-3' id='nav-tabContent' style='background: none'>
                    <div class='tab-pane fade active show' id='list-arrival{$data['id']}' role='tabpanel'
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
    
                    <div class='tab-pane fade' id='list-departure{$data['id']}' role='tabpanel'
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
                      <input type='checkbox' class='custom-control-input' id='assignTask{$data['id']}'>
                      <label class='custom-control-label' for='assignTask{$data['id']}' data-toggle='collapse'
                        data-target='#selectAssignTask{$data['id']}'>Assign Task</label>
                    </div>
                  </div>
                  <div class='col p-1'>
                    <select id='selectAssignTask{$data['id']}' selectAssignTask='' class='custom-select collapse'>
                      <option value='' selected disabled>Select POS</option>
                    </select>
                  </div>
                </div>
                <div class='row mt-4 p-1'>
                  <div class='custom-control custom-checkbox custom-control-inline'>
                    <input type='checkbox' class='custom-control-input' sendMail='' id='sendMail{$data['id']}' />
                    <label class='custom-control-label' for='sendMail{$data['id']}'>Send Mail</span>
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
            <div id='payTerm' class='col-md-12 py-1' style='background: #E4F0FE;'>
              <div class='row'>
                <select id='' class='custom-select custom-select-user'>
                  <option value=''>Balance To be Paid by Group Owner</option>
                </select>
              </div>
              <div class='row px-3'>
                <div class='custom-control custom-checkbox custom-control-inline'>
                  <input type='checkbox' class='custom-control-input' id='otherCharges-payTerm{$data['id']}'>
                  <label class='custom-control-label' for='otherCharges-payTerm{$data['id']}'>Including Other
                    Charges</label>
                </div>
                <button class='btn btn-outline-primary btn-sm ml-auto list-item-collapse' data-toggle='collapse'
                  data-target='#setLimit'>Set Limit&nbsp;</button>
              </div>
              <div id='setLimit' class='row px-3 py-2 collapse'>
                <div class='custom-control custom-checkbox custom-control-inline  ml-auto '>
                  <input type='checkbox' class='custom-control-input' id='inclusiveTax-payTerm{$data['id']}'>
                  <label class='custom-control-label' for='inclusiveTax-payTerm{$data['id']}'>Inclusive of
                    Tax</label>
                </div>
                <button class='btn btn-outline-primary btn-sm ml-2 list-item-collapse' data-toggle='collapse'
                  data-target='#editLimits'>Edit Details&nbsp;</button>
              </div>
              <div id='setLimit' class='row py-2 collapse'>
                <div class='col d-flex'>
                  $<input type='text' class='form-control form-control-sm'>
                </div>
                <div class='col'>
                  <select id='per?' class='custom-select custom-select-sm'>
                    <option value=''>Per Room</option>
                  </select>
                </div>
                <div class='col align-self-center'>
                  <div class='custom-control custom-checkbox custom-control-inline  ml-auto '>
                    <input type='checkbox' class='custom-control-input' id='perNight-payTerm{$data['id']}'>
                    <label class='custom-control-label' for='perNight-payTerm{$data['id']}'>Per Night</label>
                  </div>
                </div>
              </div>
              <div id='editLimits' class='col-md-12 py-2 collapse'>
                <hr>
                <div id='customRoomTariff' class='row'>
                  <div class='col-md-4'>
                    <label for='roomFieldRoomTariffTariff'>Room Tariff</label>
                    <input type='text' id='FieldRoomTariff' class='form-control form-control-sm'>
                  </div>
                  <div class='col-md-4 align-self-end'>
                    <div class='custom-control custom-checkbox custom-control-inline  ml-auto '>
                      <input type='checkbox' class='custom-control-input' id='TariffPerNight-payTerm{$data['id']}'>
                      <label class='custom-control-label' for='TariffPerNight-payTerm{$data['id']}'>Per
                        Night</label>
                    </div>
                  </div>
                  <div class='col-md-4 align-self-end'>
                    <div class='custom-control custom-checkbox custom-control-inline  ml-auto '>
                      <input type='checkbox' class='custom-control-input' id='TariffPerPerson-payTerm{$data['id']}'>
                      <label class='custom-control-label' for='TariffPerPerson-payTerm{$data['id']}'>Per
                        Person</label>
                    </div>
                  </div>
                </div>
                <div id='addonsTariff' class='row'>
                  <div class='col-md-4'>
                    <label for='FieldAddonsTariff'>Add-ons Tariff</label>
                    <input type='text' id='FieldAddonsTariff' class='form-control form-control-sm'>
                  </div>
                  <div class='col-md-4 align-self-end'>
                    <div class='custom-control custom-checkbox custom-control-inline  ml-auto '>
                      <input type='checkbox' class='custom-control-input' id='addonsPerNight-payTerm{$data['id']}'>
                      <label class='custom-control-label' for='addonsPerNight-payTerm{$data['id']}'>Per
                        Night</label>
                    </div>
                  </div>
                  <div class='col-md-4 align-self-end'>
                    <div class='custom-control custom-checkbox custom-control-inline  ml-auto '>
                      <input type='checkbox' class='custom-control-input' id='addonsPerPerson-payTerm{$data['id']}'>
                      <label class='custom-control-label' for='addonsPerPerson-payTerm{$data['id']}'>Per
                        Person</label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--Table Rates/Packages-->
            <div id='ratesPackages' class='col-md-12 p-0 mt-4'>
              <div class='table-responsive'>
                <table id='tableDiscount' class='table'>
                  <thead class='text-center text-white' style='background: #138c9f;'>
                    <tr>
                      <th colspan=' 2'>Rates/Packes</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class='pl-0'>
                      </td>
                      <td class='pr-0'>
                        <button class='btn btn-info btn-sm w-100' data-toggle='modal'
                          data-target='#modalPromoCode'><i class='fas fa-barcode'></i> Promo Code</button>
                      </td>
                    </tr>
                    <tr>
                      <td id='specialDiscount'></td>
                      <td id='promoCode'></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class='table-responsive'>
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
          <div class='ContentClientPayment w-100 pt-3 border-dashed-top'>
            <div class='row'>
              <div class='table-responsive'>
                <table class='table' id='tableAttachGuests'>
                  <thead class='bg-info text-white'>
                    <tr>
                      <th>
                        <div class='custom-control custom-checkbox'>
                          <input type='checkbox' id='selectClient' class='custom-control-input'>
                          <label for='selectClient' class='custom-control-label'></label>
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
                        <div class='custom-control custom-checkbox'>
                          <input type='checkbox' id='selectClient1' class='custom-control-input'>
                          <label for='selectClient' class='custom-control-label'></label>
                        </div>
                      </td>
                      <td>800021</td>
                      <td>
                        <select id='roomType' class='custom-select custom-select-user'>
                          <option value=''>Standar Room</option>
                          <option value=''>Deluxe Room</option>
                          <option value=''>Superior Room</option>
                        </select>
                      </td>
                      <td>
                        <select id='rooms' class='custom-select custom-select-user'>
                          <option value='' selected disabled>Assign</option>
                        </select>
                      </td>
                      <td id='guestName'>Jose Polanco</td>
                      <td>809-663-3315</td>
                      <td>
                        <select id='numberOfAdult' class='custom-select'></select>
                      </td>
                      <td>
                        <select id='numberOfChild' class='custom-select'></select>
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
            <div class='row mt-2'>
              <div class='col-md-8'>
                <div class='row'>
                  <button class='btn btn-outline-primary mx-1'><i class='fas fa-list'></i> Guest List</button>
                  <button class='btn btn-outline-primary mx-1'><i class='fas fa-check-circle'></i> Auto Asssign
                    Selected Room(s)</button>
                  <button class='btn btn-outline-primary mx-1'><i class='fas fa-user'></i> Manage Occupancy</button>
                  <button class='btn btn-outline-primary mx-1'><i class='fas fa-hand-holding-usd'></i> Tax
                    Exempt</button>
                </div>
                <div class='row mt-4'>
                  <button class='btn btn-primary mx-1'><i class='fas fa-plus'></i> Add New Room(s)</button>
                  <button class='btn btn-danger mx-1'><i class='fas fa-times'></i> Cancel selected</button>
                </div>
              </div>
              <div class='col-md-4'>
                <table class='table text-right'>
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
                    <tr class='bg-info text-white'>
                      <th>Total Amount</th>
                      <td>$ 1380.00</td>
                    </tr>
                    <tr class='bg-info text-white'>
                      <td>Paid</td>
                      <td>0.00</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class='row tab-pane-footer'>
          <div class='col-md-12'>
            <button class='btn btn-light mx-1'>Group Cancel</button>
            <button id='groupPaidBill' class='btn btn-light mx-1'>Group Payment</button>
          </div>
        </div>
      </div>";
      $content = 
      ("<div class='tab-pane' id='client{$data['id']}'  data-id='{$data['id']}'  role='tabpanel' aria-labelledby='client{$data['id']}-tab'><div class='col-md-12 p-0'>
        <div class='row p-3' id='headerClientDetails'>
          <div class='col-md-3'>
            <label for='roomType'>Room Type</label>
            <select id='roomType' class='custom-select'>
              ".$roomTypeList."
            </select>
          </div>
          <div class='col-md-5'>
            <label for='rooms'>Room</label>
            <div class='input-group'>
              <select id='rooms' class='custom-select'>".$roomList."</select>
              <div class='input-group-prepend'>
                <div class='input-group-text'>
                  <div class='custom-control custom-checkbox'>
                    <input type='checkbox' class='custom-control-input' assingRoom='' id='assingRoom{$data['id']}'>
                    <label for='assingRoom{$data['id']}' class='custom-control-label'>Assign Rooms</label>
                  </div>
                </div>
              </div>
            </div>
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
                  <tr>
                    <th id='GguestDetails'>Name: <span>Anastacia Grey</span></th>
                    <th></th>
                  </tr>
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
                <button class='btn btn-danger btn-sm m-2 removeItem' data-message='guest'><i class='fas fa-times'></i>
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
            <div class='table-responsive'>
              <div class='row my-1'>
                <span><b>Room Sharers</b></span>
                <button class='btn btn-primary btn-sm ml-auto' data-toggle='modal' data-target='#managerSharers'><i
                    class='fas fa-clipboard-list'></i> Manage
                  Sharer(s)</button>
              </div>
              <table class='table table-striped text-center'>
                <thead class='thead-dark'>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Date</th>
                  <th>Nights</th>
                  <th>Type</th>
                  <th>Charge action</th>
                </thead>
                <tbody>
                  <td>00001</td>
                  <td>Anastacia Grey</td>
                  <td>2020/07/30</td>
                  <td>4</td>
                  <td>Adult</td>
                  <td>
                    <button class='btn btn-outline-primary btn-sm'><i class='fas fa-pencil-alt'></i></button>
                    <button class='btn btn-outline-danger btn-sm removeItem' data-message='guest'><i
                        class='fas fa-trash'></i></button>
                  </td>
                </tbody>
              </table>
            </div>
            <div class='custom-control custom-checkbox'>
              <input type='checkbox' class='custom-control-input' sendMailConfirmation='' value='off' id='sendMailConfirmation{$data['id']}'>
              <label class='custom-control-label' for='sendMailConfirmation{$data['id']}'>Send confirmation Email </label>
            </div>
            <div class='row'>
              <div class='col-md-4 align-self-center'>
                <b>Preferences</b>
              </div>
              <div class='col-md-8 text-right'>
                <button class='btn btn-outline-success' id='btnOpenMessage' data-toggle='modal'
                  data-target='#MessagesAndTasks'>Mensajes
                  <span class='badge badge-danger'>2</span></button>
                <button class='btn btn-outline-info' id='btnOpenTask' data-toggle='modal'
                  data-target='#MessagesAndTasks'>Tasks <span class='badge badge-danger'>4</span></button>
              </div>
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
  
              <div id='guestsPreferences' class='guestsPreferences col-md-12 mt-3'>
                <div class=''>
                  <table class='table-striped w-100'>
                    <thead>
                      <th class='py-2' colspan='2'>Guests Prefereces <button class='btn' data-toggle='collapse'
                          data-target='#tableGuestsPreferences'><i class='fas fa-eye'></i></button></th>
                    </thead>
                    <tbody id='tableGuestsPreferences' class='collapse'>
                      <tr>
                        <td class='col-sm-4'><b>For: </b><span>Anastacia Grey</span></td>
                        <td class='col-sm-8 text-secondary'>Platano pollo, giusao</td>
                      </tr>
                      <tr>
                        <td class='col-sm-4'><b>For: </b><span>Anastacia Grey</span></td>
                        <td class='col-sm-8 text-secondary'>Platano pollo, giusao</td>
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
                    <input type='date' id='checkIn' class='form-control inputCalendar px-2'>
                  </div>
                  <div class='col-md-6 p-0 pl-1'>
                    <label for='checkOut'>Check-out</label>
                    <input type='date' id='checkOut' class='form-control inputCalendar px-2'>
                  </div>
                </div>
  
                <div class='row mt-3'>
                  <label for='info'>Extra Bed</label>
                  <div class='input-group'>
                    <select name='' id='extraBed' class='custom-select'></select>
                    <div class='input-group-prepend'>
                      <button class='btn btn-primary rounded-right' data-toggle='modal'
                        data-target='#modalExtraBed'><i class='fas fa-edit'></i></button>
                    </div>
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
                        data-toggle='list' href='#list-arrival{$data['id']}' role='tab' aria-controls='arrival'>Arrival</a>
                      <a class='list-group-item list-group-item-action' id='list-departure-list' data-toggle='list'
                        href='#list-departure{$data['id']}' role='tab' aria-controls='departure'>Departure</a>
                    </div>
                  </div>
  
                  <div class='tab-content mt-3' id='nav-tabContent' style='background: none'>
                    <div class='tab-pane fade active show' id='list-arrival{$data['id']}' role='tabpanel'
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
  
                    <div class='tab-pane fade' id='list-departure{$data['id']}' role='tabpanel'
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
                      <input type='checkbox' class='custom-control-input' id='assignTask{$data['id']}'>
                      <label class='custom-control-label' for='assignTask{$data['id']}' data-toggle='collapse'
                        data-target='#selectAssignTask{$data['id']}'>Assign Task</label>
                    </div>
                  </div>
                  <div class='col p-1'>
                    <select id='selectAssignTask{$data['id']}' selectAssignTask='' class='custom-select collapse'>
                      <option value='' selected disabled>Select POS</option>
                    </select>
                  </div>
                </div>
                <div class='row mt-4 p-1'>
                  <div class='custom-control custom-checkbox custom-control-inline'>
                    <input type='checkbox' class='custom-control-input' sendMail='' id='sendMail{$data['id']}' />
                    <label class='custom-control-label' for='sendMail{$data['id']}'>Send Mail</span>
                  </div>
                </div>
              </div>
              <!-- Column3 -->
              <div id='content-paymentDetails' class='col-md-6 pt-3 content-paymentDetails'>
                <h5><b>Payment Details (USD $)</b></h5>
                <table class='table'>
                  <tbody>
                    <tr>
                      <td><b>Room tariff</b></td>
                      <td id='roomTariff' class='text-right'>$200.00</td>
                    </tr>
                    <tr>
                      <td class='text-info cursor-pointer' data-toggle='modal' data-target='#modalRoomTaxes'><b>Room
                          Taxes(es)</b></td>
                      <td id='roomTaxes' class='text-right'>$150.00</td>
                    </tr>
                    <tr>
                      <td class='text-info cursor-pointer' data-toggle='modal' data-target='#modalAddOnsCharges'>
                        <b>Add-ons</b></td>
                      <td id='addOns' class='text-right'>$0.00</td>
                    </tr>
                    <tr>
                      <td><b>Other Charger</b></td>
                      <td id='otherCharger' class='text-right'>$0.00</td>
                    </tr>
                    <tr>
                      <td class='text-info cursor-pointer' data-toggle='modal' data-target='#modalOtherRoomTaxes'>
                        <b>Other Tax(es)</b></td>
                      <td id='otherTax' class='text-right'>$0.00</td>
                    </tr>
                    <tr class='bg-info text-white'>
                      <td data-toggle='modal' data-target='#modalTotal' class='cursor-pointer'><b>Total</b></td>
                      <td id='total' class='text-right'>$<b>2,150.00</b></td>
                    </tr>
                    <tr>
                      <td><b>Amount paid</b></td>
                      <td id='amountPaid' class='text-right'>$0.00</td>
                    </tr>
                    <tr>
                      <td class='text-info cursor-pointer' data-toggle='modal' data-target='#modalDiscountDetails'>
                        <b>Discount</b></td>
                      <td id='discount' class='text-right'>$0.00</td>
                    </tr>
                    <tr>
                      <td class='text-info cursor-pointer' data-toggle='modal' data-target='#modalOtherDiscount'>
                        <b>Other Discount</b></td>
                      <td id='otherDiscount' class='text-right'>$0.00</td>
                    </tr>
                    <tr class='bg-secondary text-white'>
                      <td><b>Balance</b></td>
                      <td id='balance' class='text-right'><b>$2,150.00</b></td>
                    </tr>
                  </tbody>
                </table>
                <hr>
                <div class='container-fluid p-0'>
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
            <!--Table Rates/Packages-->
            <div id='ratesPackages' class='col-md-12 p-0 mt-4'>
              <table id='tableDiscount' class='table'>
                <thead class='text-center text-white' style='background: #138c9f;'>
                  <tr>
                    <th colspan=' 2'>Rates/Packes</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class='pl-0'>
                      <button class='btn btn-success btn-sm w-100' data-toggle='modal'
                        data-target='#modalSpecialDiscount'><i class='fas fa-percentage'></i> Apply Special
                        Discount</button>
                    </td>
                    <td class='pr-0'>
                      <button class='btn btn-info btn-sm w-100' data-toggle='modal' data-target='#modalPromoCode'><i
                          class='fas fa-barcode'></i> Promo Code</button>
                    </td>
                  </tr>
                  <tr>
                    <td id='specialDiscount'></td>
                    <td id='promoCode'></td>
                  </tr>
                </tbody>
              </table>
  
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
                    <td id='inclusions-Addons' class='text-dark inclusions-Addons' colspan='3'> <i>Airport</i> <i>Pickup</i> <i>Half Board: Breakfast</i> <i>Dinner</i> </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!--Table Split-->
            <div class='table-responsive mt-4'>
              <div class='row py-2 m-0 px-2' style='background: #272b2f;'>
                <b class='align-self-center text-white'>Split reservation</b>
                <span class='ml-auto'>
                  <button class='btn btn-success btn-sm margin' data-toggle='modal'
                    data-target='#modalAddSplitReservation'>Add Split Reservation</button>
                  <button class='btn btn-info btn-sm margin-left-auto' data-toggle='modal'
                    data-target='#modalExtendSplitReservation'>Extend Split</button>
                </span>
              </div>
              <table id='tableSplitReservation' class='table text-center'>
                <thead class='thead-dark'>
                  <tr>
                    <th>Room Type</th>
                    <th>Date</th>
                    <th>Room</th>
                    <th>Nights</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Standar</td>
                    <td>2020/07/03 - 2020/07/04</td>
                    <td>
                      <select class='custom-select custom-select-user' id='changeRroom'>
                        <option value=''>STD-12</option>
                      </select>
                    </td>
                    <td>2</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class='row tab-pane-footer'>
        <div class='col-md-12'>
          <button class='btn btn-light mx-1'>Cancel</button>
          <button id='paidBill' class='btn btn-light mx-1'>Payment</button>
        </div>
        </div>
        </div>
      </div>");
      $datos = array(
        'tab-pane' => $content, 
        'name' => 'Anastacia Grey',
        'navTab' => "<li class='nav-item' data-remove='client{$data['id']}'><a class='nav-link' id='client{$data['id']}-tab' data-id='{$data['id']}' data-toggle='tab' href='#client{$data['id']}' role='tab' aria-controls='client'
        aria-selected='false'><i style='height: 10px;width: 10px;background: red;' class='badge d-inline-block'></i> Jose Lamarche <button type='button' id='tabClose' data-id='client{$data['id']}' class='close ml-1' aria-label='Close'>
        <span aria-hidden='true'>×</span> </button></a></li>"
      );
      return $datos;
    }
    protected function GroupReservation(){
      $countries = Country::all();
      $salutations = Salutation::all();
      $collectionSalutions = "";
      $collectionCountries = "";
      foreach($salutations as $item){
        $collectionSalutions .=  "<option value='$item->id'>$item->name</option>";
      }
      foreach($countries as $country){
          $collectionCountries .= "<option value='$country->id'>$country->country_name</option>";
      }
      $content = 
      "<div class='tab-pane' id='groupReservation' role='tabpanel' aria-labelledby='groupReservation-tab'>
        <div id='createGroupReservation' class='col-md-12 p-0'>
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
                <div class='row'>
                  <label for='groupOwner'>Group Owner</label>
                  <select id='groupOwner' class='custom-select' autocomplete='false'>
                    <option value='travel_agent'>Travel Agent</option>
                    <option value='corporate'>Corporate</option>
                    <option value='other'>Other</option>
                  </select>
                </div>
                <div id='contentTypeClient' class='col-12 px-0 mt-2'>
                  
                </div>
                <div class='row mt-2'>
                  <h5><b>Address And Contact Details</b></h5>
                  <br>
                  <div class='col-md-8 px-1'>
                    <label for='addressLine'>Address Line</label>
                    <input type='text' class='form-control'>
                  </div>
                  <div class='col-md-4 px-1'>
                    <label for='city'>City</label>
                    <input type='text' class='form-control'>
                  </div>
                </div>
                <div class='row mt-2'>
                  <div class='col-md-4 px-1'>
                    <label for='country'>Country</label>
                    <select id='country' class='custom-select'>
                    ".$collectionCountries."
                    </select>
                  </div>
                  <div class='col-md-4 px-1'>
                    <label for='state'>State</label>
                    <select id='state' class='custom-select'></select>
                  </div>
                  <div class='col-md-4 px-1'>
                    <label for='zipCode'>Zip Code</label>
                    <input type='text' id='zipCode' class='form-control'>
                  </div>
                </div>
                <div class='row mt-2'>
                  <div class='col-md-4 px-1'>
                    <label for='Phone'>Phone</label>
                    <div class='input-group'>
                      <div class='input-group-prepend'>
                        <div class='input-group-text'>
                          <span><i class='fas fa-phone'></i></span>
                        </div>
                      </div>
                      <input type='number' id='phone' class='form-control'>
                    </div>
                  </div>
                  <div class='col-md-4 px-1'>
                    <label for='mobile'>Mobile</label>
                    <div class='input-group'>
                      <div class='input-group-prepend'>
                        <div class='input-group-text'>
                          <span><i class='fas fa-mobile-alt'></i></span>
                        </div>
                      </div>
                      <input type='number' id='mobile' class='form-control'>
                    </div>
                  </div>
                  <div class='col-md-4 px-1'>
                    <label for='fax'>Fax</label>
                    <div class='input-group'>
                      <div class='input-group-prepend'>
                        <div class='input-group-text'>
                          <i class='fas fa-fax'></i>
                        </div>
                      </div>
                      <input type='text' id='fax' class='form-control'>
                    </div>
                  </div>
                </div>
                <div class='row mt-2'>
                  <button class='btn btn-outline-primary ml-auto' data-toggle='modal' data-target=''><i
                      class='fas fa-save'></i> Save & Add More</button>
                </div>
              </section>
              <hr>
              <div class='custom-control custom-checkbox'>
                <input type='checkbox' class='custom-control-input' sendMailConfirmation='' value='off'
                  id='sendMailConfirmationGroupReservation'>
                <label class='custom-control-label' for='sendMailConfirmationGroupReservation'>Send confirmation Email
                </label>
              </div>
              <div class='row'>
                <div class='col-md-12 mt-3'>
                  <textarea id='textPreferences' class='form-control' rows='6'></textarea>
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
                      <input type='date' id='checkIn' class='form-control inputCalendar px-2'>
                    </div>
                    <div class='col-md-6 p-0 pl-1'>
                      <label for='checkOut'>Check-out</label>
                      <input type='date' id='checkOut' class='form-control inputCalendar px-2'>
                    </div>
                  </div>

                  <div class='row mt-3'>
                    <label for='purpose'>Purpose</label>
                    <input type='text' id='purpose' class='form-control' id='purpose'>
                  </div>
                  <div class='row mt-3'>
                    <label for='sources'>Sources</label>
                    <select id='sources' class='custom-select'></select>
                  </div>
                  <div class='row mt-3'>
                    <label for='type'>Type</label>
                    <select id='type' class='custom-select'></select>
                  </div>
                  <div class='row mt-3'>
                    <label for='mktSmgt'>Mkt Smgt</label>
                    <select id='mktSmgt' class='custom-select'></select>
                  </div>
                  <div class='row mt-3'>
                    <label for='salesPerson'>Sales person</label>
                    <select id='salesPerson' class='custom-select'></select>
                  </div>

                  <div class='section-ArrivalOrDeparture'>
                    <div class='row mt-3'>
                      <div class='list-group flex-row text-center w-100' id='list-tab' role='tablist'>
                        <a class='list-group-item list-group-item-action active' id='list-arrival-list'
                          data-toggle='list' href='#list-arrivalGroupReservation' role='tab'
                          aria-controls='arrival'>Arrival</a>
                        <a class='list-group-item list-group-item-action' id='list-departure-list' data-toggle='list'
                          href='#list-departureGroupReservation' role='tab' aria-controls='departure'>Departure</a>
                      </div>
                    </div>

                    <div class='tab-content mt-3' id='nav-tabContent' style='background: none'>
                      <div class='tab-pane fade active show' id='list-arrivalGroupReservation' role='tabpanel'
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

                      <div class='tab-pane fade' id='list-departureGroupReservation' role='tabpanel'
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
                        <input type='checkbox' class='custom-control-input' id='assignTaskGroupReservation'>
                        <label class='custom-control-label' for='assignTaskGroupReservation' data-toggle='collapse'
                          data-target='#selectAssignTask{GroupReservation'>Assign Task</label>
                      </div>
                    </div>
                    <div class='col p-1'>
                      <select id='selectAssignTaskGroupReservation' selectAssignTask='' class='custom-select collapse'>
                        <option value='' selected disabled>Select POS</option>
                      </select>
                    </div>
                  </div>
                  <div class='row mt-4 p-1'>
                    <div class='custom-control custom-checkbox custom-control-inline'>
                      <input type='checkbox' class='custom-control-input' sendMail='' id='sendMailGroupReservation' />
                      <label class='custom-control-label' for='sendMailGroupReservation'>Send Mail</span>
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
              <div id='payTerm' class='col-md-12 py-1' style='background: #E4F0FE;'>
                <div class='row'>
                  <select id='' class='custom-select custom-select-user'>
                    <option value=''>Balance To be Paid by Group Owner</option>
                  </select>
                </div>
                <div class='row px-3'>
                  <div class='custom-control custom-checkbox custom-control-inline'>
                    <input type='checkbox' class='custom-control-input' id='otherCharges-payTermGroupReservation'>
                    <label class='custom-control-label' for='otherCharges-payTermGroupReservation'>Including Other
                      Charges</label>
                  </div>
                  <button class='btn btn-outline-primary btn-sm ml-auto list-item-collapse' data-toggle='collapse'
                    data-target='#setLimit'>Set Limit&nbsp;</button>
                </div>
                <div id='setLimit' class='row px-3 py-2 collapse'>
                  <div class='custom-control custom-checkbox custom-control-inline  ml-auto'>
                    <input type='checkbox' class='custom-control-input' id='inclusiveTax-payTermGroupReservation'>
                    <label class='custom-control-label' for='inclusiveTax-payTermGroupReservation'>Inclusive of
                      Tax</label>
                  </div>
                  <button class='btn btn-outline-primary btn-sm ml-2 list-item-collapse' data-toggle='collapse'
                    data-target='#editLimits'>Edit Details&nbsp;</button>
                </div>
                <div id='setLimit' class='row py-2 collapse'>
                  <div class='col d-flex'>
                    $<input type='text' class='form-control form-control-sm'>
                  </div>
                  <div class='col'>
                    <select id='per?' class='custom-select custom-select-sm'>
                      <option value=''>Per Room</option>
                    </select>
                  </div>
                  <div class='col align-self-center'>
                    <div class='custom-control custom-checkbox custom-control-inline  ml-auto'>
                      <input type='checkbox' class='custom-control-input' id='perNight-payTermGroupReservation'>
                      <label class='custom-control-label' for='perNight-payTermGroupReservation'>Per Night</label>
                    </div>
                  </div>
                </div>
                <div id='editLimits' class='col-md-12 py-2 collapse'>
                  <hr>
                  <div id='customRoomTariff' class='row'>
                    <div class='col-md-4'>
                      <label for='roomFieldRoomTariffTariff'>Room Tariff</label>
                      <input type='text' id='FieldRoomTariff' class='form-control form-control-sm'>
                    </div>
                    <div class='col-md-4 align-self-end'>
                      <div class='custom-control custom-checkbox custom-control-inline  ml-auto'>
                        <input type='checkbox' class='custom-control-input' id='TariffPerNight-payTermGroupReservation'>
                        <label class='custom-control-label' for='TariffPerNight-payTermGroupReservation'>Per
                          Night</label>
                      </div>
                    </div>
                    <div class='col-md-4 align-self-end'>
                      <div class='custom-control custom-checkbox custom-control-inline  ml-auto'>
                        <input type='checkbox' class='custom-control-input' id='TariffPerPerson-payTermGroupReservation'>
                        <label class='custom-control-label' for='TariffPerPerson-payTermGroupReservation'>Per
                          Person</label>
                      </div>
                    </div>
                  </div>
                  <div id='addonsTariff' class='row'>
                    <div class='col-md-4'>
                      <label for='FieldAddonsTariff'>Add-ons Tariff</label>
                      <input type='text' id='FieldAddonsTariff' class='form-control form-control-sm'>
                    </div>
                    <div class='col-md-4 align-self-end'>
                      <div class='custom-control custom-checkbox custom-control-inline  ml-auto'>
                        <input type='checkbox' class='custom-control-input' id='addonsPerNight-payTermGroupReservation'>
                        <label class='custom-control-label' for='addonsPerNight-payTermGroupReservation'>Per
                          Night</label>
                      </div>
                    </div>
                    <div class='col-md-4 align-self-end'>
                      <div class='custom-control custom-checkbox custom-control-inline  ml-auto'>
                        <input type='checkbox' class='custom-control-input' id='addonsPerPerson-payTermGroupReservation'>
                        <label class='custom-control-label' for='addonsPerPerson-payTermGroupReservation'>Per
                          Person</label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!--Table Rates/Packages-->
              <div id='ratesPackages' class='col-md-12 p-0 mt-4'>
                <div class='table-responsive'>
                  <table id='tableDiscount' class='table'>
                    <thead class='text-center text-white' style='background: #138c9f;'>
                      <tr>
                        <th colspan=' 2'>Rates/Packes</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class='pl-0'>
                        </td>
                        <td class='pr-0'>
                          <button class='btn btn-info btn-sm w-100' data-toggle='modal' data-target='#modalPromoCode'><i
                              class='fas fa-barcode'></i> Promo Code</button>
                        </td>
                      </tr>
                      <tr>
                        <td id='specialDiscount'></td>
                        <td id='promoCode'></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class='table-responsive'>
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
            <div class='ContentClientPayment w-100 pt-3 border-dashed-top'>
              <div class='row'>
                <div class='table-responsive'>
                  <table class='table table-checkList' id='tableAttachGuests'>
                    <thead class='bg-info text-white'>
                      <tr>
                        <th>
                          <div class='custom-control custom-checkbox'>
                            <input type='checkbox' id='selectClientGroupReservation' class='custom-control-input' value='off' autocomplete='false'>
                            <label for='selectClientGroupReservation' class='custom-control-label'></label>
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
                          <div class='custom-control custom-checkbox'>
                            <input type='checkbox' id='selectClient1' class='custom-control-input' autocomplete='false'>
                            <label for='selectClient1' class='custom-control-label'></label>
                          </div>
                        </td>
                        <td>800021</td>
                        <td>
                          <select id='roomType' class='custom-select custom-select-user'>
                            <option value=''>Standar Room</option>
                            <option value=''>Deluxe Room</option>
                            <option value=''>Superior Room</option>
                          </select>
                        </td>
                        <td>
                          <select id='rooms' class='custom-select custom-select-user'>
                            <option value='' selected disabled>Assign</option>
                          </select>
                        </td>
                        <td id='guestName'>Jose Polanco</td>
                        <td>809-663-3315</td>
                        <td>
                          <select id='numberOfAdult' class='custom-select'></select>
                        </td>
                        <td>
                          <select id='numberOfChild' class='custom-select'></select>
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
              <div class='row mt-2'>
                <div class='col-md-8'>
                  <div class='row'>
                    <button class='btn btn-outline-primary mx-1'><i class='fas fa-list'></i> Guest List</button>
                    <button class='btn btn-outline-primary mx-1'><i class='fas fa-check-circle'></i> Auto Asssign
                      Selected Room(s)</button>
                    <button class='btn btn-outline-primary mx-1'><i class='fas fa-user'></i> Manage Occupancy</button>
                    <button class='btn btn-outline-primary mx-1'><i class='fas fa-hand-holding-usd'></i> Tax
                      Exempt</button>
                  </div>
                  <div class='row mt-4'>
                    <button class='btn btn-primary mx-1'><i class='fas fa-plus'></i> Add New Room(s)</button>
                    <button class='btn btn-danger mx-1'><i class='fas fa-times'></i> Cancel selected</button>
                  </div>
                </div>
                <div class='col-md-4'>
                  <table class='table text-right'>
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
                      <tr class='bg-info text-white'>
                        <th>Total Amount</th>
                        <td>$ 1380.00</td>
                      </tr>
                      <tr class='bg-info text-white'>
                        <td>Paid</td>
                        <td>0.00</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class='row tab-pane-footer'>
            <div class='col-md-12'>
              <button id='reserve' class='btn btn-light mx-1'>Reserve</button>
              <button id='holdTill' class='btn btn-light mx-1'>Hold Till</button>
              <button id='tempReserv' class='btn btn-light mx-1'>Temp Reserv</button>             
              <button id='groupPaidBill' class='btn btn-light mx-1'>Group Payment</button>
            </div>
          </div>
        </div>
      </div>";
      $datos = array(
        'tab-pane' => $content,
        'navTab' => "<li class='nav-item' data-remove='groupReservation'>
          <a class='nav-link' id='groupReservation-tab' data-id='groupReservation' data-toggle='tab' href='#groupReservation' role='tab'
            aria-controls='groupReservation' aria-selected='true'>Group Reservation <button type='button' data-id='groupReservation'
              id='tabClose' class='close ml-1' aria-label='Close'>
              <span aria-hidden='true'>×</span>
            </button></a>
        </li>"
      );
      return $datos;
    }
    protected function CreateTypeReservation($type){
      $countries = Country::all();
      $salutations = Salutation::all();
      $collectionSalutions = "";
      $collectionCountries = "";
      foreach($salutations as $item){
        $collectionSalutions .=  "<option value='$item->id'>$item->name</option>";
      }
      foreach($countries as $country){
          $collectionCountries .= "<option value='$country->id'>$country->country_name</option>";
      }
      if($type == "travel_agent"){
        $content = 
        "<div id='agentReservation'>
          <div class='row mt-2'>
            <div class='dropdown w-100'>
              <label for='travelAgent'>Travel Agent</label>
              <input class='form-control dropdown-toggle' type='text' id='dropdownMenuButton'
                data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
              <div class='dropdown-menu w-100' aria-labelledby='dropdownMenuButton'>
                <ul class='list-group list-group-flush cursor-pointer'>
                  <li class='list-group-item list-group-item-action'>J&B Performance</li>
                  <li class='list-group-item list-group-item-action'>Avaya System</li>
                </ul>
              </div>
            </div>
          </div>
          <div class='row mt-2'>
            <h5><b>Travel Agent Details</b></h5>
            <br>
            <div class='col-md-12 px-1'>
              <label for='companyName'>Company Name<i class='text-danger'>*</i></label>
              <input type='text' id='companyName' class='form-control'>
            </div>
          </div>
          <div class='row mt-2'>
            <div class='col-md-2 px-1'>
              <label for='title'>Title<i class='text-danger'>*</i></label>
              <select id='title' class='custom-select'>
              ".$collectionSalutions."
              </select>
            </div>
            <div class='col-md-3 px-1'>
              <label for='firstName'>First Name<i class='text-danger'>*</i></label>
              <input type='text' id='firstName' class='form-control'>
            </div>
            <div class='col-md-3 px-1'>
              <label for='lastName'>Last Name<i class='text-danger'>*</i></label>
              <input type='text' id='lastName' class='form-control'>
            </div>
            <div class='col-md-4 px-1'>
              <label for='email'>Email<i class='text-danger'>*</i></label>
              <input type='text' id='email' class='form-control'>
            </div>
          </div>
        </div>";
        $datos  = array(
          "content" => $content
        );
        return $datos;
      }
      elseif($type == "corporate"){
        $content = 
        "<div id='corporateReservation'>
          <div class='row mt-2'>
            <div class='dropdown w-100'>
              <label for='corporate'>Corporate</label>
              <input class='form-control dropdown-toggle' type='text' id='dropdownMenuButton'
                data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
              <div class='dropdown-menu w-100' aria-labelledby='dropdownMenuButton'>
                <ul class='list-group list-group-flush cursor-pointer'>
                  <li class='list-group-item list-group-item-action'>J&B Performance</li>
                  <li class='list-group-item list-group-item-action'>Avaya System</li>
                </ul>
              </div>
            </div>
          </div>
          <div class='row mt-2'>
            <h5><b>Corporate Details</b></h5>
            <br>
            <div class='col-md-12 px-1'>
              <label for='companyName'>Company Name<i class='text-danger'>*</i></label>
              <input type='text' id='companyName' class='form-control'>
            </div>
          </div>
          <div class='row mt-2'>
            <div class='col-md-2 px-1'>
              <label for='title'>Title<i class='text-danger'>*</i></label>
              <select id='title' class='custom-select'>
              ".$collectionSalutions."
              </select>
            </div>
            <div class='col-md-3 px-1'>
              <label for='firstName'>First Name<i class='text-danger'>*</i></label>
              <input type='text' id='firstName' class='form-control'>
            </div>
            <div class='col-md-3 px-1'>
              <label for='lastName'>Last Name<i class='text-danger'>*</i></label>
              <input type='text' id='lastName' class='form-control'>
            </div>
            <div class='col-md-4 px-1'>
              <label for='email'>Email<i class='text-danger'>*</i></label>
              <input type='text' id='email' class='form-control'>
            </div>
          </div>
          <div class='row my-2'>
            <button id='eligibleForDiscount' class='btn btn-outline-primary ml-auto'><i
                class='fas fa-percent'></i> Eligible for Discount</button>
          </div>
        </div>";
        $datos  = array(
          "content" => $content
        );
        return $datos;
      }
      elseif($type == "other"){
        $content = 
        "<div id='otherReservation'>
            <div class='row mt-2'>
              <div class='dropdown w-100'>
                <label for='other'>Other</label>
                <input class='form-control dropdown-toggle' type='text' id='dropdownMenuButton'
                  data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                <div class='dropdown-menu w-100' aria-labelledby='dropdownMenuButton'>
                  <ul class='list-group list-group-flush cursor-pointer'>
                    <li class='list-group-item list-group-item-action'>J&B Performance</li>
                    <li class='list-group-item list-group-item-action'>Avaya System</li>
                  </ul>
                </div>
              </div>
            </div>
            <div class='row mt-2'>
              <h5 class='w-100'><b>Guest Information</b></h5>
              <br>
              <div class='col-md-2 px-1'>
                <label for='title'>Title<i class='text-danger'>*</i></label>
                <select id='title' class='custom-select'>
                  ".$collectionSalutions."
                </select>
              </div>
              <div class='col-md-3 px-1'>
                <label for='firstName'>First Name<i class='text-danger'>*</i></label>
                <input type='text' id='firstName' class='form-control'>
              </div>
              <div class='col-md-3 px-1'>
                <label for='lastName'>Last Name<i class='text-danger'>*</i></label>
                <input type='text' id='lastName' class='form-control'>
              </div>
              <div class='col-md-4 px-1'>
                <label for='nationality'>Nationality<i class='text-danger'>*</i></label>
                <select id='nationality' class='custom-select'>
                  ".$collectionCountries."
                </select>
              </div>
            </div>
            <div class='row mt-2'>
              <div class='col-md-2 px-1'>
                <label for='gender'>Gender</label>
                <select id='gender' class='custom-select'></select>
              </div>
              <div class='col-md-3 px-1'>
                <label for='birthDay'>Date of Birthday</label>
                <input type='date' id='birthDay' class='form-control inputCalendar'>
              </div>
              <div class='col-md-7 px-1'>
                <label for='email'>Email</label>
                <input type='email' id='email' class='form-control'>
              </div>
            </div>
        </div>";
        $datos  = array(
          "content" => $content
        );
        return $datos;
      }
    }
    protected function ViewFolio($data){
      $content = 
      "<div id='contentFolio' class='col-md-12 p-5'>
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
                                        <input type='checkbox' id='Tfolio{$data['id']}' autocomplete='false'
                                            class='custom-control-input' value='off'>
                                        <label for='Tfolio{$data['id']}' class='custom-control-label'></label>
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
                                        <input type='checkbox' id='TItemFlio{$data['id']}1' class='custom-control-input'
                                            disabled value='off'>
                                        <label for='TItemFlio{$data['id']}1' class='custom-control-label'></label>
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
                                        <input type='checkbox' id='TItemFlio{$data['id']}2' class='custom-control-input'
                                            value='off'>
                                        <label for='TItemFlio{$data['id']}2' class='custom-control-label'></label>
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
      </div>";
      $datos = array(
        'content' => $content
      );
      return $datos;
    }
    protected function WorkArea(Request $request){
      if($request->workAreaType == "room"){
        $rooms = $this->Rooms($request);
        $options = "";
        foreach($rooms['roomType'] as $roomType){
          $options .= "<option value='$roomType->id' disabled class='light-gray font-weight-bold'>$roomType->name</option>";
          foreach($rooms['rooms'] as $room){
            if($roomType->id == $room->room_type_id){
              $options .= "<option value='$room->id'>$room->name</option>";
            }
          }
        }
        $datos = array(
          "options" => $options
        );
        return $datos;
      }
      else if($request->workAreaType == "other"){
        $options = "";
        $datos = array(
          "options" => $options
        );
        return $datos;
      }
    }
    function destroy(){
        
    }
}
