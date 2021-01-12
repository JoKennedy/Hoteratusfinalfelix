<?php

namespace App\Http\Controllers;

use App\DefaultSetting;
use App\FrontDeskPackage;
use App\FrontDeskPackageActivationDate;
use App\FrontDeskPackageRoom;
use App\FrontDeskPackageUpcharge;
use App\Hotel;
use App\PackagesMaster;
use App\RoomType;
use Facade\Ignition\Support\Packagist\Package;
use Illuminate\Foundation\PackageManifest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontDeskPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $hotel_id = $request->session()->get('hotel_id');
        if ($request->ajax()) {

            $packagesMaster = FrontDeskPackage::with('front_desk_package_activation_dates')->where('hotel_id', $hotel_id);
            if ($request->active != '') {
                $packagesMaster->where('active',  $request->active);
            }

            return datatables()->of($packagesMaster)
                ->addColumn('btn', 'pages.frontdeskpackage.actions')
                ->addColumn('status', 'pages.frontdeskpackage.status')
                ->addColumn('staylength', 'pages.frontdeskpackage.staylength')
                ->addColumn('pricelist',function (FrontDeskPackage $frontDeskPackage) {
                    return '<a onclick="pricelist('."'$frontDeskPackage->name','$frontDeskPackage->id'".')" style="color:blue;" href="javascript:void(0)">Price List</a>';
                })

                ->addColumn('activation', function(FrontDeskPackage $frontDeskPackage){
                    return $frontDeskPackage->activation_dates_str();
                })
                ->addColumn('sortorder', '<input value="{{$sort_order}}" onkeypress="return isNumberKey(event)" style="width:50px;" type="text" class="browser-default" >')
                ->addColumn('featured', 'pages.frontdeskpackage.featured')
                ->rawColumns(['btn', 'status', 'activation', 'staylength', 'sortorder', 'featured', 'pricelist'])
                ->make();
        } else {
            $room = RoomType::where('hotel_id', $hotel_id)->where('active', 1)->orderBy('higher_occupancy', 'desc')->first();
            return view('pages.frontdeskpackage.index', compact('room') );
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $hotel_id = $request->session()->get('hotel_id');
        $packageList = array();
        $user = Auth::user();
        if ($request->master){
            $packageList = PackagesMaster::with('packages_master_rooms', 'inclusions', 'packages_master_rooms.packages_master_upcharges')
            ->where('hotel_id', $hotel_id)->whereIn('id', array_keys($request->master))->get();

            foreach($packageList as $key => $value) {

                $frontDeskPackage = FrontDeskPackage::create([
                    'hotel_id' => $value->hotel_id,
                    'user_id' => $user->id,
                    'name' => $value->name,
                    'code' => time().$value->code,
                    'stay_length' => $value->stay_length,
                    'description' => $value->description,
                    'active' => 2
                    ]);

                foreach ($value->packages_master_rooms as  $value2) {

                    $frontDeskPackageRoom = FrontDeskPackageRoom::create([
                        'user_id' => $user->id,
                        'front_desk_package_id'=> $frontDeskPackage->id,
                        'room_type_id' => $value2->room_type_id,
                    ]);
                    $frontDeskPackageRoom->front_desk_package_room_prices()->create([
                        'user_id' => $user->id,
                        'base_price' => $value2->base_price,
                        'extra_person' => $value2->extra_person,
                        'extra_bed' => $value2->extra_bed,
                        'adults_minimum' => $value2->adults_minimum,
                        'children_minimum' => $value2->children_minimum,
                    ]);
                    foreach ($value2->packages_master_upcharges as $value3) {
                        FrontDeskPackageUpcharge::create([
                            'front_desk_package_room_id' => $frontDeskPackageRoom->id,
                            'user_id' => $user->id,
                            'persons' => $value3->persons,
                            'adults' => $value3->adults,
                            'children' => $value3->children,
                        ]);
                    }
                }

                foreach ($value->inclusions as $key4 => $value4) {
                    $frontDeskPackage->inclusions()->attach($value4->id);
                }
            }
        }

        return response()->json(['success' => true], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FrontDeskPackage  $frontDeskPackage
     * @return \Illuminate\Http\Response
     */
    public function show(FrontDeskPackage $frontDeskPackage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FrontDeskPackage  $frontDeskPackage
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $frontDeskPackage = FrontDeskPackage::with('front_desk_package_rooms', 'front_desk_package_rooms.front_desk_package_room_prices')->findOrFail($id);
        
        $hotel = Hotel::with('default_setting', 'cancellation_policies', 'booking_policies', 'season_attributes', 
            'seasons',  'discount_early_birds', 'discount_early_birds.discount_early_bird_details',
            'discount_last_minutes', 'discount_last_minutes.discount_last_minute_details',
            'discount_dynamic_pricings','discount_dynamic_pricings.discount_dynamic_pricing_details',
            'discount_long_stays',)
        ->where('id', $request->session()->get('hotel_id'))->first();
        return view('pages.frontdeskpackage.update', compact('frontDeskPackage', 'hotel' ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FrontDeskPackage  $frontDeskPackage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $frontDeskPackage = FrontDeskPackage::findOrFail($id);
        $frontDeskPackage->name = $request->name;
        $frontDeskPackage->code = $request->code;
        $frontDeskPackage->stay_length = $request->stay_length;
        $frontDeskPackage->description = $request->description;
        $frontDeskPackage->day_package = $request->day_package;
        $frontDeskPackage->days_valid_id = $request->days_valid_id;
        $frontDeskPackage->update_price = $request->update_price;
        $frontDeskPackage->prorated = $request->prorated;
        $frontDeskPackage->inclusive_tax = $request->inclusive_tax;
        $frontDeskPackage->travel_agency = $request->travel_agency;
        $frontDeskPackage->publish_ta = $request->publish_ta;
        $frontDeskPackage->travel_agent_commission = $request->travel_agent_commission;
        $frontDeskPackage->travel_agent_commission_type = $request->travel_agent_commission_type;
        $frontDeskPackage->corporate = $request->corporate;
        $frontDeskPackage->publish_corporate = $request->publish_corporate;
        $frontDeskPackage->corporate_discount = $request->corporate_discount??0;
        $frontDeskPackage->validity = $request->validity;
        $frontDeskPackage->season_attribute = 0;
        $frontDeskPackage->season_id = 0;
        $frontDeskPackage->special_period_id = 0;
        $frontDeskPackage->start_date = null;
        $frontDeskPackage->end_date = null;


        //Days
        $frontDeskPackage->package_weekdays()->delete();
        if($request->days_valid_id == 1){
            $frontDeskPackage->package_weekdays()->create($request->days);
        }

        //Validity Dates
        if($request->validity == 2){
            $frontDeskPackage->season_attribute = $request->season_attribute;
        }else if($request->validity == 3){
            $frontDeskPackage->start_date =  $request->start_date;
            $frontDeskPackage->end_date =  $request->end_date;
            $frontDeskPackage->season_id =  $request->season_date;
        } else if ($request->validity == 4) {
            $frontDeskPackage->season_id =  $request->season_id;
        } else if ($request->validity == 5) {
            $frontDeskPackage->special_period_id =  $request->special_period_id;
        }
        $frontDeskPackage->active = ($frontDeskPackage->active ==2?0: $frontDeskPackage->active);
        $frontDeskPackage->save();

        if ($request->file('image')) {
            foreach ($request->file('image') as $key => $value) {
                $frontDeskPackage->images()->create([
                    'url' => $value->store('frontdeskpackage', 'public'),
                    'caption' => $request->imagename[$key]
                ]);
            }
        }



        return redirect()->back()->with(['message_success'=> 'Package has been updated']);

/*

  "early_birds_validity" => array:2 [▶]
  "early_birds_start" => array:2 [▶]
  "early_birds_end" => array:2 [▶]
  "last_minute_validity" => array:5 [▶]
  "last_minute_start" => array:5 [▶]
  "last_minute_end" => array:5 [▶]
  "long_stay_validity" => array:4 [▶]
  "long_stay_start" => array:4 [▶]
  "long_stay_end" => array:4 [▶]
  "dynamic_validity" => array:3 [▶]
  "dynamic_start" => array:3 [▶]
  "dynamic_end" => array:3 [▶]
  "room_type" => array:2 [▶]
  "upcharge" => array:1 [▶]
  "inclusion_id" => array:2 [▶]
   */
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FrontDeskPackage  $frontDeskPackage
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $frontDeskPackage = FrontDeskPackage::find($id);
        $frontDeskPackage->active =  ($frontDeskPackage->active == 1 ? 0 : ($frontDeskPackage->active == 2? 1:1) );
        $frontDeskPackage->save();
        return response()->json($frontDeskPackage);
    }

    public function activationDate (Request $request){
        $frontDeskPackage = FrontDeskPackage::find($request->id);
        if ($request->activated_forever){
            $frontDeskPackage->activated_forever = 1;
            $frontDeskPackage->save();
            FrontDeskPackageActivationDate::where('front_desk_package_id', $request->id)->delete();
        }else{
            $frontDeskPackage->activated_forever = 0;
            $frontDeskPackage->save();
            $start = $this->formatDate($request->start);
            $end = $this->formatDate($request->end);
            if($request->date_id){
                $exists = FrontDeskPackageActivationDate::whereRaw("front_desk_package_id = $request->id
                    and id != $request->date_id and (start between '$start' and '$end' or  end between '$start' and '$end')
                ")->get();
                if ($exists->count() > 0) {
                    return response()->json(['success' => false, 'message' => 'Activation date cannot be overlaping.'], 200);
                }
                $frontDeskPackageActivationDate = FrontDeskPackageActivationDate::find($request->date_id);
                $frontDeskPackageActivationDate->start = $this->formatDate($request->start);
                $frontDeskPackageActivationDate->end = $this->formatDate($request->end);
                $frontDeskPackageActivationDate->save();
            }else{

                $exists = FrontDeskPackageActivationDate::where('front_desk_package_id', $request->id)
                ->whereBetween('start', [$start, $end])
                ->orWhereBetween('end', [$start, $end]);
                if($exists->count() > 0){
                    return response()->json(['success' => false, 'message' => 'Activation date cannot be overlaping.'], 200);
                }

                FrontDeskPackageActivationDate::create([
                    'front_desk_package_id' => $request->id,
                    'start' => $this->formatDate($request->start),
                    'end' => $this->formatDate($request->end),
                ]);
            }
        }

        return response()->json(['success' => true], 200);
    }
    public function deleteDate(Request $request){
        $date =   FrontDeskPackageActivationDate::find($request->date_id)->delete();

        return response()->json(['success' => true ], 200);
    }
    private function formatDate(string $date)
    {
        return substr($date, 6, 4) . '-' . substr($date, 3, 2) . '-' . substr($date, 0, 2);
    }
    public function featured($id)
    {
        $frontDeskPackage = FrontDeskPackage::find($id);
        $frontDeskPackage->featured =  ($frontDeskPackage->featured == 1 ? 0:1);
        $frontDeskPackage->save();
        return response()->json($frontDeskPackage);
    }
    public function pricelist(Request $request){
        $currency_symbol = $request->session()->get('currency_symbol', '$');
        $frontDeskPackage = FrontDeskPackage::with('front_desk_package_rooms',
        'front_desk_package_rooms.room_type',
        'front_desk_package_rooms.front_desk_package_upcharges','inclusions',
        'front_desk_package_rooms.front_desk_package_room_prices')
        ->where('id',$request->frontDeskPackageId)->first();
        $table = "";
        $maxAdult = RoomType::where('hotel_id', $request->session()->get('hotel_id') )->max('higher_occupancy');
        foreach ($frontDeskPackage->front_desk_package_rooms as $key => $value) {

            $table .= "<tr>
                <td style='padding: 5px !important;'>
                    <div class='col'>{$value->room_type->name} ({$value->room_type->code}) </div>
                    <div class='col'>
                            <div class='row'>Base(0): {$value->room_type->base_occupancy} " . ($value->room_type->base_occupancy > 1 ? ' People' : ' Person') . " </div>
                            <div class='row'>Max: {$value->room_type->higher_occupancy}" . ($value->room_type->higher_occupancy > 1 ?  ' People' : ' Person') . " </div>
                    </div>
                </td>";

                for ($i=0; $i <= $maxAdult; $i++) {
                    $table .= "<td> <div class='row'>". ($i > $value->room_type->higher_occupancy ? "--" :  "$currency_symbol". number_format($value->person_price($i),2) )."</div>"
                                ."<div class='row'>". ($i >= $value->room_type->higher_occupancy ? "--" : "1 Ext. Child  $currency_symbol " . number_format($value->children_price($i),2) ). "</div>
                                </td>";
                }
            $table .= "</tr>";
        }

        return response()->json(['data' => $table, 'success' =>true ], 200);

    }

    public function weekdayslist(Request $request){

        $high_weekdays = DefaultSetting::where('hotel_id', $request->session()->get('hotel_id'))->first()->high_weekdays;

        if($request->type == 1){
            $frontDeskPackage = FrontDeskPackage::find($request->id);
            $data = $frontDeskPackage->package_weekdays;
        } else if($request->type == 2){
            $high_weekdays->monday =1;
            $high_weekdays->tuesday =1;
            $high_weekdays->wednesday =1;
            $high_weekdays->thursday =1;
            $high_weekdays->friday =1;
            $high_weekdays->saturday =1;
            $high_weekdays->sunday = 1;
            $data = $high_weekdays;
        } else if ($request->type == 3){
            $high_weekdays->monday = ($high_weekdays->monday == 1?0:1);
            $high_weekdays->tuesday = ($high_weekdays->tuesday == 1 ?0:1);
            $high_weekdays->wednesday = ($high_weekdays->wednesday == 1 ?0:1);
            $high_weekdays->thursday = ($high_weekdays->thursday == 1 ?0:1);
            $high_weekdays->friday = ($high_weekdays->friday == 1 ?0:1);
            $high_weekdays->saturday = ($high_weekdays->saturday == 1 ?0:1);
            $high_weekdays->sunday = ($high_weekdays->sunday == 1 ?0:1);
            $data = $high_weekdays;
        } else if($request->type == 4){
            $data = $high_weekdays;
        }
        return response()->json(['data' => $data  , 'success' => true], 200);
    }
}
