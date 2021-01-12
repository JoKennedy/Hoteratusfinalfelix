@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title',"Create a new Add-ons")
{{-- vendor style --}}
@section('vendor-style')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/flag-icon/css/flag-icon.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-sidebar.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-contacts.css')}}">
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
                        <h5 class="center-align" style="font-weight: 900;">Create a New Add-ons</h5>
                    </div>
                </div>
            </div>

            <form enctype="multipart/form-data" class="formValidate" action="{{ route('inclusions.store') }}" style="margin-bottom: 20px;" id="formSubmit" method="POST">
                @csrf

                <div class="row"></div>
                <div id="details">
                    <div class="row">
                        <div class="input-field col s8">
                            <label for="name">Add-ons Name*</label>
                            <input name="name" type="text" value="{{old('name')}}" required>
                            @error('name')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                         <div class="input-field col s4">
                            <label for="code">Add-ons Code*</label>
                            <input name="code" type="text" value="{{old('code')}}" required>
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
                            <label for="description">Description*</label>
                            <textarea required class="materialize-textarea"  name="description" type="text" >{{old('description')}}</textarea>
                                @error('description')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s6">
                            <label for="pos_point_id">Pos Point*</label>
                            <div class="input-field">
                                <select   onchange="filterProduct()" name="pos_point_id" id="pos_point_id" value="{{old('pos_point_id')}}">
                                    <option value="">Select a Pos Point</option>

                                    @foreach ($posPoint as $pos)
                                        <option value="{{$pos->id}}" {{$pos->id == old('pos_point_id')? 'selected':''}} >{{$pos->name}}</option>
                                    @endforeach
                                </select>
                                @error('pos_point_id')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                            </div>
                        </div>
                        <div class="col s6">
                            <label for="pos_product_id">Product*</label>
                            <div class="input-field">
                                <select onchange="setPrice()" class="select2 browser-default" name="pos_product_id" id="pos_product_id" value="{{old('pos_product_id')}}">
                                    <option value="">Select a Pos Point First</option>
                                </select>
                                @error('pos_product_id')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s2">

                            <div class="input-field">
                                <label for="measurement_unit_id">Price*</label>
                                <input onkeyup="calDiscount()" onkeypress="return isNumberKey(event)" value="{{old('price',0)}}" name="price" id="price" type="text" >
                            </div>
                        </div>
                        <div class="col s9">
                            <div class="input-field">
                                <label>
                                    <input type="checkbox" name="update_price" id="update_price" />
                                    <span>Do not update price of Add-ons if the price of the product changes in the POS</span>
                                </label>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col s2">
                            <div class="input-field">
                                <label for="measurement_unit_id">Discount*</label>
                                <input onkeyup="calDiscount()" onkeypress="return isNumberKey(event)" name="discount" id="discount" value="{{old('discount',0)}}" type="text" >
                            </div>
                        </div>
                        <div class="col s2">
                            <label>
                                <input onclick="calDiscount()" type="radio" value="2" name="discount_type[]" id="discount_type2" checked />
                                <span>$</span>
                            </label>
                            <br>
                            <label>
                                <input onclick="calDiscount()" type="radio" value="1" name="discount_type[]" id="discount_type1" />
                                <span>%</span>
                            </label>
                         </div>
                        <div class="col s4">
                            <div class="input-field">
                                <label for="measurement_unit_id">Price After Discount</label>
                                <input readonly name="afterdiscount" id="afterdiscount" value="{{old('afterdiscount',0)}}" type="text" >
                            </div>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col s6">
                            <label for="calculation_rule_id">Calculation Rule*</label>
                            <div class="input-field">
                                <select  name="calculation_rule_id" id="calculation_rule_id" value="{{old('calculation_rule_id')}}">
                                    <option value="">Select a Calculation Rule</option>

                                    @foreach ($calculationRules as $item)
                                        <option value="{{$item->id}}" {{$item->id == old('calculation_rule_id')? 'selected':''}} >{{$item->name}}</option>
                                    @endforeach
                                </select>
                                @error('calculation_rule_id')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                            </div>
                        </div>
                        <div class="col s6">
                            <label for="posting_rhythm_id">Posting Rhythm*</label>
                            <div class="input-field">
                                <select  name="posting_rhythm_id" id="posting_rhythm_id" value="{{old('posting_rhythm_id')}}">
                                    <option value="">Select a Posting Rhythm</option>

                                    @foreach ($postingRhythms as $item)
                                        <option value="{{$item->id}}" {{$item->id == old('posting_rhythm_id')? 'selected':''}} >{{$item->name}}</option>
                                    @endforeach
                                </select>
                                @error('posting_rhythm_id')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col s12">
                            <div class="input-field">
                                <label>
                                    <input type="checkbox" name="public_web" id="public_web" />
                                    <span>Publish on Web</span>
                                </label>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row s12 right">
                    <button type="submit" class="mb-6 btn waves-effect waves-light gradient-45deg-green-teal" >Save </button>
                    <a href="{{ route('inclusions.index') }}" class="mb-6 btn waves-effect waves-light gradient-45deg-purple-deep-orange">Cancel</a>
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
<script src="{{asset('vendors/sweetalert/sweetalert.min.js')}}"></script>
<script src="{{asset('vendors/select2/select2.full.min.js')}}"></script>
@endsection

