@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title',"Create a new Product")
{{-- vendor style --}}
@section('vendor-style')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/flag-icon/css/flag-icon.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-sidebar.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-contacts.css')}}">
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
                        <h5 class="center-align" style="font-weight: 900;">Create a New Product</h5>
                    </div>
                </div>
            </div>

            <form enctype="multipart/form-data" class="formValidate" action="{{ route('products.store') }}" style="margin-bottom: 20px;" id="formSubmit" method="POST">
                @csrf

                <div class="row"></div>
                <div id="details">
                    <div class="row">
                        <div class="input-field col s8">
                            <label for="name">Product Name*</label>
                            <input name="name" type="text" value="{{old('name')}}" required>
                            @error('name')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                         <div class="input-field col s4">
                            <label for="code">Product Code*</label>
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
                        <div class="col s6">
                            <label for="property_department_id">Category*</label>
                            <div class="input-field">
                                <select   onchange="filterSubCategory()" name="categoryid" id="categoryid" value="{{old('categoryid')}}">
                                    <option value="">Select a Category</option>

                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}" {{$category->id == old('categoryid')? 'selected':''}} >{{$category->name}}</option>
                                    @endforeach
                                </select>
                                @error('categoryid')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                            </div>
                        </div>
                        <div class="col s6">
                            <label for="account_code_id">Sub-Category*</label>
                            <div class="input-field">
                                <select name="product_subcategory_id" id="product_subcategory_id" value="{{old('product_subcategory_id')}}">
                                    <option value="">Select a Category First</option>
                                </select>
                                @error('product_subcategory_id')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <label for="measurement_unit_id">Measurement Unit*</label>
                            <div class="input-field">
                                <select required name="measurement_unit_id" id="measurement_unit_id" value="{{old('measurement_unit_id')}}">
                                    <option value="">Select a Measurement Unit</option>

                                    @foreach ($measurementUnits as $unit)
                                        <option value="{{$unit->id}}" {{$unit->id == old('measurement_unit_id')? 'selected':''}} >{{$unit->name}}</option>
                                    @endforeach
                                </select>
                                @error('measurement_unit_id')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                            </div>
                        </div>
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

                </div>
                <div class="row s12 right">
                    <button type="submit" class="mb-6 btn waves-effect waves-light gradient-45deg-green-teal" >Save </button>
                    <a href="{{ route('products.index') }}" class="mb-6 btn waves-effect waves-light gradient-45deg-purple-deep-orange">Cancel</a>
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
@endsection

{{-- page script --}}
@section('page-script')
<script src="{{asset('js/scripts/form-validation.js')}}"></script>
<script src="{{asset('js/scripts/ui-alerts.js')}}"></script>
<script>


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
        function filterSubCategory(){
            $(".loader").show();
            var aid = "{{old('product_subcategory_id')}}";
            $("#product_subcategory_id").html('<option value="">Select a Subcategory</option>')
            $.ajax({
                type: "post",
                url: "{{ route('productsubcategories.list') }}",
                data: {product_category_id: $("#categoryid").val() , _token: $('input:hidden[name=_token]').val()},
                success: function (response) {

                        if(response.success){

                            response.data.forEach(element => {
                                $("#product_subcategory_id").append('<option '+(element.id==aid?'selected':'')+' value="'+element.id+'" >'+element.name+'</option>');
                            });
                        }

                        $('#product_subcategory_id').formSelect()
                        $('#product_subcategory_id').trigger('change');

                        $(".loader").hide();
                }
            }).fail(() => {
                $(".loader").hide();
            });;
        }

    </script>
@endsection
