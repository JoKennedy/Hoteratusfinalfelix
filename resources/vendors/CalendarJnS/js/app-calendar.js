let dayNames = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
let monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

let currentDate = new Date();
let currentDay = currentDate.getDate();
let monthNumber = currentDate.getMonth();
let currentYear = currentDate.getFullYear();
/*Dates = agregar los dias */
let dates = document.querySelector('#calendar #dates');
let month = document.querySelector("#calendar .date-info #month")
let year = document.querySelector('#calendar .date-info #year');
let dayWeek = document.querySelector('#calendar #daysWeek');

var setRooms = document.querySelector('#calendar #rooms');

month.textContent = monthNames[monthNumber];
month.setAttribute("month", monthNumber + 1);
year.textContent = currentYear.toString();



function typeDateActive() {
    var typeDate = $(".calendar .date-change .active").attr("id");
    return typeDate;
}

function dayName(m, d, y) {
    /*MM/DD/YYYY*/
    let date = new Date(" " + m + "/" + d + "/" + y + " ");
    let options = {
        weekday: 'short'
    };
    return date.toLocaleDateString('en-US', options);
}
var rooms = "";
async function NumOfRooms(totalDays, numRooms = 10) {
    let data = 
    {
        "TO": "Rooms",
        "ACTION" : "View"
    }
    datos = await GetInformation(data);

    /* CHEQUEAR COMO PONER QUE SE GENEREN LAS HABITACIONES CON EL ID Y SE DIVIDA  EN TIPO DE HABITACIONES */
    setRooms.textContent = '';
    datos['roomType'].forEach((dataroomElement, index) => {

        setRooms.innerHTML += `<tr><td class="typeRoom"colspan="${totalDays + 1}">${dataroomElement["name"]}</td></tr>`;
        datos['rooms'].forEach((DataElement) => {
            if(dataroomElement['id'] == DataElement['room_type_id']){
                setRooms.innerHTML += `<tr data-idroom="${DataElement["id"]}" data-typeRoomName="${dataroomElement["name"]}"><td class="nameRoom" data-index="${DataElement["id"]}">${DataElement["name"]}</td>` + rooms + "</tr>";
            }
        });
    });
    //console.log(rooms)
    rooms = "";
    requestInformation()
}
function starWeek() {
    let starDayofWeek = 0;
    let actualDay = dayName(monthNumber + 1, currentDay, currentYear);
    if (actualDay === "Mon") {
        return currentDay;
    }
    else if (actualDay === "Tue") {
        return currentDay - 1;
    }
    else if (actualDay === "Wed") {
        return currentDay - 2;
    }
    else if (actualDay === "Thu") {
        return currentDay - 3;
    }
    else if (actualDay === "Fri") {
        return currentDay - 4;
    }
    else if (actualDay === "Sat") {
        return currentDay - 5;
    }
    else if (actualDay === "Sun") {
        return currentDay - 6;
    }
}
const writeMonth = (month) => {
    dates.textContent = '';
    dayWeek.textContent = '';
    /* for(let i = startDay(); i>0;i--){
         let day =getTotalDays(monthNumber-1)-(i-1);
         dates.innerHTML += ` <td class="calendar__date calendar__item calendar__last-days">
             ${day}
         </td>`;
         dayWeek.innerHTML+= "<th>"+dayName(monthNumber,day,2020)+"<th";
         console.log(monthNumber+"-"+day+"-"+currentYear);
     }*/
    var widthColumn = 85 / (getTotalDays(month));
    dayWeek.innerHTML += `<th class="rooms day-week" style="width:15%;">Rooms<th`;
    for (let i = 1; i <= getTotalDays(month); i++) {
        if (i == 1) {
            dates.innerHTML += ` <td class="calendar__date calendar__item containerDragable"></td>`;
        }
        if (i === currentDay && month + 1 === (new Date().getMonth()) + 1 && currentYear === new Date().getFullYear()) {

            dates.innerHTML += ` <td id="calendar__item" class="calendar__date calendar__item calendar__today containerDragable" data-day="${i}" data-month="${month + 1}" data-year="${currentYear}">${i}</td>`;
            dayWeek.innerHTML += `<th class="day-week calendar__today" style="width:${widthColumn}%;">${dayName(monthNumber + 1, i, currentYear)}<th`;
            //NumOfRooms(monthNumber + 1, i, currentYear, getTotalDays(month));
            rooms += `<td class="calendar__date calendar__item containerDragable" data-day="${i}" data-month="${month + 1}" data-year="${currentYear}"></td>`;
        } else {
            dates.innerHTML += ` <td id="calendar__item" class="calendar__date calendar__item" data-day="${i}" data-month="${month + 1}" data-year="${currentYear}">${i}</td>`;
            dayWeek.innerHTML += `<th class="day-week" style="width:${widthColumn}%;">${dayName(monthNumber + 1, i, currentYear)}<th`;
            //NumOfRooms(monthNumber + 1, i, currentYear, getTotalDays(month));
            rooms += `<td class="calendar__date calendar__item containerDragable" data-day="${i}" data-month="${month + 1}" data-year="${currentYear}"></td>`;
        }

    }
    NumOfRooms(getTotalDays(month));
}

