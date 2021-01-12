<?php

namespace App\Http\Controllers;

use App\SeasonAttribute;
use App\SpecialPeriod;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class SpecialPeriodController extends Controller
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
            $specialPeriod = SpecialPeriod::with('season_attribute')->where('hotel_id', '=',  $hotel_id)

                ->orderby('start', 'asc');
            if ($request->active != '') {
                $specialPeriod->where('active',  $request->active);
            }

            return datatables()->of($specialPeriod)
                ->addColumn('btn', 'pages.specialperiod.actions')
                ->addColumn('seasonattribute', function (SpecialPeriod $specialPeriod) {
                    return $specialPeriod->season_attribute->name;
                })
                ->addColumn('startdate', function (SpecialPeriod $specialPeriod) {
                    return date('d/m/Y', strtotime($specialPeriod->start));
                })
                ->addColumn('enddate', function (SpecialPeriod $specialPeriod) {
                    return date('d/m/Y', strtotime($specialPeriod->end));
                })
                ->addColumn('duration', function (SpecialPeriod $specialPeriod) {
                    return $specialPeriod->duration();
                })
                ->addColumn('delete', 'pages.specialperiod.status')
                ->rawColumns(['seasonattribute', 'startdate', 'enddate',  'duration', 'btn', 'delete',])
                ->make();
        } else {

            return view('pages.specialperiod.index');
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
        $seasonAttribute = SeasonAttribute::where('hotel_id', $hotel_id)->get();

        return view('pages.specialperiod.create', compact('seasonAttribute'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $start = $this->formatDate($request->start);
        $end =  $this->formatDate($request->end);
        $hotel_id = $request->session()->get('hotel_id');
        $request->validate([
            'name' => 'required',
            'season_attribute_id' => 'required',
            'start' => 'required|date_format:d/m/Y',
            'end' => 'required|date_format:d/m/Y|after:start',
        ]);

        $valStart = SpecialPeriod::whereRaw(" ('$start' between special_periods.start and special_periods.end
        or '$end' between special_periods.start and special_periods.end  ) and hotel_id = $hotel_id")->count();

        if ($valStart > 0) {

            $specialPeriod = $request->all();
            $hotel_id = $request->session()->get('hotel_id');
            $seasonAttribute = SeasonAttribute::where('hotel_id', $hotel_id)->get();
            $message_error =  'The specified Special Period cannot be added as the dates overlap the existing Special Period.';
            return view('pages.specialperiod.create', compact('seasonAttribute', 'specialPeriod', 'message_error'));
        }


        $specialPeriod = SpecialPeriod::create([
            'hotel_id' =>  $hotel_id,
            'name' => $request->name,
            'start' => $start,
            'end' => $end,
            'season_attribute_id' => $request->season_attribute_id
        ]);

        return redirect('special-periods')->with('message_success', 'Special Period was created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SpecialPeriod  $specialPeriod
     * @return \Illuminate\Http\Response
     */
    public function show(SpecialPeriod $specialPeriod)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SpecialPeriod  $specialPeriod
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id )
    {
        $specialPeriod = SpecialPeriod::findOrFail($id);

        $hotel_id = $request->session()->get('hotel_id');

        if (($specialPeriod->hotel_id ?? '') != $hotel_id) {
            return   redirect('admin-season')->with('message_success', "You do not have access through this hotel");
        }
        $specialPeriod['start'] = date('d/m/Y', strtotime($specialPeriod['start']));
        $specialPeriod['end'] = date('d/m/Y', strtotime($specialPeriod['end']));
        $seasonAttribute = SeasonAttribute::where('hotel_id', $hotel_id)->get();
        return view('pages.specialperiod.update', compact('seasonAttribute', 'specialPeriod'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SpecialPeriod  $specialPeriod
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SpecialPeriod $specialPeriod)
    {


        $hotel_id = $request->session()->get('hotel_id');
        $request->validate([
            'name' => 'required',
            'season_attribute_id' => 'required',
            'start' => 'required|date_format:d/m/Y',
            'end' => 'required|date_format:d/m/Y|after:start',
        ]);

        $start = $this->formatDate($request->start);
        $end =  $this->formatDate($request->end);

        $valStart = SpecialPeriod::whereRaw(" ('$start' between special_periods.start and special_periods.end
        or '$end' between special_periods.start and special_periods.end  ) and hotel_id = $hotel_id and id != $specialPeriod->id ")->count();

        if ($valStart > 0) {

            $specialPeriod->name = $request->name;
            $specialPeriod->start = $request->start;
            $specialPeriod->end = $request->end;
            $specialPeriod->season_attribute_id = $request->season_attribute_id;
            $hotel_id = $request->session()->get('hotel_id');
            $seasonAttribute = SeasonAttribute::where('hotel_id', $hotel_id)->get();
            $message_error =  'The specified Special Period cannot be added as the dates overlap the existing Special Period.';
            return view('pages.specialperiod.update', compact('seasonAttribute', 'specialPeriod', 'message_error'));
        }


        if (($specialPeriod->hotel_id ?? '') != $hotel_id) {
            return   redirect('special-periods')->with('message_success', "You do not have access through this hotel");
        }

        $specialPeriod->update([
            'name' => $request->name,
            'start' => $start,
            'end' => $end,
            'season_attribute_id' => $request->season_attribute_id
        ]);


        return redirect('special-periods')->with('message_success', "Special Period [$specialPeriod->name] has been updated");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SpecialPeriod  $specialPeriod
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $specialPeriod = SpecialPeriod::findOrFail($id);
        $specialPeriod->active =  ($specialPeriod->active ? 0 : 1);
        $specialPeriod->save();
        return response()->json($specialPeriod);
    }

    private function formatDate(string $date)
    {
        return substr($date, 6, 4) . '-' . substr($date, 3, 2) . '-' . substr($date, 0, 2);
    }
}
