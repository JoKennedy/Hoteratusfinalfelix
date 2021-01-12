{{-- extend Layout --}}
@extends('layouts.calendarLayou')

{{-- page title --}}
@section('title','Housekeeping')

{{-- page styles --}}

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
    integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/CalendarJnS/css/bootstrap.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/CalendarJnS/css/app-calendar.css')}}">

{{-- page content --}}
@section('content')
<div class="calendar bg-white housekeeping" id="housekeeping">
    <div class="col-md-2 px-0">
        <div id="navbar-list-group" class="list-group bg-white">
            <a class="list-group-item list-item-collapse list-group-item-action" data-toggle="collapse"
                data-target="#list-dnr-house" href="#list-dnr-house" role="tab">
                Show DNR/House Use
            </a>
            <div id="list-dnr-house" class="collapse">
                <ul class="list">
                    <li><span class="badge" style="background: #ff0000">&nbsp;&nbsp;&nbsp;</span> Reserved</li>
                    <li><span class="badge" style="background: #2bff00">&nbsp;&nbsp;&nbsp;</span> Hold</li>
                </ul>
            </div>
            <a class="list-group-item list-group-item-action bg-primary text-white" href="#" role="tab"><i
                    class="fas fa-list"></i> Today's Room Status
            </a>
            <div class="px-1">
                <table id="tableTodaysRoomStatus" class="table table-sm table-2part">
                    <tbody>
                        <tr class="todays-checkIn">
                            <td class="text-primary cursor-pointer">Today's Check-In</td>
                            <td id="todaysCheckIn">8</td>
                        </tr>
                        <tr class="todays-checkOut">
                            <td class="text-primary cursor-pointer">Today's Check-Out</td>
                            <td id="todaysCheckOut">7</td>
                        </tr>
                        <tr>
                            <td>Available</td>
                            <td id="available">25</td>
                        </tr>
                        <tr>
                            <td id="reserved">Reserved</td>
                            <td>8</td>
                        </tr>
                        <tr>
                            <td id="occupied">Occupied</td>
                            <td>14</td>
                        </tr>
                        <tr>
                            <td id="blocked">Blocked</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td id="overBooking">Overbooking</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td id="checkOut">Checked-Out</td>
                            <td>0</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <a class="list-group-item list-group-item-action bg-primary text-white" href="#" role="tab"><i
                    class="fas fa-list"></i> Housekeeping
            </a>
            <div class="px-1">
                <table id="housekeepingStatus" class="table table-sm table-2part">
                    <tbody>
                        <tr>
                            <td>Dirty</td>
                            <td id="dirty">0</td>
                        </tr>
                        <tr>
                            <td>Touch Up</td>
                            <td id="touchUp">0</td>
                        </tr>
                        <tr>
                            <td>Clean</td>
                            <td id="clean">40</td>
                        </tr>
                        <tr>
                            <td>Repair</td>
                            <td id="repair">0</td>
                        </tr>
                        <tr>
                            <td>Inspect</td>
                            <td id="inspect">0</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <a class="list-group-item list-item-collapse list-group-item-action" data-toggle="collapse"
                data-target="#list-status-legends" href="#list-status-legends" role="tab">
                Room Status Legends
            </a>
            <div id="list-status-legends" class="collapse">
                <ul class="list">
                    @foreach ($roomStatus as $status)
                    <li><span class="badge"
                            style="background: {{$status->hotel_room_status_color($hotel_id)->color}}">&nbsp;&nbsp;&nbsp;</span>
                        {{$status->name}}</li>
                    @endforeach
                </ul>
            </div>

            <a class="list-group-item list-item-collapse list-group-item-action" data-toggle="collapse"
                data-target="#list-house-status-legends" href="#list-house-status-legends" role="tab">
                House Status Legends
            </a>
            <div id="list-house-status-legends" class="collapse">
                <ul class="list">
                    @foreach ($housekeepingStatus as $housekeeping)
                    <li><span class="badge"
                            style="background: {{$housekeeping->hotel_housekeeping_status_color($hotel_id)->color}}">&nbsp;&nbsp;&nbsp;</span>
                        {{$housekeeping->name}}</li>
                    @endforeach
                </ul>
            </div>
            <a class="list-group-item" href="#" role="tab">
                Refresh Housekeeping Status
            </a>
            <a class="list-group-item list-item-collapse list-group-item-action d-flex justify-content-between"
                data-toggle="collapse" data-target="#list-task" href="#list-task" role="tab">
                Task
                <div><button id="addTask" class="btn btn-primary py-0 px-1">Add Task</button> |
                    <button id="allTask" class="btn btn-primary py-0 px-1" data-toggle="modal"
                        data-target="#modalAllTask">All</button>
                </div>
            </a>
            <div id="list-task" class="collapse">
                <ul class="list">
                    <li><span class="badge" style="background: #ff0000">&nbsp;&nbsp;&nbsp;</span> Reserved</li>
                    <li><span class="badge" style="background: #2bff00">&nbsp;&nbsp;&nbsp;</span> Hold</li>
                </ul>
            </div>
            <a class="list-group-item" data-toggle="modal" data-target="#modalAuditTrail" href="#" role="tab">
                Housekeeping Audit Trail
            </a>
        </div>
    </div>
    <div class="col-md-10 border-dashed-left p-0">
        <div id="filter" class="bg-lightblue py-3">
            <div class="row">
                <div class="col-md-4">
                    <label for="setHpgS">Set Housekeeping Status</label>
                    <div class="input-group">
                        <select id="setHpgS" class="custom-select">
                            @foreach($housekeepingStatus as $housekeeping)
                            <option value="{{$housekeeping->id}}">{{$housekeeping->name}}</option>
                            @endforeach
                        </select>
                        <div class="input-group-prepend pl-1">
                            <div class="input-group-btn">
                                <button class="btn btn-primary" id="setHpgS-search">Go</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="assignRoomTo">Assign Selected Room to</label>
                    <div class="input-group">
                        <select id="assignRoomTo" class="custom-select">

                        </select>
                        <div class="input-group-prepend pl-1">
                            <div class="input-group-btn">
                                <button class="btn btn-primary" id="assignRoomTo-search">Assign Room</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="systemDate">System Date: 09/19/2020</label>
                    <div class="d-flex">
                        <label for="viewBy">View By:</label>
                        <select id="viewBy" class="custom-select" autocomplete="off">
                            <option value="allrooms" selected>All Rooms</option>
                            <option class="bg-light-gray font-weight-bold" disabled>Room Status</option>
                            @foreach ($roomStatus as $status)
                            <option value="{{$status->id}}">{{$status->name}}</option>
                            @endforeach
                            <option class="bg-light-gray font-weight-bold" disabled>Availability</option>
                            @foreach($housekeepingStatus as $housekeeping)
                            <option value="{{$housekeeping->id}}">{{$housekeeping->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row mt-1 d-block text-right px-3">
                <button class="btn btn-primary" data-toggle="modal" data-target="#modalAuditTrail">Audit Trail</button>
            </div>
        </div>
        <div class="row">
            <div class="table-responsive">
                <table id="tableRoomStatus" class="table table-striped table-checkList">
                    <thead>
                        <tr>
                            <th>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" id="checkHousekeeping" class="custom-control-input"
                                        value="off" autocomplete="off">
                                    <label for="checkHousekeeping" class="custom-control-label"></label>
                                </div>
                            </th>
                            <th>Room</th>
                            <th>Room Type</th>
                            <th>Status</th>
                            <th>Availability</th>
                            <th>Remarks</th>
                            <th>Discrepancy</th>
                            <th>Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" id="folioList3030-1" class="custom-control-input"
                                        value="off">
                                    <label for="folioList3030-1" class="custom-control-label"></label>
                                </div>
                            </td>
                            <th>STD-101</th>
                            <td>Standar Room</td>
                            <td class="bg-success p-0 h-100 text-center">
                                <select id="roomStatus" class="custom-select custom-select-user text-white">
                                    <option value="22">Clean</option>
                                    <option value="23">Dirty</option>
                                </select>
                            </td>
                            <td>Available</td>
                            <td id="remark" class="cursor-pointer" data-id="2">---</td>
                            <td> <button id="addDiscrepancy" class="btn btn-outline-primary" data-id="2"><i
                                        class="fas fa-plus"></i></button></td>
                            <td>
                                <select id="hkName" class="custom-select custom-select-user" data-id="2">
                                    <option value="Un-Assign">Un-Assign</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" id="folioList3030-3" class="custom-control-input"
                                        value="off">
                                    <label for="folioList3030-3" class="custom-control-label"></label>
                                </div>
                            </td>
                            <th>DLX-101</th>
                            <td>Deluxe Room</td>
                            <td class="bg-success p-0 h-100 text-center">
                                <select id="roomStatus" class="custom-select custom-select-user text-white">
                                    <option value="22">Clean</option>
                                    <option value="23">Dirty</option>
                                </select>
                            </td>
                            <td>Available</td>
                            <td id="remark" data-id="2">---</td>
                            <td> <button id="addDiscrepancy" class="btn btn-outline-primary" data-id="3"><i
                                        class="fas fa-plus"></i></button></td>
                            <td>
                                <select id="hkName" class="custom-select custom-select-user" data-id="3">
                                    <option value="Un-Assign">Un-Assign</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mt-3 p-3 d-block text-center bg-lightblue">
            <button class="btn btn-primary w-25"><i class="fas fa-print"></i> Print</button>
        </div>
    </div>

    <!-- Modal Today's Check-in Room-->
    <div class="modal fade" id="modalTodaysCheckInRooom" tabindex="-1" role="dialog" aria-labelledby=""
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h6 class="modal-title">Today's Check-In Room</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped dataTable">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>Group ID/Rsv ID</th>
                                    <th>Guest Name</th>
                                    <th>Check-in - check-out</th>
                                    <th>Nights</th>
                                    <th>Room# / Type</th>
                                    <th>Pax</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                    <th>Preferences / Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>G 09195/091917</td>
                                    <td>Anastacia grey</td>
                                    <td>Sept 16-2020 - Sept 19-2020</td>
                                    <td>3</td>
                                    <td>DLX-116/Deluxe</td>
                                    <td>3(A) 0(C)</td>
                                    <td>Check In</td>
                                    <td>$ 663.50</td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div><!-- Fin Modal body -->
                <div class="modal-footer">
                    <button id="btnUpdateRoom" class="btn btn-primary ml-auto"><i class="fas fa-print"></i>
                        Print</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Today's Check-Out Room-->
    <div class="modal fade" id="modalTodaysCheckOutRooom" tabindex="-1" role="dialog" aria-labelledby=""
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h6 class="modal-title">Today's Check-Out Room</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped dataTable">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>Group ID/Rsv ID</th>
                                    <th>Guest Name</th>
                                    <th>Check-in - check-out</th>
                                    <th>Nights</th>
                                    <th>Room# / Type</th>
                                    <th>Pax</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                    <th>Preferences / Notes</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div><!-- Fin Modal body -->
                <div class="modal-footer">
                    <button id="btnUpdateRoom" class="btn btn-primary ml-auto"><i class="fas fa-print"></i>
                        Print</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Audit Trail-->
    <div class="modal fade" id="modalAuditTrail" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h6 class="modal-title">Audit Trail</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <div class="filter bg-lightblue py-3">
                        <div class="row">
                            <div class="col">
                                <label for="fromDate">From Date</label>
                                <input type="date" id="fromDate" class="form-control inputCalendar"
                                    value={{date('Y-m-d')}}>
                            </div>
                            <div class="col">
                                <label for="toDate">To Date </label>
                                <input type="date" id="toDate" class="form-control inputCalendar"
                                    value={{date('Y-m-d')}}>
                            </div>
                            <div class="col">
                                <label for="roomType">Room Type</label>
                                <select id="roomType" class="custom-select">
                                    <option value="">--Select--</option>
                                    @foreach($roomType as $room)
                                    <option value="{{$room->id}}">{{$room->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <label for="rooms">Room Name</label>
                                <select id="rooms" class="custom-select"></select>
                            </div>
                            <div class="col">
                                <label for="filter">Filter</label>
                                <select id="filter" class="custom-select"></select>
                            </div>
                        </div>
                        <div class="row mt-3 d-block text-center">
                            <button id="search" class="btn btn-primary w-25"><i class="fas fa-search"></i>
                                Search</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="tableAuditTrail" class="table table-striped">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><b>Sep. 22-2020 08:58PM: </b> Room STD-102 assigned to Hotelogix Support by
                                        <span class="text-info">Jhon Smith</span> </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div><!-- Fin Modal body -->
                <div class="modal-footer">
                    <button id="btnUpdateRoom" class="btn btn-primary ml-auto"><i class="fas fa-print"></i>
                        Print</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Add Discrepancy-->
    <div class="modal fade" id="modalAddDiscrepancy" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h6 class="modal-title">Add Discrepancy</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <table class="verticalTable">
                            <tbody>
                                <tr>
                                    <th>Room Name</th>
                                    <td id="roomName">STD-101</td>
                                </tr>
                                <tr>
                                    <th>Room Type</th>
                                    <td id="roomType">Standar Room</td>
                                </tr>
                                <tr>
                                    <th>Room Status</th>
                                    <td id="roomStatus">Clean</td>
                                </tr>
                                <tr>
                                    <th>FO Status</th>
                                    <td id="foStatus">Available</td>
                                </tr>
                                <tr>
                                    <th>Hk Status</th>
                                    <td>
                                        <select id="hkStatus" class="custom-select">
                                            <option value="" disabled selected>-Select Status-</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>FO Occupancy</th>
                                    <td id="fooAdults">0 Adult(s)</td>
                                    <td id="fooChilds"> 0 Child(s)</td>
                                </tr>
                                <tr>
                                    <th>Hk Occuppancy</th>
                                    <td>
                                        <label for="hkoAdults">Adult(s)</label>
                                        <input type="number" id="hkoAdults" class="form-control">
                                    </td>
                                    <td>
                                        <label for="childs">Child(s)</label>
                                        <input type="number" id="hkoChilds" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <th>Discrepancy</th>
                                    <td colspan="3">
                                        <textarea id="Discrepancy" class="form-control"></textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div><!-- Fin Modal body -->
                <div class="modal-footer">
                    <button id="btnUpdateRoom" class="btn btn-primary ml-auto"><i class="fas fa-save"></i> Add</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i>
                        Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Remarks-->
    <div class="modal fade" id="modalRemarks" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h6 class="modal-title">Remarks</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <textarea id="remarks" class="form-control"></textarea>
                    </div>
                </div><!-- Fin Modal body -->
                <div class="modal-footer">
                    <button id="save" class="btn btn-primary ml-auto"><i class="fas fa-save"></i> Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i>
                        Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Add Task-->
    <div class="modal fade" id="modalAddTask" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h6 class="modal-title">Add Task</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mt-2">
                        <label for="workAreaType">Work Area Type</label>
                        <select id="workAreaType" class="custom-select">
                            <option value="room" selected>Room</option>
                            <option value="other">Other</option>
                        </select>

                    </div>
                    <div class="row mt-2">
                        <div class="col-6 pl-0">
                            <label for="info">For</label>
                            <select id="taskFor" class="custom-select">
                                <option value="">Housekeeping</option>
                            </select>
                        </div>
                        <div class="col-6 pr-0">
                            <label for="workArea">Work Area</label>
                            <select id="workArea" class="custom-select"></select>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <label for="contentTaskMessage">Tasks</label>
                        <textarea id="" class="form-control"></textarea>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-6 px-0">
                            <input type="date" id="taskDate" class="form-control inputCalendar" value="{{date("Y-m-d")}}">
                        </div>
                        <div class="col-sm-6 d-flex">
                            <input type="time" id="taskTime" class="form-control">
                        </div>
                    </div>
                </div><!-- Fin Modal body -->
                <div class="modal-footer">
                    <button id="save" class="btn btn-primary ml-auto"><i class="fas fa-save"></i> Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i>
                        Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal All Task-->
    <div class="modal fade" id="modalAllTask" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h6 class="modal-title">Task List</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <div id="filter" class="filter p-3 bg-lightblue">
                        <div class="row">
                            <div class="col-12">
                                <label for="typeSearch">Name/Group ID/Res ID/Room/Other Area:</label>
                                <input type="text" id="typeSearch" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 px-1">
                                <label for="from">Started Bettwen:</label>
                                <input type="date" id="from" class="form-control inputCalendar" value={{date('Y-m-d')}}>
                            </div>
                            <div class="col-md-3 px-1">
                                <label for="to">To</label>
                                <input type="date" id="to" class="form-control inputCalendar" value={{date('Y-m-d')}}>
                            </div>
                            <div class="col-md-3 px-1">
                                <label for="status">Status</label>
                                <select id="status" class="custom-select">
                                    <option value="all">All</option>
                                    <option value="tp">Task in Progress</option>
                                </select>
                            </div>
                            <div class="col-md-3 px-1">
                                <label for="">&nbsp;</label>
                                <button id="search" class="btn btn-primary w-100"><i class="fas fa-search"></i>
                                    Search</button>
                            </div>
                        </div>
                    </div>
                    <div class="row p-3">
                        <div class="table-responsive">
                            <table id="tableAllTask" class="table table-striped dataTable w-100">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <td>Group ID</td>
                                        <td>Rsv ID</td>
                                        <td>Room Names/Numbers</td>
                                        <td>Other Hotel Area</td>
                                        <td>Guest Name</td>
                                        <td>Stay Details</td>
                                        <td>Task# / Alert</td>
                                        <td>Due Date & Time</td>
                                        <td>Action</td>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div><!-- Fin Modal body -->
                <div class="modal-footer">
                    <button id="print" class="btn btn-primary ml-auto"><i class="fas fa-save"></i> Print</button>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection