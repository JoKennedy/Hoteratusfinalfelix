<?php

namespace App\Http\Controllers;

use App\SeasonAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SeasonAttributeController extends Controller
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
            $seasonAttribute = SeasonAttribute::where('hotel_id', '=', $hotel_id);

            if ($request->active != '') {
                $seasonAttribute->where('active',  $request->active);
            }

            return datatables()->of($seasonAttribute)
                ->addColumn('btn', 'pages.seasonattribute.actions')
                ->addColumn('status', 'pages.seasonattribute.status')
                ->rawColumns(['btnrooms', 'btn', 'status'])
                ->make();
        } else {

            return view('pages.seasonattribute.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.seasonattribute.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        $hotel_id = $request->session()->get('hotel_id');

        SeasonAttribute::create(['hotel_id' =>  $hotel_id , 'name' => $request->name]);

        return redirect('seasons-attribute')->with('message_success', 'Seasons Attribute has been created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SeasonAttribute  $seasonAttribute
     * @return \Illuminate\Http\Response
     */
    public function show(SeasonAttribute $seasonAttribute)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SeasonAttribute  $seasonAttribute
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $seasonAttribute = SeasonAttribute::find($id);

        if($seasonAttribute->hotel_id != Session::get('hotel_id') ){
            return redirect('seasons-attribute')->with('message_success', "You can't access to see this Season Attribute through the current hotel");
        }
        return view('pages.seasonattribute.update', compact('seasonAttribute'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SeasonAttribute  $seasonAttribute
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $seasonAttribute = SeasonAttribute::find($id);
        $hotel_id = $request->session()->get('hotel_id');
        if ($seasonAttribute->hotel_id != Session::get('hotel_id')) {
            return redirect('seasons-attribute')->with('message_success', "You can't access to see this Season Attribute through the current hotel");
        }
        $request->validate(['name' => 'required']);
        $seasonAttribute->update($request->all());

        return redirect('seasons-attribute')->with('message_success', 'Seasons Attribute has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SeasonAttribute  $seasonAttribute
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $seasonAttribute = SeasonAttribute::find($id);
        $seasonAttribute->active =  ($seasonAttribute->active ? 0 : 1);
        $seasonAttribute->save();
        return response()->json($request->all());
    }
}
