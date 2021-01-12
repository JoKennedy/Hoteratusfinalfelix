<?php

namespace App\Http\Controllers;

use App\Floor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FloorController extends Controller
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
            $floors = Floor::withCount(['rooms'])->where('hotel_id', '=', $hotel_id);
            if ($request->active != '') {
                $floors->where('active',  $request->active);
            }

            return datatables()->of($floors)
                ->addColumn('btn', 'pages.floor.actions')
                ->addColumn('btnrooms', 'pages.floor.rooms')
                ->addColumn('status', 'pages.floor.status')
                ->rawColumns(['btnrooms', 'btn', 'status'])
                ->make();
        } else {

            return view('pages.floor.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.floor.create');
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

        $floor = Floor::create(["hotel_id" => $hotel_id] + $request->all());

        return redirect(route('floors.index'))->with('message_success', 'Floor was created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Floor  $floor
     * @return \Illuminate\Http\Response
     */
    public function show(Floor $floor)
    {
        return view('pages.floor.show', compact('floor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Floor  $floor
     * @return \Illuminate\Http\Response
     */
    public function edit(Floor $floor)
    {
        return view('pages.floor.update', compact('floor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Floor  $floor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Floor $floor)
    {
        $floor->update($request->all());

        return back()->with('message_success', "Floor [$request->name] has been updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Floor  $floor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Floor $floor)
    {
        $floor->active =  ($floor->active ? 0 : 1);
        $floor->save();
        return response()->json($floor);
    }
}
