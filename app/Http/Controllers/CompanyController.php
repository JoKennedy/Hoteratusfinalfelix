<?php

namespace App\Http\Controllers;

use App\Company;
use App\Country;
use App\Salutation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        $company = Company::where('owner_id', $user->owner_id ?? $user->id)->first()->load('billing_address', 'billing_contact');

        $countries = Country::all();
        $salutations = Salutation::all();

       // $company->billing_contact()->create([]);
      //  dd($company);
        return view('pages.company.index', compact('user', 'company', 'countries', 'salutations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {

        DB::transaction( function () use ($request) {

            $user = Auth::user();
            $company = Company::where('owner_id', $user->owner_id ?? $user->id)->first()->load('billing_address', 'billing_contact');
            $company->billing_address->update($request->billing);
            $company->billing_contact->update($request->contact);
            $company->update($request->company);

        });


        return redirect( route('company.index'))->with('message_success', 'Company was updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        //
    }
}