//TotoalDays = Total de dias a recorrer -R
//R = cantidad de dias restantes del mes anterior (en caso de que haya)
let beforeMonth = false;
let totalDays = 0;
let limitDays = 0;
const writeMonth_week = (month, i = 1) => {
    let r = 0;
    clearFields();
    var widthColumn = 85 / ((limitDays));

    dayWeek.innerHTML += `<th class="rooms day-week" style="width:15%;">Rooms<th`;
    dates.innerHTML += ` <td class="calendar__date calendar__item" disabled></td>`;

    if (beforeMonth) {
        for (let e = startDay(); e > 0; e--) {
            //Prodia reemplazar el StarDay console.log(index + "-0-" + totalDays+"--"+(getTotalDays(monthNumber - 1)-(index-limitDays)));
            if (monthNumber === 0) {
                let day = getTotalDays(monthNumber - 1) - (e - 1);
                dayWeek.innerHTML += `<th class="day-week" style="width:${widthColumn}%;">${dayName(12, day, currentYear - 1)}<th`;
                dates.innerHTML += ` <td id="calendar__item" class="calendar__date calendar__item  calendar__last-days" data-day="${day}" data-month="12" data-year="${currentYear - 1}">${day}</td>`;
                /* Agregar las habitaciones */
                rooms += `<td class="calendar__date calendar__item" data-day="${day}" data-month="12" data-year="${currentYear - 1}"></td>`;
                r++;
            }
            else {
                let day = getTotalDays(monthNumber - 1) - (e - 1);
                dayWeek.innerHTML += `<th class="day-week" style="width:${widthColumn}%;">${dayName(monthNumber, day, currentYear)}<th`;
                dates.innerHTML += ` <td id="calendar__item" class="calendar__date calendar__item  calendar__last-days" data-day="${day}" data-month="${month - 1}" data-year="${currentYear}">${day}</td>`;
                /* Agregar las habitaciones */
                rooms += `<td class="calendar__date calendar__item" data-day="${day}" data-month="${month - 1}" data-year="${currentYear}"></td>`;
                r++;
            }
        }
        i = 1;
        totalDays = (limitDays - r);
        index = totalDays;
    }
    else {
        r = 0;
    }
    for (i; i <= totalDays; i++) {

        if (i === currentDay && month === new Date().getMonth() + 1 && currentYear === new Date().getFullYear()) {
            dayWeek.innerHTML += `<th class="day-week" style="width:${widthColumn}%;">${dayName(monthNumber + 1, i, currentYear)}<th`;
            dates.innerHTML += ` <td id="calendar__item" class="calendar__date calendar__item calendar__today" data-day="${i}" data-month="${month}" data-year="${currentYear}">${i}</td>`;
            /* Agregar las habitaciones */
            rooms += `<td class="calendar__date calendar__item" data-day="${i}" data-month="${month}" data-year="${currentYear}"></td>`;
        } else {
            dayWeek.innerHTML += `<th class="day-week" style="width:${widthColumn}%;">${dayName(monthNumber + 1, i, currentYear)}<th`;
            dates.innerHTML += ` <td id="calendar__item" class="calendar__date calendar__item" data-day="${i}" data-month="${month}" data-year="${currentYear}">${i}</td>`;
            /* Agregar las habitaciones */
            rooms += `<td class="calendar__date calendar__item" data-day="${i}" data-month="${month}" data-year="${currentYear}"></td>`;
        }
    }
    NumOfRooms(limitDays);

}
var index = starWeek();
function nextWeek() {
    if (totalDays == index + 6) {

        index = totalDays + 1;
        totalDays += + 7;
        if (totalDays >= getTotalDays(monthNumber)) {
            /* RESET VARIABLES */
            beforeMonth = true;
            nextMonth();
            writeMonth_week(monthNumber + 1, index);
            totalDays = 1;
            beforeMonth = false;
        }
        else {
            writeMonth_week(monthNumber + 1, index);
        }
    }
    else {
        totalDays = index;
        index = totalDays + 1;
        totalDays += + 7;
        writeMonth_week(monthNumber + 1, index);
    }
}

