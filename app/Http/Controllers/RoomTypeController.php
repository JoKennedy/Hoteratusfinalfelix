<?php

namespace App\Http\Controllers;

use App\Amenity;
use App\RoomPrice;
use App\RoomPricePolicy;
use App\RoomTax;
use App\RoomTaxRoomType;
use App\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RoomTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $hotel_id = $request->session()->get('hotel_id');

            $roomType = RoomType::withCount(['rooms'])->where('hotel_id', '=', $hotel_id);
            if ($request->active != '') {
                $roomType->where('active',  $request->active);
            }

            return datatables()->of($roomType)
                ->addColumn('image', function (RoomType $roomType) {
                    return view('pages.roomtype.image', compact('roomType'));
                })
                ->addColumn('btn', 'pages.roomtype.actions')
                ->addColumn('btnrooms', 'pages.roomtype.rooms')
                ->addColumn('status', 'pages.roomtype.status')
                ->addColumn('occupancy', 'pages.roomtype.occupancy')
                ->addColumn('sort_order', '<input style="width: 70px;" type="number" name="roomid[][{{$id}}]" value="0"  />')
                ->rawColumns(['btnrooms', 'btn', 'status', 'image', 'occupancy', 'sort_order'])

                ->make();
        } else {

            return view('pages.roomtype.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $hotel_id = $request->session()->get('hotel_id');
        $amenities = Amenity::where('hotel_id', $hotel_id)->get();
        $taxes = RoomTax::with('department', 'tax_applied', 'room_tax_details')->where('hotel_id', $hotel_id)->get();
        return view('pages.roomtype.create', compact('amenities', 'taxes'));
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
       // dd($request->all());
        $request->validate([
            'name' => ['required', Rule::unique('room_types')->where(function ($query) use ($request, $hotel_id) {
                return $query->where('name', $request->name)->where('hotel_id', $hotel_id);
            })],
            'code' => ['required', Rule::unique('room_types')->where(function ($query) use ($request, $hotel_id) {
                return $query->where('code', $request->code)->where('hotel_id', $hotel_id);
            })],
            'base_occupancy' => 'numeric|required|min:1',
            'base_price' => 'numeric|required|min:1',
            'higher_price' => 'numeric|required|min:1',
            'extra_bed_price' => 'numeric|required|min:1',
        ]);

        $RoomType = RoomType::create(['hotel_id' => $hotel_id ] + $request->all()  );
        $RoomType->room_taxes()->attach($request->room_tax_id);
        $RoomType->amenities()->attach($request->amenity_id);
        $user = Auth::user();
        RoomPrice::create([
            'user_id' =>$user->id,
            'priceable_type' => 'Rack',
            'priceable_id' => 1,
            'room_type_id' =>$RoomType->id,
            'base_occupancy' => $RoomType->base_price,
            'extra_person' => $RoomType->higher_price,
            'extra_bed' => $RoomType->extra_bed_price,
            'base_occupancy_high' => 0,
            'extra_person_high' => 0,
            'extra_bed_high' => 0,
            'web' => 0,
            'corp' => 0,
            'agent' => 0,
        ]);

        if ($request->file('image')) {

            foreach ($request->file('image') as $key => $value) {
                $RoomType->images()->create([
                    'url' => $value->store('roomtypes', 'public'),
                    'caption' => $request->imagename[$key]
                ]);
            }
        }

        return redirect('room-types')->with('message_success', "Room Type [{$RoomType->code}] has been created!!");

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RoomType  $roomType
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, RoomType $roomType)
    {
        $hotel_id = $request->session()->get('hotel_id');
        $roomTax = array();
        $roomAmenities = array();
        foreach ($roomType->room_taxes as $key => $value) {
            $roomTax[] =  $value->id;
        }
        foreach ($roomType->amenities as $key => $value) {
            $roomAmenities[] =  $value->id;
        }

        $amenities = Amenity::where('hotel_id', Auth::user()->last_hotel_id)->get();
        $taxes = RoomTax::with('department', 'tax_applied', 'room_tax_details')->where('hotel_id', $hotel_id)->get();
        return view('pages.roomtype.show', compact('roomType', 'amenities', 'taxes', 'roomTax', 'roomAmenities'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RoomType  $roomType
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, RoomType $roomType)
    {
        $hotel_id = $request->session()->get('hotel_id');
        $roomTax =array();
        $roomAmenities =array();
        foreach ($roomType->room_taxes as $key => $value) {
           $roomTax[] =  $value->id;
        }
        foreach ($roomType->amenities as $key => $value) {
            $roomAmenities[] =  $value->id;
        }

        $amenities = Amenity::where('hotel_id', Auth::user()->last_hotel_id)->get();
        $taxes = RoomTax::with('department', 'tax_applied', 'room_tax_details')->where('hotel_id', $hotel_id)->get();
       return view('pages.roomtype.update', compact('roomType', 'amenities', 'taxes', 'roomTax', 'roomAmenities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RoomType  $roomType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RoomType $roomType)
    {
        $hotel_id = $request->session()->get('hotel_id');
        $request->validate([
            'name' => ['required', Rule::unique('room_types')->where(function ($query) use ($request, $hotel_id,  $roomType) {
                return $query->where('name', $request->name)->where('hotel_id', $hotel_id)->where('id', '!=', $roomType->id);
            })],
            'code' => ['required', Rule::unique('room_types')->where(function ($query) use ($request, $hotel_id, $roomType) {
                return $query->where('code', $request->code)->where('hotel_id', $hotel_id)->where('id','!=', $roomType->id );
            })],
            'base_occupancy' => 'numeric|required|min:1',
            'base_price' => 'numeric|required|min:1',
            'higher_price' => 'numeric|required|min:1',
            'extra_bed_price' => 'numeric|required|min:1',
        ]);

        $roomType->update($request->all());
        if(!isset($request->exta_bed_allowed)){
            $roomType->exta_bed_allowed = 0;
            $roomType->exta_bed_allowed_total =0;
             $roomType->save();
        }

        $roomType->room_taxes()->sync($request->room_tax_id);
        $roomType->amenities()->sync($request->amenity_id);

        $roomPrice = $roomType->rack_rate();
        $policies = $roomPrice->room_price_policies??array();
        $user_id = Auth::user()->id;
        $roomPrice = RoomPrice::create([
            'user_id' => $user_id,
            'priceable_type' => 'Rack',
            'priceable_id' =>  1,
            'room_type_id' =>  $roomType->id,
            'base_occupancy' => $roomType->base_price,
            'extra_person' => $roomType->higher_price,
            'extra_bed' => $roomType->extra_bed_price,
            'base_occupancy_high' => $roomPrice->base_occupancy_high??0,
            'extra_person_high' => $roomPrice->extra_person_high??0,
            'extra_bed_high' => $roomPrice->extra_bed_high??0,
            'web' => $roomPrice->web??0,
            'corp' => $roomPrice->corp??0,
            'agent' => $roomPrice->agent??0,
            'web_policy_type_id' => $roomPrice->web_policy_type_id ?? 1,
            'deposit_amount' => $roomPrice->deposit_amount ?? 0,
            'deposit_type' => $roomPrice->deposit_type ?? 1,
            'value_type' => $roomPrice->value_type ?? 2,
        ]);

        foreach ($policies as $key => $value) {
            if ($value['policyable_type'] == 'App\CancellationPolicy') {
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


        if ($request->file('image')) {
            foreach ($request->file('image') as $key => $value) {
                $roomType->images()->create([
                    'url' => $value->store('roomtypes', 'public'),
                    'caption' => $request->imagename[$key]
                ]);
            }
        }

        return back()->with('message_success', "Room Type [{$roomType->code}] has been updated!!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RoomType  $roomType
     * @return \Illuminate\Http\Response
     */
    public function destroy(RoomType $roomType)
    {
        $roomType->active = $roomType->active==1? 0 : 1;
        $roomType->save();
        return response()->json($roomType, 200);
    }
}
