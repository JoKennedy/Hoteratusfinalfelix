<?php

namespace App\Http\Controllers;

use App\AccountCode;
use App\PropertyDepartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AccountCodeController extends Controller
{


    public function store(Request $request)
    {
        $hotel_id  = $request->session()->get('hotel_id'); ;
        $valid = $request->validate([
            'name' => ['required', Rule::unique('account_codes')->where(function ($query) use ($request, $hotel_id) {
                return $query->where('name', $request->name)->where('hotel_id' , $hotel_id);
            })],
            'code' => ['required', Rule::unique('account_codes')->where(function ($query) use ($request, $hotel_id) {
                return $query->where('code', $request->code)->where('hotel_id', $hotel_id);
            })]
        ]);
        if($request->department_id){
            $department_id = $request->department_id;
        }else{
            $deparment = PropertyDepartment::where('hotel_id', $hotel_id)->where('editable', 2)->first();
            $department_id = $deparment->id??0;
        }

        $accountCode = AccountCode::create(['hotel_id' => $hotel_id, 'property_department_id' => $department_id ] + $valid);

        return response()->json($accountCode, 201);
    }

    public function list(Request $request){

        $hotel_id  = $request->session()->get('hotel_id');
        $accountCodes = AccountCode::where('hotel_id' ,$hotel_id)->where( 'property_department_id' , $request->department_id)->get();

        return response()->json(['data'=>$accountCodes, 'success' => true], 200);
    }
}
