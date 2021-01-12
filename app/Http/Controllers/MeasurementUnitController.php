<?php

namespace App\Http\Controllers;

use App\MeasurementUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class MeasurementUnitController extends Controller
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
            $measurementUnit = MeasurementUnit::where('hotel_id', $hotel_id);
            if ($request->active != '') {
                $measurementUnit->where('active',  $request->active);
            }

            return datatables()->of($measurementUnit)
                ->addColumn('btn', 'pages.measurementunit.actions')
                ->addColumn('status', 'pages.measurementunit.status')
                ->rawColumns(['btn', 'status'])
                ->make();
        } else {

            return view('pages.measurementunit.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('pages.measurementunit.create');
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
            'name' => ['required', Rule::unique('measurement_units')->where(function ($query) use ($request, $hotel_id) {
                return $query->where('name', $request->name)->where('hotel_id', $hotel_id);
            })],
            'code' => 'required'
        ]);
        $user = Auth::user();
        $measurementUnit = MeasurementUnit::create(['user_id' => $user->id, "hotel_id" => $hotel_id] + $request->all());

        return redirect(route('measurement-units.index'))->with('message_success', "Measurement Unit [$measurementUnit->name] has been created successfully");
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MeasurementUnit  $measurementUnit
     * @return \Illuminate\Http\Response
     */
    public function edit(MeasurementUnit $measurementUnit)
    {
        return view('pages.measurementunit.update', compact('measurementUnit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MeasurementUnit  $measurementUnit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MeasurementUnit $measurementUnit)
    {
        $hotel_id = $request->session()->get('hotel_id');
        $request->validate([
            'name' => ['required', Rule::unique('measurement_units')->where(function ($query) use ($request, $hotel_id, $measurementUnit) {
                return $query->where('name', $request->name)->where('hotel_id', $hotel_id)->where('id', '!=', $measurementUnit->id);
            })],
            'code' => 'required'
        ]);
        $user = Auth::user();
        $measurementUnit->update(['user_id' => $user->id] + $request->all());

        return redirect(route('measurement-units.index'))->with('message_success', "Measurement Unit [$measurementUnit->name] has been updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MeasurementUnit  $measurementUnit
     * @return \Illuminate\Http\Response
     */
    public function destroy(MeasurementUnit $measurementUnit)
    {
        $measurementUnit->active =  ($measurementUnit->active ? 0 : 1);
        $measurementUnit->save();
        return response()->json($measurementUnit);
    }
}
