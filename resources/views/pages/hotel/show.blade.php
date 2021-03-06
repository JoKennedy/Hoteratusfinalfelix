@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Hotel Information')
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
                        <h5 class="center-align" style="font-weight: 900;">Hotel Information</h5>
                         <div class="input-field col s12 center-align">
                            <img class="z-depth-4 circle responsive-img" width="75" src="{{$hotel->get_logo ?? 'https://ui-avatars.com/api/?name='.$hotel['name'].'&size=255'   }}" alt=""/>
                            <p>{{$hotel['name']}}</p>
                        </div>

                    </div>

                </div>

                 <div class="row">
                        <ul class="tabs">
                            <li class="tab col  p-5"><a class="active p-0" href="#details">Hotel Details</a></li>
                            <li class="tab col  p-5"><a class="p-0" href="#billig-address">Billing Address</a></li>
                            <li class="tab col  p-5"><a class="p-0" href="#billing-contact">Main Billing Contact </a></li>
                        </ul>
                </div>
            </div>

            <form enctype="multipart/form-data" class="formValidate" action="{{ route('hotel.update', $hotel['slug']) }}" style="margin-bottom: 20px;" id="formSubmit" method="POST">
                <div class="row s12 right">
                    <a href="{{ route('hotel.index') }}" class="mb-6 btn waves-effect waves-light gradient-45deg-purple-deep-orange">Hotel List</a>
                </div>
                <div class="row"></div>
                <div id="details">
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="name">Name of the Hotel/Property*</label>
                            <input name="hotel[name]" type="text" value="{{old('hotel.name', $hotel['name'])}}" required>
                            @error('hotel.name')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="file-field input-field">
                            <div class="btn">
                                <span>Upload Hotel Logo</span>
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
                            <input name="hotel[address1]" type="text" value="{{old('hotel.address1', $hotel['address1'])}}" required>
                            @error('hotel.address1')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="prueba">Address Line 2</label>
                             <input name="hotel[address2]" type="text" value="{{old('hotel.address2', $hotel['address2'])}}" >
                            @error('hotel.address2')
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
                                <select  name="hotel[country_id]" value="{{old('hotel.country_id',$hotel['country_id'])}}" required >
                                    <option value="">Select a Country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{$country->id}}" {{$country->id == old('hotel.country_id', $hotel['country_id'])? 'selected' : '' }}>{{$country->country_name}}</option>
                                    @endforeach
                                </select>
                                @error('hotel.country_id')
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
                            <input name="hotel[state]" value="{{old('hotel.state', $hotel['state'])}}" type="text" required>
                                @error('hotel.state')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6">
                            <label for="city">City*</label>
                            <input  name="hotel[city]" type="text" value="{{old('hotel.city', $hotel['city'])}}" required>
                                @error('hotel.city')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                        </div>
                        <div class="input-field col s6">
                            <label for="zip_code">Zip Code*</label>
                            <input  name="hotel[zip_code]" type="text" value="{{old('hotel.zip_code', $hotel['zip_code'])}}" >
                                @error('hotel.zip_code')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6">
                            <label for="phone">Phone*</label>
                            <input  name="hotel[phone]" type="text" value="{{old('hotel.phone', $hotel['phone'])}}" required >
                                @error('hotel.phone')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                        </div>
                        <div class="input-field col s6">
                            <label for="prueba">Fax</label>
                            <input  name="hotel[fax]" type="text" value="{{old('hotel.fax', $hotel['fax'])}}" >
                                @error('hotel.fax')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="website_address">Website Address</label>
                            <input name="hotel[website_address]" type="text" value="{{old('hotel.website_address', $hotel['website_address'])}}" >
                                @error('hotel.website_address')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                        </div>
                    </div>
                     <div class="row">
                        <div class="input-field col s12">
                            <label for="website_address">Email Address</label>
                            <input name="hotel[email]" type="email" value="{{old('hotel.email' , $hotel['email'])}}" >
                                @error('hotel.email')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <label for="description">Brief description of your Hotel</label>
                            <textarea class="materialize-textarea"  name="hotel[description]" type="text" >{{old('hotel.description', $hotel['description'])}}</textarea>
                                @error('hotel.description')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <label for="description">Services Offered</label>
                            <textarea class="materialize-textarea"  name="hotel[description_service]" type="text" >{{old('hotel.description_service', $hotel['description_service'])}}</textarea>
                                @error('hotel.description_service')
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
                            <label for="name">Billing Hotel Name</label>
                        <input name="billing[name]" type="text" value="{{old('billing.name',  $hotel->billing_address->name)}}" >
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
                            <input name="billing[address1]" type="text" value="{{old('billing.address1', $hotel->billing_address->address1)}}" >
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
                            <input name="billing[address2]" type="text" value="{{old('billing.address2', $hotel->billing_address->address2)}}" >
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
                            <div class="input-field">country_id
                                <select  name="billing[country_id]" value="{{old('billing.country_id', $hotel->billing_address->country_id)}}"  >
                                    <option value="">Select a Country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{$country->id}}" {{$country->id == old('billing.country_id', $hotel->billing_address->country_id)? 'selected' : '' }}>{{$country->country_name}}</option>
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
                            <input name="billing[state]" type="text" value="{{old('billing.state', $hotel->billing_address->state)}}" >
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
                            <input name="billing[city]" type="text" value="{{old('billing.city', $hotel->billing_address->city)}}" >
                            @error('billing.city')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>

                        <div class="input-field col s6">
                            <label for="prueba">Zip Code*</label>
                            <input name="billing[zip_code]" type="text" value="{{old('billing.zip_code', $hotel->billing_address->zip_code)}}" >
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
                            <input name="billing[phone]" type="text" value="{{old('billing.phone', $hotel->billing_address->phone)}}" >
                            @error('billing.phone')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                        <div class="input-field col s6">
                            <label for="prueba">Fax</label>
                            <input name="billing[fax]" type="text" value="{{old('billing.fax', $hotel->billing_address->fax)}}" >
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
                            <select name="contact[salutation_id]" value="{{old('contact.salutation_id',$hotel->billing_contact->salutation_id )}}"  >
                                <option value="">Title</option>
                                @foreach ($salutations as $item)
                                    <option value="{{$item->id}}" {{$item->id == old('contact.salutation_id',$hotel->billing_contact->salutation_id ) ? 'selected' : '' }} >{{$item->name}}</option>
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
                            <input name="contact[first_name]" type="text" value="{{old('contact.first_name',$hotel->billing_contact->first_name )}}" >
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
                            <input name="contact[last_name]" type="text" value="{{old('contact.last_name',$hotel->billing_contact->last_name )}}" >
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
                            <input name="contact[designation]" type="text" value="{{old('contact.designation',$hotel->billing_contact->designation )}}" >
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
                            <input name="contact[phone]" type="text" value="{{old('contact.phone',$hotel->billing_contact->phone )}}" >
                            @error('contact.phone')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                        <div class="input-field col s4">
                            <label for="prueba">Extn#</label>
                           <input name="contact[extension]" type="text" value="{{old('contact.extension',$hotel->billing_contact->extension )}}" >
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
                             <input name="contact[fax]" type="text" value="{{old('contact.fax',$hotel->billing_contact->fax )}}" >
                            @error('contact.fax')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                        <div class="input-field col s4">
                            <label for="prueba">Email*</label>
                            <input name="contact[email]" type="text" value="{{old('contact.email',$hotel->billing_contact->email )}}" >
                            @error('contact.email')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                        <div class="input-field col s4">
                            <label for="prueba">Mobile</label>
                             <input name="contact[mobile]" type="text" value="{{old('contact.mobile',$hotel->billing_contact->mobile )}}" >
                            @error('contact.mobile')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row s12 right">
                    <a href="{{ route('hotel.index') }}" class="mb-6 btn waves-effect waves-light gradient-45deg-purple-deep-orange">Hotel List</a>
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
