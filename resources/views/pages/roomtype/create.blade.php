@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Create a new Room Type')
{{-- vendor style --}}
@section('vendor-style')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2-materialize.css')}}">
@endsection

@section('page-style')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/form-select2.css')}}">
@endsection

{{-- page content --}}
@section('content')
<div class="section">
  <div class="row" >
    <div class="col s12">

      <div id="validations" class="card card-tabs">

        <div class="card-content">
            <div class="card-title">
                <div class="row center">
                    <div class="col s12">
                        <h5 class="center-align" style="font-weight: 900;">Create a New Room Type</h5>
                    </div>
                        @if(Session::has('message_success'))
                         <div >
                            <div class="card-alert card gradient-45deg-green-teal">
                                <div class="card-content white-text">
                                    <p>
                                    <i class="material-icons">check</i> {{Session::get('message_success') }}.
                                    </p>
                                </div>
                                <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                                </button>
                            </div>
                         </div>
                        @endif
                </div>
            </div>

            <form enctype="multipart/form-data"  class="formValidate" action="{{ route('room-types.store') }}" style="margin-bottom: 20px;" id="formSubmit" method="POST">
                @csrf

                <div class="row s12 right">
                    <button type="submit" class="mb-6 btn waves-effect waves-light gradient-45deg-green-teal" >Save </button>
                    <a href="{{ route('room-types.index') }}" class="mb-6 btn waves-effect waves-light gradient-45deg-purple-deep-orange">Cancel</a>
                </div>
                <div class="row"></div>
                <div id="details">
                    <div class="row">
                        <div class="input-field col s8">
                            <label for="name">Name the Room Type*</label>
                            <input name="name" type="text" value="{{old('name')}}" required>
                            @error('name')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                        <div class="input-field col s4">
                            <label for="name">Short Name*</label>
                            <input name="code" type="text" value="{{old('code')}}" required>
                            <small>(This abbreviated form is used in many places to display the room type. So please make it relevant.)</small>
                            @error('code')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="file-field input-field">
                            <div class="btn">
                                <span>Upload Image(s)</span>
                            <input id="image" name="image[]" type="file" value="{{old('image')}}" multiple>
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text" >
                            </div>
                        </div>
                        <div id="preview"></div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="description">Description</label>
                            <textarea class="materialize-textarea"  name="description" type="text" >{{old('description')}}</textarea>
                                @error('description')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s6">

                            <div id="accouncode" class="input-field">
                                <select id="base_occupancy" name="base_occupancy" value="{{old('base_occupancy')}}" required >
                                    @for ($i = 0; $i <= 50; $i++)
                                        <option value="{{$i}}" {{$i== old('base_occupancy')? 'selected' : '' }}>{{$i}}</option>
                                    @endfor

                                </select>
                                <label for="base_occupancy">Base Occupancy (People)*</label>
                                @error('base_occupancy')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                            </div>
                        </div>
                        <div class="col s6">

                            <div id="accouncode" class="input-field">
                                <select id="higher_occupancy" name="higher_occupancy" value="{{old('higher_occupancy')}}"  >
                                    @for ($i = 0; $i <= 50; $i++)
                                        <option value="{{$i}}" {{$i== old('higher_occupancy')? 'selected' : '' }}>{{$i}}</option>
                                    @endfor

                                </select>
                                 <label for="higher_occupancy">Max. Occupancy (People)</label>
                                @error('higher_occupancy')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s3">
                            <br><br>
                            <label>
                                <span>Extra bed allowed?&nbsp;</span>
                            <input value="1" {{old('exta_bed_allowed') == 1? 'checked' : '' }}  type="checkbox" id="exta_bed_allowed" name="exta_bed_allowed" />
                                <span>Yes</span>
                            </label>
                        </div>
                         <div class="col s3">

                            <div id="accouncode" class="input-field">

                                <select id="exta_bed_allowed_total" name="exta_bed_allowed_total" value="{{old('exta_bed_allowed_total')}}"  >
                                    @for ($i = 0; $i <= 50; $i++)
                                        <option value="{{$i}}" {{$i== old('exta_bed_allowed_total')? 'selected' : '' }}>{{$i}}</option>
                                    @endfor
                                </select>
                                <label for="exta_bed_allowed_total">Extra Beds Allowed</label>
                                @error('exta_bed_allowed_total')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <h6 class="text-center">Select Amenities*</h6>
                        <div class="col s12">
                            <div class="input-field" >
                                <select name="amenity_id[]" class="select2-size-sm browser-default" multiple="multiple">
                                    @foreach ($amenities as $amenity)
                                        <option value="{{$amenity->id}}" {{old('amenity_id') && in_array($amenity->id,old('amenity_id') )? 'selected':''}} >{{$amenity->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <h6 class="text-center">Rack Rate (List price)*</h6>
                         <div class="input-field col s4">
                            <label for="base_price">Base Price</label>
                            <input min="1" name="base_price" onkeypress="return isNumberKey(event)" type="text" value="{{old('base_price')}}" required>
                            @error('base_price')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                        <div class="input-field col s4">
                            <label for="higher_price">Upcharge for Additional Person</label>
                            <input name="higher_price" onkeypress="return isNumberKey(event)" type="text" value="{{old('higher_price')}}" required>
                            @error('higher_price')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                        <div class="input-field col s4">
                            <label for="extra_bed_price">Extra Bed Price</label>
                            <input name="extra_bed_price" onkeypress="return isNumberKey(event)" type="text" value="{{old('extra_bed_price')}}" required>
                            @error('extra_bed_price')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>

                    </div>
                      <div class="row">
                        <h6 class="text-center">Select Applicable Tax/Fee(es)</h6>
                        @foreach ($taxes as $tax)
                            <div class="row">
                                <div class="col s12">
                                    <label>
                                    <input value="{{$tax->id}}" type="checkbox" {{old('room_tax_id') && in_array($tax->id,old('room_tax_id') )? 'checked':''}} name="room_tax_id[]"  />
                                    <span >
                                        <div>
                                            <div class="row" style="font-weight: 900 !important; color: black !important;">
                                            <span>{{$tax->name}} ({{$tax->department->name}})</span>
                                                <small> {!!$tax->details!!}</small>
                                            </div>
                                        </div>
                                    </span>
                                    </label>
                                </div>
                            </div>
                        @endforeach
                      </div>
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
<script src="{{asset('vendors/select2/select2.full.min.js')}}"></script>
@endsection

{{-- page script --}}
@section('page-script')
<script src="{{asset('js/scripts/form-validation.js')}}"></script>
<script src="{{asset('js/scripts/ui-alerts.js')}}"></script>
<script src="{{asset('js/scripts/form-select2.js')}}"></script>
<script src="{{asset('js/scripts/hoteratus.js')}}"></script>
 <script>
     $(document).ready(function () {
            $('.select2-size-sm').select2({
    dropdownAutoWidth: true,
    width: '100%',
    containerCssClass: 'select-sm'
});
     });

        document.getElementById("image").onchange = function(e) {
        // Creamos el objeto de la clase FileReader
            let preview = document.getElementById('preview')
             preview.innerHTML = '';
        for (let index = 0; index < e.target.files.length; index++) {
            let reader = new FileReader();
             reader.readAsDataURL(e.target.files[index]);
        reader.onload = function(){
            let div = document.createElement('div');
            div.className = "col s4"
            let image = document.createElement('img'), input = document.createElement('input')
            image.height = 100;
            input.name ="imagename[]"
            input.placeholder ="Image Caption"
            div.append(image)
             div.append(input)
            image.src = reader.result;
            image.width = 125
            preview.append(div);
        };

        }



        // Le decimos que cuando este listo ejecute el código interno

        }

    </script>
@endsection

