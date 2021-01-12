<?php

namespace App\Http\Controllers;

use App\Country;
use App\Hotel;
use App\PropertyDepartment;
use App\Salutation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HotelController extends Controller
{

    public function index(Request $request)
    {
        if($request->ajax()){
            $hotels = Hotel::where('company_id', '=', session()->get('company_id'));

            return datatables()->of($hotels)
                ->addColumn('btnaction', 'pages.hotel.actions')
                ->addColumn('btnstatus', 'pages.hotel.status')
                ->rawColumns(['btnstatus', 'btnaction'])
                ->make();

        }else{

            return view('pages.hotel.index');
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();
        $salutations = Salutation::all();
        return view('pages.hotel.create', compact('countries', 'salutations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {

            $hotel = Hotel::create([
                'company_id' => session()->get('company_id')
            ] + $request->hotel);

            $hotel->billing_address()->create([
                $request->billing
            ]);
            $hotel->billing_contact()->create([
                $request->contact
            ]);

            $default_setting = $hotel->default_setting()->create();
            $default_setting->high_weekdays()->create();
            if($request->file('image')){
                $hotel->logo = $request->file('image')->store('hotels','public');
                $hotel->save();
            }

            $this->departments($hotel->id);


            $request->session()->put('hotel_id', $hotel->id);
            $request->session()->put('hotel_name', $hotel->name);
        });
        return redirect(route('hotel.index'))->with('message_success', 'Hotel was created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function show(Hotel $hotel)
    {

        $countries = Country::all();
        $salutations = Salutation::all();
        return view('pages.hotel.show', compact('hotel', 'countries', 'salutations'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function edit(Hotel $hotel)
    {

        $countries = Country::all();
        $salutations = Salutation::all();
        return view('pages.hotel.update', compact('hotel', 'countries', 'salutations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hotel $hotel)
    {
        DB::transaction(function () use ($request, $hotel) {

            $hotel->update($request->hotel);

            $hotel->billing_address()->update($request->billing);
            $hotel->billing_contact()->update( $request->contact );


            if ($request->file('image')) {
                if ($hotel->logo) {
                    Storage::disk('public')->delete($hotel->logo);
                }
                $hotel->logo = $request->file('image')->store('hotels', 'public');
                $hotel->save();
            }
        });
        return back()->with('message_success', 'Hotel was updated successfully');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hotel $hotel)
    {
        $hotel->active = $hotel->active == 1 ? 0 : 1;
        $hotel->save();

        return response()->json($hotel);
    }

    private function departments($hotel_id){

        PropertyDepartment::firstOrCreate([
            'hotel_id' => $hotel_id,
            'hotel_id' => $hotel_id,
            'name' => 'Sales',
            'code' => 'Sales',
            'description' => 'Sales'
        ]);
        PropertyDepartment::firstOrCreate([
            'hotel_id' => $hotel_id,
            'name' => 'Purchase',
            'code' => 'Purchase',
            'description' => 'Purchase',
        ]);
        PropertyDepartment::firstOrCreate([
            'hotel_id' => $hotel_id,
            'name' => 'KST',
            'code' => 'KST',
            'description' => 'KST',
        ]);
        PropertyDepartment::firstOrCreate([
            'hotel_id' => $hotel_id,
            'name' => 'IT',
            'code' => 'IT',
            'description' => 'IT',
        ]);
        PropertyDepartment::firstOrCreate([
            'hotel_id' => $hotel_id,
            'name' => 'HR',
            'code' => 'HR',
            'description' => 'HR',
        ]);
        PropertyDepartment::firstOrCreate([
            'hotel_id' => $hotel_id,
            'name' => 'Housekeeping',
            'code' => 'Housekeeping',
            'description' => 'Housekeeping',
        ]);
        PropertyDepartment::firstOrCreate([
            'hotel_id' => $hotel_id,
            'name' => 'Front Office',
            'code' => 'Front Office',
            'description' => 'Front Office',
        ]);
        PropertyDepartment::firstOrCreate([
            'hotel_id' => $hotel_id,
            'name' => 'Finance',
            'code' => 'Finance',
            'description' => 'Finance',
        ]);
        PropertyDepartment::firstOrCreate([
            'hotel_id' => $hotel_id,
            'name' => 'F&B Service',
            'code' => 'F&B Service',
            'description' => 'F&B Service',
        ]);
        PropertyDepartment::firstOrCreate([
            'hotel_id' => $hotel_id,
            'name' => 'F&B Production',
            'code' => 'F&B Production',
            'description' => 'F&B Production',
        ]);
        PropertyDepartment::firstOrCreate([
            'hotel_id' => $hotel_id,
            'name' => 'Engineering',
            'code' => 'Engineering',
            'description' => 'Engineering',
        ]);
        PropertyDepartment::firstOrCreate([
            'hotel_id' => $hotel_id,
            'name' => 'Billing',
            'code' => 'Billing',
            'description' => 'Billing',
            'editable' => 1
        ]);
        PropertyDepartment::firstOrCreate([
            'hotel_id' => $hotel_id,
            'name' => 'Tax',
            'code' => 'Tax',
            'description' => 'Tax',
            'editable' => 2
        ]);
        PropertyDepartment::firstOrCreate([
            'hotel_id' => $hotel_id,
            'name' => 'Account',
            'code' => 'Account',
            'description' => 'Account',
            'editable' => 1
        ]);
        PropertyDepartment::firstOrCreate([
            'hotel_id' => $hotel_id,
            'name' => 'Default Account',
            'code' => 'Default Account',
            'description' => 'Default Account',
            'editable' => 1
        ]);
    }
}
