<?php

namespace App\Http\Controllers;

use App\DiscountLastMinute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscountLastMinuteController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $hotel_id = $request->session()->get('hotel_id');
            $dicountLastMinute = DiscountLastMinute::where('hotel_id', '=', $hotel_id);
            if ($request->active != '') {
                $dicountLastMinute->where('active',  $request->active);
            }

            return datatables()->of($dicountLastMinute)
                ->addColumn('btn', 'pages.lastminute.actions')
                ->addColumn('discountrule', function (DiscountLastMinute $dicountLastMinute) {
                    $result = '';
                    foreach ($dicountLastMinute->discount_last_minute_details as $key => $value) {
                        $result .= "<div class='row'>For days from $value->start to $value->end, discount applicable is " . number_format($value->start_percentage, 2) . "% to " . number_format($value->end_percentage, 2) . "%.</div>";
                    }
                    return $result;
                })
                ->addColumn('status', 'pages.lastminute.status')
                ->rawColumns(['discountrule', 'btn', 'status'])
                ->make();
        } else {

            return view('pages.lastminute.index');
        }
    }


    public function create()
    {
        return view('pages.lastminute.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $hotel_id = $request->session()->get('hotel_id');
        $user_id = Auth::user()->id;
        $dicountLastMinute = DiscountLastMinute::create(
            [
                'hotel_id' => $hotel_id, 'user_id' => $user_id, 'name' => $request->name
            ]
        );
        foreach ($request->start as $key => $value) {
            $dicountLastMinute->discount_last_minute_details()->create([
                'user_id' => $user_id,
                'start' => $request->start[$key],
                'end' => $request->end[$key],
                'start_percentage' => $request->start_percentage[$key],
                'end_percentage' => $request->end_percentage[$key],
            ]);
        }

        return redirect(route('last-minute-discount.index'))->with('message_success', 'Last Minute Discount has been created!!');
    }


    public function edit($id)
    {
        $dicountLastMinute = DiscountLastMinute::with('discount_last_minute_details')->findOrFail($id);
        return view('pages.lastminute.update', compact('dicountLastMinute'));
    }


    public function update(Request $request, $id)
    {
        $dicountLastMinute = DiscountLastMinute::findOrFail($id);
        $request->validate([
            'name' => 'required'
        ]);

        $user_id = Auth::user()->id;
        $dicountLastMinute->update(
            [
                'user_id' => $user_id, 'name' => $request->name
            ]
        );
        $dicountLastMinute->discount_last_minute_details()->delete();
        if ($request->start) {
            foreach ($request->start as $key => $value) {
                $dicountLastMinute->discount_last_minute_details()->create([
                    'user_id' => $user_id,
                    'start' => $request->start[$key],
                    'end' => $request->end[$key],
                    'start_percentage' => $request->start_percentage[$key],
                    'end_percentage' => $request->end_percentage[$key],
                ]);
            }
        }


        return redirect(route('last-minute-discount.index'))->with('message_success', 'Last Minute Discount has been updated!!');
    }


    public function destroy($id)
    {
        $dicountLastMinute = DiscountLastMinute::findOrFail($id);
        $dicountLastMinute->active =  ($dicountLastMinute->active ? 0 : 1);
        $dicountLastMinute->save();
        return response()->json($dicountLastMinute);
    }
}
