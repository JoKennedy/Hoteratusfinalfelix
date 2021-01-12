<?php

namespace App\Http\Controllers;

use App\DiscountDynamicPricing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscountDynamicPricingController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $hotel_id = $request->session()->get('hotel_id');
            $dicountDynamicPricing = DiscountDynamicPricing::where('hotel_id', '=', $hotel_id);
            if ($request->active != '') {
                $dicountDynamicPricing->where('active',  $request->active);
            }

            return datatables()->of($dicountDynamicPricing)
                ->addColumn('btn', 'pages.dinamicpricing.actions')
                ->addColumn('discountrule', function (DiscountDynamicPricing $dicountDynamicPricing) {
                    $result = '';
                    foreach ($dicountDynamicPricing->discount_dynamic_pricing_details as $key => $value) {
                        $result .= "<div class='row'>For Occupancy Ranging from ".number_format($value->start_occupancy, 2)."% to ".number_format($value->end_occupancy, 2)."%, discount applicable is " . number_format($value->start_percentage, 2) . "% to " . number_format($value->end_percentage, 2) . "%.</div>";

                    }
                    return $result;
                })
                ->addColumn('status', 'pages.dinamicpricing.status')
                ->rawColumns(['discountrule', 'btn', 'status'])
                ->make();
        } else {

            return view('pages.dinamicpricing.index');
        }
    }


    public function create()
    {
        return view('pages.dinamicpricing.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $hotel_id = $request->session()->get('hotel_id');
        $user_id = Auth::user()->id;
        $dicountDynamicPricing = DiscountDynamicPricing::create(
            [
                'hotel_id' => $hotel_id, 'user_id' => $user_id, 'name' => $request->name
            ]
        );
        foreach ($request->start_occupancy as $key => $value) {
            $dicountDynamicPricing->discount_dynamic_pricing_details()->create([
                'user_id' => $user_id,
                'start_occupancy' => $request->start_occupancy[$key],
                'end_occupancy' => $request->end_occupancy[$key],
                'start_percentage' => $request->start_percentage[$key],
                'end_percentage' => $request->end_percentage[$key],
            ]);
        }

        return redirect(route('dynamic-pricing.index'))->with('message_success', 'Dynamic Pricing Discount has been created!!');
    }


    public function edit($id)
    {
        $dicountDynamicPricing = DiscountDynamicPricing::with('discount_dynamic_pricing_details')->findOrFail($id);
        return view('pages.dinamicpricing.update', compact('dicountDynamicPricing'));
    }


    public function update(Request $request, $id)
    {
        $dicountDynamicPricing = DiscountDynamicPricing::findOrFail($id);
        $request->validate([
            'name' => 'required'
        ]);

        $user_id = Auth::user()->id;
        $dicountDynamicPricing->update(
            [
                'user_id' => $user_id, 'name' => $request->name
            ]
        );
        $dicountDynamicPricing->discount_dynamic_pricing_details()->delete();
        if ($request->start_occupancy) {
            foreach ($request->start_occupancy as $key => $value) {
                $dicountDynamicPricing->discount_dynamic_pricing_details()->create([
                    'user_id' => $user_id,
                    'start_occupancy' => $request->start_occupancy[$key],
                    'end_occupancy' => $request->end_occupancy[$key],
                    'start_percentage' => $request->start_percentage[$key],
                    'end_percentage' => $request->end_percentage[$key],
                ]);
            }
        }


        return redirect(route('dynamic-pricing.index'))->with('message_success', 'Dynamic Pricing Discount has been updated!!');
    }


    public function destroy($id)
    {
        $dicountDynamicPricing = DiscountDynamicPricing::findOrFail($id);
        $dicountDynamicPricing->active =  ($dicountDynamicPricing->active ? 0 : 1);
        $dicountDynamicPricing->save();
        return response()->json($dicountDynamicPricing);
    }
}
