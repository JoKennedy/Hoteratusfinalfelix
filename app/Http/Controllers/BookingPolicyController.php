<?php

namespace App\Http\Controllers;

use App\BookingPolicy;
use App\WebPolicyType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingPolicyController extends Controller
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
            $cancellationsPolicy = BookingPolicy::with('web_policy_type')->where('hotel_id', '=', $hotel_id);
            if ($request->active != '') {
                $cancellationsPolicy->where('active',  $request->active);
            }

            return datatables()->of($cancellationsPolicy)
                ->addColumn('btn', 'pages.bookingpolicy.actions')
                ->addColumn('before', function (BookingPolicy $policy) {
                    return ($policy->before == null  ? "This Booking Policy is valid for all the other days where a Booking period is not defined" : ("Less Than $policy->before " . ($policy->before_type == 1 ? 'Day(s)' : 'Hour(s)')));
                })
                ->addColumn('bookingtype', function (BookingPolicy $policy) {
                    return $policy->web_policy_type->name;
                })
                ->addColumn('charge', function (BookingPolicy $policy) {
                    return $policy->charge==null? "--": "$policy->charge " .
                    ($policy->charge_type_id == 1 ? '% of Booking' : ($policy->charge_type_id == 2 ? '$' : 'Room Night'));
                })
                ->addColumn('status', 'pages.bookingpolicy.status')
                ->rawColumns(['btn', 'status'])
                ->make();
        } else {

            return view('pages.bookingpolicy.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $webPolicyType = WebPolicyType::all();

        return view('pages.bookingpolicy.create', compact('webPolicyType'));
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
        ]);
        $policy = BookingPolicy::create(["hotel_id" => $request->session()->get('hotel_id'), 'user_id' => Auth::user()->id] + $request->all());

        return redirect(route('booking-policy.index'))->with('message_success', "Booking Policy [$policy->name] was created successfully");

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BookingPolicy  $bookingPolicy
     * @return \Illuminate\Http\Response
     */
    public function show(BookingPolicy $bookingPolicy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BookingPolicy  $bookingPolicy
     * @return \Illuminate\Http\Response
     */
    public function edit(BookingPolicy $bookingPolicy)
    {
        $webPolicyType = WebPolicyType::all();
        return view('pages.bookingpolicy.update', compact('webPolicyType', 'bookingPolicy'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BookingPolicy  $bookingPolicy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BookingPolicy $bookingPolicy)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $bookingPolicy->update($request->all());

        return redirect(route('booking-policy.index'))->with('message_success', "Booking Policy [$bookingPolicy->name] has been updated");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BookingPolicy  $bookingPolicy
     * @return \Illuminate\Http\Response
     */
    public function destroy(BookingPolicy $bookingPolicy)
    {
        $bookingPolicy->delete();

        return response()->json(['success' => true]);
    }
}
