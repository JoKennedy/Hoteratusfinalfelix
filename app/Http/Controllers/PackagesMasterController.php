<?php

namespace App\Http\Controllers;

use App\Hotel;
use App\PackageCancellationPolicy;
use App\PackagesMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PackagesMasterController extends Controller
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
            $packagesMaster = PackagesMaster::with('hotel', 'hotel.room_types', 'packages_master_rooms')->where('hotel_id', $hotel_id);
            if ($request->active != '') {
                $packagesMaster->where('active',  $request->active);
            }

            return datatables()->of($packagesMaster)
                ->addColumn('btn', 'pages.packagesmaster.actions')
                ->addColumn('status', 'pages.packagesmaster.status')
                ->addColumn('roomtype', function (PackagesMaster $packagesMaster) {
                    $result ='<table border="0" width="100%" > <tbody>';
                    foreach ($packagesMaster->hotel->room_types as $room) {
                        $result .= '<tr><td align="left">'. $room->name .'</td><tr>';
                    }
                    return $result. '</tbody></table>';
                })
                ->addColumn('pricepernight', function (PackagesMaster $packagesMaster) {

                    $result = '<table border="0" width="100%" > <tbody>';
                    foreach ($packagesMaster->packages_master_rooms as $room) {
                        $result .= '<tr><td style="text-align:right; margin-right:5px;">' . $room->base_price . '</td><tr>';
                    }
                    return $result . '</tbody></table>';
                })
                ->rawColumns(['btn', 'status', 'price', 'roomtype', 'pricepernight'])
                ->make();
        } else {

            return view('pages.packagesmaster.index');
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
        $hotel = Hotel::with('room_types', 'inclusions')->where('id', $hotel_id)->first();

        return view('pages.packagesmaster.create', compact('hotel'));
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
        $request->validate([
            'name' => ['required', Rule::unique('packages_masters')->where(function ($query) use ($request, $hotel_id) {
                return $query->where('name', $request->name)->where('hotel_id', $hotel_id);
            })],
            'description' => 'required',
            'code' => 'required',
            'stay_length' => 'required'

        ]);

        $user = Auth::user();
        $packagesMaster = PackagesMaster::create(['user_id' => $user->id, "hotel_id" => $hotel_id] + $request->all());

        foreach ($request->room_type as $key => $value) {
            $packages_master_rooms =  $packagesMaster->packages_master_rooms()->create([
                'user_id' => $user->id, 'room_type_id'=> $key
            ]+ $value);

            if (isset($request->upcharge) && isset($request->upcharge[$key])) {

                foreach ($request->upcharge[$key]['adult'] as $qty => $amount) {
                    $packages_master_rooms->packages_master_upcharges()->create([
                        'user_id' => $user->id,
                        'persons' => $qty,
                        'adults' => $amount,
                        'children' => $request->upcharge[$key]['children'][$qty]
                    ]);
                }
            }

        }
        $packagesMaster->inclusions()->attach($request->inclusion_id);


        return redirect(route('packages-master.index'))
        ->with('message_success', "Product [$packagesMaster->name] has been created successfully");
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PackagesMaster  $packagesMaster
     * @return \Illuminate\Http\Response
     */
    public function edit($id )
    {
        $packagesMaster = PackagesMaster::with('inclusions','packages_master_rooms.room_type', 'packages_master_rooms', 'packages_master_rooms.packages_master_upcharges')->findOrFail($id);
        $hotel_id = $packagesMaster->hotel_id;
        $hotel = Hotel::with('room_types', 'inclusions')->where('id', $hotel_id)->first();

        return view('pages.packagesmaster.update', compact('hotel', 'packagesMaster'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PackagesMaster  $packagesMaster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PackagesMaster $packagesMaster)
    {

        $hotel_id = $request->session()->get('hotel_id');
        $dataverified = $request->validate([
            'name' => ['required', Rule::unique('packages_masters')->where(function ($query) use ($request, $hotel_id, $packagesMaster) {
                return $query->where('name', $request->name)->where('hotel_id', $hotel_id)->where('id', '!=', $packagesMaster->id);
            })],
            'description' => 'required',
            'code' => 'required',
            'stay_length' => 'required'

        ]);

        $user = Auth::user();
        $packagesMaster->update(['user_id' => $user->id] + $dataverified);


        foreach ($request->room_type as $key => $value) {
            $packages_master_rooms =  $packagesMaster->packages_master_rooms()->updateOrCreate(
                [
                    'room_type_id' => $key
                ],
                [
                    'user_id' => $user->id
                ]+ $value );

            if (isset($request->upcharge) && isset($request->upcharge[$key])) {

                foreach ($request->upcharge[$key]['adult'] as $qty => $amount) {
                    $packages_master_rooms->packages_master_upcharges()->updateOrCreate([
                        'user_id' => $user->id,
                        'persons' => $qty
                    ],
                    [
                        'adults' => $amount,
                        'children' => $request->upcharge[$key]['children'][$qty]
                    ]);
                }
            }
        }


        $packagesMaster->inclusions()->sync($request->inclusion_id);


        return redirect(route('packages-master.index'))
        ->with('message_success', "Product [$packagesMaster->name] has been updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PackagesMaster  $packagesMaster
     * @return \Illuminate\Http\Response
     */
    public function destroy(PackagesMaster $packagesMaster)
    {
        $packagesMaster->active =  ($packagesMaster->active ? 0 : 1);
        $packagesMaster->save();
        return response()->json($packagesMaster);
    }
    public function filterPackage(Request $request){
        $data = array();
        $hotel_id = $request->session()->get('hotel_id');
        $data['data'] = array();
        $data['success'] = false;
        $data['package_type'] = $request->package_type;
        switch ($request->package_type) {
            case 'master':
                $data['data'] = PackagesMaster::where('hotel_id', $hotel_id)->where('active',1)->get();
                $data['type'] = "Master Package";
                $data['success'] = $data['data']->count()>0?true:false;;
                break;
            case 'frontdesk':
                $data['type'] = "Frontdesk Package";
                break;
            case 'web':
                $data['type'] = "Web Package";
                break;
            case 'travel_agent':
                $data['type'] = "Tarvel Agent Package";
                break;
            case 'corporate':
                $data['type'] = "Corporate Package";
                break;
            case 'centralized_rate':
                $data['type'] = "Centralized Rate Package";
                break;

            default:
                $data['type'] = "";
                break;
        }


        return response()->json($data , 200);

    }

    public function attachPackage(Request $request){
        return $request->all();
    }
}