{{-- page script --}}
@section('page-script')
<script src="{{asset('js/scripts/form-validation.js')}}"></script>
<script src="{{asset('js/scripts/ui-alerts.js')}}"></script>
<script src="{{asset('js/scripts/form-select2.js')}}"></script>
<script src="{{asset('js/scripts/hoteratus.js')}}"></script>
<script>


        document.getElementById("image").onchange = function(e) {

            let preview = document.getElementById('preview')
                preview.innerHTML = '';
            for (let index = 0; index < e.target.files.length; index++) {
                let reader = new FileReader();
                reader.readAsDataURL(e.target.files[index]);
            reader.onload = function(){
                let div = document.createElement('div');
                div.className = "col s4"
                div.id = "img"+index;
                let image = document.createElement('img'), input = document.createElement('input')
                input.name ="imagename[]"
                image.height = 100;
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
        function calDiscount() {

            var price =$("#price").val();
            var discount = $("#discount").val();
            if ($('#discount_type2').is(':checked')) {
                $("#afterdiscount").val(price-discount);
            }else{
                 $("#afterdiscount").val(price-(price*discount/100));
            }


            //afterdiscount
        }
        function filterProduct(){
            $(".loader").show();
            var aid = "{{old('pos_product_id')}}";
            $("#pos_product_id").html('<option value="">Select a Product</option>')
            $.ajax({
                type: "post",
                url: "{{ route('posproduct.list') }}",
                data: {pos_point_id: $("#pos_point_id").val() , _token: $('input:hidden[name=_token]').val()},
                success: function (response) {

                        if(response.success){

                            response.data.forEach(element => {
                                $("#pos_product_id").append('<option '+(element.id==aid?'selected':'')+' value="'+element.id+'" >'+element.product.name+'</option>');
                            });
                        }

                        $('#pos_product_id').formSelect()
                        $('#pos_product_id').trigger('change');

                        $(".loader").hide();
                }
            }).fail( () => {
                $(".loader").hide();
            });
        }
        function setPrice(){
            if($("#pos_product_id").val() == "" ){return;}
            $(".loader").show();

            $.ajax({
                type: "post",
                url: "{{ route('posproduct.current_price') }}",
                data: {pos_product_id: $("#pos_product_id").val() , _token: $('input:hidden[name=_token]').val()},
                success: function (response) {
                console.log(response);

                        if(response.success){
                            $("#price").val(response.data.price)
                            calDiscount()
                        }
                        $(".loader").hide();
                }
            }).fail(() => {
                $(".loader").hide();
            });;
        }

    </script>
@endsection
