<?php

namespace App\Http\Controllers;

use App\PropertyDepartment;
use Illuminate\Http\Request;

class PropertyDepartmentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
           $hotel_id = $request->session()->get('hotel_id');
            $departments = PropertyDepartment::where('hotel_id',$hotel_id);
            if ($request->active != '') {
                $departments->where('active',  $request->active);
            }

            return datatables()->of($departments)
                ->addColumn('btn', 'pages.department.actions')
                ->addColumn('status', 'pages.department.status')
                ->rawColumns(['btn', 'status'])
                ->make();
        } else {

            return view('pages.department.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.department.create');
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
        $floor = PropertyDepartment::create(["hotel_id" => $hotel_id] + $request->all());

        return redirect(route('departments.index'))->with('message_success', 'Department was created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Floor  $floor
     * @return \Illuminate\Http\Response
     */
    public function show(PropertyDepartment $department)
    {
        return view('pages.department.show', compact('department'));
    }


    public function edit(PropertyDepartment $department)
    {
        return view('pages.department.update', compact('department'));
    }


    public function update(Request $request, PropertyDepartment $department)
    {
        $department->update($request->all());

        return back()->with('message_success', "Department [$request->name] has been updated");
    }


    public function destroy(PropertyDepartment $department)
    {
        $department->active =  ($department->active ? 0 : 1);
        $department->save();
        return response()->json($department);
    }
}