const lastWeek = () => {

    if (totalDays == getTotalDays(monthNumber - 1)) {
        totalDays = getTotalDays(monthNumber - 1) + index - 7;
        index = totalDays - 6;
        lastMonth();
        writeMonth_week(monthNumber + 1, index);
    }
    else if (index == 1) {
        totalDays = getTotalDays(monthNumber - 1);
        index = totalDays - 6;
        lastMonth();
        writeMonth_week(monthNumber + 1, index);

    }
    else if ((index - 7) <= 0) {
        beforeMonth = true;
        index = 1;
        totalDays += -7;
        writeMonth_week(monthNumber + 1, index);
        totalDays = getTotalDays(monthNumber - 1);
        beforeMonth = false;
    }
    else if (totalDays == index + 6) {
        index += -7;
        totalDays += - 7;
        writeMonth_week(monthNumber + 1, index);
    }

}

function next15Days() {

    if (totalDays == index + 13) {
        index = totalDays + 1;
        totalDays += + 14;
        if (totalDays >= getTotalDays(monthNumber)) {
            console.log(index + "-3-" + totalDays);
            /* RESET VARIABLES */
            beforeMonth = true;
            nextMonth();
            writeMonth_week(monthNumber + 1, index);
            totalDays = 1;
            beforeMonth = false;
        }
        else {
            console.log(index + "-4-" + totalDays);
            writeMonth_week(monthNumber + 1, index);
        }
    }
    else {
        totalDays = index;
        index = totalDays + 1;
        totalDays += + 14;
        console.log(index + "-5.1-" + totalDays);
        writeMonth_week(monthNumber + 1, index);
    }
}
function last15Days() {
    if (totalDays == getTotalDays(monthNumber - 1)) {

        totalDays = getTotalDays(monthNumber - 1) + index - 14;
        index = totalDays - 13;
        lastMonth();
        writeMonth_week(monthNumber + 1, index);
        console.log(1 + "-" + index + "-" + totalDays);
    }
    else if (index == 1) {

        totalDays = getTotalDays(monthNumber - 1);
        index = totalDays - 13;
        lastMonth();
        writeMonth_week(monthNumber + 1, index);
        console.log(2 + "-" + index + "-" + totalDays);

    }
    else if ((index - 14) <= 0) {
        beforeMonth = true;
        index = 1;
        totalDays += -14;
        console.log(3 + "a-" + index + "-" + totalDays);
        writeMonth_week(monthNumber + 1, index);

        console.log(3 + "-" + index + "-" + totalDays);
        totalDays = getTotalDays(monthNumber - 1);
        beforeMonth = false;

    }
    else if (totalDays == index + 13) {

        index += -14;
        totalDays += - 14;
        writeMonth_week(monthNumber + 1, index);
        console.log(4 + "-" + index + "-" + totalDays);
    }
}/* En dado caso que vaya de 14 dias, actualizar la funcion next15Days */

const getTotalDays = month => {
    if (month === -1) month = 11;

    if (month == 0 || month == 2 || month == 4 || month == 6 || month == 7 || month == 9 || month == 11) {
        return 31;

    } else if (month == 3 || month == 5 || month == 8 || month == 10) {
        return 30;

    } else {

        return isLeap() ? 29 : 28;
    }
}
/* Saber si el año es viciesto */
const isLeap = () => {
    return ((currentYear % 100 !== 0) && (currentYear % 4 === 0) || (currentYear % 400 === 0));
}

const startDay = () => {
    let start = new Date(currentYear, monthNumber, 1);
    return ((start.getDay() - 1) === -1) ? 6 : start.getDay() - 1;
}

