@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Manager Display Color')
{{-- vendor style --}}
@section('vendor-style')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/flag-icon/css/flag-icon.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/fullcalendar/css/fullcalendar.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/fullcalendar/daygrid/daygrid.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/fullcalendar/timegrid/timegrid.min.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/spectrum-colorpicker2@2.0.0/dist/spectrum.min.css">
@endsection
@section('page-style')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-calendar.css')}}">
@endsection
{{-- page content --}}
@section('content')
<div class="section">

    <form action="{{ route('display-color.store')}}" method="POST" id="formSubmit" >
        @csrf
        <h5 class="text-center">Manager Display Color</h5>
        <div class="row s12 right">
            <button type="submit" class="mb-6 btn waves-effect waves-light gradient-45deg-green-teal" >Save </button>
        </div>
        <div class="row" >
            <div class="col s12">
                <table style="font-size: .80em; border-collapse: unset;" >
                    <thead style="display: table-header-group; vertical-align: middle; border-color: inherit; color:black;">
                        <tr><th colspan="5" style="background-color: #D7DBDD; padding: 5px 5px !important;">Select Color Coding of Room status for the Front Desk tape chart</th></tr>
                        <tr><th colspan="5" style="padding: 5px 5px !important;">Color Coding : to identify the status of room in a glance, the following color coding will appear in the tape Chart</th></tr>
                        <tr><th colspan="3"></th><th colspan="2" style="padding: 5px 5px !important;">Here is the sample to show how the cells will appear in the tape chart</th></tr>
                    </thead>
                    @foreach ($roomStatus as $room)
                    <tr >
                        <td style="padding: 5px 5px !important; width: 3px !important;">{{$room->id}}</td>
                        <td style="padding: 5px 5px !important; color:black; font-weight: bold;">{{$room->name}}</td>
                        <td style="padding: 5px 5px !important;">{{$room->description}}</td>
                        <td style="padding: 5px 5px !important;"><input onchange="cambio(this)" name="roomStatus[{{$room->id}}]" class="color-picker" value="{{$room->hotel_room_status_color($hotel_id)->color??'#fff'}}" data-value="#pp{{$room->id}}" /></td>
                    <td style="padding: 5px 5px !important;"> <div class="fc-events-container"><div id="pp{{$room->id}}" class='fc-event' data-color="black" style="padding: 10px 30px; background-color: {{$room->hotel_room_status_color($hotel_id)->color??'#fff'}}"> </div></div></td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
         <div class="row" >
            <div class="col s12">
                <table style="font-size: .80em; border-collapse: unset;" >
                    <thead style="display: table-header-group; vertical-align: middle; border-color: inherit; color:black;">
                        <tr><th colspan="5" style="background-color: #D7DBDD; padding: 5px 5px !important;">Select Color Coding of Housekeeping status</th></tr>
                        <tr><th colspan="5" style="padding: 5px 5px !important;">Color Coding : to identify the Housekeeping status of a room in a glance, the following color coding will appear behind the checkbox of the rooms in the front desk tape chart and in Housekeeping</th></tr>
                        <tr><th colspan="2"></th><th colspan="3" style="padding: 5px 5px !important; text-align: right;" >Here is the sample to show how the rooms will appear in the tape chart and in Housekeeping</th></tr>
                    </thead>
                    @foreach ($housekeepingStatus as $housekeeping)
                    <tr >
                        <td style="padding: 5px 5px !important; width: 3px !important;">{{$housekeeping->id}}</td>
                        <td style="padding: 5px 5px !important; color:black; font-weight: bold;">{{$housekeeping->name}}</td>
                        <td style="padding: 5px 5px !important;">{{$housekeeping->description}}</td>
                        <td style="padding: 5px 5px !important; width: 20%;"><input onchange="cambio(this)" name="housekeeping[{{$housekeeping->id}}]" class="color-picker" value="{{$housekeeping->hotel_housekeeping_status_color($hotel_id)->color??'#fff'}}" data-value="#house{{$housekeeping->id}}" /></td>
                        <td style="padding: 5px 5px !important; width: 15px;"> <div class="fc-events-container"><div id="house{{$housekeeping->id}}" class='fc-event' data-color="black" style=" width: 10px; padding: 10px 10px; background-color: {{$housekeeping->hotel_housekeeping_status_color($hotel_id)->color??'#fff'}}"> </div></div></td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="row" >
            <div class="col s12">
                <table style="font-size: .80em; border-collapse: unset;" >
                    <thead style="display: table-header-group; vertical-align: middle; border-color: inherit; color:black;">
                        <tr><th colspan="5" style="background-color: #D7DBDD; padding: 5px 5px !important;">Select Alphabet Coding for the Front Desk tape chart</th></tr>
                        <tr><th colspan="5" style="padding: 5px 5px !important;">Alphabet Coding : to identify the source of booking in a glance, the following alphabet coding will appear along with the color cell in the tape Chart</th></tr>
                        <tr><th colspan="2"></th><th colspan="3" style="padding: 5px 5px !important; text-align: right;" >Here is the sample to show how the cells will appear in the tape chart</th></tr>
                    </thead>
                    @foreach ($alphabetCoding as $alpha)
                    <tr >
                        <td style="padding: 5px 5px !important; width: 3px !important;">{{$alpha->id}}</td>
                        <td style="padding: 5px 5px !important; color:black; font-weight: bold; width: 150px;">{{$alpha->name}}</td>
                        <td style="padding: 5px 5px !important;">@if ($alpha->id !=6)
                            <input name="alpha[{{$alpha->id}}]" style="width: 30px; text-align: center; font-size: 11px;" maxlength="1" type="text" value="{{$alpha->alphabet_coding_hotel_code($hotel_id)->code??$alpha->default}}">
                        @endif</td>
                        <td style="padding: 5px 5px !important;">{{$alpha->description}}</td>
                        <td style="padding: 5px 5px !important;"> <div class="fc-events-container"><div class="fc-event pp1" data-color="black" style="padding-top: 5px; width: 140px; text-align: right; font-size: 11px; background-color: {{$colorReserva}}" >  ({{$alpha->alphabet_coding_hotel_code($hotel_id)->code??$alpha->default}})</div></div></td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </form>
</div>
@endsection

{{-- vendor script --}}
@section('vendor-script')
<script src="{{asset('vendors/jquery-validation/jquery.validate.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/spectrum-colorpicker2@2.0.0/dist/spectrum.min.js"> </script>
@endsection

{{-- page script --}}
@section('page-script')
<script src="{{asset('js/scripts/form-validation.js')}}"></script>
<script src="{{asset('js/scripts/ui-alerts.js')}}"></script>
<script>
    var color = "";
$('.color-picker').spectrum({
  type: "color",
  hideAfterPaletteSelect: "true",
  showAlpha: "false",
    showInitial: "true",
  showButtons: "false",
  allowEmpty: "true"
});

function cambio(obj){
    let id =  $(obj).data('value');
  $(id).attr('data-color',$(obj).val())
    $(id).css('background-color',$(obj).val() )
    if(id == "#pp1"){
        color = $(obj).val()
       $(".pp1").css('background-color', color )
    }
}
function reserveColor(){
    $(".pp1").css('background-color', color )
}
</script>
@endsection
