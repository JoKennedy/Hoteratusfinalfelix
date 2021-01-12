@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Room Type')
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
                        <h5 class="center-align" style="font-weight: 900;">Room Type</h5>
                        <p>{{$roomType->name}}</p>
                    </div>

                </div>
            </div>

            <form enctype="multipart/form-data"  class="formValidate"  style="margin-bottom: 20px;" id="formSubmit" method="POST">
                @csrf
                <div class="row s12 right">
                    <button type="submit" class="mb-6 btn waves-effect waves-light gradient-45deg-green-teal" >Update </button>
                    <a href="{{ route('room-types.index') }}" class="mb-6 btn waves-effect waves-light gradient-45deg-purple-deep-orange">Cancel</a>
                </div>
                <div class="row"></div>
                <div id="details">
                    <div class="row">
                        <div class="input-field col s8">
                            <label for="name">Name the Room Type*</label>
                            <input name="name" type="text" value="{{old('name',$roomType->name)}}" readonly>
                            @error('name')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                        <div class="input-field col s4">
                            <label for="name">Short Name*</label>
                            <input name="code" type="text" value="{{old('code',$roomType->code)}}" readonly>
                            <small>(This abbreviated form is used in many places to display the room type. So please make it relevant.)</small>
                            @error('code')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        @foreach ($roomType->images as $image )
                        <div class="row" class="file-path-wrapper">
                        <div class="col s9 border-bottom-1"><span> {{$image->url}} </span> -><strong>{{$image->caption}}</strong></div>
                           <div class="invoice-action col s3" style="display: flex;">
                                <a href="javascript:void(0"  onclick="showImage('{{ $image->get_image }}', '{{ $image->caption }}')" class="invoice-action-view mr-12"> <i class="material-icons">remove_red_eye</i> </a>
                           </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="description">Description</label>
                            <textarea readonly class="materialize-textarea"  name="description" type="text" >{{old('description',$roomType->description)}}</textarea>
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
                                <select id="base_occupancy" name="base_occupancy" value="{{old('base_occupancy',$roomType->base_occupancy)}}" readonly >
                                        <option value="{{$roomType->base_occupancy}}" {{$roomType->base_occupancy== old('base_occupancy',$roomType->base_occupancy)? 'selected' : '' }}>{{$roomType->base_occupancy}}</option>
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
                                <select id="higher_occupancy" name="higher_occupancy" value="{{old('higher_occupancy',$roomType->higher_occupancy)}}"  >
                                        <option value="{{$roomType->higher_occupancy}}" {{$roomType->higher_occupancy== old('higher_occupancy',$roomType->higher_occupancy)? 'selected' : '' }}>{{$roomType->higher_occupancy}}</option>
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
                            <label class="disabled">
                                <span>Extra bed allowed?&nbsp;</span>
                            <input readonly value="1" type="checkbox" {{old('exta_bed_allowed',$roomType->exta_bed_allowed) == 1? 'checked' : '' }} id="exta_bed_allowed" name="exta_bed_allowed" />
                                <span>Yes</span>
                            </label>
                        </div>
                         <div class="col s3">

                            <div id="exta_bed_allowed_total" class="input-field">

                                <select  name="exta_bed_allowed_total" value="{{old('exta_bed_allowed_total',$roomType->exta_bed_allowed_total)}}"  >
                                        <option value="{{$roomType->exta_bed_allowed_total}}" {{$roomType->exta_bed_allowed_total== old('exta_bed_allowed_total',$roomType->exta_bed_allowed_total)? 'selected' : '' }}>{{$roomType->exta_bed_allowed_total}}</option>
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
                                <select disabled name="amenity_id[]" class="select2-size-sm browser-default" multiple="multiple">
                                    @foreach ($amenities as $amenity)
                                    @if ($roomAmenities && in_array($amenity->id,$roomAmenities) )
                                        <option value="{{$amenity->id}}" selected disabled>{{$amenity->name}}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <h6 class="text-center">Rack Rate (List price)*</h6>
                         <div class="input-field col s4">
                            <label for="base_price">Base Price</label>
                            <input min="1" name="base_price" onkeypress="return isNumberKey(event)" type="text" value="{{old('base_price',$roomType->base_price)}}" readonly>
                            @error('base_price')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                        <div class="input-field col s4">
                            <label for="higher_price">Upcharge for Additional Person</label>
                            <input name="higher_price" onkeypress="return isNumberKey(event)" type="text" value="{{old('higher_price',$roomType->higher_price)}}" readonly>
                            @error('higher_price')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                        <div class="input-field col s4">
                            <label for="extra_bed_price">Extra Bed Price</label>
                            <input name="extra_bed_price" onkeypress="return isNumberKey(event)" type="text" value="{{old('extra_bed_price',$roomType->extra_bed_price)}}" readonly>
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
                        @if ( $roomTax && in_array($tax->id,$roomTax))
                             <div class="row">
                                <div class="col s12">
                                    <label>
                                    <input value="{{$tax->id}}" type="checkbox" checked name="room_tax_id[]"  />
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
                        @endif

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
<script src="{{asset('vendors/sweetalert/sweetalert.min.js')}}"></script>
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
            input.name ="imagename[]"
            input.placeholder ="Image Caption"
            div.append(image)
             div.append(input)
            image.src = reader.result;
            image.width = 125
            preview.append(div);
        };

        }

        }
         function  deleteimage(id, obj ){


          swal({
                title: "Are you sure?",
                text: "You will not be able to recover this image!",
                icon: 'warning',
                dangerMode: true,
                buttons: {
                cancel: 'No, Please!',
                delete: 'Yes, Delete It'
                }
            }).then(function (willDelete) {
                if (willDelete) {

                    $.ajax({
                        url: "{!!URL::to('images/"+id+"' )!!}" ,
                        method: 'DELETE',
                        data: { _token: $(obj).data("token") }

                    }).done( function(response){
                        swal("Poof! image  has been deleted!", {
                            icon: "success",
                        });
                        $(obj).parent().parent().remove();
                    }).fail(function(response){
                        console.log(response)
                    });



                } else {
                swal("Your image is safe", {
                    title: 'Cancelled',
                    icon: "error",
                });
                }
            });
    }
    function showImage(url, txt){
        var el = document.createElement('span'),
            t = document.createElement("img");
            t.src= url
            t.width = 400
            el.appendChild(t);
            swal({
            title: txt,
            content: {
                element: el,
            }
            });
    }
    </script>
@endsection