const lastMonth = () => {
    if (monthNumber !== 0) {
        monthNumber--;
    } else {
        monthNumber = 11;
        currentYear--;
    }

    currentDate.setFullYear(currentYear, monthNumber, currentDay);
    month.textContent = monthNames[monthNumber];
    month.setAttribute("month", monthNumber + 1);
    year.textContent = currentYear.toString();

    writeMonth(monthNumber);
}

const nextMonth = () => {
    if (monthNumber !== 11) {
        monthNumber++;
    } else {
        monthNumber = 0;
        currentYear++;
    }

    currentDate.setFullYear(currentYear, monthNumber, currentDay);
    month.textContent = monthNames[monthNumber];
    month.setAttribute("month", monthNumber + 1);
    year.textContent = currentYear.toString();

    writeMonth(monthNumber);
}

const clearFields = () => {
    dates.textContent = '';
    dayWeek.textContent = '';
}
const setNewDate = (timeData) => {

    typeDate = typeDateActive()
    //writeMonth(monthNumber);
    if (typeDate == "month") {
        if (timeData == "next") {
            nextMonth();
        }
        else if (timeData == "prev") {
            lastMonth();
        }
    }
    else if (typeDate == "fiveteenDays") {
        if (timeData == "next") {
            next15Days();
        }
        else {
            last15Days();
        }
    }
    else if (typeDate == "week") {
        if (timeData == "next") {
            nextWeek();
        }
        else {
            lastWeek();
        }
    }
    requestInformation()
}
writeMonth(monthNumber);
requestInformation()

/*JQUERY*/
var isMouseDown = false;
let FDayStart = "";
let FMonthStart = "";
let FYearStart = "";
let FStart = "";

let FDayStop = "";
let FMonthStop = "";
let FYearStop = "";
let FStop = "";
let columnIndex = "";
let Rowindex = "";
let RowindexOver = "";

