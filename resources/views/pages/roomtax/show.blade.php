@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','View Room Tax/Fee')
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
                        <h5 class="center-align" style="font-weight: 900;">Tax/Fee</h5>
                    <p>{{$roomTax['name']}}</p>
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
            <form  class="formValidate"  style="margin-bottom: 20px;" id="formSubmit" method="POST">

                <div class="row s12 right">
                    <a href="{{ route('room-taxes.index') }}" class="mb-6 btn waves-effect waves-light gradient-45deg-purple-deep-orange">Room Tax/Fee List</a>
                </div>
                <div class="row"></div>
                <div id="details">
                    <div class="row">
                        <div class="input-field col s8">
                            <label for="name">Tax Title*</label>
                            <input name="name" type="text" value="{{old('name', $roomTax['name'])}}" readonly>
                            @error('name')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                         <div class="input-field col s4">
                            <label for="name">Tax ID(Short Name)*</label>
                            <input name="code" type="text" value="{{old('code', $roomTax['code'])}}" readonly>
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
                                <select  name="department_id" value="{{old('department_id')}}" readonly >
                                    @foreach ($departments as $department)
                                    @if ($department->id == $roomTax['department_id'])
                                        <option value="{{$department->id}}" {{$department->id == old('department_id', $roomTax['department_id'])? 'selected' : '' }}>{{$department->name}}</option>

                                    @endif
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
                            <input disabled type="checkbox" id="included" name="included" {{$roomTax->included ? 'checked':''}} readonly/>
                            <span> Is Included</span>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s8">
                            <label for="account_code_id">Account Code*</label>
                            <div id="accouncode" class="input-field">
                                <select id="account_code_id" name="account_code_id" value="{{old('account_code_id', $roomTax->account_code_id)}}" readonly >
                                    @foreach ($accountCodes as $accountCode)
                                    @if( $roomTax->account_code_id == $accountCode->id)
                                        <option value="{{$accountCode->id}}" {{$accountCode->id == old('account_code_id', $roomTax->account_code_id)? 'selected' : '' }}>{{$accountCode->code}}</option>
                                    @endif
                                        @endforeach
                                </select>
                                @error('account_code_id')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="description">Description</label>
                            <textarea readonly class="materialize-textarea" name="description">{{old('description', $roomTax->description)}}</textarea>
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
                                    <input readonly onclick="showOptions(this.value)"  class="radiobtn" value="2" name="type" type="radio" {{$roomTax->tax_applied->tax_type_id ==2? 'checked':''}} />
                                    <span><i  class="material-icons">attach_money</i></span>
                                </label>
                                <label>
                                    <input readonly onclick="showOptions(this.value)"  class="radiobtn" value="1" name="type" type="radio" {{$roomTax->tax_applied->tax_type_id ==1? 'checked':''}}  />
                                    <span><i  class="material-icons">%</i></span>
                                </label>
                           </div>
                           <div class="col s6">
                                <select id="tax_applied_id" name="tax_applied_id" value="{{old('tax_applied_id', $roomTax->tax_applied_id)}}" required >

                                    @foreach ($taxApplieds as $taxapplied)
                                      @if ($taxapplied->id ==  $roomTax->tax_applied_id)
                                     <option style="display: none;" class="{{$taxapplied->tax_type_id==1?'money':'percent'}} taxoption" value="{{$taxapplied->id}}" {{$taxapplied->id == old('tax_applied_id', $roomTax->tax_applied_id)? 'selected' : '' }}>{{$taxapplied->name}}</option>

                                    @endif
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
                                    @foreach ($roomTax->room_tax_details as $key => $details )
                                    <tr class="{{$key==0?'principal':''}}" id="{{$key}}">
                                         <td>
                                            <div class="input-field">
                                                <input readonly class="limpiar" name="charge_less[]" onkeypress="return isNumberKey(event)" type="text" value="{{$details->charge_less ==0? '' : number_format($details->charge_less, 2, '.', ',') }}" />
                                            </div>
                                        </td>
                                         <td>
                                            <div id="accouncode">
                                                <select class="selectable"  name="account_code[]"  >

                                                    @foreach ($hotel->account_codes as $accountCode)
                                                    @if ($accountCode->id ==$details->account_code_id )
                                                        <option value="{{$accountCode->id}}" {{$accountCode->id == old('account_code', $details->account_code_id )? 'selected' : '' }}>{{$accountCode->code}}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        <td >
                                            <div class="input-field">
                                                <input readonly class="limpiar" onkeypress="return isNumberKey(event)" name="tax_value[]" type="text"  value="{{ number_format($details->tax_value, 2, '.', ',') }}"  required>
                                            </div>
                                        </td>
                                    <td ></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
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

@endsection

{{-- page script --}}
@section('page-script')
<script src="{{asset('js/scripts/form-validation.js')}}"></script>
<script src="{{asset('js/scripts/hoteratus.js')}}"></script>
<script src="{{asset('vendors/sweetalert/sweetalert.min.js')}}"></script>

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
        $(obj).find('.deleterow').val(-1)
        $(obj).find('.limpiar').val('')
         $('.selectable').formSelect()
      $("tbody").append(obj.removeClass('principal'));
   }
   function removeTr(obj){
      if ($(obj).parent().parent().parent().attr('id') == '0' ) {return;}
        var idd = $(obj).parent().parent().find('input').val()
        if(idd){
            swal({
                title: "Are you sure?",
                text: "Do you want to remove this condition?",
                icon: 'warning',
                dangerMode: true,
                buttons: {
                cancel: 'No, Please!',
                delete: 'Yes, Remove It'
                }
            }).then(function (willDelete) {
                if (willDelete) {

                    $.ajax({
                        url: "{!!URL::to('hotel-manager/delete/"+idd+"' )!!}" ,
                        method: 'DELETE',
                        data: { _token: $(obj).data("token") }

                    }).done( function(response){

                        if(response.success){
                            $(obj).parent().parent().parent().remove();
                            swal("Tax/Fee  has been deactivated!", {
                                icon: "success",
                            });
                        }else{
                               swal("Something went wrong!", {
                                icon: "error",
                            });
                        }


                    }).fail(function(response){
                        console.log(response)
                    });



                } else {
                swal("Your Tax/Fee is safe", {
                    title: 'Cancelled',
                    icon: "error",
                });
                }
            });
        }else{
           $(obj).parent().parent().parent().remove();
        }

   }
   $(document).ready(function () {

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
