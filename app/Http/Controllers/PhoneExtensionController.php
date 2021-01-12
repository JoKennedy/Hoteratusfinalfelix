<?php

namespace App\Http\Controllers;

use App\PhoneExtension;
use App\PropertyDepartment;
use App\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class PhoneExtensionController extends Controller
{



    public function index(Request $request)
    {
        if($request->ajax()){

            $hotel_id = $request->session()->get('hotel_id');
            $rooms = Room::where('hotel_id', $hotel_id)->where('active', 1)->get();
            $property_departments = PropertyDepartment::where('hotel_id', $hotel_id)->where('active', 1)->get();
            $phone_extensions = PhoneExtension::where('hotel_id', $hotel_id  );

            if ($request->active != '') {
                $phone_extensions->where('active',  $request->active);
            }

            return datatables()->of($phone_extensions)
                ->addColumn('btn', 'pages.phone-extensions.actions')
                ->addColumn('extension_number', ' <a href="{{ route("phone-extensions.show", $id)}}" class="invoice-action-view mr-6">{{$extension_number}}</a>')
                ->addColumn('roomnumbers', function(PhoneExtension $phoneExtension) use ($rooms){
                    return view('pages.phone-extensions.rooms', compact('phoneExtension', 'rooms'));
                })
                ->addColumn('departments', function (PhoneExtension $phoneExtension) use ($property_departments) {
                    return view('pages.phone-extensions.department', compact('phoneExtension', 'property_departments'));
                })
                ->addColumn('status', 'pages.phone-extensions.status')
                ->rawColumns(['btnrooms', 'btn', 'status', 'roomnumbers', 'extension_number' ])
                ->make();

        }else{
            return view('pages.phone-extensions.index');
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
        $rooms = Room::where('hotel_id', $hotel_id)->where('active', 1)->get();
        $property_departments = PropertyDepartment::where('hotel_id', $hotel_id)->where('active', 1)->get();

        return view('pages.phone-extensions.create', compact('rooms', 'hotel_id' , 'property_departments' ));
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
            'extension_number' => ['required', Rule::unique('phone_extensions')->where(function ($query) use ($request, $hotel_id) {
                return $query->where('extension_number', $request->extension_number)->where('hotel_id', $hotel_id);
            })]
        ]);

        PhoneExtension::create(['hotel_id' => $hotel_id] + $request->all());

        return redirect('phone-extensions')->with('message_success', 'Phone Extension has been created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PhoneExtension  $phoneExtension
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, PhoneExtension $phoneExtension)
    {
        $hotel_id = $request->session()->get('hotel_id');;
        $rooms = Room::where('hotel_id', $hotel_id)->where('active', 1)->get();
        $property_departments = PropertyDepartment::where('hotel_id', $hotel_id)->where('active', 1)->get();

        return view('pages.phone-extensions.show', compact('rooms', 'hotel_id', 'property_departments', 'phoneExtension'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PhoneExtension  $phoneExtension
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, PhoneExtension $phoneExtension)
    {
        $hotel_id = $request->session()->get('hotel_id');
        $rooms = Room::where('hotel_id', $hotel_id)->where('active', 1)->get();
        $property_departments = PropertyDepartment::where('hotel_id', $hotel_id)->where('active', 1)->get();

        return view('pages.phone-extensions.update', compact('rooms', 'hotel_id', 'property_departments', 'phoneExtension'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PhoneExtension  $phoneExtension
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PhoneExtension $phoneExtension)
    {
        $hotel_id = $request->session()->get('hotel_id');
        $request->validate([
            'extension_number' => ['required', Rule::unique('phone_extensions')->where(function ($query) use ($request, $hotel_id,  $phoneExtension) {
                return $query->where('extension_number', $request->extension_number)->where('hotel_id', $hotel_id)->where('id', '!=',  $phoneExtension->id);
            })]
        ]);
        $phoneExtension->update($request->all());

        return back()->with('message_success', 'Phone Extension has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PhoneExtension  $phoneExtension
     * @return \Illuminate\Http\Response
     */
    public function destroy(PhoneExtension $phoneExtension)
    {
        $phoneExtension->active = $phoneExtension->active == 1 ? 0 : 1;
        $phoneExtension->save();

        return response()->json($phoneExtension, 200);
    }

    public function saveChanges(Request $request){

        $phone = PhoneExtension::findOrFail($request->id);
        $phone[$request->name] =$request->value ;
        $phone->save();


        return response()->json($request->all(), 200);
    }
}
