@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Create a Room Tax/Fee')
{{-- vendor style --}}
@section('vendor-style')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/flag-icon/css/flag-icon.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-sidebar.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-contacts.css')}}">
@endsection

{{-- page content --}}
@section('content')
<div class="section" >
  <div class="row">
    <div class="col s12">

      <div id="validations" class="card card-tabs">

        <div class="card-content">
            <div class="card-title">
                <div class="row center">
                    <div class="col s12">
                        <h5 class="center-align" style="font-weight: 900;">Create a Tax/Fee</h5>
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

            <form  class="formValidate" action="{{ route('room-taxes.store') }}" style="margin-bottom: 20px;" id="formSubmit" method="POST">
                @csrf

                <div class="row s12 right">
                    <button type="submit" class="mb-6 btn waves-effect waves-light gradient-45deg-green-teal" >Save </button>
                    <a href="{{ route('room-taxes.index') }}" class="mb-6 btn waves-effect waves-light gradient-45deg-purple-deep-orange">Cancel</a>
                </div>
                <div class="row"></div>
                <div id="details">
                    <div class="row">
                        <div class="input-field col s8">
                            <label for="name">Tax Title*</label>
                            <input name="name" type="text" value="{{old('name')}}" required>
                            @error('name')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                         <div class="input-field col s4">
                            <label for="name">Tax ID(Short Name)*</label>
                            <input name="code" type="text" value="{{old('code')}}" required>
                            @error('code')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s8">
                            <label for="department_id">Department*</label>
                            <div class="input-field">
                                <select  name="department_id" value="{{old('department_id')}}" required >
                                    @foreach ($departments as $department)
                                        <option value="{{$department->id}}" {{$department->id == old('department_id')? 'selected' : '' }}>{{$department->name}}</option>
                                    @endforeach
                                </select>
                                @error('department_id')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                            </div>
                        </div>
                        <div class="col s4">
                             <br><br><br>
                            <label>
                            <input  type="checkbox" id="included" name="included" />
                            <span> Is Included</span>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s8">
                            <label for="account_code_id">Account Code*</label>
                            <div id="accouncode" class="input-field">
                                <select id="account_code_id" name="account_code_id" value="{{old('account_code_id')}}" required >
                                    <option value="">Select Account Code </option>
                                    @foreach ($accountCodes as $accountCode)
                                        <option value="{{$accountCode->id}}" {{$accountCode->id == old('account_code_id')? 'selected' : '' }}>{{$accountCode->code}}</option>
                                    @endforeach
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
                                    <a id="add" class="waves-effect waves-light btn-small add"><i class="material-icons left">add</i>Add New Account Code</a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="description">Description</label>
                            <textarea class="materialize-textarea" name="description">{{old('description')}}</textarea>
                            @error('description')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                       <h6 class="text-center">Tax/Fee Type</h6>
                       <div class="row">
                           <div class="col s2">
                               <label>
                                    <input onclick="showOptions(this.value)"  class="radiobtn" value="2" name="type" type="radio"  />
                                    <span><i  class="material-icons">attach_money</i></span>
                                </label>
                                <label>
                                    <input onclick="showOptions(this.value)"  class="radiobtn" value="1" name="type" type="radio" checked />
                                    <span><i  class="material-icons">%</i></span>
                                </label>
                           </div>
                           <div class="col s6">
                                <select id="tax_applied_id" name="tax_applied_id" value="{{old('tax_applied_id')}}" required >
                                    <option value="">Select</option>
                                    @foreach ($taxApplieds as $taxapplied)
                                     <option style="display: none;" class="{{$taxapplied->tax_type_id==1?'money':'percent'}} taxoption" value="{{$taxapplied->id}}" {{$taxapplied->id == old('tax_applied_id')? 'selected' : '' }}>{{$taxapplied->name}}</option>
                                    @endforeach
                                </select>
                           </div>
                            <div class="col s2 adult" style="display: none;">
                                <br>
                                <p>
                                    <label>
                                    <input type="checkbox" name="adult_child" id="adult_child" />
                                    <span> Adult/Child Tax</span>
                                    </label>
                                </p>
                            </div>
                             <div class="col s2 adult" style="display: none;">
                                 <select name="adult_type" id="adult_type">
                                        <option value="">Select</option>
                                        <option value="1">Adult</option>
                                        <option value="2">Child</option>
                                 </select>
                             </div>
                       </div>
                        <div class="row">
                             <table id="tablename" class="table">
                                <thead>
                                    <tr>
                                        <th><strong>Less than $ <br>(Leave blank if not required)</strong></th>
                                        <th class="text-center"><strong>Account Code</strong></th>

                                        <th class="text-center"><strong>Value</strong></th>
                                        <th><strong>Action</strong></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="principal" id="0">
                                        <td>
                                            <div class="input-field">
                                                <input onkeypress="return isNumberKey(event)" name="charge_less[]" type="text" >
                                            </div>
                                        </td>
                                        <td>
                                            <div id="accouncode">
                                                <select  name="account_code[]"  >
                                                    <option value="">Select</option>
                                                    @foreach ($hotel->account_codes as $accountCode)
                                                        <option value="{{$accountCode->id}}" {{$accountCode->id == old('account_code')? 'selected' : '' }}>{{$accountCode->code}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        <td >
                                            <div class="input-field">
                                                <input onkeypress="return isNumberKey(event)" name="tax_value[]" type="text" required>
                                            </div>
                                        </td>
                                        <td> <span><a  onclick="removeTr(this)" href="javascript:void(0)"><i  class="material-icons">delete</i></a></span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <a id="addcondition" onclick="addRow()" class="waves-effect waves-light btn-small"><i class="material-icons left">add</i>Add Condition</a>
                        </div>

                </div>
            </form>
        </div>
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
      </form>
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

<script>

   var contactComposeSidebar = $(".contact-compose-sidebar")
   $(".contact-sidebar-trigger").on("click", function () {
      contactComposeSidebar.addClass("show");
   })
   function addRow() {
       var id = $("#tablename  tr:last").attr('id');
        var obj = $(".principal").clone();
        obj.removeClass('principal');
        obj.addClass('secundario')
        obj.attr('id', (id+1) );
      $("tbody").append(obj.removeClass('principal'));
   }
   function removeTr(obj){
      if ($(obj).parent().parent().parent().attr('id') == '0' ) {return;}
        $(obj).parent().parent().parent().remove();
   }
   $(document).ready(function () {

        showOptions();
        $("#account_code_id").on('change', function () {
            if ($("#account_code_id").val()){
                $("#add").hide();
            }else{
                $("#add").show();
            }
        } );
        $("#tax_applied_id").on('change', function () {
            if ($("#tax_applied_id").val() < 5){
                $(".adult").hide();
                $('#addcondition').show();

            }else{
                $(".adult").show();
                $(".secundario").remove();
                $('#addcondition').hide();
            }
        } );


        $(".add").on("click", function () {
            $(".contact-compose-sidebar").addClass("show");
        });

        $(".closeico").on("click", function () {
            $(".contact-compose-sidebar").removeClass("show");
        });
    });
    function showOptions( type =1){
        $('.taxoption').remove();

        $.ajax({
            url: "{{route('taxapplied')}}",
            data: {tax_type_id: type },
            success: function (response) {
                response.forEach(element => {
                     $("#tax_applied_id").append('<option class="taxoption" value="'+element.id+'" >'+element.name+'</option>');
                    $('#tax_applied_id').formSelect()
                    $('#tax_applied_id').trigger('change');
                });


            }
        });

    }

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
                $("#account_code_id").attr("value",)
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

</script>
@endsection
