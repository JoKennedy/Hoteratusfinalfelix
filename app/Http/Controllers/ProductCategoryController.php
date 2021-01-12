<?php

namespace App\Http\Controllers;

use App\ProductCategory;
use App\PropertyDepartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProductCategoryController extends Controller
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
            $categories = ProductCategory::withCount('subcategories')->where('hotel_id', $hotel_id);
            if ($request->active != '') {
                $categories->where('active',  $request->active);
            }

            return datatables()->of($categories)
                ->addColumn('btn', 'pages.productcategory.actions')
                ->addColumn('status', 'pages.productcategory.status')
                ->addColumn('subcategories', 'pages.productcategory.subcategory')
                ->rawColumns(['btn', 'status', 'subcategories'])
                ->make();
        } else {

            return view('pages.productcategory.index');
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
        $departments = PropertyDepartment::where('hotel_id', $hotel_id)->where('active', 1)->get();

        return view('pages.productcategory.create', compact('departments'));
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
            'name' => ['required', Rule::unique('product_categories')->where(function ($query) use ($request, $hotel_id) {
                return $query->where('name', $request->name)->where('hotel_id', $hotel_id);
            })],
            'description' => 'required'
        ]);
        $user = Auth::user();
        $category = ProductCategory::create(['user_id'=> $user->id,"hotel_id" => $hotel_id] + $request->all());

        return redirect(route('productcategories.index'))->with('message_success', "Category [$category->name] has been created successfully");
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $category = ProductCategory::findOrFail($id);
        $hotel_id = $request->session()->get('hotel_id');
        $departments = PropertyDepartment::where('hotel_id', $hotel_id)->where('active', 1)->get();
        return view('pages.productcategory.update', compact('category', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = ProductCategory::findOrFail($id);
        $hotel_id = $request->session()->get('hotel_id');
        $request->validate([
            'name' => ['required', Rule::unique('product_categories')->where(function ($query) use ($request, $hotel_id, $category) {
                return $query->where('name', $request->name)->where('hotel_id', $hotel_id)->where('id','!=', $category->id);
            })],
            'description' => 'required'
        ]);

        $user = Auth::user();
        $category->update(['user_id'=> $user->id]+$request->all());
        return redirect(route('productcategories.index'))->with('message_success', "Category [$category->name] has been update successfully");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = ProductCategory::findOrFail($id);
        $category->active =  ($category->active ? 0 : 1);
        $category->save();
        return response()->json($category);
    }
}
