$(document).ready(function () {
    let monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

    let currentDate = ""
    let currentDay = ""
    let monthNumber = ""
    let currentYear = ""
    let dates = ""
    monthMNC = ""
    year = ""
    prevMonthDOM = ""
    nextMonthDOM = ""
    inputCalendarActive = ""
    function init() {
        currentDate = new Date();
        currentDay = currentDate.getDate();
        monthNumber = currentDate.getMonth();
        currentYear = currentDate.getFullYear();

        dates = document.querySelector('#miniCalendar #dates');
        monthMNC = document.querySelector('#miniCalendar #month');
        year = document.querySelector('#miniCalendar #year');

        prevMonthDOM = document.querySelector('#miniCalendar #prev-month');
        nextMonthDOM = document.querySelector('#miniCalendar #next-month');

        monthMNC.textContent = monthNames[monthNumber];
        year.textContent = currentYear.toString();

        prevMonthDOM.addEventListener('click', () => lastMonthMNC());
        nextMonthDOM.addEventListener('click', () => nextMonthMNC());
    }

    const writeMonthMNC = (monthMNC) => {
        setMonthsMNC();
        for (let i = StartDayMNC(); i > 0; i--) {

            dates.innerHTML += ` <div class="calendar-date disabled calendar-item calendar-last-days">
            ${getTotalDaysMNC(monthNumber - 1) - (i - 1)}</div>`;
        }

        for (let i = 1; i <= getTotalDaysMNC(monthMNC); i++) {
            if (i === currentDay && new Date().getMonth() + 1 == monthNumber + 1 && new Date().getFullYear() == currentYear) {
                dates.innerHTML += ` <div class="calendar-date calendar-item calendar-today"  data-day='${i}' data-month='${monthNumber + 1}' data-year='${currentYear}'>${i}</div>`;
            } else {
                dates.innerHTML += ` <div class="calendar-date calendar-item" data-day='${i}' data-month='${monthNumber + 1}' data-year='${currentYear}'>${i}</div>`;
            }
        }
    }
    const setCustomDateMNC = () => {
        monthNumber = parseInt($("#miniCalendar #month").val());
        currentYear = parseInt($("#miniCalendar #year").val());

        if (currentYear.toString().length == 4) {
            $("#miniCalendar #year").css({ "color": "#495057" })
            setNewDateMNC();
        }
        else {
            $("#miniCalendar #year").css({ "color": "#f00" })
        }
    }
    const setMonthsMNC = () => {
        monthNames.forEach((element, index) => {
            $(monthMNC).append(`<option value='${index}'>${element}</option>`);
        });
        $(`#miniCalendar #month option[value='${monthNumber}']`).attr("selected", "selected");
        $("#miniCalendar #year").val(currentYear)
    }

    const getTotalDaysMNC = month => {
        if (month === -1) month = 11;

        if (month == 0 || month == 2 || month == 4 || month == 6 || month == 7 || month == 9 || month == 11) {
            return 31;

        } else if (month == 3 || month == 5 || month == 8 || month == 10) {
            return 30;

        } else {

            return isLeapMNC() ? 29 : 28;
        }
    }

    const isLeapMNC = () => {
        return ((currentYear % 100 !== 0) && (currentYear % 4 === 0) || (currentYear % 400 === 0));
    }

    const StartDayMNC = () => {
        let start = new Date(currentYear, monthNumber, 1);
        return ((start.getDay() - 1) === -1) ? 6 : start.getDay() - 1;
    }

    const lastMonthMNC = () => {
        if (monthNumber !== 0) {
            monthNumber--;
        } else {
            monthNumber = 11;
            currentYear--;
        }
        setNewDateMNC();
    }

    const nextMonthMNC = () => {
        if (monthNumber !== 11) {
            monthNumber++;
        } else {
            monthNumber = 0;
            currentYear++;
        }
        setNewDateMNC();
    }

    const setNewDateMNC = () => {
        currentDate.setFullYear(currentYear, monthNumber, currentDay);
        monthMNC.textContent = monthNames[monthNumber];
        year.value = currentYear;
        dates.textContent = '';
        writeMonthMNC(monthNumber);
    }
    const startCalendarMNC = () => {
        let miniCalendar = `
        <div class="card miniCalendar shadow" tabindex='0' id="miniCalendar">
            <div class="card-header">
                <div class="calendar-info">
                    <div class="calendar-prev" id="prev-month"><i class="fas fa-angle-left"></i></div>
                    <select id="month" class="custom-select calendar-month"></select>
                    <input type="text" id="year" class="calendar-year" value="" placeholder="year">
                    <div class="calendar-next" id="next-month"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
            <div class="card-body">
                <div class="calendar-week">
                    <div class="calendar-day calendar-item">Mon</div>
                    <div class="calendar-day calendar-item">Tue</div>
                    <div class="calendar-day calendar-item">Wed</div>
                    <div class="calendar-day calendar-item">Thu</div>
                    <div class="calendar-day calendar-item">Fri</div>
                    <div class="calendar-day calendar-item">Sat</div>
                    <div class="calendar-day calendar-item">Sun</div>
                </div>
                <div class="calendar-dates" id="dates"></div>
            </div>
        </div>`;
        $("body #miniCalendar").remove();
        $("body").append(miniCalendar);
        init()
        writeMonthMNC(monthNumber);
        $("#miniCalendar").addClass("active");
    }
    $("body").on("click", "#miniCalendar #month option", function () {
        setCustomDateMNC()
    });
    $("body").on("change", "#miniCalendar #year", function () {
        setCustomDateMNC()
    });
    $("body").on("click", "#miniCalendar #dates .calendar-item", function () {
        let day = $(this).attr("data-day");
        let month = $(this).attr("data-month");
        let year = $(this).attr("data-year");
        //$(inputCalendarActive).val(day + " / " + month + " / " + year)
        $(inputCalendarActive).val(formatDate(year,month,day))
    });
    $("body").on("click", ".inputCalendar", function (e) {
        e.stopPropagation()
        $(this).attr("readonly", "");
        inputCalendarActive = this;
        startCalendarMNC();
        let position = $(this).offset();
        let positionLeft = parseInt($(this).css('margin-left'))+position.left;
        let positionTop = parseInt($(this).css('margin-top')) + position.top+40;
        startCalendarMNC();
        $("#miniCalendar").css({"top": positionTop, "left": positionLeft})
        
    });
    $("body").on("click","#miniCalendar",function(e){
        e.stopPropagation()
    })
    $("html").click(function(e){
        $("body #miniCalendar").remove();
    })
})