$(document).ready(function () {


    $("body").on("click", ".navbar-left .angle-left", function () {
        $("#navbar-list-group").animate({ width: 'toggle' }, 500);

        if ($(".navbar-left #navbar-list-group").hasClass("active")) {
            $(".navbar-left #navbar-list-group").removeClass("active")
            $(".navbar-left .angle-left i").removeClass('fa-angle-left');
            $(".navbar-left .angle-left i").addClass('fa-angle-right');

            $(".navbar-left .subpanel-content").addClass("full-width");
        }
        else {
            $(".navbar-left #navbar-list-group").addClass("active")
            $(".navbar-left .angle-left i").removeClass('fa-angle-right');
            $(".navbar-left .angle-left i").addClass('fa-angle-left');

            $(".navbar-left .subpanel-content").removeClass("full-width");
        }
    })
    $("body").on("click", "#navbar-list-group a[data-toggle='list']", function () {
        $(".navbar-left #subpanel-content").addClass("show")
        let title = $(this).text();
        $("#calendar .navbar-left #subpanel-content .subpanel-header #title").text(title)
    });
    //$('.toast').toast('show');
    $(".removeItem").attr(
        {
            "data-toggle": "modal",
            "data-target": "#ModalRemoveItem"
        }
    );
    $("#myTabCalendar").on("click", "#tabClose", function () {
        let id = $(this).attr("data-id");
        $(`#myTabCalendar .nav-item[data-remove='${id}']`).remove();
        $(`#tab-content #${id}`).remove();
        $("#frontDesk-tab").tab("show")
    });

    $("#ModalReservation").click(function () {
        cleanFields();
    });
    $("#ModalReservation .modal-footer #btnSingleReservation,#btnAgentOrCorporateReservation,#btnGroupReservation").click(function () {
        AgentReservation($(this).attr("data-type-reservation"));
    });
    $(".calendar .date-change #month,#week,#fiveteenDays").click(function () {
        //setNewDate();
        $(".calendar .date-change #month,#week,#fiveteenDays").removeClass("active");
        $(this).addClass("active");
        $(".calendar .date-change #month,#week,#fiveteenDays").removeAttr("disabled");
        $(this).attr("disabled", "disabled");
    });

    $(".calendar .date-change #next").click(function () {
        setNewDate("next");
    });

    $(".calendar .date-change #prev").click(function () {
        setNewDate("prev");
    });

    $(".calendar .date-change #week").click(function () {
        limitDays = 7;
        index = starWeek();
        totalDays = index + (limitDays - 1);
        console.log(index + "-" + totalDays)
        nextWeek();
    });

    $(".calendar .date-change #month").click(function () {
        writeMonth(monthNumber);

    });

    $(".calendar .date-change #fiveteenDays").click(function () {
        limitDays = 14;
        index = starWeek() - 1;
        totalDays = index + (limitDays - 1);
        //console.log(index + "-" + totalDays);
        next15Days();
    });

    $("#calendar__dates #rooms").on("click", "tr", function () {
        Rowindex = $(this).index();
    });

    $("#calendar__dates #rooms").on("mouseover", "tr", function () {
        RowindexOver = $(this).index();
    });

    $("#calendar__dates #rooms").on("click", ".EventsCalendar", function () {
        let id = $(this).attr("data-id");
        fillModalDetails(id)
    });
    /* MODALS */
    $("#ModalReservation button.close").on("click", function () {
        cleanFields();
    });
    $("#ModalDetailsReservation #viewDetailsReserv").on("click", function () {
        ShowAllDetails();
    });

    $("#modalUpdateRoom .modal-footer #btnUpdateRoom").click(function () {
        let from = $("#modalUpdateRoom .modal-body #from").val();
        let to = $("#modalUpdateRoom .modal-body #to").val();
        let roomNumber = $("#modalUpdateRoom .modal-body #roomNumber").val();
        let roomType = $("#modalUpdateRoom .modal-body #roomType").val();
        let Id = $("#modalUpdateRoom .modal-footer #btnUpdateRoom").attr("data-id");
        UpdateReserv(Id, from, to, roomNumber, roomType);
    });
    $("#calendar__dates #rooms").on("mousedown", "td.calendar__item", function () {

        if (isMouseDown) {
            isMouseDown = false;
            FDayStop = $(this).attr("data-day");
            FMonthStop = $(this).attr("data-month");
            FYearStop = $(this).attr("data-year");
            FStop = formatDate(FYearStop, FMonthStop, FDayStop);
            //Comprovar si el fecha final es inferior a la fecha inicial
            if (FMonthStart <= FMonthStop && FYearStart <= FYearStop) {
                if (FMonthStop > FMonthStart && FYearStop >= FYearStart && FDayStart >= FDayStop) {
                    ShowModalReserv();
                }
                else if (FMonthStart <= FMonthStop && FDayStart <= FDayStop) {
                    ShowModalReserv();
                }
                else {
                    isMouseDown = true;
                }
            }
            else {
                isMouseDown = true;
            }
        }
        else {
            //Activar el evento de seleccion de fechas
            isMouseDown = true;
            $(".calendar .date-change *").prop("disabled", "true");
            $(this).addClass("index");

            columnIndex = $(this).index();
            FDayStart = parseInt($(this).attr("data-day"));
            FMonthStart = $(this).attr("data-month");
            FYearStart = $(this).attr("data-year");
            FStart = formatDate(FYearStart, FMonthStart, FDayStart);

        }
    })
        .on("mouseover", "td.calendar__item", function () {
            TotalItems = $(`#calendar__dates #rooms tr:eq(${Rowindex}) td.calendar__item`).length;
            let FDayOver = parseInt($(this).attr("data-day"));
            let ItemOver = $(this).index();
            if (isMouseDown === true && Rowindex === RowindexOver) {
                if ($(this).hasClass("active")) {
                    //remover la clase ACTIVE de los elementos mayores al FDayOver
                    ModalNight((ItemOver - columnIndex) + 1, $(this).position().left, $(this).position().top);
                    for (let i = ItemOver; i <= TotalItems; i++) {
                        $(`#calendar__dates #rooms tr:eq("${Rowindex}") td.calendar__item:eq(${(i - 1)})`).removeClass("active");
                    }
                }
                else {
                    if (columnIndex <= ItemOver) {
                        //$(this).addClass("active");
                        ModalNight((ItemOver - columnIndex) + 1, $(this).position().left, $(this).position().top);
                        //Agregar la clase ACTIVE de los elementos menores al Hover y mayores al INDEX (ColumnIndex)
                        for (let i = columnIndex; i < ItemOver; i++) {
                            $(`#calendar__dates #rooms tr:eq("${Rowindex}") td.calendar__item:eq(${(i)})`).addClass("active");
                        }
                    }
                }
            }
        });
});//Final

