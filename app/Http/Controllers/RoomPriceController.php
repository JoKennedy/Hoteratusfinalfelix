<?php

namespace App\Http\Controllers;

use App\BookingPolicy;
use App\CancellationPolicy;
use App\DefaultSetting;
use App\Hotel;
use App\RoomPrice;
use App\RoomPricePolicy;
use App\RoomType;
use App\Season;
use App\SpecialPeriod;
use App\WebPolicyType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $hotel_id = $request->session()->get('hotel_id');
        $roomTypes = RoomType::where('hotel_id', $hotel_id)->where('active', 1)->orderBy('sort_order')->get();
        $seasons = Season::where('hotel_id', $hotel_id)->where('active', 1)->orderBy('start')->get();
        $specialPeriods = SpecialPeriod::where('hotel_id', $hotel_id)->where('active', 1)->orderBy('start')->get();
        $defaultSetting = DefaultSetting::where('hotel_id', $hotel_id)->first();
        $webPolicyTypes = WebPolicyType::all();
        return view('pages.roomprice.index', compact('roomTypes', 'defaultSetting', 'seasons', 'specialPeriods', 'webPolicyTypes'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RoomPrice  $roomPrice
     * @return \Illuminate\Http\Response
     */
    public function show(RoomPrice $roomPrice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RoomPrice  $roomPrice
     * @return \Illuminate\Http\Response
     */
    public function edit(RoomPrice $roomPrice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RoomPrice  $roomPrice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RoomPrice $roomPrice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RoomPrice  $roomPrice
     * @return \Illuminate\Http\Response
     */
    public function destroy(RoomPrice $roomPrice)
    {
        //
    }

    public function roomprice (Request $request){

        if ($request->ajax()){

            $roomPrice = RoomType::where('id',$request->id)->first();

            switch ($request->type) {
                case 'Rack':
                    $roomPrice = $roomPrice->rack_rate();
                    break;
                case 'LastMin':
                    $roomPrice = $roomPrice->last_min_rate();
                break;
                case 'Web':
                    $roomPrice = $roomPrice->web_rate();
                    break;
                case 'App-Season':
                    $roomPrice = $roomPrice->season_rate($request->categoryid);
                    break;
                case 'App-SpecialPeriod':
                    $roomPrice = $roomPrice->special_period_rate($request->categoryid);
                    break;
                default:
                    # code...
                    break;
            }

            return ['data' => $roomPrice , 'success' => true] ;
        }
    }
    public function saveroomtypeweb(Request $request){

        $price = RoomPrice::where('id',$request->webid)->first();
        if($price->id??0 > 0){

            if ($request->web_policy_type_id  != $price->web_policy_type_id
             ||  $request->deposit_amount != $price->deposit_amount
             || $request->deposit_type[0] != $price->deposit_type
             || $request->value_type[0] != $price->value_type
              ){
                $user_id = Auth::user()->id;
                $priceNew = RoomPrice::create([
                    'user_id' => $user_id ,
                    'priceable_type' => $price->priceable_type,
                    'priceable_id' => $price->priceable_id,
                    'room_type_id' => $price->room_type_id,
                    'base_occupancy' => $price->base_occupancy,
                    'extra_person' => $price->extra_person,
                    'extra_bed' => $price->extra_bed,
                    'base_occupancy_high' => $price->base_occupancy_high,
                    'extra_person_high' => $price->extra_person_high,
                    'extra_bed_high' => $price->extra_bed_high,
                    'web' => $price->web,
                    'corp' => $price->corp,
                    'agent' => $price->agent,
                    'web_policy_type_id' => $request->web_policy_type_id,
                    'deposit_amount' => $request->deposit_amount,
                    'deposit_type' => $request->deposit_type[0],
                    'value_type' => $request->value_type[0],
                ]);
                $policies = $price->room_price_policies;
                foreach ($policies as $key => $value) {
                    if ($value['policyable_type'] == 'App\CancellationPolicy') {
                        $policy = RoomPricePolicy::firstOrCreate(
                            [
                                'room_price_id' => $priceNew->id,
                                'policyable_id' => $value['policyable_id'],
                                'policyable_type' => $value['policyable_type']
                            ],
                            [
                                'user_id' => $user_id
                            ]
                        );
                    }
                }
              }else{
                return response()->json(['data' => ($priceNew ?? $price), 'success' => false,
                'message' => 'you do not make changes to the current policy']);
              }

        }
        return response()->json(['data'=>($priceNew ?? $price), 'success' => isset($priceNew) ,
            'message' => 'Something went wrong']);
    }

    public function saveroomprice(Request $request){

        $roomPrice = RoomType::where('id', $request->RateTypeId)->first();
        $typeid = 1;
        $ratename ='';
        switch ($request->category) {
            case 'Rack':
                $roomPrice->base_price =  $request->base_occupancy;
                $roomPrice->higher_price =  $request->extra_person;
                $roomPrice->extra_bed_price =  $request->extra_bed;
                $roomPrice->save();
                $roomPrice = $roomPrice->rack_rate();
                $typeid = 1;
                $ratename = ' Rack Rate <br>( Since ' . date('d/m/Y').')';
                break;
            case 'LastMin':
                $roomPrice = $roomPrice->last_min_rate();
                $typeid = 1;
                $ratename = 'Last Min Rate <br>( Since ' . date('d/m/Y') . ')';
            break;
            case 'Web':
                $roomPrice = $roomPrice->web_rate();
                $typeid = 1;
                $ratename = 'Web Rate <br>( Since ' . date('d/m/Y') . ')';
                break;
            case 'App-Season':
                $roomPrice = $roomPrice->season_rate($request->categoryid);
                $typeid = $request->categoryid;
            break;
            case 'App-SpecialPeriod':
                $roomPrice = $roomPrice->special_period_rate($request->categoryid);
                $typeid = $request->categoryid;
                break;
            default:

                # code...
                break;
        }

        $policies = $roomPrice->room_price_policies;
        $user_id = Auth::user()->id;
        $roomPrice= RoomPrice::create([
            'user_id' => $user_id,
            'priceable_type' => $request->category,
            'priceable_id' =>  $typeid,
            'room_type_id' => $request->RateTypeId,
            'base_occupancy' => $request->base_occupancy,
            'extra_person' => $request->extra_person,
            'extra_bed' => $request->extra_bed,
            'base_occupancy_high' => $request->base_occupancy_high,
            'extra_person_high' => $request->extra_person_high,
            'extra_bed_high' => $request->extra_bed_high,
            'web' => $request->category== 'LastMin'?1:isset($request->web),
            'corp' => isset($request->corp),
            'agent' => isset($request->agent),
            'web_policy_type_id' => $roomPrice->web_policy_type_id??1,
            'deposit_amount' => $roomPrice->deposit_amount??0,
            'deposit_type' => $roomPrice->deposit_type??1,
            'value_type' => $roomPrice->value_type ?? 2,
        ]);

        foreach ($policies as $key => $value) {
            if($value['policyable_type']== 'App\CancellationPolicy'){
                $policy = RoomPricePolicy::firstOrCreate(
                        [
                            'room_price_id' => $roomPrice->id,
                            'policyable_id' => $value['policyable_id'],
                            'policyable_type' => $value['policyable_type']
                        ],
                        [
                            'user_id' => $user_id
                        ]
                    );
            }
        }
        $hotel_id = $request->session()->get('hotel_id');
        $defaultSetting = DefaultSetting::where('hotel_id', $hotel_id)->first();
        $roomPrice->base_occupancy = number_format($roomPrice->base_occupancy, $defaultSetting['currency_decimal_place'], '.', ',');
        $roomPrice->extra_person = number_format($roomPrice->extra_person, $defaultSetting['currency_decimal_place'], '.', ',');
        $roomPrice->extra_bed = number_format($roomPrice->extra_bed, $defaultSetting['currency_decimal_place'], '.', ',');
        $roomPrice->base_occupancy_high = number_format($roomPrice->base_occupancy_high, $defaultSetting['currency_decimal_place'], '.', ',');
        $roomPrice->extra_person_high = number_format($roomPrice->extra_person_high, $defaultSetting['currency_decimal_place'], '.', ',');
        $roomPrice->extra_bed_high = number_format($roomPrice->extra_bed_high, $defaultSetting['currency_decimal_place'], '.', ',');
        $roomPrice->ratename = $ratename ;

        return response()->json(['data' => $roomPrice, 'success' => true]);

    }

    public function history(Request $request, $id,$category, $categoryid){

        if($request->ajax()){
            $hotel_id = $request->session()->get('hotel_id');
            $defaultSetting = DefaultSetting::with('time_zone')->where('hotel_id', $hotel_id)->first();
            $roomPrice =  RoomPrice::with('user')->whereRaw("room_type_id = $id and priceable_type = '$category' and priceable_id =$categoryid")
            ->orderBy('created_at', 'desc');
            return datatables()->of($roomPrice)
                ->addColumn('base_occupancy', function (RoomPrice $roomPrice) use($defaultSetting) {
                    return  number_format($roomPrice->base_occupancy ?? 0.00, $defaultSetting['currency_decimal_place'], '.', ',');
                })->addColumn('extra_person', function (RoomPrice $roomPrice) use($defaultSetting){
                     return  number_format($roomPrice->extra_person ?? 0.00, $defaultSetting['currency_decimal_place'], '.', ',');
                })->addColumn('extra_bed', function (RoomPrice $roomPrice) use($defaultSetting){
                    return  number_format($roomPrice->extra_bed ?? 0.00, $defaultSetting['currency_decimal_place'], '.', ',');
                })->addColumn('base_occupancy_high', function (RoomPrice $roomPrice) use($defaultSetting){
                    return  number_format($roomPrice->base_occupancy_high ?? 0.00, $defaultSetting['currency_decimal_place'], '.', ',');
                })->addColumn('extra_person_high', function (RoomPrice $roomPrice) use($defaultSetting){
                    return  number_format($roomPrice->extra_person_high ?? 0.00, $defaultSetting['currency_decimal_place'], '.', ',');
                })->addColumn('extra_bed_high', function (RoomPrice $roomPrice) use($defaultSetting){
                    return  number_format($roomPrice->extra_bed_high ?? 0.00, $defaultSetting['currency_decimal_place'], '.', ',');
                })->addColumn('web', function (RoomPrice $roomPrice) {
                    return  '<i class="material-icons">'.($roomPrice->web??0 == 1? "check_circle": "").'</i>';
                })->addColumn('corp', function (RoomPrice $roomPrice){
                    return  '<i class="material-icons">' . ($roomPrice->corp ?? 0 == 1 ? "check_circle" : "") . '</i>';
                })->addColumn('agent', function (RoomPrice $roomPrice) {
                    return  '<i class="material-icons">' . ($roomPrice->agent ?? 0 == 1 ? "check_circle" : "") . '</i>';
                })->addColumn('webpolicy', function (RoomPrice $roomPrice) {
                   return  $roomPrice->web_rate();
                })->addColumn('createby', function (RoomPrice $roomPrice) {
                    return $roomPrice->user->firstname.' '. $roomPrice->user->lastname;
                })->addColumn('createon', function (RoomPrice $roomPrice) use($defaultSetting){
                    return  date('d/m/Y', strtotime($roomPrice->created_at ?? date('Y-m-d H:i:s'))).'<br>'.
                    date('h:i:s A', strtotime($roomPrice->created_at ?? date('Y-m-d H:i:s')));
                })
                ->rawColumns(['base_occupancy', 'extra_person', 'extra_bed',
                'base_occupancy_high', 'extra_person_high', 'extra_bed_high',
                'web', 'corp', 'agent',
                'webpolicy', 'createby', 'createon'])
                ->make();



        }
        $roomType = RoomType::where('id', $id)->first();
        switch ($category) {
            case 'Rack':
                $roomPrice = $roomType->rack_rate();
                $ratename  = ' Rack Rate ( Since ' . date('d/m/Y', strtotime($roomPrice->created_at??date('Y-m-d'))) . ')';
                break;
            case 'LastMin':
                $roomPrice = $roomType->last_min_rate();
                $ratename = ' Last Min Rate ( Since ' . date('d/m/Y', strtotime($roomPrice->created_at ?? date('Y-m-d'))) . ')';
                break;
            case 'Web':
                $roomPrice = $roomType->web_rate();
                $ratename = ' Web Rate ( Since ' . date('d/m/Y', strtotime($roomPrice->created_at ?? date('Y-m-d'))) . ')';
                break;
            case 'App-Season':
                $season = Season::where('id', $categoryid )->first();
                $roomPrice = $roomType->season_rate($categoryid);
                $ratename = "Seasonal Rate: ". $season->name." (".date('d/m/Y', strtotime($season->start))." to ".date('d/m/Y', strtotime($season->end)).")";
                break;
            case 'App-SpecialPeriod':
                $specialPeriod= SpecialPeriod::where('id', $categoryid)->first();
                $roomPrice = $roomType->special_period_rate($categoryid);
                $ratename = "Special Period Rate: " . $specialPeriod->name . " (" . date('d/m/Y', strtotime($specialPeriod->start)) . " to " . date('d/m/Y', strtotime($specialPeriod->end)) . ")";
                break;
            default:
                # code...
                break;
        }
        $url = route('room-price.history', [$id, $category, $categoryid]);

        return view('pages.roomprice.history', compact('roomType', 'ratename', 'url'));

    }
    public function roompricepolicies(Request $request){
        $id= $request->otherroomtypeid;
        $category= $request->othercategory;
        $categoryid= $request->othercategoryid;
        $option = $request->otheroption;
        $type = $request->othertype;
        $name ='';
        $roomType = RoomType::where('id', $id)->first();
        $hotel_id = $request->session()->get('hotel_id');
        switch ($category) {
            case 'Rack':
                $roomPrice = $roomType->rack_rate();
                $name = 'Rack Rate';
                break;
            case 'LastMin':
                $roomPrice = $roomType->last_min_rate();
                $name = 'Last Min Rate';
                break;
            case 'Web':
                $roomPrice = $roomType->web_rate();
                $name ='Web';
                break;
            case 'App-Season':
                $season = Season::where('id', $categoryid)->first();
                $roomPrice = $roomType->season_rate($categoryid);
                $name =  $season->name;
                break;
            case 'App-SpecialPeriod':
                $specialPeriod = SpecialPeriod::where('id', $categoryid)->first();
                $roomPrice = $roomType->special_period_rate($categoryid);
                $name =  $specialPeriod->name;
                break;
            default:
                # code...
                break;
        }
        if (!$roomPrice)
        {
            return ['message'=> "You must config Prices first than policies", 'success' => false];
        }

        if($option=='add'){
            $rateheader = ($type == 'cancel' ? 'Add Cancellation Policy' : 'Add Booking Policy') . " ($name)";
            if($type == 'cancel'){
                $policies = CancellationPolicy::where('hotel_id',$hotel_id)
                ->whereNotIn('id',RoomPricePolicy::where('policyable_type', 'App\CancellationPolicy' )
                ->where('room_price_id', $roomPrice->id)->pluck('policyable_id'))->get();
            }else{
                $policies = BookingPolicy::where('hotel_id', $hotel_id)
                ->whereNotIn('id', RoomPricePolicy::where('policyable_type', 'App\BookingPolicy')
                ->where('room_price_id', $roomPrice->id)->pluck('policyable_id'))->get();
            }
        }else{
            $rateheader = ($type == 'cancel' ? 'Cancellation Policy' : 'Booking Policy') . " ($name)";
            if ($type == 'cancel') {
                $policies = CancellationPolicy::where('hotel_id', $hotel_id)
                    ->whereIn('id', RoomPricePolicy::where('policyable_type', 'App\CancellationPolicy')
                        ->where('room_price_id', $roomPrice->id)->pluck('policyable_id'))->get();
            }else{
                $policies = BookingPolicy::where('hotel_id', $hotel_id)
                    ->whereIn('id', RoomPricePolicy::where('policyable_type', 'App\BookingPolicy')
                        ->where('room_price_id', $roomPrice->id)->pluck('policyable_id'))->get();
            }
        }
        $defaultSetting = DefaultSetting::with('time_zone')->where('hotel_id', $hotel_id)->first();
        date_default_timezone_set(explode(',',$defaultSetting->time_zone->utc)[0]);
        foreach ($policies as $key => $value) {
            $policies[$key]->description = $value->get_description($defaultSetting);
        }

        if($roomPrice){
            return ['data' => ['rateheader' => $rateheader, 'policies' => $policies, 'id'=> $roomPrice->id], 'success' => true];
        }

    }

    public function saveroompricepolicies(Request $request){
        $user_id = Auth::user()->id;
        if(!isset($request->policyid)){
            return ['data' => $request->all(), 'success' => false, 'message'=> 'You must select at least one policy'];
        }

        foreach ($request->policyid as $key => $value) {

            $policy = RoomPricePolicy::firstOrCreate(
            [
                'room_price_id' => $request->otherid,
                'policyable_id' => $value ,
                'policyable_type' => ($request->othertype == 'cancel'?'App\CancellationPolicy': 'App\BookingPolicy')
            ],
            [
                'user_id' => $user_id
            ]);
        }



        return ['data' => $request->all(), 'success' => true, 'message' => ($request->othertype == 'cancel'?'Cancellation':'Booking'). ' Policies has been added!!!'];

    }
    public function deleteroompricepolicies(Request $request){

        $policy = RoomPricePolicy::where('room_price_id',$request->otherid)->where('policyable_id', $request->policyid)
        ->where('policyable_type' , ($request->othertype == 'cancel'?'App\CancellationPolicy': 'App\BookingPolicy'))->first();

        return ['success' => $policy->delete(), 'message'=> ($request->othertype == 'cancel' ? 'Cancellation' : 'Booking') . ' Policy has been removed!!!' ];

    }
}

