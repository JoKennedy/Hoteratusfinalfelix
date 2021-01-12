<?php

namespace App\Http\Controllers;

use App\PosPoint;
use App\PosType;
use App\PrintType;
use App\PropertyDepartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PosPointController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $hotel_id = $request->session()->get('hotel_id');
            $postPoints = PosPoint::where('hotel_id', $hotel_id);
            if ($request->active != '') {
                $postPoints->where('active',  $request->active);
            }

            return datatables()->of($postPoints)
                ->addColumn('products', '--')
                ->addColumn('tables', '--')
                ->addColumn('availability', '--')
                ->addColumn('shifts', '--')
                ->addColumn('paymentmethods', '--')
                ->addColumn('status', 'pages.pospoints.status')
                ->addColumn('btn', 'pages.pospoints.actions')
                ->rawColumns(['btn', 'status', 'categories', 'products', 'tables', 'availability', 'shifts', 'paymentmethods'])
                ->make();
        } else {

            return view('pages.pospoints.index');
        }
    }

    public function create(Request $request)
    {
        $hotel_id = $request->session()->get('hotel_id');
        $departments = PropertyDepartment::where('hotel_id', $hotel_id  )->where('active',1)->get();
        $printTypes = PrintType::where('active', 1)->get();
        $posTypes = PosType::where('active', 1)->get();
        return view('pages.pospoints.create', compact('departments', 'printTypes', 'posTypes'));
    }

    public function store(Request $request){

        $hotel_id = $request->session()->get('hotel_id');
        $request->validate([
            'name' => ['required', Rule::unique('pos_points')->where(function ($query) use ($request, $hotel_id) {
                return $query->where('name', $request->name)->where('hotel_id', $hotel_id);
            })],
            'description' => 'required'
        ]);
        $user = Auth::user();
        PosPoint::create(['hotel_id'=> $hotel_id, 'user_id' => $user->id] + $request->all() );

        return redirect('pospoints')->with('message_success', "New POS has been created!!");

    }
    public function destroy($id)
    {
        $posPoint = PosPoint::findOrFail($id);
        $user = Auth::user();
        $posPoint->active =  ($posPoint->active ? 0 : 1);
        $posPoint->user_id = $user->id;
        $posPoint->save();
        return response()->json($posPoint);
    }
}
