@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Create a new POS Point')
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
                        <h5 class="center-align" style="font-weight: 900;">Create a New POS Point</h5>
                    </div>
                </div>
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
            <form  class="formValidate" action="{{ route('pospoints.store') }}" style="margin-bottom: 20px;" id="formSubmit" method="POST">
                @csrf
                <div class="row"></div>
                <div id="details">
                    <div class="row">
                        <div class="input-field col s8">
                            <label for="name">POS Point Name*</label>
                            <input name="name" type="text" value="{{old('name')}}" required>
                            @error('name')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                        <div class="input-field col s3">
                            <label for="code">Code*</label>
                            <input name="code" type="text" value="{{old('code')}}" required>
                            @error('code')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s4">
                            <label for="property_department_id">Department*</label>
                            <div class="input-field">
                                <select onchange="filterAccountCode()" name="property_department_id" id="property_department_id" value="{{old('property_department_id')}}">
                                    <option value="">Select a Department</option>
                                    @foreach ($departments as $department)
                                        <option value="{{$department->id}}" {{$department->id==old('property_department_id')? 'selected':''}}>{{$department->name}}</option>
                                    @endforeach
                                </select>
                                @error('property_department_id')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                            </div>
                        </div>
                        <div class="col s4">
                            <label for="account_code_id">Account Code*</label>
                            <div class="input-field">
                                <select name="account_code_id" id="account_code_id" value="{{old('account_code_id')}}">
                                    <option value="">Select a Account Code</option>
                                </select>
                                @error('account_code_id')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                            </div>
                        </div>
                        <div class="col s4">
                            <br><br>
                            <div class="input-field">
                                    <a onclick="displaynewaccount()" id="add" class="waves-effect waves-light btn-small"><i class="material-icons left">add</i>Add New Account Code</a>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="file-field input-field">
                            <div class="btn">
                                <span>Upload POS Logo</span>
                                <input name="logo" type="file">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text" placeholder="(Image dimensions 274pxX130px)">
                            </div>
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
                            <label for="base_price">Company Name</label>
                            <input  name="company_name"  type="text" value="{{old('company_name')}}" >
                            @error('company_name')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                    </div>
                     <div class="row">
                        <div class="input-field col s12">
                            <label for="company_address">Company Address</label>
                            <textarea  class="materialize-textarea"  name="company_address" type="text" >{{old('company_address')}}</textarea>
                                @error('company_address')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="task_emails">POS Assign Task Email Address</label>
                            <textarea required class="materialize-textarea"  name="task_emails" type="text" >{{old('task_emails')}}</textarea>
                                @error('task_emails')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                        </div>
                    </div>
                    <div class="row">
                        <h6 class="text-center">POS Printer Type*</h6>
                        <div class="col s12">
                            <div class="input-field" >
                                <select required name="print_type_id[]" class="select2-size-sm browser-default" multiple="multiple">
                                    @foreach ($printTypes as $printType)
                                        <option value="{{$printType->id}}" {{old('print_type_id') && in_array($printType->id,old('print_type_id') )? 'selected':''}} >{{$printType->name}}</option>
                                    @endforeach
                                </select>
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
                    <div class="row">
                        <div class="col s4">
                            <label for="pos_type_id">POS Type*</label>
                            <div class="input-field">
                                <select name="pos_type_id" id="pos_type_id" value="{{old('pos_type_id')}}">
                                    <option value="">Select a POS Type</option>
                                    @foreach ($posTypes as $posType)
                                        <option value="{{$posType->id}}" {{$posType->id==old('pos_type_id')? 'selected':''}}>{{$posType->name}}</option>
                                    @endforeach
                                </select>
                                @error('pos_type_id')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                            </div>
                        </div>
                        <div class="col s4">

                        </div>
                    </div>
                </div>
                <div class="row s12 right">
                    <button type="submit" class="mb-6 btn waves-effect waves-light gradient-45deg-green-teal" >Save </button>
                    <a href="{{ route('pospoints.index') }}" class="mb-6 btn waves-effect waves-light gradient-45deg-purple-deep-orange">Cancel</a>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
    <div class="contact-compose-sidebar">
        <div class="card quill-wrapper">
            <div class="card-content pt-0">
                <div class="card-header display-flex pb-2">
                    <h3 class="card-title contact-title-label">Create New Account Code</h3>
                    <div class="close close-icon">
                    <i  class="material-icons closeico">close</i>
                    </div>
                </div>
                <div class="divider"></div>
                <!-- form start -->
                <form id="formaccountCode" class="edit-contact-item mb-5 mt-5" method="POST">
                    @csrf
                    <input type="hidden" name="department_id" id="department_id">
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix"> account_box </i>
                            <input name="name"  type="text" class="validate" required>
                            <label for="first_name">Account Name*</label>
                            <div id="accounterrorsname" class="validaciones">
                            </div>
                        </div>
                        <div class="input-field col s12">
                            <i class="material-icons prefix"> account_balance </i>
                            <input name="code"  type="text" class="validate" required>
                            <label for="last_name">Account Code*</label>
                            <div id="accounterrorscode" class="validaciones">
                            </div>
                        </div>
                        <div class="row s12 center">
                            <button type="button" onclick="saveaccount()" class="mb-6 btn waves-effect waves-light gradient-45deg-green-teal" >Save </button>
                            <a  class="mb-6 btn waves-effect waves-light gradient-45deg-purple-deep-orange closeico">Cancel</a>
                        </div>
                    </div>
                </form>
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
<script>
    var contactComposeSidebar = $(".contact-compose-sidebar")
   $(".contact-sidebar-trigger").on("click", function () {
      contactComposeSidebar.addClass("show");
   })

   $(document).ready(function () {


        $("#account_code_id").on('change', function () {
            if ($("#account_code_id").val()){
                $("#add").hide();
            }else{
                $("#add").show();
            }
        } );


        $(".closeico").on("click", function () {
            $(".contact-compose-sidebar").removeClass("show");
        });
    });

   function saveaccount(){
       $(".validaciones").html("");
        $(".loader").show();
       $.ajax({
           method: "post",
           url: "{{ route('accountcode.store') }}",
           data: $("#formaccountCode").serialize(),
           success: function (response) {
                $(".loader").hide();
                $(".contact-compose-sidebar").removeClass("show");
                $(".validaciones").html("");
                $("#account_code_id").append('<option value="'+response.id+'" selected>'+response.code+'</option>');
                $("#account_code_id").attr("value",response.id)
                $('#account_code_id').formSelect()
                $("#formaccountCode").find("input[type=text]").val("")
                $('#account_code_id').trigger('change');

           },error:function (error) {

            if(error.responseJSON.hasOwnProperty('errors')){

              if(error.responseJSON.errors.name){
                $("#accounterrorsname").append('<div class="row" style="color:red;">'+error.responseJSON.errors.name+' </div>');
                }
                if(error.responseJSON.errors.code){
                 $("#accounterrorscode").append('<div class="row" style="color:red;">'+error.responseJSON.errors.code+' </div>');
                }
            }
    }
       }).fail(() => {
           $(".loader").hide();
       });

   }

   function displaynewaccount(){

    if($("#property_department_id").val() ==""){

         swal("Select a Department first to continue",
            {
                title: 'New Account Code',
                icon: "error",
            });
        return;
    }
    $("#department_id").val($("#property_department_id").val())
    contactComposeSidebar.addClass("show");

   }

function filterAccountCode(){
    $(".loader").show();
    $("#account_code_id").html('<option value="">Select a Account Code</option>')
       $.ajax({
           type: "post",
            url: "{{ route('accountcode.list') }}",
           data: {department_id: $("#property_department_id").val() , _token: $('input:hidden[name=_token]').val()},
           success: function (response) {

                if(response.success){

                    response.data.forEach(element => {
                        $("#account_code_id").append('<option value="'+element.id+'" >'+element.code+'</option>');
                    });
                }

                $('#account_code_id').formSelect()
                $('#account_code_id').trigger('change');
                $(".loader").hide();
           }
       }).fail(() => {
           $(".loader").hide();
       });;
   }
</script>
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
</script>
@endsection
