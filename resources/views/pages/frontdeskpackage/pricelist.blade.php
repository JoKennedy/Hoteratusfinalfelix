 <div class="contact-compose-sidebar pricelist"  style="width:100%;" >
        <div class="card quill-wrapper">
                <div class="card-content pt-0">
                    <div class="card-header display-flex ">
                        <h3 class="card-title contact-title-label" >Price List-(Frontdesk)</h3>
                        <div class="close close-icon pr-9">
                            <span id="packagename">ds</span>
                             <i  class="material-icons closeico">close</i>
                        </div>
                    </div>
                    <div  style="font-size: .6em;" class="mr-6">
                        <h6 style="background-color: #F8F9F9" id="validation"></h6>

                        <table id="priceList" class="table responsive-table tablecustom">
                            <thead>
                                <tr>
                                    <th  >Room Types</th>
                                    <th colspan="{{$room->higher_occupancy+1}}" >Per Night Package Rate Based on Adult Occupancy</th>
                                </tr>
                                <tr>
                                    <th ></th>
                                    <th >
                                        Base
                                    </th>
                                    @for ($i = 1; $i <= $room->higher_occupancy; $i++)
                                        <th>

                                            {{($i==1? 'Single':($i==2?'Double':($i==3?'Triple':($i==4?'Four':($i==5?'Five':($i==6?'Six':
                                            ($i==7?'Seven':($i==8?'Eight':($i==9?'Nine':($i==10?'Ten':($i==11?'Eleven':($i==12?'Twelve':
                                            ($i==13?'Thirteen':($i==14?'Fourteen':($i==15?'Fifteen':($i==16?'Sixteen':$i))))))))))))))))}}
                                        </th>
                                    @endfor
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>

                </div>
        </div>
    </div>
