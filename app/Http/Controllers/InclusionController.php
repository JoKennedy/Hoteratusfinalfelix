<?php

namespace App\Http\Controllers;

use App\CalculationRule;
use App\Inclusion;
use App\PosPoint;
use App\PostingRhythm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class InclusionController extends Controller
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
            $inclusion = Inclusion::where('hotel_id', $hotel_id);
            if ($request->active != '') {
                $inclusion->where('active',  $request->active);
            }

            return datatables()->of($inclusion)
                ->addColumn('btn', 'pages.inclusion.actions')
                ->addColumn('status', 'pages.inclusion.status')
                ->addColumn('public_web', '{{$public_web?"Yes":"NO"}}')
                ->addColumn('price', function(Inclusion $inclusion){
                    return $inclusion->price_after_discount();
                })
                ->rawColumns(['btn', 'status', 'public_web', 'price'])
                ->make();
        } else {

            return view('pages.inclusion.index', );
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
        $posPoint = PosPoint::where('hotel_id', $hotel_id)->where('active', 1)->get();
        $calculationRules = CalculationRule::where('active', 1)->get();
        $postingRhythms = PostingRhythm::where('active', 1)->get();
        return view('pages.inclusion.create', compact('posPoint', 'postingRhythms', 'calculationRules'));
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
            'name' => ['required', Rule::unique('inclusions')->where(function ($query) use ($request, $hotel_id) {
                return $query->where('name', $request->name)->where('hotel_id', $hotel_id);
            })],
            'description' => 'required',
            'code' => 'required', 'pos_product_id' => 'required',
            'calculation_rule_id' => 'required', 'posting_rhythm_id' => 'required',
            'price' => 'required',

        ]);
        $user_id = Auth::user()->id;
        $inclusion = Inclusion::create([
            'hotel_id' =>  $hotel_id, 'user_id' => $user_id, 'name' => $request->name,
            'code' =>$request->code , 'description' => $request->description,
            'pos_product_id' => $request->pos_product_id, 'price' => $request->price,
            'update_price' => $request->update_price?1:0, 'discount' => $request->discount,
            'discount_type' => $request->discount_type[0],
            'calculation_rule_id' => $request->calculation_rule_id,
            'posting_rhythm_id' => $request->posting_rhythm_id, 'public_web' => $request->public_web?1:0
        ]);

        if ($request->file('image')) {

            foreach ($request->file('image') as $key => $value) {
                $inclusion->images()->create([
                    'url' => $value->store('inclusion', 'public'),
                    'caption' => $request->imagename[$key]
                ]);
            }
        }

        return redirect(route('inclusions.index'))
        ->with('message_success', "Add-ons [$inclusion->name] has been created successfully");

    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Inclusion  $inclusion
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Inclusion $inclusion)
    {
        $hotel_id = $request->session()->get('hotel_id');
        $posPoint = PosPoint::where('hotel_id', $hotel_id)->where('active', 1)->get();
        $calculationRules = CalculationRule::where('active', 1)->get();
        $postingRhythms = PostingRhythm::where('active', 1)->get();
        return view('pages.inclusion.update', compact('posPoint', 'postingRhythms', 'calculationRules', 'inclusion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Inclusion  $inclusion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inclusion $inclusion)
    {
        $hotel_id = $request->session()->get('hotel_id');
        $request->validate([
            'name' => ['required', Rule::unique('inclusions')->where(function ($query) use ($request, $hotel_id, $inclusion) {
                return $query->where('name', $request->name)->where('hotel_id', $hotel_id)->where('id', '!=', $inclusion->id);
            })],
            'description' => 'required',
            'code' => 'required', 'pos_product_id' => 'required',
            'calculation_rule_id' => 'required', 'posting_rhythm_id' => 'required',
            'price' => 'required',

        ]);
        $user_id = Auth::user()->id;
        $inclusion->update([
            'user_id' => $user_id, 'name' => $request->name,
            'code' => $request->code, 'description' => $request->description,
            'pos_product_id' => $request->pos_product_id, 'price' => $request->price,
            'update_price' => $request->update_price ? 1 : 0, 'discount' => $request->discount,
            'discount_type' => $request->discount_type[0],
            'calculation_rule_id' => $request->calculation_rule_id,
            'posting_rhythm_id' => $request->posting_rhythm_id, 'public_web' => $request->public_web ? 1 : 0
        ]);

        if ($request->file('image')) {

            foreach ($request->file('image') as $key => $value) {
                $inclusion->images()->create([
                    'url' => $value->store('inclusion', 'public'),
                    'caption' => $request->imagename[$key]
                ]);
            }
        }

        return redirect(route('inclusions.index'))
        ->with('message_success', "Add-ons [$inclusion->name] has been updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Inclusion  $inclusion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inclusion $inclusion)
    {
        $inclusion->active =  ($inclusion->active ? 0 : 1);
        $inclusion->save();
        return response()->json($inclusion);
    }
}
