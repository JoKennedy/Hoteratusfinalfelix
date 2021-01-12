<?php

namespace App\Http\Controllers;

use App\DiscountEarlyBird;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscountEarlyBirdController extends Controller
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
            $discountEarlyBird = DiscountEarlyBird::where('hotel_id', '=', $hotel_id);
            if ($request->active != '') {
                $discountEarlyBird->where('active',  $request->active);
            }

            return datatables()->of($discountEarlyBird)
                ->addColumn('btn', 'pages.earlybird.actions')
                ->addColumn('discountrule', function (DiscountEarlyBird $discountEarlyBird ){
                    $result ='';
                    foreach ($discountEarlyBird->discount_early_bird_details as $key => $value) {
                        $result .= "<div class='row'>For days from $value->start to $value->end, discount applicable is ".number_format($value->start_percentage,2)."% to ".number_format($value->end_percentage,2)."%.</div>";
                    }
                    return $result;
                })
                ->addColumn('status', 'pages.earlybird.status')
                ->rawColumns(['discountrule', 'btn', 'status'])
                ->make();
        } else {

            return view('pages.earlybird.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.earlybird.create');
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
            'name' => 'required'
        ]);

        $hotel_id = $request->session()->get('hotel_id');
        $user_id = Auth::user()->id;
        $discountEarlyBird = DiscountEarlyBird::create(
            [
                'hotel_id' => $hotel_id, 'user_id'=> $user_id , 'name' => $request->name
            ]);
        foreach ($request->start as $key => $value) {
            $discountEarlyBird->discount_early_bird_details()->create([
                'user_id' => $user_id,
                'start' => $request->start[$key],
                'end' => $request->end[$key],
                'start_percentage' => $request->start_percentage[$key],
                'end_percentage' => $request->end_percentage[$key],
            ]);
        }

        return redirect(route('early-bird-discount.index'))->with('message_success','Early Bird Discount has been created!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DiscountEarlyBird  $discountEarlyBird
     * @return \Illuminate\Http\Response
     */
    public function show(DiscountEarlyBird $discountEarlyBird)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DiscountEarlyBird  $discountEarlyBird
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $discountEarlyBird = DiscountEarlyBird::with('discount_early_bird_details')->findOrFail($id);
        return view('pages.earlybird.update', compact('discountEarlyBird'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DiscountEarlyBird  $discountEarlyBird
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $discountEarlyBird = DiscountEarlyBird::findOrFail($id);
        $request->validate([
            'name' => 'required'
        ]);

        $hotel_id = $request->session()->get('hotel_id');
        $user_id = Auth::user()->id;
        $discountEarlyBird->update(
            [
                'user_id' => $user_id, 'name' => $request->name
            ]
        );
        $discountEarlyBird->discount_early_bird_details()->delete();
        if($request->start){
            foreach ($request->start as $key => $value) {
                $discountEarlyBird->discount_early_bird_details()->create([
                    'user_id' => $user_id,
                    'start' => $request->start[$key],
                    'end' => $request->end[$key],
                    'start_percentage' => $request->start_percentage[$key],
                    'end_percentage' => $request->end_percentage[$key],
                ]);
            }
        }


        return redirect(route('early-bird-discount.index'))->with('message_success', 'Early Bird Discount has been updated!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DiscountEarlyBird  $discountEarlyBird
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $discountEarlyBird = DiscountEarlyBird::findOrFail($id);
        $discountEarlyBird->active =  ($discountEarlyBird->active ? 0 : 1);
        $discountEarlyBird->save();
        return response()->json($discountEarlyBird);
    }
}
