<?php

namespace App\Http\Controllers;

use App\AccountCode;
use App\Department;
use App\Hotel;
use App\PropertyDepartment;
use App\RoomTax;
use App\RoomTaxDetail;
use App\TaxApplied;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomTaxController extends Controller
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
            $roomtaxes = RoomTax::with('room_tax_details')->where('room_taxes.hotel_id', '=', $hotel_id)->get();
            if ($request->active != '') {
                $roomtaxes->where('room_taxes.active',  $request->active);
            }

            return datatables()->of($roomtaxes)
                ->addColumn('btn', 'pages.roomtax.actions')
                ->addColumn('status', 'pages.roomtax.status')
                ->addColumn('details', function (RoomTax $tax) {

                    return $tax->details;
                })
                ->addColumn('btnsort_order', '<input style="width:80px;" type="number" value="{{$sort_order}}" name="roomtax[][{{$id}}]" />')
                ->addColumn('namefull', function (RoomTax $tax) {

                    return "$tax->name  ( ". $tax->department->name ." )";
                })
                ->rawColumns([ 'btn', 'status', 'btnsort_order', 'details'])
                ->make();
        } else {

            return view('pages.roomtax.index');
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
        $departments = Department::all();
        $hotel = Hotel::find($hotel_id, 'id');
        $taxApplieds = TaxApplied::all();
        $deparment = PropertyDepartment::where('hotel_id', $hotel_id)->where('editable', 2)->first();
        $accountCodes = AccountCode::where('property_department_id', $deparment->id??0 )->get();
        return view('pages.roomtax.create', compact('departments', 'hotel', 'taxApplieds', 'accountCodes' ));
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
        $roomTax = RoomTax::create([
            'hotel_id'              =>  $hotel_id,
            'name'                  => $request->name,
            'code'                  => $request->code,
            'department_id'         => $request->department_id,
            'account_code_id'       => $request->account_code_id,
            'description'           => $request->description,
            'included'              => (isset($request->included) ? 1:0),
            'adult_child'           => (isset($request->adult_child) ? 1 : 0),
            'adult_type'            => ($request->adult_type ?? 0),
            'tax_applied_id'        => $request->tax_applied_id
        ]);


        foreach ($request->charge_less as $key => $value) {
            $roomTax->room_tax_details()->create([
                'charge_less' => $request->charge_less[$key],
                'account_code_id' => $request->account_code[$key],
                'tax_value' => $request->tax_value[$key],
            ]);
        }

        return redirect('room-taxes')->with('message', 'Room Tax/Fee was created');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RoomTax  $roomTax
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, RoomTax $roomTax)
    {
        $hotel_id = $request->session()->get('hotel_id');
        $departments = Department::all();
        $hotel = Hotel::find($hotel_id, 'id');
        $taxApplieds = TaxApplied::all();
        $deparment = PropertyDepartment::where('hotel_id', $hotel_id)->where('editable', 2)->first();
        $accountCodes = AccountCode::where('property_department_id', $deparment->id)->get();
        return view('pages.roomtax.show', compact('roomTax', 'departments', 'hotel', 'taxApplieds', 'accountCodes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RoomTax  $roomTax
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, RoomTax $roomTax)
    {
        $hotel_id = $request->session()->get('hotel_id');
        $departments = Department::all();
        $hotel = Hotel::find($hotel_id, 'id');
        $taxApplieds = TaxApplied::all();
        $deparment = PropertyDepartment::where('hotel_id', $hotel_id)->where('editable', 2)->first();
        $accountCodes = AccountCode::where('property_department_id', $deparment->id)->get();
       return view('pages.roomtax.update', compact('roomTax', 'departments', 'hotel', 'taxApplieds', 'accountCodes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RoomTax  $roomTax
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RoomTax $roomTax)
    {
            $roomTax->update([
                'name'                  => $request->name,
                'code'                  => $request->code,
                'department_id'         => $request->department_id,
                'account_code_id'       => $request->account_code_id,
                'description'           => $request->description,
                'included'              => (isset($request->included) ? 1 : 0),
                'adult_child'           => (isset($request->adult_child) ? 1 : 0),
                'adult_type'            => ($request->adult_type ?? 0),
                'tax_applied_id'        => $request->tax_applied_id
            ]);
        foreach ($request->charge_less as $key => $value) {
            if($request->room_tax_detail_id[$key] == -1){
                $roomTax->room_tax_details()->create([
                    'charge_less' => ($request->charge_less[$key] ? str_replace(',', '', $request->charge_less[$key]) : 0),
                    'account_code_id' => $request->account_code[$key],
                    'tax_value' => str_replace(',', '',  $request->tax_value[$key]),
                ]);
            }else{
                RoomTaxDetail::where('id', $request->room_tax_detail_id[$key])
                            ->update([
                    'charge_less' => ( $request->charge_less[$key] ? str_replace(',', '', $request->charge_less[$key]): 0),
                    'account_code_id' => $request->account_code[$key],
                    'tax_value' => str_replace(',', '',  $request->tax_value[$key]),
                ]);
            }

        }


            return back()->with('message_success','Room Tax has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RoomTax  $roomTax
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, RoomTax $roomTax)
    {
        if($request->ajax()){

          // $roomTaxDetail= RoomTaxDetail::findOrFail($request->id);

            //return response()->json($roomTaxDetail, 200);
            return response()->json($request->all(), 200);

        }
    }
    public function deleteDetail(Request $request,  $id){


        if ($request->ajax()) {

            $roomTaxDetail= RoomTaxDetail::findOrFail($id);
            if($roomTaxDetail->delete()){
                 return response()->json(['success' => true], 200);
            }

            //return response()->json($roomTaxDetail, 200);
             return response()->json(['success' => false], 200);
        }
    }
}
