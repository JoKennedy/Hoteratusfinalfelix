<?php

namespace App\Http\Controllers;

use App\ProductCategory;
use App\ProductSubcategory;
use App\PropertyDepartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProductSubcategoryController extends Controller
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
            $subCategories = ProductSubcategory::withCount('products')->where('product_category_id', $request->product_category_id);
            if ($request->active != '') {
                $subCategories->where('active',  $request->active);
            }

            return datatables()->of($subCategories)
                ->addColumn('btn', 'pages.productsubcategory.actions')
                ->addColumn('status', 'pages.productsubcategory.status')
                ->addColumn('products', 'pages.productsubcategory.product')
                ->rawColumns(['btn', 'status', 'products'])
                ->make();
        } else {
            if (!$request->product_category_id) {
                return redirect(route('productcategories.index'))->with('message_warning', "Select a Category to continue!!");
            }
            $category = ProductCategory::findOrFail($request->product_category_id);
            $product_category_id = $request->product_category_id;
            return view('pages.productsubcategory.index', compact('category', 'product_category_id'));
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
        $category = ProductCategory::findOrFail($request->product_category_id);
        return view('pages.productsubcategory.create', compact('departments', 'category'));
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
            'name' => ['required', Rule::unique('product_subcategories')->where(function ($query) use ($request) {
                return $query->where('name', $request->name)->where('product_category_id', $request->product_category_id);
            })],
            'description' => 'required'
        ]);
        $user = Auth::user();
        $subCategory = ProductSubcategory::create(['user_id' => $user->id, "hotel_id" => $hotel_id] + $request->all());

        return redirect(route('productsubcategories.index',['product_category_id'=> $request->product_category_id] ))
        ->with('message_success', "Subcategory [$subCategory->name] has been created successfully");
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductSubcategory  $productSubcategory
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,  $id)
    {   $subCategory = ProductSubcategory::findOrFail($id);
        $hotel_id = $request->session()->get('hotel_id');
        $departments = PropertyDepartment::where('hotel_id', $hotel_id)->where('active', 1)->get();
        $category = ProductCategory::findOrFail($subCategory->product_category_id);
        return view('pages.productsubcategory.update', compact('departments', 'category', 'subCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductSubcategory  $productSubcategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $subCategory = ProductSubcategory::findOrFail($id);
        $hotel_id = $request->session()->get('hotel_id');
        $request->validate([
            'name' => ['required', Rule::unique('product_subcategories')->where(function ($query) use ($request, $subCategory) {
                return $query->where('name', $request->name)->where('id','!=', $subCategory->id)->where('product_category_id', $request->product_category_id);
            })],
            'description' => 'required'
        ]);

        $user = Auth::user();
        $subCategory->update(['user_id' => $user->id] + $request->all());

        return redirect(route('productsubcategories.index', ['product_category_id' => $subCategory->product_category_id]))
            ->with('message_success', "Subcategory [$subCategory->name] has been updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductSubcategory  $productSubcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subCategory = ProductSubcategory::findOrFail($id);
        $subCategory->active =  ($subCategory->active ? 0 : 1);
        $subCategory->save();
        return response()->json($subCategory);
    }
    public function list(Request $request){

        $subcategories = ProductSubcategory::where('product_category_id', $request->product_category_id)->where('active',1)->get();

        return response()->json(['data' => $subcategories, 'success' => true], 200);

    }
}
