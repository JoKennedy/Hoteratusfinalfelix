@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Company Profile')
{{-- vendor style --}}
@section('vendor-style')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/flag-icon/css/flag-icon.min.css')}}">
@endsection

{{-- page content --}}
@section('content')
<div class="section">
  <div class="row">
    <div class="col s12">

      <div id="validations" class="card card-tabs">

        <div class="card-content">
            <div class="card-title">
                <div class="row center">
                    <div class="col s12">
                        <h5 class="center-align" style="font-weight: 900;">Company Profile</h5>
                    </div>

                    <div class="col s12 m6 ">
                        <ul class="tabs">
                            <li class="tab col  p-5"><a class="active p-0" href="#details">Company Details</a></li>
                            <li class="tab col  p-5"><a class="p-0" href="#billig-address">Billing Address</a></li>
                            <li class="tab col  p-5"><a class="p-0" href="#billing-contact">Main Billing Contact </a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <form enctype="multipart/form-data" class="formValidate" action="{{ route('company.update') }}" style="margin-bottom: 20px;" id="formSubmit" method="POST">
                @csrf
                <div class="row s12 right">
                    <button type="submit" class="mb-6 btn waves-effect waves-light gradient-45deg-green-teal" >Save </button>
                    <a class="mb-6 btn waves-effect waves-light gradient-45deg-purple-deep-orange">Cancel</a>
                </div>
                <div class="row"></div>
                <div id="details">
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="name">Company Name*</label>
                            <input name="company[name]" type="text" value="{{old('company.name',$company['name'])}}" required>
                            @error('company.name')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="file-field input-field">
                            <div class="btn">
                                <span>Upload Company Logo</span>
                                <input name="image" type="file">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text" placeholder="(Image dimensions 274pxX130px)">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="address1">Address Line 1*</label>
                            <input name="company[address1]" type="text" value="{{old('company.address1',$company['address1'])}}" required>
                            @error('company.address1')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="prueba">Address Line 2</label>
                             <input name="company[address2]" type="text" value="{{old('company.address2',$company['address2'])}}" >
                            @error('company.address2')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <label for="country_id">Country*</label>
                            <div class="input-field">
                                <select  name="company[country_id]" value="{{old('company.country_id',$company['country_id'])}}" required >
                                    <option value="">Select a Country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{$country->id}}" {{$country->id == old('company.country_id',$company['country_id'])? 'selected' : '' }}>{{$country->country_name}}</option>
                                    @endforeach
                                </select>
                                @error('company.country_id')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="state">State*</label>
                            <input name="company[state]" value="{{old('company.state',$company['state'])}}" type="text" required>
                                @error('company.state')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6">
                            <label for="city">City*</label>
                            <input  name="company[city]" type="text" value="{{old('company.city',$company['city'])}}" required>
                                @error('company.city')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                        </div>
                        <div class="input-field col s6">
                            <label for="zip_code">Zip Code*</label>
                            <input  name="company[zip_code]" type="text" value="{{old('company.zip_code',$company['zip_code'])}}" >
                                @error('company.zip_code')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6">
                            <label for="phone">Phone*</label>
                            <input  name="company[phone]" type="text" value="{{old('company.phone',$company['phone'])}}" required >
                                @error('company.phone')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                        </div>
                        <div class="input-field col s6">
                            <label for="prueba">Fax</label>
                            <input  name="company[fax]" type="text" value="{{old('company.fax',$company['fax'])}}" >
                                @error('company.fax')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="website_address">Website Address</label>
                            <input name="company[website_address]" type="text" value="{{old('company.website_address',$company['website_address'])}}" >
                                @error('company.website_address')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="gst_number">GST No</label>
                            <input  name="company[gst_number]" type="text" value="{{old('company.gst_number',$company['gst_number'])}}"  >
                                @error('company.gst_number')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="description">Brief description of your Company</label>
                            <textarea class="materialize-textarea"  name="company[description]" type="text" >{{old('company.description',$company['description'])}}</textarea>
                                @error('company.description')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                        </div>
                    </div>
                </div>
                <div id="billig-address" style="display: none;">
                     <div class="row">
                        <div class="input-field col s12">
                            <label for="name">Billing Company Name</label>
                        <input name="billing[name]" type="text" value="{{old('billing.name',$company->billing_address->name)}}" >
                            @error('billing.name')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="prueba">Address Line 1*</label>
                            <input name="billing[address1]" type="text" value="{{old('billing.address1',$company->billing_address->address1)}}" >
                            @error('billing.address1')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>

                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="prueba">Address Line 2</label>
                            <input name="billing[address2]" type="text" value="{{old('billing.address2',$company->billing_address->address2)}}" >
                            @error('billing.address2')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                    </div>
                     <div class="row">
                        <div class="col s12">
                            <label for="billing[country_id]">Country*</label>
                            <div class="input-field">
                                <select  name="billing[country_id]" value="{{old('billing.country_id',$company->billing_address->country_id)}}"  >
                                    <option value="">Select a Country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{$country->id}}" {{$country->id == old('billing.country_id',$company->billing_address->country_id)? 'selected' : '' }}>{{$country->country_name}}</option>
                                    @endforeach
                                </select>
                                @error('billing.country_id')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="prueba">State*</label>
                            <input name="billing[state]" type="text" value="{{old('billing.state',$company->billing_address->state)}}" >
                            @error('billing.state')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6">
                            <label for="prueba">City*</label>
                            <input name="billing[city]" type="text" value="{{old('billing.city',$company->billing_address->city)}}" >
                            @error('billing.city')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>

                        <div class="input-field col s6">
                            <label for="prueba">Zip Code*</label>
                            <input name="billing[zip_code]" type="text" value="{{old('billing.zip_code',$company->billing_address->zip_code)}}" >
                            @error('billing.zip_code')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6">
                            <label for="prueba">Phone*</label>
                            <input name="billing[phone]" type="text" value="{{old('billing.phone',$company->billing_address->phone)}}" >
                            @error('billing.phone')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                        <div class="input-field col s6">
                            <label for="prueba">Fax</label>
                            <input name="billing[fax]" type="text" value="{{old('billing.fax',$company->billing_address->fax)}}" >
                            @error('billing.fax')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div id="billing-contact" style="display: none;">
                    <div class="row">
                        <div class="col s12">
                            <label for="crole">Salutation*</label>
                            <div class="input-field">
                            <select name="contact[salutation_id]" value="{{old('contact.salutation_id',$company->billing_contact->salutation_id)}}"  >
                                <option value="">Title</option>
                                @foreach ($salutations as $item)
                                    <option value="{{$item->id}}" {{$item->id == old('contact.salutation_id',$company->billing_contact->salutation_id) ? 'selected' : '' }} >{{$item->name}}</option>
                                @endforeach
                                </select>
                                 @error('contact.salutation_id')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="prueba">First Name*</label>
                            <input name="contact[first_name]" type="text" value="{{old('contact.first_name',$company->billing_contact->first_name)}}" >
                            @error('contact.first_name')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="prueba">Last Name*</label>
                            <input name="contact[last_name]" type="text" value="{{old('contact.last_name',$company->billing_contact->last_name)}}" >
                            @error('contact.last_name')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="prueba">Designation*</label>
                            <input name="contact[designation]" type="text" value="{{old('contact.designation',$company->billing_contact->designation)}}" >
                            @error('contact.designation')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s8">
                            <label for="prueba">Phone Office*</label>
                            <input name="contact[phone]" type="text" value="{{old('contact.phone',$company->billing_contact->phone)}}" >
                            @error('contact.phone')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                        <div class="input-field col s4">
                            <label for="prueba">Extn#</label>
                           <input name="contact[extension]" type="text" value="{{old('contact.extension',$company->billing_contact->extension)}}" >
                            @error('contact.extension')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                    </div>
                     <div class="row">
                        <div class="input-field col s4">
                            <label for="prueba">Fax</label>
                             <input name="contact[fax]" type="text" value="{{old('contact.fax',$company->billing_contact->fax)}}" >
                            @error('contact.fax')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                        <div class="input-field col s4">
                            <label for="prueba">Email*</label>
                            <input name="contact[email]" type="text" value="{{old('contact.email',$company->billing_contact->email)}}" >
                            @error('contact.email')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                        <div class="input-field col s4">
                            <label for="prueba">Mobile</label>
                             <input name="contact[mobile]" type="text" value="{{old('contact.mobile',$company->billing_contact->mobile)}}" >
                            @error('contact.mobile')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row s12 right">
                   <button type="submit" class="mb-6 btn waves-effect waves-light gradient-45deg-green-teal" >Save </button>
                    <a class="mb-6 btn waves-effect waves-light gradient-45deg-purple-deep-orange">Cancel</a>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

{{-- vendor script --}}
@section('vendor-script')
<script src="{{asset('vendors/jquery-validation/jquery.validate.min.js')}}"></script>
@endsection

{{-- page script --}}
@section('page-script')
<script src="{{asset('js/scripts/form-validation.js')}}"></script>
<script src="{{asset('js/scripts/ui-alerts.js')}}"></script>
@endsection
