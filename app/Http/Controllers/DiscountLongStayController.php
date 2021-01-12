<?php

namespace App\Http\Controllers;

use App\DiscountLongStay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscountLongStayController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $hotel_id = $request->session()->get('hotel_id');
            $discountLongStay = DiscountLongStay::where('hotel_id', '=', $hotel_id);
            if ($request->active != '') {
                $discountLongStay->where('active',  $request->active);
            }

            return datatables()->of($discountLongStay)
                ->addColumn('btn', 'pages.longstay.actions')
                ->addColumn('discountrule', function (DiscountLongStay $discountLongStay) {

                    $result = "For Stay of $discountLongStay->min_stay Night(s) get ". ($discountLongStay->discount_type == 2 ? '' : ' next ').
                    number_format($discountLongStay->value)
                    . ($discountLongStay->discount_type ==2? ' percent discount': ' Night(s) free');

                    return $result;
                })
                ->addColumn('status', 'pages.lastminute.status')
                ->rawColumns(['discountrule', 'btn', 'status'])
                ->make();
        } else {

            return view('pages.longstay.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.longstay.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'min_stay' => ['required', 'integer', 'min:1'],
            'discount_type' => 'required',
            'value' => ['required', 'numeric','min:1']
        ]);
        $hotel_id = $request->session()->get('hotel_id');
        $user_id = Auth::user()->id;
        DiscountLongStay::create(['hotel_id' => $hotel_id, 'user_id'=> $user_id ]+ $request->all());

        return redirect(route('long-stay-discount.index'))->with('message_success', 'Long Stay Discount has been created!!');
    }

    public function edit($id)
    {
        $discountLongStay = DiscountLongStay::findOrFail($id);

        return view('pages.longstay.update', compact('discountLongStay'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DiscountLongStay  $discountLongStay
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        $request->validate([
            'name' => 'required',
            'min_stay' => ['required', 'integer', 'min:1'],
            'discount_type' => 'required',
            'value' => ['required', 'numeric', 'min:1']
        ]);
        $discountLongStay = DiscountLongStay::findOrFail($id);

        $user_id = Auth::user()->id;
        $discountLongStay->update(['user_id' => $user_id] + $request->all());

        return redirect(route('long-stay-discount.index'))->with('message_success', 'Long Stay Discount has been updated!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DiscountLongStay  $discountLongStay
     * @return \Illuminate\Http\Response
     */
    public function destroy(  $id)
    {
        $discountLongStay = DiscountLongStay::findOrFail($id);
        $discountLongStay->active =  ($discountLongStay->active ? 0 : 1);
        $discountLongStay->save();
        return response()->json($discountLongStay);
    }
}
