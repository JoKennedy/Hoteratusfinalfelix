@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title',"Create a new Package")
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
                            <h5 class="center-align" style="font-weight: 900;">Create a New Package</h5>
                        </div>
                    </div>
                </div>

                <form  class="formValidate" action="{{ route('packages-master.store') }}" onsubmit="return verifyInclusion()" style="margin-bottom: 20px;" id="formSubmit" method="POST">
                    @csrf
                    <div class="row"></div>
                    <div id="details">
                        <div class="row">
                            <div class="input-field col s12">
                                <label for="name">Package Name*</label>
                                <input name="name" type="text" value="{{old('name')}}" required>
                                @error('name')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <label for="code">Short Name*</label>
                                <input name="code" type="text" value="{{old('code')}}" required>
                                <small class="black-text">
                                        <p>(This abbreviated form is used in many places to display the room type. So please make it relevant.)</p>
                                </small>
                                @error('code')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col s5">

                                <div class="input-field">
                                    <label for="stay_length">Length of Stay*</label>
                                    <input  onkeypress="return isNumberKey(event)" value="{{old('stay_length',0)}}" name="stay_length" id="stay_length" type="text" >
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
                    <div id="roomtypes" style="font-size: .7em;">
                        <h5 class="center-align">Room Types</h5>
                        <table class="table">
                            <thead style="padding: 0px !important; background-color: #F8F9F9  ; display: table-header-group; vertical-align: middle; border-color: inherit; color:black;">
                                <tr style="border: 1px solid #F4F6F6 ">
                                    <th rowspan="2" style="padding: 5px !important; margin-left :5px;  border: 1px solid #D5DBDB  !important; text-align: center;">Room Types</th>
                                    <th rowspan="2" style="padding: 5px !important; margin-left :5px;  border: 1px solid #D5DBDB  !important; text-align: center;">Base Occupancy</th>
                                    <th rowspan="2" style="padding: 5px !important; margin-left :5px;  border: 1px solid #D5DBDB  !important; text-align: center;">Max Occupancy</th>
                                    <th colspan="3" style="padding: 5px !important; margin-left :5px;  border: 1px solid #D5DBDB  !important; text-align: center;">Rack Rate</th>
                                    <th colspan="3" style="padding: 5px !important; margin-left :5px;  border: 1px solid #D5DBDB  !important; text-align: center;">Discount Rate (Room Only)</th>
                                    <th colspan="4" rowspan="2" style="padding: 5px !important; margin-left :5px;  border: 1px solid #D5DBDB  !important; text-align: center;">Select Minimum Person(s) for this package</th>
                                </tr>
                                <tr>
                                    <th style="padding: 5px !important; margin-left :5px;  border: 1px solid #D5DBDB  !important; text-align: center;">Room Only Price</th>
                                    <th style="padding: 5px !important; margin-left :5px;  border: 1px solid #D5DBDB  !important; text-align: center;">Upcharge per person</th>
                                    <th style="padding: 5px !important; margin-left :5px;  border: 1px solid #D5DBDB  !important; text-align: center;">Extra bed</th>
                                    <th style="padding: 5px !important; margin-left :5px;  border: 1px solid #D5DBDB  !important; text-align: center;">Room Only Price</th>
                                    <th style="padding: 5px !important; margin-left :5px;  border: 1px solid #D5DBDB  !important; text-align: center;">Upcharge per person</th>
                                    <th style="padding: 5px !important; margin-left :5px;  border: 1px solid #D5DBDB  !important; text-align: center;">Extra bed</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hotel->room_types as $room_type)
                                    @php
                                        $rack = $room_type->rack_rate();
                                    @endphp
                                    <tr>
                                        <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; vertical-align: top;">
                                            {{$room_type->name}}
                                        </td>
                                        <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; vertical-align: top;">
                                            {{$room_type->base_occupancy}} {{Str::plural('Person', $room_type->base_occupancy)}}
                                        </td>
                                        <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; vertical-align: top;">
                                            {{$room_type->higher_occupancy}} {{Str::plural('Person', $room_type->higher_occupancy)}}
                                        </td>
                                        <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; vertical-align: top;">
                                            {{$rack->base_occupancy}}
                                        </td>
                                        <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; vertical-align: top;">
                                            {{$rack->extra_person}}
                                        </td>
                                        <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; vertical-align: top;">
                                            {{$rack->extra_bed}}
                                        </td>
                                        <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; text-align: center; vertical-align: top;">
                                            <input name="room_type[{{$room_type->id}}][base_price]" onkeypress="return isNumberKey(event)" style="width:50px;" type="text" class="browser-default" value=" {{$rack->base_occupancy}}">
                                        </td>
                                        <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; text-align: center; vertical-align: top;">
                                            <input name="room_type[{{$room_type->id}}][extra_person]" onkeypress="return isNumberKey(event)" style="width:50px;" type="text" class="browser-default" value=" {{$rack->extra_person}}">
                                            <br>
                                                <div id="upcharge{{$room_type->id}}"></div>
                                            <br>
                                            <a href="javascript:void(0)" onclick="displaydata({{$room_type->id}}, {{$room_type->higher_occupancy}} )" >Add/Edit Surcharge</a>
                                        </td>
                                        <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; text-align: center; vertical-align: top;">
                                            <input name="room_type[{{$room_type->id}}][extra_bed]" onkeypress="return isNumberKey(event)" style="width:50px;" type="text" class="browser-default" value="{{$rack->extra_bed}}">
                                        </td>

                                        <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; vertical-align: top;">
                                            <select name="room_type[{{$room_type->id}}][adults_minimum]" class="browser-default">
                                                @for ($i = 0; $i <= $room_type->higher_occupancy; $i++)
                                                    <option {{$i == $room_type->base_occupancy? 'selected':''}} value="{{$i}}">{{$i}} {{Str::plural('Person', $i)}}</option>
                                                @endfor
                                            </select>
                                        </td>
                                        <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; vertical-align: top;">
                                            <select name="room_type[{{$room_type->id}}][children_minimum]" class="browser-default">
                                                @for ($i = 0; $i <= $room_type->higher_occupancy; $i++)
                                                    <option value="{{$i}}">{{$i}} {{Str::plural('Child', $i)}}</option>
                                                @endfor
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div id="inclusions" style="font-size: .7em;">
                        <h5 class="center-align">Inclusions</h5>
                        <table id="inclusions" class="table">
                            <thead style="padding: 0px !important; background-color: #F8F9F9  ; display: table-header-group; vertical-align: middle; border-color: inherit; color:black;">
                                <tr style="border: 1px solid #F4F6F6 ">
                                    <th style="width:10%; padding: 5px !important; margin-left :5px;  border: 1px solid #D5DBDB  !important; text-align: center;">S. No.</th>
                                    <th style="width:55%; padding: 5px !important; margin-left :5px;  border: 1px solid #D5DBDB  !important; text-align: center;">Inclusions</th>
                                    <th style="padding: 5px !important; margin-left :5px;  border: 1px solid #D5DBDB  !important; text-align: center;">Price</th>
                                    <th style="padding: 5px !important; margin-left :5px;  border: 1px solid #D5DBDB  !important; text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <td colspan="4"  style="text-align: center;"><button onclick="showInclusion()" class="btn btn-light-green" type="button">Add inclusions</button></td>
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <div class="row s12 right">
                        <button type="submit" class="mb-6 btn waves-effect waves-light gradient-45deg-green-teal" >Save </button>
                        <a href="{{ route('packages-master.index') }}" class="mb-6 btn waves-effect waves-light gradient-45deg-purple-deep-orange">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>
    <div class="contact-compose-sidebar inclusion" style="width:80%; padding-right:5%;">
        <div class="card quill-wrapper">
                <div class="card-content pt-0">
                    <div class="card-header display-flex pb-2">
                        <h3 class="card-title contact-title-label">Inclusions</h3>
                        <div class="close close-icon">
                        <i  class="material-icons closeico">close</i>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <!-- form start -->
                    <form id="formaccountCode" class="edit-contact-item mb-5 mt-5" method="POST">
                        <table id="all_inclusions" class="table">
                            <thead style="padding: 0px !important; background-color: #F8F9F9  ; display: table-header-group; vertical-align: middle; border-color: inherit; color:black;">
                                <tr style="border: 1px solid #F4F6F6 ">
                                    <th style="width:10%; padding: 5px !important; margin-left :5px;  border: 1px solid #D5DBDB  !important; text-align: center;">No.</th>
                                    <th style="width:10%; padding: 5px !important; margin-left :5px;  border: 1px solid #D5DBDB  !important; text-align: center;">
                                        <label ><input  type="checkbox" id="checkall" ></label>
                                    </th>
                                    <th style="width:55%; padding: 5px !important; margin-left :5px;  border: 1px solid #D5DBDB  !important; text-align: center;">Inclusions</th>
                                    <th style="padding: 5px !important; margin-left :5px;  border: 1px solid #D5DBDB  !important; text-align: center;">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $contador =0;
                                @endphp
                                @foreach ($hotel->inclusions as $inclusion)
                                    @php
                                        $contador++;
                                    @endphp
                                    <tr>
                                        <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important;">
                                            {{$contador}}
                                        </td>
                                        <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; text-align: center;">
                                            <input id="check{{$inclusion->id}}" data-id="{{$inclusion->id}}" data-name="{{$inclusion->name}}" data-price="{{$inclusion->price_after_discount()}}"
                                            class="selection" style="opacity: 1;  pointer-events: all;"  type="checkbox"  />
                                        </td>
                                        <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important;">
                                            {{$inclusion->name}}
                                        </td>

                                        <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; text-align: right;">
                                            {{number_format($inclusion->price_after_discount(), 2,".",",") }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <br>
                        <div class="row s12 right">
                        <button type="button" onclick="addInclusion()" class="mb-6 btn waves-effect waves-light gradient-45deg-green-teal" >Add to Package </button>
                        <a class="mb-6 btn waves-effect waves-light gradient-45deg-purple-deep-orange closeico">Cancel</a>
                    </div>
                    </form>
                </div>
        </div>
    </div>
    <div class="contact-compose-sidebar surcharge" >
        <div class="card quill-wrapper">
                <div class="card-content pt-0">
                    <div class="card-header display-flex pb-2">
                        <h3 class="card-title contact-title-label">Upcharge</h3>
                        <div class="close close-icon">
                        <i  class="material-icons closeico">close</i>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <!-- form start -->
                    <form id="formUpcharge" class="edit-contact-item mb-5 mt-5" method="POST">
                        <input type="hidden" id="upcharge_hidden">
                        <table id="all_upcharge" class="table">
                            <thead style="padding: 0px !important;  display: table-header-group; vertical-align: middle; border-color: inherit; color:black;">
                                <tr style="border: 1px solid #F4F6F6; background-color: #F8F9F9  ; ">
                                    <th style="padding: 5px !important; margin-left :5px;  border: 1px solid #D5DBDB  !important; text-align: center;">Person</th>
                                    <th colspan="2" style="padding: 5px !important; margin-left :5px;  border: 1px solid #D5DBDB  !important; text-align: center;">Charge</th>
                                </tr>
                                <tr>
                                    <th style="padding: 5px !important; margin-left :5px;  border: 1px solid #D5DBDB  !important; text-align: center;"></th>
                                    <th style="padding: 5px !important; margin-left :5px;  border: 1px solid #D5DBDB  !important; text-align: center;">Adult</th>
                                    <th style="padding: 5px !important; margin-left :5px;  border: 1px solid #D5DBDB  !important; text-align: center;">Children</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                        <br>
                        <div class="row s12 right">
                        <button type="button" onclick="saveUpcharge()" class="mb-6 btn waves-effect waves-light gradient-45deg-green-teal" >Save</button>
                        <a class="mb-6 btn waves-effect waves-light gradient-45deg-purple-deep-orange closeico">Close</a>
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
@endsection

{{-- page script --}}
@section('page-script')
<script src="{{asset('js/scripts/form-validation.js')}}"></script>
<script src="{{asset('js/scripts/ui-alerts.js')}}"></script>
<script src="{{asset('js/scripts/hoteratus.js')}}"></script>
<script>

    var inclusionComposeSidebar = $(".contact-compose-sidebar.inclusion")
    var surchargeComposeSidebar = $(".contact-compose-sidebar.surcharge")
    var auht =0;
    $(".contact-sidebar-trigger.inclusion").on("click", function () {
      inclusionComposeSidebar.addClass("show");
      surchargeComposeSidebar.addClass("show");
   })
   function showInclusion(){
        inclusionComposeSidebar.addClass("show");
   }

   $(".closeico").on('click', function(){
        inclusionComposeSidebar.removeClass("show");
        surchargeComposeSidebar.removeClass("show");
   });

    function displaydata(room_id, adult){
        $("#all_upcharge tbody").html('');
        $("#upcharge_hidden").val(room_id)
        for (let index = 1; index <= adult; index++) {
            var adults = $('#upcharge_'+room_id+'_adult_'+index).val()
            var chldren = $('#upcharge_'+room_id+'_chldren_'+index).val()

            var tr = '<tr class="upcharge_modal"><td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; text-align: center;" >Person '+index+'</td>';
                tr += '<td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; text-align: center;" >'
                tr += '<input value="'+(adults??'0.00')+'" class="adult" data-person="'+index+'"  data-room="'+room_id+'" onkeypress="return isNumberKey(event)" style="width:50px;" type="text" class="browser-default"> </td>';
                tr += '<td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; text-align: center;" >';
                tr += '<input value="'+(chldren??'0.00')+'" class="children" data-person="'+adult+'" onkeypress="return isNumberKey(event)" style="width:50px;" type="text" class="browser-default"> </td></tr>';

            $("#all_upcharge tbody").append(tr);
        }
        surchargeComposeSidebar.addClass("show");
    }
    function saveUpcharge(){
            var room_id =$("#upcharge_hidden").val()
            $("#upcharge"+room_id).html('');
            $("#all_upcharge tbody tr.upcharge_modal").each(function (index, obj) {
            var adult = $(obj).find('.adult');
            var children = $(obj).find('.children');
            var info = '<span><strong style="color: black; font-weight:900;">Person '+adult.data('person')+':</strong> $'+
                (adult.val().length==0?'0.00': adult.val())+'(A)</span>  <span> $'+ (children.val().length==0?'0.00': children.val())+'(C)</span> <br>'+
                '<input type="hidden" name="upcharge['+room_id+'][adult]['+(index+1)+']" id="upcharge_'+room_id+'_adult_'+(index+1)+'" value="'+adult.val()+'" />'+
                '<input type="hidden" name="upcharge['+room_id+'][children]['+(index+1)+']" id="upcharge_'+room_id+'_children_'+(index+1)+'" value="'+children.val()+'"  />'
            $("#upcharge"+adult.data('room')).append(info);
        });
        surchargeComposeSidebar.removeClass("show");
        swal("All Changes has been Added, now you must save this information", {
                title: 'Saved',
                icon: "success",
        });
    }
    function addInclusion(){
            var contador =0;
            var total = 0;
            $(".loader").show();
            $('#inclusions tbody').html('');
            $("#all_inclusions tbody tr").each(function (index, obj) {
                if($(obj).find(".selection").is(':checked')){
                    contador++;

                    var data = $(obj).find(".selection");
                    total += parseFloat(data.data('price'))
                    var tr = '<tr id="inclusion'+data.data('id')+'" > <td style="padding: 5px !important; border: 1px solid #D5DBDB  !important;">'+contador+'</td>';
                        tr += '<td style="padding: 5px !important; border: 1px solid #D5DBDB  !important;">'+data.data('name')+'</td>';
                        tr += '<td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; text-align: right;">'
                        tr += thousands_separators(data.data('price'))+'<input class="inclusion_id" name="inclusion_id[]" type="hidden" value="'+data.data('id')+'" /></td>';
                        tr += '<td class="invoice-action-edit mr-6"  style="padding: 5px !important; border: 1px solid #D5DBDB  !important;text-align: center; "><a onclick="removeInclusion('+data.data('price')+','+data.data('id')+')" href="javascript:void(0)"><i class="material-icons">delete</i></a></td>';
                    $('#inclusions tbody').append(tr)
                }

            });

            if(contador==0){
                $('#inclusions tbody').append('<tr><td colspan="4"  style="text-align: center;"><button onclick="showInclusion()" class="btn btn-light-green" type="button">Add inclusions</button></td></tr>');

            }else{
                var tr = '<tr><td style="padding: 5px !important; border: 1px solid #D5DBDB  !important;"></td>';
                    tr+='<td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; text-align: center;"><button onclick="showInclusion()" type="button" class="btn btn-light-green" >Add more inclusions</button></td>';
                    tr += '<td style="padding: 5px !important; border: 1px solid #D5DBDB  !important; text-align: right;"><span id="total" data-total="'+total+'">'+thousands_separators(total)+'</span></td>';
                    tr += '<td style="padding: 5px !important; border: 1px solid #D5DBDB  !important;"></td></tr>';
                $('#inclusions tbody').append(tr);
            }
            $(".loader").hide();
            inclusionComposeSidebar.removeClass("show");

    }
    function  removeInclusion(amount, id){
       var total = parseFloat($('#total').data('total'))-parseFloat(amount);
       $('#total').data('total',total);
       $('#total').html(thousands_separators(total))
       $('#inclusion'+id).remove();
       $("#check"+id).prop('checked', false);
       if(total==0){
            $('#inclusions tbody').html('<tr><td colspan="4"  style="text-align: center;"><button onclick="showInclusion()" class="btn btn-light-green" type="button">Add inclusions</button></td></tr>');

       }
    }
    function thousands_separators(num)
    {
        var num_parts = num.toString().split(".");
        num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return num_parts.join(".");
    }

    function verifyInclusion(){
       if (auht ==1) return true;
       if($('.inclusion_id').length==0){
           setTimeout(() => {
                $(".loader").css('display', 'none');
           }, 100);
            swal({
                title: "Are you sure you want to create a package without inclusions?",
                text: "You can add it later!",
                icon: 'warning',
                dangerMode: true,
                buttons: {
                cancel: 'No, Please!',
                delete: 'Yes, Create It'
                }
            }).then(function (willDelete) {
                if (willDelete) {
                    auht=1;
                    $("#formSubmit").submit();
                } else {
                    swal("Select at least a inclusion", {
                        title: 'Cancelled',
                        icon: "error",
                    });
                    return false;
                }
            });
            return false;
       }
    }

</script>
@endsection