/*-- funciones del calendario  --*/
function formatDate(year, month, day) {
    //correct format YYYY-M-D
    if (month <= 9) {
        month = "0" + month;
    }
    if (day <= 9) {
        day = "0" + day;
    }
    date = year + "-" + month + "-" + day
    return date;
}
function ModalNight(NumNight, x, y) {
    $("#ModalNight").remove();
    let modal = `<div id="ModalNight" style="left:${x + 80}px;top:${y + 106}px;" class="ModalNight shadow"><p>${NumNight}Night</p></div>`;
    $("body").before(modal);
}
function ShowModalReserv() {
    $("#ModalReservation").modal("show")
    //$("#ModalReservation").toggle().removeClass("show").addClass("show");
    $("#ModalReservation .modal-body #from").val(FStart);
    $("#ModalReservation .modal-body #to").val(FStop);
}
function cleanFields() {
    $(".calendar .date-change *").removeAttr("disabled");
    if ($(".calendar .date-change button").hasClass("active")) { $(this).attr("disabled", "disabled") }
    //$("#ModalReservation").toggle().removeClass("show");
    $("#ModalNight").remove();
    $("#calendar__dates #rooms tr td.calendar__item").each(function () {
        $(this).removeClass("active").removeClass("index");
    });
}
function resetDayOrMonth(date) {
    if (date < 10) {
        date = date.replace("0", "");
    }
    return parseInt(date);
}
function itemReserv(id, nicename, colpsan, status, stayFrom, stayTo) {
    let reserv = `<td data-toggle="modal" data-target="#ModalDetailsReservation" data-stayFrom="${stayFrom}" data-stayTo="${stayTo}" data-id="${id}" title="${nicename}" draggable="true" class="EventsCalendar itemDraggable" style="background:${status}" colspan="${colpsan} "><span>${nicename}<span></span></span></td>`;
    return reserv;
}
function setEvent(checkIn, checkOut, idRoom, IdReserv, nicename, status) {
    let yearCheckIn = checkIn.slice(0, 4);
    let monthCheckIn = resetDayOrMonth(`${checkIn.slice(5, 7)}`);
    let dayCheckIn = resetDayOrMonth(`${checkIn.slice(8, 10)}`);

    let yearCheckOut = checkOut.slice(0, 4);
    let monthCheckOut = resetDayOrMonth(checkOut.slice(5, 7));
    let dayCheckOut = resetDayOrMonth(checkOut.slice(8, 10));
    let stayFrom = formatDate(yearCheckIn, monthCheckIn, dayCheckIn);
    let stayTo = formatDate(yearCheckOut, monthCheckOut, dayCheckOut);
    let colspan = 0;
    let start = 0;

    if (monthCheckIn === monthCheckOut) {
        for (let i = dayCheckIn; i <= dayCheckOut; i++) {
            if ($(`#calendar__dates #rooms tr[data-idroom=${idRoom}] td[data-day=${i}]td[data-month=${monthCheckIn}]td[data-year=${yearCheckIn}]`).length > 0) {
                start++;
                if (start == 1) {
                    $(`#calendar__dates #rooms tr[data-idroom=${idRoom}] td[data-day=${i}]td[data-month=${monthCheckIn}]td[data-year=${yearCheckIn}]`).before(`<td id="start"></td>`);
                }
                $(`#calendar__dates #rooms tr[data-idroom=${idRoom}] td[data-day=${i}]td[data-month=${monthCheckIn}]td[data-year=${yearCheckIn}]`).remove();
                colspan++;
            }
        }
        $(`#calendar__dates #rooms tr[data-idroom=${idRoom}] #start`).after(itemReserv(IdReserv, nicename, colspan, status, stayFrom, stayTo));
        $(`#calendar__dates #rooms tr[data-idroom=${idRoom}] #start`).remove();
    }

    else if (monthCheckOut > monthCheckIn) {
        /* Agregara la reserva a los dias que esten antes del mes de checkout en un mes diferente */
        for (let i = dayCheckIn; i <= getTotalDays(monthNumber); i++) {
            if ($(`#calendar__dates #rooms tr[data-idroom=${idRoom}] td[data-day=${i}]td[data-month=${monthCheckIn}]td[data-year=${yearCheckIn}]`).length > 0) {
                start++;
                if (start == 1) {
                    $(`#calendar__dates #rooms tr[data-idroom=${idRoom}] td[data-day=${i}]td[data-month=${monthCheckIn}]td[data-year=${yearCheckIn}]`).before(`<td id="start" data-idroom="${idRoom}"></td>`);
                }
                $(`#calendar__dates #rooms tr[data-idroom=${idRoom}] td[data-day=${i}]td[data-month=${monthCheckIn}]td[data-year=${yearCheckIn}]`).remove();
                colspan++;
            }
        }
        $(`#calendar__dates #rooms tr[data-idroom=${idRoom}] #start`).after(itemReserv(IdReserv, nicename, colspan, status, stayFrom, stayTo));
        $(`#calendar__dates #rooms tr[data-idroom=${idRoom}] #start`).remove();
        start = 0;

        if (monthCheckOut == monthNumber + 1) {
            for (let i = 1; i <= dayCheckOut; i++) {
                if ($(`#calendar__dates #rooms tr[data-idroom=${idRoom}] td[data-day=${i}]td[data-month=${monthCheckOut}]td[data-year=${yearCheckOut}]`).length > 0) {

                    start++;
                    if (start == 1) {
                        $(`#calendar__dates #rooms tr[data-idroom=${idRoom}] td[data-day=${i}]td[data-month=${monthCheckOut}]td[data-year=${yearCheckIn}]`).before(`<td id="start" data-idroom="${idRoom}"></td>`);
                    }
                    $(`#calendar__dates #rooms tr[data-idroom=${idRoom}] td[data-day=${i}]td[data-month=${monthCheckOut}]td[data-year=${yearCheckOut}]`).remove();
                    colspan++;
                }
            }
            $(`#calendar__dates #rooms tr[data-idroom=${idRoom}] #start`).after(itemReserv(IdReserv, nicename, colspan, status, stayFrom, stayTo));
            $(`#calendar__dates #rooms tr[data-idroom=${idRoom}] #start`).remove();
        }
    }/* Fin else if */
}
function requestInformation() {
    setEvent("2020-09-03", "2020-09-14", 1, 3100, "Jose Polanco", "#1a9316");
    setEvent("2020-09-01", "2020-09-08", 2, 3301, "Maria Lamarche", "#f00612");
    setEvent("2020-09-01", "2020-09-10", 3, 3030, "Peco Lamarche", "#ffc107");
    setEvent("2020-09-02", "2020-09-14", 5, 2200, "Peco Lamarche", "#ffc107");
    setEvent("2020-09-25", "2020-09-28", 8, 3020, "Peco Lamarche", "#ffc107");
}
/*-- funciones del calendario para los Modal --*/
function fillModalDetails(ID) {
    const data =
        [{
            "typeReservation": "SINGLE RESERVATION",
            "IdReservation": ID,
            "groupId": "00033221",
            "nicename": "Anastacia Greyciana",
            "reservationStatus": "Temp reservation",
            "roomType": "Deluxe Room",
            "roomName": "STD-1",
            "guestID": "P2300",
            "guestName": "Anastacia Grey",
            "address" : "Av. Henrriquillo #366, Santo Domingo Distrito Nacional",
            "country" : "Domincan Republic",
            "zipCode" : "10023",
            "phone": "809-222-3333",
            "email": "agrey@outlook.com",
            "ratetype": "Half Board",
            "checkInDate": "2020/07/24",
            "checkOutDate": "2020/07/29",
            "roomNight": "6",
            "adults": "2",
            "arrivalTime": "",
            "departureTime": "",
            "totalAmount": "200",
            "paid": "0.00",
            "balance": "200",
            "groupTotal": "",
            "groupDeposit": ""
        }];

    data.forEach(datos => {

        $("#ModalDetailsReservation #typeReservation").html(datos["typeReservation"]);
        $("#ModalDetailsReservation #IdReservation").html(datos["IdReservation"]);
        $("#ModalDetailsReservation #IdReservation").attr("data-id", (datos["IdReservation"]));
        $("#ModalDetailsReservation #groupId").html(datos["groupId"]);
        $("#ModalDetailsReservation #nicename").html(datos["nicename"]);
        $("#ModalDetailsReservation #reservationStatus").html(datos["reservationStatus"]);
        $("#ModalDetailsReservation #roomType").html(datos["roomType"] + " " + datos["roomName"]);
        $("#ModalDetailsReservation #guestID").html(datos["guestID"]);
        $("#ModalDetailsReservation #guestName").html(datos["guestName"]);
        $("#ModalDetailsReservation #Address").html(datos["address"]);
        $("#ModalDetailsReservation #zipCode").html(datos["zipCode"]);
        $("#ModalDetailsReservation #country").html(datos["country"]);
        $("#ModalDetailsReservation #phone").html(datos["phone"]);
        $("#ModalDetailsReservation #email").html(datos["email"]);
        $("#ModalDetailsReservation #ratetype").html(datos["ratetype"]);
        $("#ModalDetailsReservation #checkInDate").html(datos["checkInDate"]);
        $("#ModalDetailsReservation #checkOutDate").html(datos["checkOutDate"]);
        $("#ModalDetailsReservation #roomNight").html(datos["roomNight"]);
        $("#ModalDetailsReservation #adults").html(datos["adults"]);
        $("#ModalDetailsReservation #arrivalTime").html(datos["arrivalTime"]);
        $("#ModalDetailsReservation #departureTime").html(datos["departureTime"]);
        $("#ModalDetailsReservation #totalAmount").html(datos["totalAmount"]);
        $("#ModalDetailsReservation #paid").html(datos["paid"]);
        $("#ModalDetailsReservation #balance").html(datos["balance"]);
        $("#ModalDetailsReservation #groupTotal").html(datos["groupTotal"]);
        $("#ModalDetailsReservation #groupDeposit").html(datos["groupDeposit"]);
    });

}
/*-- TAB --*/
async function ShowAllDetails() {
    let id = $("#ModalDetailsReservation #IdReservation").attr("data-id");
    clientIdActive = id;
    let data =
    {
        "TO": "tab-pane",
        "ACTION": "view",
        "id": clientIdActive
    }
    datos = await GetInformation(data);

    $("#myTabCalendar").append(datos["navTab"]);
    $("#tab-content").append(datos["tab-pane"]);

    $(`#client${id}-tab`).tab("show");
    $("#ModalDetailsReservation").modal("hide");
}
async function AgentReservation(typeReservation) {
    let stayFrom = $("#ModalDetailsReservation #IdReservation .modal-body #from").val();
    let stayTo = $("#ModalDetailsReservation #IdReservation .modal-body #to").val();
    let data =
    {
        "TO": "GroupReservation",
        "ACTION": "view",
        "FOR": "viewCreateReservation",
        "id": "",
        "checkIn": stayFrom,
        "checkOut": stayTo
    }
    datos = await GetInformation(data);

    $("#myTabCalendar").append(datos["navTab"]);
    $("#tab-content").append(datos["tab-pane"]);
    new GroupReservation().CreateTypeReservation(typeReservation);

    $("#ModalReservation").modal("hide");
    $(`#calendar #groupReservation-tab`).tab("show");

}
async function UpdateReserv(ID, STAYFROM, STAYTO, ROOMNUMBER, ROOMTYPE) {
    let data =
    {
        "TO": "Reservation",
        "ACTION": "update",
        "FOR": "UpdateReservation",
        "id": ID,
        "checkIn": STAYFROM,
        "checkOut": STAYTO,
        "roomType": ROOMTYPE,
        "RoomNumber": ROOMNUMBER
    }
    datos = await GetInformation(data);
    if (datos) {
        $("#modalUpdateRoom").modal("hide");
        $(elementDragable).appendTo(containerDraggable)
        writeMonth(monthNumber);
        setEvent("2020-87-3", "2020-08-14", 1, 3100, "Jose Polanco", "#1a9316");
        setEvent("2020-08-1", "2020-08-3", 2, 3301, "Maria Lamarche", "#f00612");
        setEvent("2020-09-3", "2020-09-14", 2, 3030, "Peco Lamarche", "#ffc107");
        setEvent("2020-08-2", "2020-09-14", 5, 2200, "Peco Lamarche", "#ffc107");
        setEvent("2020-08-28", "2020-09-14", 8, 3020, "Peco Lamarche", "#ffc107");
    }
}
function modalUpdateReserv() {
    $("#modalUpdateRoom").modal("show");
    $(document).on("click","#modalUpdateRoom",function(){
        if(!$(this).hasClass("show")){
            //si se cancela la opcion se vuelve a poner el elemento en su lugar
             $(elementDragable).css({"top":"inherit","left":"inherit","position":"relative"})
        } 
    });
}