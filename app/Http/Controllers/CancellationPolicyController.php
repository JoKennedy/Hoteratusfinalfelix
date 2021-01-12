<?php

namespace App\Http\Controllers;

use App\CancellationPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CancellationPolicyController extends Controller
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
            $cancellationsPolicy = CancellationPolicy::where('hotel_id', '=', $hotel_id);
            if ($request->active != '') {
                $cancellationsPolicy->where('active',  $request->active);
            }

            return datatables()->of($cancellationsPolicy)
                ->addColumn('btn', 'pages.cancellationpolicy.actions')
                ->addColumn('before', function (CancellationPolicy $policy){
                    return ($policy->before == null  ? "This Cancellation Policy is valid for all the other days where a cancellation period is not defined":
                             ("Less Than $policy->before ". ($policy->before_type==1? 'Day(s)': 'Hour(s)')) );
                })
                ->addColumn('charge', function (CancellationPolicy $policy) {
                    return "$policy->charge " .
                    ($policy->charge_type_id == 1 ? '% of Booking' : ($policy->charge_type_id == 2 ? '$' : 'Room Night' ));
                })
                ->addColumn('status', 'pages.cancellationpolicy.status')
                ->rawColumns([ 'btn', 'status'])
                ->make();

        } else {

            return view('pages.cancellationpolicy.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.cancellationpolicy.create');
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
            'before_type' => 'required',
            'charge' => 'required',
            'charge_type_id' => 'required',
        ]);
        $policy = CancellationPolicy::create(["hotel_id" => $request->session()->get('hotel_id'), 'user_id'=> Auth::user()->id ] + $request->all());

        return redirect(route('cancellation-policy.index'))->with('message_success', "Cancellation Policy [$policy->name] was created successfully");

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CancellationPolicy  $cancellationPolicy
     * @return \Illuminate\Http\Response
     */
    public function show(CancellationPolicy $cancellationPolicy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CancellationPolicy  $cancellationPolicy
     * @return \Illuminate\Http\Response
     */
    public function edit(CancellationPolicy $cancellationPolicy)
    {
        return view('pages.cancellationpolicy.update', compact('cancellationPolicy'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CancellationPolicy  $cancellationPolicy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CancellationPolicy $cancellationPolicy)
    {
        $request->validate([
            'name' => 'required',
            'before_type' => 'required',
            'charge' => 'required',
            'charge_type_id' => 'required',
        ]);

        $cancellationPolicy->update($request->all());

        return redirect(route('cancellation-policy.index'))->with('message_success', "Cancellation Policy [$cancellationPolicy->name] has been updated");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CancellationPolicy  $cancellationPolicy
     * @return \Illuminate\Http\Response
     */
    public function destroy(CancellationPolicy $cancellationPolicy)
    {

        $cancellationPolicy->delete();

        return response()->json(['success' => true]);
    }
}
