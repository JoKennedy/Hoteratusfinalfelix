//   DESCOMENTAR ESTA LINEA QUE ESTA EN EL ARCHIVO KERNEL.PHP //\App\Http\Middleware\VerifyCsrfToken::class,


var clientIdActive = null;
/*var dataSet = [
    ["Tiger Nixon", "System Architect", "Edinburgh", "5421", "2011/04/25", "$320,800"],
    ["Garrett Winters", "Accountant", "Tokyo", "8422", "2011/07/25", "$170,750"],
    ["Ashton Cox", "Junior Technical Author", "San Francisco", "1562", "2009/01/12", "$86,000"],
    ["Cedric Kelly", "Senior Javascript Developer", "Edinburgh", "6224", "2012/03/29", "$433,060"],
    ["Airi Satou", "Accountant", "Tokyo", "5407", "2008/11/28", "$162,700"],
    ["Brielle Williamson", "Integration Specialist", "New York", "4804", "2012/12/02", "$372,000"],
    ["Herrod Chandler", "Sales Assistant", "San Francisco", "9608", "2012/08/06", "$137,500"],
    ["Rhona Davidson", "Integration Specialist", "Tokyo", "6200", "2010/10/14", "$327,900"],
    ["Colleen Hurst", "Javascript Developer", "San Francisco", "2360", "2009/09/15", "$205,500"],
    ["Sonya Frost", "Software Engineer", "Edinburgh", "1667", "2008/12/13", "$103,600"],
    ["Jena Gaines", "Office Manager", "London", "3814", "2008/12/19", "$90,560"],
    ["Quinn Flynn", "Support Lead", "Edinburgh", "9497", "2013/03/03", "$342,000"],
    ["Charde Marshall", "Regional Director", "San Francisco", "6741", "2008/10/16", "$470,600"],
    ["Haley Kennedy", "Senior Marketing Designer", "London", "3597", "2012/12/18", "$313,500"],
    ["Tatyana Fitzpatrick", "Regional Director", "London", "1965", "2010/03/17", "$385,750"],
    ["Michael Silva", "Marketing Designer", "London", "1581", "2012/11/27", "$198,500"],
    ["Paul Byrd", "Chief Financial Officer (CFO)", "New York", "3059", "2010/06/09", "$725,000"],
    ["Gloria Little", "Systems Administrator", "New York", "1721", "2009/04/10", "$237,500"],
    ["Bradley Greer", "Software Engineer", "London", "2558", "2012/10/13", "$132,000"],
    ["Dai Rios", "Personnel Lead", "Edinburgh", "2290", "2012/09/26", "$217,500"],
    ["Jenette Caldwell", "Development Lead", "New York", "1937", "2011/09/03", "$345,000"],
    ["Yuri Berry", "Chief Marketing Officer (CMO)", "New York", "6154", "2009/06/25", "$675,000"],
    ["Caesar Vance", "Pre-Sales Support", "New York", "8330", "2011/12/12", "$106,450"],
    ["Doris Wilder", "Sales Assistant", "Sydney", "3023", "2010/09/20", "$85,600"],
    ["Angelica Ramos", "Chief Executive Officer (CEO)", "London", "5797", "2009/10/09", "$1,200,000"],
    ["Gavin Joyce", "Developer", "Edinburgh", "8822", "2010/12/22", "$92,575"],
    ["Jennifer Chang", "Regional Director", "Singapore", "9239", "2010/11/14", "$357,650"],
    ["Brenden Wagner", "Software Engineer", "San Francisco", "1314", "2011/06/07", "$206,850"],
    ["Fiona Green", "Chief Operating Officer (COO)", "San Francisco", "2947", "2010/03/11", "$850,000"],
    ["Shou Itou", "Regional Marketing", "Tokyo", "8899", "2011/08/14", "$163,000"],
    ["Michelle House", "Integration Specialist", "Sydney", "2769", "2011/06/02", "$95,400"],
    ["Suki Burks", "Developer", "London", "6832", "2009/10/22", "$114,500"],
    ["Prescott Bartlett", "Technical Author", "London", "3606", "2011/05/07", "$145,000"],
    ["Gavin Cortez", "Team Leader", "San Francisco", "2860", "2008/10/26", "$235,500"],
    ["Martena Mccray", "Post-Sales support", "Edinburgh", "8240", "2011/03/09", "$324,050"],
    ["Unity Butler", "Marketing Designer", "San Francisco", "5384", "2009/12/09", "$85,675"]
];*/
let dataa = [
    {
        "id": "1",
        "name": "Tiger Nixon",
        "position": "System Architect",
        "salary": "$320,800",
        "start_date": "2011/04/25",
        "office": "Edinburgh",
        "extn": "5421"
    },
    {
        "id": "2",
        "name": "Garrett Winters",
        "position": "Accountant",
        "salary": "$170,750",
        "start_date": "2011/07/25",
        "office": "Tokyo",
        "extn": "8422"
    }];
$(document).ready(function () {

    $('#tableGuestLookUp').DataTable({
        data: dataa,
        /*columns: [
            { title: "name" },
            { title: "position" },
            { title: "salary" },
            { title: "start_date" },
            { title: "office" },
            { title: "extn" }
        ]*/
        columns: [
            { data: "id" },
            { data: "name" },
            { data: "position" },
            { data: "salary" },
            { data: "start_date" },
            { data: "office" },
            { data: "extn" }
        ]
    });



    $("body").on("click", "#btnOpenTask", function () {
        $('#tabMessageTasks a[href="#tabTasks"]').tab('show')
    });
    $("body").on("click", "#btnOpenMessage", function () {
        $('#tabMessageTasks a[href="#tabMessage"]').tab('show')
    });
    $("body").on("click", "[data-action='rooms'] option", function () {
        //loadRooms($(this).val());
        //console.log($(this).val());
    });
    $("body").on("click", "#personalInformation #ViewIDS", function () {
        let dataType = $(this).attr("data-type");
        let dataId = $(this).attr("data-id");
        new ManagerIDS().ViewID(dataType, dataId);
    });
    $("body").on("click", "#ModalViewID #saveIDS", function () {
        result = validationFields("#ModalViewID .modal-body")
        if (result) {
            new ManagerIDS().NewId();
        }
        console.log(result)
    });
    $("body").on("click", "[data-target='#addOrEditGuestDetails']", function () {
        ViewinformationGuests()
    });
    $("body").on("click", "[data-target='#managerSharers']", function () {
        new ManagerSharers().ViewManagerSharers();
    });
    $("body").on("click", "[data-target='#MessagesAndTasks']", function () {
        new ViewMessageAndTask().ViewMessages();
        new ViewMessageAndTask().Viewtasks();
    });
    $("body").on("click", "[data-target='#modalExtraBed']", function () {
        new ExtraBeds().ViewExtraBed()
    });
    $("body").on("click", "[data-target='#ModalRemoveItem']", function () {
        let message = $(this).attr("data-message");
        $("#ModalRemoveItem .modal-body #messageRemove").text(message)
    });
    $("body").on("click", "[data-target='#modalTotal']", function () {
        new PaymentDetails().ViewTotal();
    });
    $("body").on("click", "#currencyConverter", function () {
        let amount = $(`#client${clientIdActive} #paybill #tableBalance #totalAmount`).attr("data-value");
        let currency = $(`#client${clientIdActive} #paybill #tableBalance #totalAmount`).attr("data-currency");
        $(`#modalConverterCurrency #currency option[value='${currency}']`).attr("selected", "selected");
        $("#modalConverterCurrency #amount").val(amount);
        $("#modalConverterCurrency").modal();
    });
    $("body").on("click", "#modalConverterCurrency #btnConverterCurrency", function () {
        new PayBill().convertCurrency()
    });
    $("body").on("click", "#calendar #tab-content #paidBill,#groupPaidBill", function () {
        new PayBill().ViewPayBill();
    });
    $("body").on("click", "#calendar #tab-content #backToReserv", function () {
        new PayBill().BackToReserv();
    });
    $("body").on("click", `#calendar #tab-content #tableFolios tbody tr`, function () {
        let id = $(this).attr("data-id");
        new PayBill().ViewFolio(id)
    });
    $("body").on("click", "#calendar #tab-content #contentFolio #backToAcc", function () {
        new PayBill().ViewPayBill();
    });
    $("#calendar #myTabCalendar").on("click", ".nav-link", function () {
        clientIdActive = $(this).attr("data-id");
    });
    $("#calendar #tab-content").on("click", "#createGroupReservation #personalInformation #groupOwner option", function () {
        new GroupReservation().CreateTypeReservation();
    });
    $("body").on("click", "#housekeeping .todays-checkIn", function () {
        $("#modalTodaysCheckInRooom").modal("show");
    });
    $("body").on("click", "#housekeeping .todays-checkOut", function () {
        $("#modalTodaysCheckOutRooom").modal("show");
    });


    /*=================================================
                    HOUSEKEEPING EVENTS
    ==================================================*/
    $("body").on("click", "#housekeeping #tableRoomStatus #roomStatus option", function () {
        new Housekeeping().UpdateRoomStatus();
    })
    $("body").on("click", "#housekeeping #tableRoomStatus #remark", function () {
        let id = $(this).attr("data-id");
        let remark = $(this).text();

        $("#modalRemarks .modal-body #remarks").val(remark);
        $("#modalRemarks .modal-footer #save").attr("data-id", `${id}`);
        $("#modalRemarks").modal("show");
    });
    $("body").on("click", "#housekeeping #modalRemarks .modal-footer #save", function () {
        new Housekeeping().UpdateRemarks();
    });

    $("body").on("click", "#tableRoomStatus #addDiscrepancy", function () {
        let id = $(this).attr("data-id")
        $("#modalAddDiscrepancy").modal("show")
        new Housekeeping().ViewDiscrepancy(id);
    });
    $("body").on("click", "#housekeeping #tableRoomStatus #hkName option", function () {
        let id = $(this).closest("tr").find("#hkName").attr("data-id");
        let status = $(this).val();
        new Housekeeping().UpdateHkName(id, status);
    });
    $("body").on("click", "#housekeeping #navbar-list-group #addTask", function () {
        $("#modalAddTask").modal("show");
        new Housekeeping().WorkArea();
    });
    $("body").on("click", "#modalAddTask #workAreaType option", function () {
        if ($(this).val() == "room") {
            new Housekeeping().WorkArea();
        }
        else if ($(this).val() == "other") {
            $("#modalAddTask #workArea").html("");
        }
    });
    $("body").on("click", "#housekeeping [data-target='#modalAuditTrail'],#housekeeping #modalAuditTrail .filter #search", function () {
        new Housekeeping().AuditTrailFilter();
    });
    $("body").on("click", "#housekeeping [data-target='#modalAllTask'],#modalAllTask .filter #search", function () {
        new Housekeeping().TaskList();
    });
    $("body").on("click", "#housekeeping #filter #setHpgS-search", function () {
        new Housekeeping().setHousekeepingStatus();
    });
    $("body").on("click", "#housekeeping #filter #assignRoomTo-search", function () {
        new Housekeeping().AssignSelectRooomTo();
    });
    /*==================================================
                        Operaciones
    ====================================================*/
    $("#prueba").click(function () {
        guestsPreferences()
    });
    $('.modal-dialog').draggable({
        handle: ".modal-header"
    });
    /*$("body").on("change",".table-checkList",function () {
        $("input:checkbox").prop('checked', $(this).prop("checked"));
        console.log(1)
     });
    */
    $("body").on("click", "input[type='checkbox']", function () {
        if ($(this).val() != "on") {
            $(this).attr("checked", "")
            $(this).val("on");
        }
        else {
            $(this).removeAttr("checked")
            $(this).val("off");
        }
    });
    
    $("body").on("click", ".table-checkList th input[type='checkbox']", function () {
        //ASSelectItems(this);
        let check = $(this).val();
        let padre = $(this).closest("table");
        $(padre).each(function () {
            if (check == "on") {
                $(this).find("tbody tr td input[disabled!='disabled']").prop({ "checked": true, "value": "on" });
            }
            else {
                $(this).find("tbody tr td input[type='checkbox']").prop("checked", false);
                $(this).find("tbody tr td input[type='checkbox']").val("off");
            }
        });
    });

    $("body").on("click", "#roomType option", function () {
        let parent = $(this).closest(".row,tr");
        loadRooms($(this).val(), parent);
    });
    //evento para los "field-required"
    $("body").on("change keyup", ".field-required", function () {
        if ($(this).val().length > 0) {
            $(this).removeClass("field-required");
        }
    });
});

/*============================================
                    VIEWS
==============================================*/
const IDS = [{
    "MVIid": "00112330206",
    "MVIname": "Anastacia Grey's",
    "MVIplaceInsue": "Dajabom",
    "MVIinsueOn": "2018-02-14",
    "MVIexpireOn": "2024-02-14",
    "MVIaddress": "Dajabon RD"
}];
async function ViewinformationGuests() {
    /*----- Guest Details -----*/
    $("#guestDetails #guestId b").text()
    $("#guestDetails #noShareInfo").attr("checked", "")
    $("#guestDetails #markVIP").attr("checked", "")
    $("#guestDetails #markBlackList").attr("unchecked", "")
    $("#guestDetails #title option[value='3']").attr("selected", "")
    $("#guestDetails #name").val("Anastacia")
    $("#guestDetails #lastName").val("Grey")
    $("#guestDetails #gender option[value='2']").attr("selected", "")
    //other data
    $("#guestDetails #fileID")
    $("#guestDetails #moreInfo")
    $("#guestDetails #note").val("Platanos maduros")
    $("#guestDetails #nationality option[value='2']").attr("selected", "")
    $("#guestDetails #dateOBD").val("1996-07-10")
    $("#guestDetails .col-md-6 #phone").val("8093376268")
    $("#guestDetails .col-md-6 #mobile").val("8093376268")
    $("#guestDetails #email").val("agrey@outlook.com")
    $("#guestDetails #fax").val("faxxxX.max")
    /*----- Fin Guest Details -----*/

    /*----- Work Details -----*/
    $("#workDetails #organization").val("Los voladores")
    $("#workDetails #designation").val("Air")
    $("#workDetails #address").val("Villa Mella")
    $("#workDetails #country option[value='2']").attr("selected", "")
    $("#workDetails #state option[value='2']").attr("selected", "")
    $("#workDetails #city").val("Santo Domingo N")
    $("#workDetails #zipCode").val("20011")
    $("#workDetails #workPhone1").val("8098770000")
    $("#workDetails #workPhone2").val("8098780000")

    /*----- Home Address -----*/
    $("#homeAddress #address").val("Villa Mella")
    $("#homeAddress #country option[value='2']").attr("selected", "")
    $("#homeAddress #state option[value='2']").attr("selected", "")
    $("#homeAddress #city").val("Santo Domingo N")
    $("#homeAddress #zipCode").val("20011")
    $("#homeAddress #workPhone1").val("8098723333")
    $("#homeAddress #workPhone2").val("8098896000")

    /*----- Guest Preferences -----*/
    $("#guestPreferences #guestPreference").val("Mangusito de platano maduro")
    $("#guestPreferences #title option[value='2']").attr("selected", "")
    $("#guestPreferences #name").val("Anastacia")
    $("#guestPreferences #lastName").val("Grey's")


}

async function sendConfirmationMail(ID) {
    let data =
    {
        "TO": "sendConfirmationMail",
        "ACTION": "set",
        "id": ID
    }
    let result = await GetInformation(data);
    if (result != 0) {
        $("[sendMailConfirmation]").val("off").removeAttr("selected")
    }
}
async function guestsPreferences() {
    let data =
    {
        "TO": "guestsPreferences",
        "ACTION": "view",
        "id": "all"
    }
    let datos = await GetInformation(data);
    let row = "";
    datos.forEach(data => {
        row +=
            `<tr>
                <td class="col-sm-4"><b>For: </b><span>Anastacia Grey</span></td>
                <td class="col-sm-8 text-secondary">Platano pollo, giusao</td>
            </tr>`;
    });
    $(`#client${clientIdActive} #guestsPreferences #tableGuestsPreferences`).html(row);
}
/*============================================
                Manager Ids
==============================================*/
class ManagerIDS {
    async ViewID(DATATYPE, ID = 1) {
        let data =
        {
            "TO": "managerIDS",
            "ACTION": "view",
            "id": ID
        }
        let datos = await GetInformation(data);/*IDS*/
        $("#ModalViewID .modal-title").text(DATATYPE);
        if (datos.length != 0) {
            datos.forEach(data => {
                $("#ModalViewID #MVIid").val(data[`MVIid`]).attr("disabled", "");
                $("#ModalViewID #MVIname").val(data[`MVIname`]).attr("disabled", "");
                $("#ModalViewID #MVIplaceInsue").val(data[`MVIplaceInsue`]).attr("disabled", "");
                $("#ModalViewID #MVIinsueOn").val(data[`MVIinsueOn`]).attr("disabled", "");
                $("#ModalViewID #MVIexpireOn").val(data[`MVIexpireOn`]).attr("disabled", "");
                $("#ModalViewID #MVIaddress").val(data[`MVIaddress`]).attr("disabled", "");
                $("#ModalViewID #saveIDS").attr("disabled", "");
            });
            $("#ModalViewID #saveIDS").attr("disabled", "");
        }
    }
    async NewId() {
        let data =
        {
            "TO": "managerIDS",
            "ACTION": "set",
            "id": $("#ModalViewID #MVIid").val(),
            "name": $("#ModalViewID #MVIname").val(),
            "placeInsue": $("#ModalViewID #MVIplaceInsue").val(),
            "insueOn": $("#ModalViewID #MVIinsueOn").val(),
            "expireOn": $("#ModalViewID #MVIexpireOn").val(),
            "address": $("#ModalViewID #MVIaddress").val()
        }
        await GetInformation(data);
    }
    async ViewForEditID(DATATYPE, ID) {
        let data =
        {
            "TO": "managerIDS",
            "ACTION": "view",
            "id": ID
        }
        let datos = await GetInformation(data)
        $("#ModalViewID .modal-title").text(DATATYPE);

        if (datos.length != 0) {
            datos.forEach(data => {
                $("#ModalViewID #MVIid").val(data[`MVIid`]).attr("disabled", "");
                $("#ModalViewID #MVIname").val(data[`MVIname`]).attr("disabled", "");
                $("#ModalViewID #MVIplaceInsue").val(data[`MVIplaceInsue`]).attr("disabled", "");
                $("#ModalViewID #MVIinsueOn").val(data[`MVIinsueOn`]).attr("disabled", "");
                $("#ModalViewID #MVIexpireOn").val(data[`MVIexpireOn`]).attr("disabled", "");
                $("#ModalViewID #MVIaddress").val(data[`MVIaddress`]).attr("disabled", "");
                $("#ModalViewID #saveIDS").attr("disabled", "");
            });
            $("#ModalViewID #saveIDS").removeAttr("disabled", "");
            $("#ModalViewID #saveIDS").attr("data-action", "update");
        }
    }
    async EditID() {
        let data =
        {
            "TO": "managerIDS",
            "ACTION": "set",
            "id": $("#ModalViewID #MVIid").val(),
            "name": $("#ModalViewID #MVIname").val(),
            "placeInsue": $("#ModalViewID #MVIplaceInsue").val(),
            "insueOn": $("#ModalViewID #MVIinsueOn").val(),
            "expireOn": $("#ModalViewID #MVIexpireOn").val(),
            "address": $("#ModalViewID #MVIaddress").val()
        }
        await GetInformation(data);
        $("#ModalViewID #saveIDS").attr("disabled", "");
        $("#ModalViewID #saveIDS").attr("data-action", "set");
        $("#ModalViewID").modal("hide");
    }
    async deleteID(ID) {
        let data =
        {
            "TO": "managerIDS",
            "ACTION": "delete",
            "id": ID
        }
        await GetInformation(data);
    }
}
/*============================================
                ManagerSharers
==============================================*/
class ManagerSharers {
    async ViewManagerSharers() {
        let data =
        {
            "TO": "managerSharers",
            "ACTION": "view",
            "id": "all"
        }
        let row = "";
        /* let datos = GetInformation(data);
         datos.forEach(data =>{
             row +=
             `<tr>
                 <td>1.</td>
                 <td>Anastacia Grey</td>
                 <td>809-333-0000</td>
                 <td>2020/07/10</td>
                 <td>P24</td>
                 <td>
                 <div class="custom-control custom-checkbox text-center">
                     <input type="checkbox" id="p24" checked="checked" class="custom-control-input">
                     <label for="p24" class="custom-control-label"></label>
                 </div>
                 </td>
                 <td>
                 <select id="" class="custom-select">
                     <option value="">Adult</option>
                 </select>
                 </td>
             </tr>`;
         });
         $("#client${clientIdActive} #managerSharers #tableManageSharers tbody").html(row);
         */
        row =
            `<tr>
            <td>1.</td>
            <td>Anastacia Grey</td>
            <td>809-333-0000</td>
            <td>2020/07/10</td>
            <td>P24</td>
            <td>
            <div class="custom-control custom-checkbox text-center">
                <input type="checkbox" id="p24" checked="checked" class="custom-control-input">
                <label for="p24" class="custom-control-label"></label>
            </div>
            </td>
            <td>
            <select id="" class="custom-select">
                <option value="">Adult</option>
            </select>
            </td>
        </tr>`;
        $("#managerSharers #tableManageSharers tbody").append(row);

    }
    async NewGuest() {
        let data =
        {
            "TO": "managerSharers",
            "ACTION": "set",
            "title": $("#managerSharers #title").val(),
            "firstName": $("#managerSharers #firstName").val(),
            "lastName": $("#managerSharers #lastName").val(),
            "phone": $("#managerSharers #phone").val(),
            "date": $("#managerSharers #date").val(),
            "shareSharge": $("#managerSharers #shareSharge").val(),
            "typeHuman": $("#managerSharers #typeHuman").val()
        }
        await GetInformation(data);
        $("#managerSharers #title").val("")
        $("#managerSharers #firstName").val("")
        $("#managerSharers #lastName").val("")
        $("#managerSharers #date").val("")
        $("#managerSharers #shareSharge").val("")
        $("#managerSharers #typeHuman").val("")
        this.ViewManagerSharers("");
    }
    async ViewForEditGuest(ID) {
        let data =
        {
            "TO": "managerSharers",
            "ACTION": "view",
            "id": ID
        }
        let datos = await GetInformation(data);
        datos.forEach(data => {
            $("#managerSharers #title").val(data['']);
            $("#managerSharers #firstName").val(data['']);
            $("#managerSharers #lastName").val(data['']);
            $("#managerSharers #date").val(data['']);
            $("#managerSharers #shareSharge").val(data['']);
            $("#managerSharers #typeHuman").val(data['']);
        });
        $("#managerSharers #save").attr("data-action", "update");
    }
    async EditGuest(ID) {
        let data =
        {
            "TO": "managerSharers",
            "ACTION": "set",
            "title": $("#managerSharers #title").val(),
            "firstName": $("#managerSharers #firstName").val(),
            "lastName": $("#managerSharers #lastName").val(),
            "phone": $("#managerSharers #phone").val(),
            "date": $("#managerSharers #date").val(),
            "shareSharge": $("#managerSharers #shareSharge").val(),
            "typeHuman": $("#managerSharers #typeHuman").val()
        }
        let datos = await GetInformation(data);
        $("#managerSharers #save").attr("data-action", "set");
        this.ViewManagerSharers();
    }
    async DeleteGuest(ID) {
        let data =
        {
            "TO": "managerSharers",
            "ACTION": "delete",
            "id": ID
        }
        await GetInformation(data)
    }
}
/*============================================
                Message and Task
==============================================*/
class ViewMessageAndTask {
    async ViewMessages() {
        let data =
        {
            "TO": "message",
            "ACTION": "view",
            "id": "all"
        }
        //let datos = await GetInformation(data)
        //let row = "";
        /*datos.forEach(data =>{
            row +=
            `<tr>
                <td>
                <span>For Room</span><br>
                <span>Limpia</span><br>
                <span>Aug,07 2020 at 12:04 PM</span>
                </td>
                <td>
                <select id="" class="custom-select">
                    <option value="">Delivered</option>
                    <option value="">Pending</option>
                </select>
                </td>
                <td>
                <button class="btn btn-outline-primary btn-sm ml-1"><i class="fas fa-pencil-alt"></i></button>
                <button class="btn btn-outline-danger btn-sm ml-1 removeItem" data-toggle="modal" data-target="#ModalRemoveItem" data-message="message"><i
                    class="fas fa-trash-alt"></i></button>
                </td>
            </tr>`;
        });*/
        //$("#MessagesAndTasks #tableMessage tbody").html(row);
        let row =
            `<tr>
            <td>
            <span>For Room</span><br>
            <span>Limpia</span><br>
            <span>Aug,07 2020 at 12:04 PM</span>
            </td>
            <td>
            <select id="" class="custom-select">
                <option value="">Delivered</option>
                <option value="">Pending</option>
            </select>
            </td>
            <td>
            <button class="btn btn-outline-primary btn-sm ml-1"><i class="fas fa-pencil-alt"></i></button>
            <button class="btn btn-outline-danger btn-sm ml-1 removeItem" data-toggle="modal" data-target="#ModalRemoveItem" data-message="message"><i
                class="fas fa-trash-alt"></i></button>
            </td>
        </tr>`;
        $("#MessagesAndTasks #tableMessage tbody").append(row);
    }
    async NewMessage() {
        let data =
        {
            "TO": "message",
            "ACTION": "set",
            "messageFor": $(`#MessagesAndTasks #messageFor`).val(),
            "contentMessage": $(`#MessagesAndTasks #contentMessage`).val()
        }
        await GetInformation(data);
        this.ViewMessages();
        $(`#MessagesAndTasks #messageFor`).value("");
        $(`#MessagesAndTasks #contentMessage`).val("");
        $(`#MessagesAndTasks #addMessage`).attr('data-action', 'set');
    }
    async ViewForEditMessage(ID) {
        let data =
        {
            "TO": "message",
            "ACTION": "view",
            "id": ID
        }
        let datos = await GetInformation(data);
        datos.forEach(data => {
            $(`#MessagesAndTasks #messageFor option[value='${data['']}']`).attr('selected', '')
            $(`#MessagesAndTasks #contentMessage`).val(`${data['']}`)
        });
        $(`#MessagesAndTasks #addMessage`).attr('data-action', 'update');

    }
    async MessageEdit(ID) {
        $(`#MessagesAndTasks #messageFor option[value='${data['']}']`).attr('selected', '')
        $(`#MessagesAndTasks #contentMessage`).val(`${data['']}`)
        let data =
        {
            "TO": "message",
            "ACTION": "update",
            "id": ID,
            "messageFor": $(`#MessagesAndTasks #messageFor`).val(),
            "contentMessage": $(`#MessagesAndTasks #contentMessage`).val()
        }
        await GetInformation(data);
        $(`#MessagesAndTasks #addMessage`).attr('data-action', 'set');
    }
    async MessageDelete(ID) {
        let data =
        {
            "TO": "message",
            "ACTION": "delete",
            "id": ID
        }
        await GetInformation(data);
        this.ViewMessages();
    }
    /*--------- TASKS ----------*/

    async Viewtasks() {
        //descomentar luego de las consultas reales
        let data =
        {
            "TO": "task",
            "ACTION": "view",
            "id": "all"
        }
        //let datos = await GetInformation(data)
        let row = "";
        /*datos.forEach(data =>{
            row +=
                `<tr>
                    <td>
                    For: BAR
                    Licors
                    Aug 07, 2020 at 1:28:11 PM
                    </td>
                    <td>
                    Aug 07, 2020 at 1:30:00 PM
                    </td>
                    <td></td>
                    <td>NA</td>
                    <td>NA</td>
                    <td>
                    <select id="" class="custom-select p-0" style="height: 30px;">
                        <option value=""></option>
                    </select>
                    </td>
                    <td>
                    <button class="btn btn-outline-primary btn-sm ml-1"><i class="fas fa-pencil-alt"></i></button>
                    <button class="btn btn-outline-danger btn-sm ml-1 removeItem" data-toggle="modal" data-target="#ModalRemoveItem" data-message="task"><i
                        class="fas fa-trash-alt"></i></button>
                    </td>
                </tr>`;
        });
        $("#MessagesAndTasks #tableTask tbody").html(row);*/
        row =
            `<tr>
            <td>
            For: BAR
            Licors
            Aug 07, 2020 at 1:28:12 PM
            </td>
            <td>
            Aug 07, 2020 at 1:30:00 PM
            </td>
            <td></td>
            <td>NA</td>
            <td>NA</td>
            <td>
            <select id="" class="custom-select p-0" style="height: 30px;">
                <option value=""></option>
            </select>
            </td>
            <td>
            <button class="btn btn-outline-primary btn-sm ml-1"><i class="fas fa-pencil-alt"></i></button>
            <button class="btn btn-outline-danger btn-sm ml-1 removeItem" data-toggle="modal" data-target="#ModalRemoveItem" data-message="task"><i
                class="fas fa-trash-alt"></i></button>
            </td>
        </tr>`;
        $("#MessagesAndTasks #tableTask tbody").append(row);
    }
    async NewTask() {
        let taskFor = $("#MessagesAndTasks #taskFor").val();
        let contentTaskMessage = $("#MessagesAndTasks #contentTasMessage").val();
        let taskDate = $("#MessagesAndTasks #taskDate").val();
        let tasktime = $("#MessagesAndTasks taskTime").val();
        let datos =
        {
            "TO": "task",
            "ACTION": "set",
            "taskFor": taskFor,
            "contentTaskMessage": contentTaskMessage,
            "taskDate": taskDate,
            "tasktime": tasktime
        }
        await GetInformation(datos)
        $("#MessagesAndTasks #taskFor").val("");
        $("#MessagesAndTasks #contentTasMessage").val("");
        $("#MessagesAndTasks #taskDate").val("");
        $("#MessagesAndTasks taskTime").val("");
        $('#MessagesAndTasks #addTask').attr('data-action', 'set')
        Viewtask();
    }
    async ViewForEditTask(ID) {
        let data =
        {
            "TO": "task",
            "ACTION": "view",
            "id": ID
        }
        let datos = await GetInformation(data);
        datos.forEach(result => {
            $("#MessagesAndTasks #taskFor").val(result['']);
            $("#MessagesAndTasks #contentTasMessage").val(result['']);
            $("#MessagesAndTasks #taskDate").val(result['']);
            $("#MessagesAndTasks taskTime").val(result['']);
        });
        $('#MessagesAndTasks #addTask').attr('data-action', 'update')
    }
    async TaskEdit(ID) {
        let taskFor = $("#MessagesAndTasks #taskFor").val();
        let contentTaskMessage = $("#MessagesAndTasks #contentTasMessage").val();
        let taskDate = $("#MessagesAndTasks #taskDate").val();
        let tasktime = $("#MessagesAndTasks taskTime").val();
        let datos =
        {
            "TO": "task",
            "ACTION": "update",
            "id": ID,
            "taskFor": taskFor,
            "contentTaskMessage": contentTaskMessage,
            "taskDate": taskDate,
            "tasktime": tasktime
        }
        await GetInformation(datos)
        $("#MessagesAndTasks #taskFor").val("");
        $("#MessagesAndTasks #contentTasMessage").val("");
        $("#MessagesAndTasks #taskDate").val("");
        $("#MessagesAndTasks taskTime").val("");
        $('#MessagesAndTasks #addTask').attr('data-action', 'set')
        Viewtask();
    }
    async TaskDelete(ID) {
        let data =
        {
            "TO": "task",
            "ACTION": "delete",
            "id": ID
        }
        await GetInformation(data);
        this.Viewtasks();
    }
}

/*============================================
                    NOTES
==============================================*/
class Notes {
    async ViewNotes() {
        let datos =
        {
            "TO": "notes",
            "ACTION": "view",
            "id": "all"
        }
        datos = await GetInformation(datos);
        let row = "";
        datos.forEach(data => {
            row +=
                `<tr>
                <td class="col-sm-9"><b>Fincance: </b>Cobrar restante.</td>
                <td class="col-sm-3 text-center">
                <button class="btn btn-outline-primary btn-sm"><i class="fas fa-pencil-alt"></i></button>
                <button class="btn btn-outline-danger btn-sm removeItem" data-toggle="modal" data-target="#ModalRemoveItem" data-message="note"><i
                    class="fas fa-trash-alt"></i></button>
                </td>
            </tr>`;
        });
        $(`#client${clientIdActive} #notes table tbody`).html(row);

    }
    async NewNote() {
        let title = $("#addNewNote #titleNote").val();
        let description = $("#addNewNote #descriptionNote").val();
        let datos =
        {
            "TO": "notes",
            "ACTION": "set",
            "title": title,
            "description": description
        }
        await GetInformation(datos);
        ViewNotes();
    }
    async ViewForEditNote(ID) {
        $("#addNewNote #save").attr("data-action", "update");
        let datos =
        {
            "TO": "notes",
            "ACTION": "view",
            "id": ID
        }
        datos = await GetInformation(datos);
        //llenar con los nombres de las variables que va a devolver
        $("#addNewNote #titleNote option[value=``]").attr("selected", "");
        $("#addNewNote #descriptionNote").val();
    }
    async EditNote(ID) {
        let title = $("#addNewNote #titleNote").val();
        let description = $("#addNewNote #descriptionNote").val();
        let datos =
        {
            "TO": "notes",
            "ACTION": "update",
            "id": ID,
            "title": title,
            "description": description
        }
        await GetInformation(datos);
        ViewNotes();
    }
    async DeleteNote(ID) {
        let datos =
        {
            "TO": "notes",
            "ACTION": "delete",
            "id": ID
        }
        await GetInformation(datos);
        ViewNotes()
    }
}

/*==================================================================================
                                    STAY DETAILS
====================================================================================*/

/*============================================
                    EXTRA BEDS
==============================================*/
class ExtraBeds {
    async ViewExtraBed() {
        let data =
        {
            "TO": "ExtraBeds",
            "ACTION": "view"
        }
        let datos = await GetInformation(data);
        let row =
            `<tr>
            <td>1</td>
            <td>Aug 06, 2020 - Aug 08, 2020</td>
            <td>1</td>
            <td>2</td>
            <td>$50.00</td>
            <td>$100.00</td>
            <td><button class="btn btn-outline-danger btn-sm removeItem" data-toggle="modal" data-target="#ModalRemoveItem" data-message="bed"><i class="fas fa-trash"></i></button>
            </td>
        </tr>`;
        /*datos.forEach(data =>{
            row +=
            `<tr>
                <td>1</td>
                <td>Aug 06, 2020 - Aug 08, 2020</td>
                <td>1</td>
                <td>2</td>
                <td>$50.00</td>
                <td>$100.00</td>
                <td><button class="btn btn-outline-danger btn-sm removeItem" data-toggle="modal" data-target="#ModalRemoveItem" data-message="bed"><i class="fas fa-trash"></i></button>
                </td>
            </tr>`;
        });*/
        $("#modalExtraBed #tableExtraBed tbody").append(row);
        //$(`#client${clientIdActive} #content-StayDetails #extraBed`).val(datos[""]);
    }
    async SetExtraBed() {
        let datos =
        {
            "TO": "extraBeds",
            "ACTION": "set",
            "from": $("#modalExtraBed #addExtraBed #from").val(),
            "to": $("#modalExtraBed #addExtraBed #to").val(),
            "beds": $("#modalExtraBed #addExtraBed #beds").val()
        }
        await GetInformation(datos);
        ViewExtraBed();
    }
    async DeleteExtraBed(ID) {
        let datos =
        {
            "TO": "ExtraBeds",
            "ACTION": "delete",
            "Id": ID
        }
        await GetInformation(datos);
        ViewExtraBed();
    }
}
class StayDetails {
    async Purpose(ID) {
        let datos =
        {
            "TO": "stayDetails",
            "FOR": "purpose",
            "ACTION": "update",
            "Id": ID,
            "purpose": $(`#client${clientIdActive} #content-StayDetails #purpose`).val()
        }
        await GetInformation(datos);
    }
    async ViewSources(ID) {
        let datos =
        {
            "TO": "stayDetails",
            "ACTION": "view",
            "FOR": "sources",
            "Id": "all",
            "sources": $(`#client${clientIdActive} #content-StayDetails #sources`).val()
        }
        await GetInformation(datos);
    }
    async Sources(ID) {
        let datos =
        {
            "TO": "stayDetails",
            "ACTION": "update",
            "FOR": "sources",
            "Id": ID,
            "sources": $(`#client${clientIdActive} #content-StayDetails #sources`).val()
        }
        await GetInformation(datos);
    }
    async Type(ID) {
        let datos =
        {
            "TO": "stayDetails",
            "ACTION": "update",
            "FOR": "type",
            "Id": ID,
            "type": $(`#client${clientIdActive} #content-StayDetails #type`).val()
        }
        await GetInformation(datos);
    }
    async MtkSmgt(ID) {
        let datos =
        {
            "TO": "stayDetails",
            "ACTION": "update",
            "FOR": "mktSmgt",
            "Id": ID,
            "mktSmgt": $(`#client${clientIdActive} #content-StayDetails #mktSmgt`).val()
        }
        await GetInformation(datos);
    }
    async SalesPerson(ID) {
        let datos =
        {
            "TO": "stayDetails",
            "ACTION": "update",
            "FOR": "SalesPerson",
            "Id": ID,
            "salesPerson": $(`#client${clientIdActive} #content-StayDetails #salesPerson`).val()
        }
        await GetInformation(datos);
    }

    async arrivalAndDeparture() {
        let modeArrival = $(`#client${clientIdActive} #content-StayDetails #list-arrival #mode`).val();
        let arrivalFlight = $(`#client${clientIdActive} #content-StayDetails #list-arrival #arrivalFlight`).val();
        let arrivalTime = $(`#client${clientIdActive} #content-StayDetails #list-arrival #arrivalTime`).val();

        let departureMode = $(`#client${clientIdActive} #content-StayDetails #list-departure #departureMode`).val();
        let departureFlight = $(`#client${clientIdActive} #content-StayDetails #list-departure #departureFlight`).val();
        let departureTime = $(`#client${clientIdActive} #content-StayDetails #list-departure #departureTime`).val();
        let data =
        {
            "TO": "stayDetails",
            "FOR": "arrivalAndDeparture",
            "ACTION": "update",
            "modeArrival": modeArrival,
            "arrivalFlight": arrivalFlight,
            "arrivalTime": arrivalTime,
            "departureMode": departureMode,
            "departureFlight": departureFlight,
            "departureTime": departureTime
        }
        await GetInformation(data);
    }

    async AssignTask(ID) {
        if ($("#content-StayDetails [selectAssignTask]").val()) {
            let datos =
            {
                "TO": "stayDetails",
                "ACTION": "update",
                "FOR": "AssignTask",
                "Id": ID,
                "confirmationMail": $(`#client${clientIdActive} #content-StayDetails #selectAssignTask`).val()
            }
            await GetInformation(datos);
        }
        else {
            let datos = [
                {
                    "TO": "stayDetails-sendMail",
                    "ACTION": "update",
                    "Id": ID,
                    "confirmationMail": ""
                }
            ]
            GetInformation(datos);
        }
    }
    async SendMail(ID) {
        let datos =
        {
            "TO": "stayDetails",
            "ACTION": "update",
            "FOR": "SendMail",
            "Id": ID,
            "confirmationMail": $(`#client${clientIdActive} #content-StayDetails [sendMail]`).val()
        }
        await GetInformation(datos);
    }
}

class PaymentDetails {
    async ViewPayment(ID) {
        let data =
        {
            "TO": "PaymentDetails",
            "FOR": "ViewPayment",
            "ACTION": "view",
            "Id": "all"
        }
        let datos = await GetInformation(data)
        datos.forEach(data => {
            $(`#client${clientIdActive} #content-paymentDetails #roomTariff`).text(data['']);
            $(`#client${clientIdActive} #content-paymentDetails #roomTaxes`).text(data['']);
            $(`#client${clientIdActive} #content-paymentDetails #addOns`).text(data['']);
            $(`#client${clientIdActive} #content-paymentDetails #otherCharges`).text(data['']);
            $(`#client${clientIdActive} #content-paymentDetails #otherTax`).text(data['']);
            $(`#client${clientIdActive} #content-paymentDetails #total b`).text(data['']);
            $(`#client${clientIdActive} #content-paymentDetails #amountPaid`).text(data['']);
            $(`#client${clientIdActive} #content-paymentDetails #discount`).text(data['']);
            $(`#client${clientIdActive} #content-paymentDetails #otherDiscount`).text(data['']);
            $(`#client${clientIdActive} #content-paymentDetails #balance`).text(data['']);
        });

        /*let roomTariff = $("#content-paymentDetails #roomTariff").text();
        let roomTaxes = $("#content-paymentDetails #roomTaxes").text();
        let addOns = $("#content-paymentDetails #addOns").text();
        let otherCharges = $("#content-paymentDetails #otherCharges").text();
        let otherTax = $("#content-paymentDetails #otherTax").text();
        let total = $("#content-paymentDetails #total b").text();
        let amountPaid = $("#content-paymentDetails #amountPaid").text();
        let discount = $("#content-paymentDetails #discount").text();
        let otherDiscount = $("#content-paymentDetails #otherDiscount").text();
        let balance = $("#content-paymentDetails #balance").text();*/

    }
    //MODAL
    async ViewTaxes() {
        let data =
        {
            "TO": "PaymentDetails",
            "FOR": "ViewTaxes",
            "ACTION": "view",
            "Id": "all"
        }
        let row = "";
        let datos = await GetInformation(data);
        datos.forEach(data => {
            row +=
                `<tr id="${data['']}">
                    <th id="taxName">${data['']}</th>
                    <td id="taxDiscount">${data['']}%</td>
                    <td id="actionTax">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" id="statusTax" data-id="${data['']}" class="custom-control-input" value="off">
                        <label for="statusTax" class="custom-control-label"></label>
                    </div>
                    </td>
                </tr>`;
        });
        $(`#modalRoomTaxes #reason [value='${datos['']}']`).attr("selected", "");
        $("#modalRoomTaxes #descriptionReason").val(datos['']);
        $("#modalRoomTaxes #tableTaxes tbody").html(row);
    }
    //MODAL
    async SetTaxes(ID) {
        let data =
        {
            "TO": "PaymentDetails",
            "FOR": "SetTaxes",
            "ACTION": "set",
            "Id": ID,
            "Reason": $("#modalRoomTaxes #reason").val(),
            "DescriptionReason": $("#modalRoomTaxes #descriptionReason").val()
        }
        let collectionIdTax = [];
        $("#modalRoomTaxes #tableTaxes tbody tr").each(function () {

            let status = $(this).find("#actionTax input").val()
            if (status == "on") {
                let id = $(this).find("#actionTax input").attr("data-id");
                collectionIdTax.push(id)
                //$(`#modalRoomTaxes #tableTaxes tr:eq(${id}) #taxName`).text()
            }
        });
        data["taxes"] = collectionIdTax;
        await GetInformation(data);
        this.ViewPayment();
    }
    //MODAL
    async SetOtherTaxes(ID) {
        let data =
        {
            "TO": "PaymentDetails",
            "ACTION": "set",
            "FOR": "SetOtherTaxes",
            "Id": ID,
            "Reason": $("#modalOtherRoomTaxes #reason").val(),
            "DescriptionReason": $("#modalOtherRoomTaxes #descriptionReason").val()
        }
        let collectionIdTax = [];
        $("#modalOtherRoomTaxes #tableTaxes tbody tr").each(function () {

            let status = $(this).find("#actionTax input").val()
            if (status == "on") {
                let id = $(this).find("#actionTax input").attr("data-id");
                collectionIdTax.push(id)
                //$(`#modalOtherRoomTaxes #tableTaxes tr:eq(${id}) #taxName`).text()
            }
        });
        data["taxes"] = collectionIdTax;
        await GetInformation(data);
        this.ViewTaxes();
        this.ViewPayment();
    }
    //MODAL
    async ViewAddOns() {
        let data =
        {
            "TO": "PaymentDetails",
            "FOR": "ViewAddOnd",
            "ACTION": "view",
            "Id": "all"
        }
        let row = "";
        let total = "";
        datos = await GetInformation(data);
        datos.forEach(data => {
            total += datos[''];
            row +=
                `<tr>
                <td>${datos['']}</td>
                <td>${datos['']}.</td>
                <td>${datos['']}</td>
                <td>$ ${datos['']}</td>
            </tr>`;
        });
        $("#modalAddOnsCharges #tableAddOns tbody").html(row)
        $("#modalAddOnsCharges #total").text(total)
    }
    async ViewTotal() {
        let data =
        {
            "TO": "PaymentDetails",
            "FOR": "ViewTotal",
            "ACTION": "view",
            "Id": "all"
        }
        let total = 430.00;
        let row =
            `<tr>
                <td> Aug 19 - Aug 23</td>
                <td>Seasonal rate</td>
                <td></td>
                <td>$ 510.00</td>
            </tr>`;
        /*let datos = await GetInformation(data);
        datos.forEach(data => {
            total += datos[''];
            row = 
            `<tr>
                <td> Aug 19 - Aug 23</td>
                <td>Seasonal rate</td>
                <td></td>
                <td>$ 510.00</td>
            </tr>`
        });*/
        let discount = 10/*datos['']*/;
        let tax = 140/*datos['']*/;
        $("#modalTotal #tableTotal tbody").html(row);
        $("#modalTotal #TotalWithoutTax").text("$" + total);
        $("#modalTotal #tax").text("$" + tax);
        $("#modalTotal #discount").text("$" + discount);
        $("#modalTotal #TotalWithTax").text("$" + ((total + tax) - discount));
    }
    async ViewDiscount() {
        let data =
        {
            "TO": "PaymentDetails",
            "FOR": "Discount",
            "ACTION": "view",
            "Id": "all"
        }
        let datos = await GetInformation(data);
        let row = "";
        let totalDiscount = "";
        datos.forEach(data => {
            totalDiscount += data[""];
            row +=
                `<tr>
                <td>Aug 30 - Sep 05, 2020</td>
                <td>Seasonal Rate</td>
                <td>$ 4.35</td>
            </tr>`;
        });
        $("#modalDiscountDetails #tableDiscount tbody").html(row);
        $("#modalDiscountDetails #totalDiscount").text(total);
    }
    async ViewOtherDiscount() {
        let data =
        {
            "TO": "PaymentDetails",
            "FOR": "OtherDiscount",
            "ACTION": "view",
            "Id": "all"
        }
        let datos = await GetInformation(data);
        let row = "";
        let totalDiscount = "";
        datos.forEach(data => {
            totalDiscount += data[""];
            row +=
                `<tr>
                <td>Aug 30 - Sep 05, 2020</td>
                <td>Seasonal Rate</td>
                <td>$ 4.35</td>
            </tr>`;
        });
        $("#modalOtherDiscount #tableOtherDiscount tbody").html(row);
        $("#modalOtherDiscount #totalDiscount").text(total);
    }

    async ViewCreditCards() {
        let data =
        {
            "TO": "PaymentDetails",
            "FOR": "CreditCard",
            "ACTION": "view",
            "Id": "all"
        }
        let datos = await GetInformation(data);
        datos.forEach(data => {
            row +=
                `<tr>
                <td>Anastacia</td>
                <td>XXXXXXXXXXXX3333</td>
                <td>VISA</td>
                <td>06/2024</td>
                <td><button class="btn btn-outline-danger btn-sm removeItem" data-id="" data-message="card information"><i
                    class="fas fa-trash"></i></button>
            </tr>`
        })
        $("#ModalAddCreditCard .#tableCard").html(row)
    }
    async ClearCreditCard() {
        $("#ModalAddCreditCard #sharer").val("")
        $("#ModalAddCreditCard #nameSharer").val("")
        $("#ModalAddCreditCard #cardNo").val("")
        $("#ModalAddCreditCard #mm").val("")
        $("#ModalAddCreditCard #yyyy").val("")
        $("#ModalAddCreditCard #cvc").val("")
        $("#ModalAddCreditCard #billingAddress").val("")
        $("#ModalAddCreditCard #state").val("")
        $("#ModalAddCreditCard #country").val("")
        $("#ModalAddCreditCard #city").val("")
        $("#ModalAddCreditCard #zipCode").val("")
    }
    async SetCreditCard() {
        let data =
        {
            "TO": "PaymentDetails",
            "FOR": "CreditCard",
            "ACTION": "view",
            "Id": "all",
            "sharer": $("#ModalAddCreditCard #sharer").val(),
            "nameSharer": $("#ModalAddCreditCard #nameSharer").val(),
            "cardNo": $("#ModalAddCreditCard #cardNo").val(),
            "cardType": $("#ModalAddCreditCard #cardType").val(),
            "mm": $("#ModalAddCreditCard #mm").val(),
            "yyyy": $("#ModalAddCreditCard #yyyy").val(),
            "cvc": $("#ModalAddCreditCard #cvc").val(),
            "billingAddress": $("#ModalAddCreditCard #billingAddress").val(),
            "state": $("#ModalAddCreditCard #state").val(),
            "country": $("#ModalAddCreditCard #country").val(),
            "city": $("#ModalAddCreditCard #city").val(),
            "zipCode": $("#ModalAddCreditCard #zipCode").val()
        }
        let datos = await GetInformation(data);
        if (datos) {
            this.ClearCreditCard();
        }
    }
    async DeleteCreditCard(ID) {
        let data =
        {
            "TO": "PaymentDetails",
            "FOR": "CreditCard",
            "ACTION": "delete",
            "Id": ID
        }
        await GetInformation(data);
        this.ViewCreditCards();
    }

    async ViewSpecialDiscount() {
        let data =
        {
            "TO": "PaymentDetails",
            "FOR": "SpecialDiscount",
            "ACTION": "view"
        }
        let datos = await GetInformation(data);
        $(`#modalSpecialDiscount #discount[value='${datos[""]}']`).attr("selected", "")
        LoadTypeIdentificationSD(datos[""]);
        $(`#modalSpecialDiscount #typeIdentification[value='${datos[""]}']`).attr("selected", "")
        $("#modalSpecialDiscount #numberRequirement").val(datos[""])
    }
    async ApplySpecialDiscount() {
        let data =
        {
            "TO": "PaymentDetails",
            "FOR": "SpecialDiscount",
            "ACTION": "set",
            "discount": $("#modalSpecialDiscount #discount").val(),
            "typeIdentification": $("#modalSpecialDiscount #typeIdentification").val(),
            "numberRequirement": $("#modalSpecialDiscount #numberRequirement").val()
        }
        let datos = await GetInformation(data);
        this.ViewPayment();
    }
    async LoadTypeIdentificationSD(WHO) {
        let data =
        {
            "TO": "PaymentDetails",
            "FOR": "SpecialDiscount",
            "ACTION": "viewTypesIdentification",
            "of": WHO
        }
        let datos = await GetInformation(data);
        $(`#modalSpecialDiscount #typeIdentification`).html(datos[""]);
    }

    async ViewPromoCode() {
        let data =
        {
            "TO": "PaymentDetails",
            "FOR": "PromoCode",
            "ACTION": "view"
        }
        let datos = await GetInformation(data);
        $("#modalPromoCode #promoCode").val(datos[""]);
    }
    async SetPromoCode() {
        let data =
        {
            "TO": "PaymentDetails",
            "FOR": "PromoCode",
            "ACTION": "set",
            "PromoCode": $("#modalPromoCode #promoCode").val()
        }
        let datos = await GetInformation(data);
        this.ViewPayment();
    }

    async ViewSplitsReservation() {
        let data =
        {
            "TO": "PaymentDetails",
            "FOR": "SplitReservation",
            "ACTION": "view"
        }
        let datos = await GetInformation(data);
        let row = "";
        datos.forEach(data => {
            row +=
                `<tr>
                <td>Standar</td>
                <td>2020/07/03 - 2020/07/04</td>
                <td><span class="text-info">STD-12</span></td>
                <td>2</td>
            </tr>`;
        });
        $("#tableSplitReservation tbody").html(row);
    }
    async ViewModalSplitReservation() {
        let data =
        {
            "TO": "PaymentDetails",
            "FOR": "SplitReservation",
            "ACTION": "view"
        }
        let datos = await GetInformation(data);
        $("#modalAddSplitReservation #from").val(datos[""]);
        $("#modalAddSplitReservation #to").val(datos[""]);
        loadRooms();
        $("#modalAddSplitReservation #currentRooms span").text(datos[""]);
    }
    async SetSplitReservation() {

        let data =
        {
            "TO": "PaymentDetails",
            "FOR": "SplitReservation",
            "ACTION": "set",
            "from": $("#modalAddSplitReservation #from").val(),
            "to": $("#modalAddSplitReservation #to").val(),
            "roomType": $("#modalAddSplitReservation #roomType").val(),
            "rooms": $("#modalAddSplitReservation #rooms").val()
        }
        let datos = await GetInformation(data);
        this.ViewPayment();
    }

    async ViewExtendReservation() {
        let data =
        {
            "TO": "PaymentDetails",
            "FOR": "ExtendReservation",
            "ACTION": "view"
        }
        let datos = await GetInformation(data);
        $("#modalExtendSplitReservation #from").val(datos[""]);
        $("#modalExtendSplitReservation #to").val(datos[""]);
        loadRooms();
        $("#modalExtendSplitReservation #currentRooms span").text(datos[""]);
    }
    async SetExtendSplitReservation() {

        let data =
        {
            "TO": "PaymentDetails",
            "FOR": "ExtendSplitReservation",
            "ACTION": "set",
            "from": $("#modalAddSplitReservation #from").val(),
            "to": $("#modalAddSplitReservation #to").val(),
            "roomType": $("#modalAddSplitReservation #roomType").val(),
            "rooms": $("#modalExtendSplitReservation #rooms").val()
        }
        let datos = await GetInformation(data);
        this.ViewPayment();
    }
    async ChangeTyperate() {
        let data =
        {
            "TO": "PaymentDetails",
            "FOR": "ChangeRateType",
            "ACTION": "update",
            "typeRate": $("#tableRatesPackes #changeRateType").value()
        }
        let datos = await GetInformation(data);
        this.ViewPayment();
    }
    async ViewInclusionsAddons() {
        let data =
        {
            "TO": "PaymentDetails",
            "FOR": "InclusionsAddons",
            "ACTION": "view"
        }
        let datos = await GetInformation(data);
        let row = ``;
        datos.forEach(data => {
            row +=
                `<div class="custom-control custom-checkbox item-checkbox">
                <input type="checkbox" class="custom-control-input" id="item1" data-id="" value="off">
                <label for="item1" class="custom-control-label">
                Airport Drop - ($30.00) <br>
                <span class="subtext">Charge One</span>
                </label>
            </div>`
        });
        $("#tableRatesPackes tbody #inclusions-Addons").text(row);
    }
    async ViewModalInclusionsAddons() {
        let data =
        {
            "TO": "PaymentDetails",
            "FOR": "InclusionsAddons",
            "ACTION": "view"
        }
        let datos = await GetInformation(data);
        let row = ``;
        datos.forEach(data => {
            row +=
                `<div class="custom-control custom-checkbox item-checkbox">
                <input type="checkbox" class="custom-control-input" id="item1" data-id="" value="off">
                <label for="item1" class="custom-control-label">
                Airport Drop - ($30.00) <br>
                <span class="subtext">Charge One</span>
                </label>
            </div>`
        });
        $("#modalInclusionsAddons #list-checkbox").html(row);
    }
    async SetInclusionsAddons() {
        let Ids = [];
        $("#modalInclusionsAddons #list-checkbox .item-checkbox").each(function () {
            if ($(this).find(".custom-control-input").val() == "on") {
                Ids.push($(this).find(".custom-control-input").attr("data-id"))
            }
        });
        let data =
        {
            "TO": "PaymentDetails",
            "FOR": "InclusionsAddons",
            "ACTION": "set",
            "IDS": Ids
        }
        let datos = await GetInformation(data);
        this.ViewPayment();
    }

}
class PayBill {
    async ViewPayBill() {
        let data = {
            "TO": "PayBill",
            "FOR": "paybill",
            "ACTION": "view",
            "id": clientIdActive
        }
        let datos = await GetInformation(data);
        $(`#calendar #tab-content #client${clientIdActive}`).html(datos['content']);
    }
    async PayBill() {
        let data = {
            "TO": "PayBill",
            "FOR": "paybill",
            "ACTION": "paid",
            "id": clientIdActive,
            "modePaid": $("#payment #modePaid").val(),
            "type": $("#payment #type").val(),
            "amount": $("#payment #amount").val(),
            "cc-chequeNo": $("#payment #cc-chequeNo").val(),
            "receip": $("#payment #receip").val(),
            "description": $("#payment #description").val(),
        }
        let datos = await GetInformation(data);
    }
    async Refund() {
        let data = {
            "TO": "PayBill",
            "FOR": "folio",
            "ACTION": "set"
        }
        await GetInformation(data)
    }
    async routeCharges() {
        let data = {
            "TO": "PayBill",
            "FOR": "routeCharges",
            "ACTION": "set"
        }
        await GetInformation(data)
    }
    async RouteNewFolio() {
        let data = {
            "TO": "PayBill",
            "FOR": "folio",
            "ACTION": "routeNew"
        }
        await GetInformation(data)
    }
    async RoutePayment() {
        let data = {
            "TO": "PayBill",
            "FOR": "routePayment",
            "ACTION": "set"
        }
        await GetInformation(data)
    }
    async ViewFolios() {
        let data = {
            "TO": "PayBill",
            "FOR": "folio",
            "ACTION": "viewAll"
        }
        let datos = await GetInformation(data);
        let firstRow =
            `<tr class="bg-light-gray">
            <td colspan="6">
            <b>Room Type(Room): </b><span class="text-info">Superior Room (SUP-131)</span>
            </td>
        </tr>`;
        let row = ``
        datos.forEach(data => {
            row +=
                `<tr>
                <td>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" id="folioList{$data['id']}" class="custom-control-input">
                    <label for="folioList{$data['id']}" class="custom-control-label"></label>
                </div>
                </td>
                <td><p class="action">INV1</p></td>
                <td>April Monique</td>
                <td>460.00</td>
                <td>460.00</td>
                <td><i class="fas fa-lock"></i></td>
            </tr>`
        });
        $("#tab-content #paybill #folioList #tableFolios tbody").html(firstRow);
        $("#tab-content #paybill #folioList #tableFolios tbody").append(row);

    }
    async ViewFolio(ID) {
        let data = {
            "TO": "PayBill",
            "FOR": "folio",
            "ACTION": "view",
            "id": ID
        }
        let datos = await GetInformation(data);
        $(`#calendar #tab-content #client${clientIdActive} #paymentDetails`).html(datos['content']);
    }
    async GenerateFolio() {
        let data = {
            "TO": "PayBill",
            "FOR": "folio",
            "ACTION": "set"
        }
        await GetInformation(data)
    }
    async ConsolidateAccount() {
        let data = {
            "TO": "PayBill",
            "FOR": "consolidateAccount",
            "ACTION": "set"
        }
        await GetInformation(data)
    }
    async BackToReserv() {
        let data =
        {
            "TO": "tab-pane",
            "ACTION": "view",
            "id": clientIdActive
        }
        datos = await GetInformation(data);
        $(`#calendar #tab-content #client${clientIdActive}`).html(datos['tab-pane']);
    }
    async convertCurrency() {
        let amount = $("#modalConverterCurrency #amount").val();
        let currency = $("#modalConverterCurrency #currency").val();
        let convertTo = $("#modalConverterCurrency #convertTo").val();
        let data = {
            "TO": "PayBill",
            "FOR": "currency",
            "ACTION": "view",
            "currency": currency,
            "convertTo": convertTo
        }
        //let datos = await GetInformation(data);
        let datos = {
            "valueCurrency": "58.20"
        }
        let valueConvertTo = datos["valueCurrency"];
        let total = parseToDecimal(amount * valueConvertTo);

        $("#modalConverterCurrency #convertedCurrency").text("$ " + total);
        if ($("#modalConverterCurrency #convertApplyToPaid").val() == "on") {
            $(`#tab-content-restaurant #${clientIdActive} .payment-details #amount`).val(total);
        }
    }
    async AccountStatement() {
        let data = {
            "TO": "PayBill",
            "FOR": "accountStatement",
            "ACTION": "view"
        }
        let datos = GetInformation(data);
        let row = ``;
        if (datos.length > 0) {
            datos.forEach(data => {
                row +=
                    `<tr>
                    <td>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" id="A325" class="custom-control-input" value="off">
                        <label for="A325" class="custom-control-label"></label>
                    </div>
                    </td>
                    <td>Aug 31, 2020</td>
                    <td>Rack Rate Room Superior Room/SUP-131</td>
                    <td>INV1</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>$ 119.00</td>
                </tr>`;
            });
            $("#tab-content #paybill #tableAccountStatement tbody").html(row);
        }
        else {
            row = `<tr><td colspan='9' class='text-center'>No Transaction Found</td></tr>`
            $("#tab-content #paybill #tableAccountStatement tbody").html(row)
        }
    }

}

/*=======================================
        Elmentos Menu lateral
=========================================*/
class ListCheckIn {
    async Filter() {
        let data = {
            "TO": "ListCheckIn",
            "FOR": "filtre",
            "ACTION": "view",
            "nameOrId": $("#list-checkIn-list #filtre #nameOrId").val(),
            "from": $("#list-checkIn-list #filtre #nameOrId").val(),
            "from": $("#list-checkIn-list #filtre #from").val(),
            "to": $("#list-checkIn-list #filtre #to").val(),
            "allNotes": $("#list-checkIn-list #filtre #allNotes").val(),
            "status": $("#list-checkIn-list #filtre #status").val(),
            "filterBy": $("#list-checkIn-list #filtre #filterBy").val(),
            "textFilterBy": $("#list-checkIn-list #filtre #textFilterBy").val(),
            "sortBy": $("#list-checkIn-list #filtre #sortBy").val(),
            "typeReservation": $("#list-checkIn-list #filtre #typeReservation").val(),
            "excludeComp": $("#list-checkIn-list #filtre #in-excludeComp").val(),
            "thirdResId": $("#list-checkIn-list #filtre #in-thirstResId").val(),
            "dayUseRes": $("#list-checkIn-list #filtre #in-dayUseRes").val(),
            "rmsummary": $("#list-checkIn-list #filtre #in-rmsummary").val()
        }
        let datos = GetInformation(data);
        let row = "";
        datos.forEach(data => {
            rows +=
                `<tr>
                <td></td>
                <td>081830</td>
                <td>Anastacia Grey</td>
                <td>18 Aug - 24 Aug(6)</td>
                <td>N/A /Standard Room / N/A / N/A</td>
                <td>2(A)0(C)</td>
                <td>Reserve</td>
                <td class="text-right px-0">$ 1035.00</td>
                <td></td>
                <td>
                <button class="btn btn-primary btn-sm"><i class="fas fa-print"></i></button>
                <button class="btn btn-danger btn-sm"><i class="fas fa-envelope-open-text"></i></button>
                </td>
            </tr>`;
        });
        $("#list-checkIn-list #filtre #tableCheckIn tbody").html(rows)

    }
    async AddNewGroup() {
        let data = {
            "TO": "ListCheckIn",
            "FOR": "addNewGroup",
            "ACTION": "set",
        }
        let datos = GetInformation(data);
    }
    async RemoveFromGroup() {
        let data = {
            "TO": "ListCheckIn",
            "FOR": "removeGroup",
            "ACTION": "remove",
        }

        let datos = GetInformation(data);
    }
    async AddToGroup() {
        let data = {
            "TO": "ListCheckIn",
            "FOR": "addToGroup",
            "ACTION": "set",
        }

        let datos = GetInformation(data);
    }
}
class ListCheckOut {
    async Filter() {
        let data = {
            "TO": "ListCheckOut",
            "FOR": "filtre",
            "ACTION": "view",
            "nameOrId": $("#list-checkOut-list #filtre #nameOrId").val(),
            "from": $("#list-checkOut-list #filtre #nameOrId").val(),
            "from": $("#list-checkOut-list #filtre #from").val(),
            "to": $("#list-checkOut-list #filtre #to").val(),
            "allNotes": $("#list-checkOut-list #filtre #allNotes").val(),
            "status": $("#list-checkOut-list #filtre #status").val(),
            "filterBy": $("#list-checkOut-list #filtre #filterBy").val(),
            "textFilterBy": $("#list-checkOut-list #filtre #textFilterBy").val(),
            "sortBy": $("#list-checkOut-list #filtre #sortBy").val(),
            "typeReservation": $("#list-checkOut-list #filtre #typeReservation").val(),
            "thirdResId": $("#list-checkOut-list #filtre #out-thirstResId").val(),
            "dayUseRes": $("#list-checkOut-list #filtre #out-dayUseRes").val(),
            "rmsummary": $("#list-checkOut-list #filtre #out-rmsummary").val()
        }
        let datos = GetInformation(data);
        let row = "";
        datos.forEach(data => {
            rows +=
                `<tr>
                <td></td>
                <td>081830</td>
                <td>Anastacia Grey</td>
                <td>18 Aug - 24 Aug(6)</td>
                <td>N/A /Standard Room / N/A / N/A</td>
                <td>2(A)0(C)</td>
                <td>Reserve</td>
                <td class="text-right px-0">$ 1035.00</td>
                <td></td>
                <td>
                <button class="btn btn-primary btn-sm"><i class="fas fa-print"></i></button>
                <button class="btn btn-danger btn-sm"><i class="fas fa-envelope-open-text"></i></button>
                </td>
            </tr>`;
        });
        $("#list-checkIn-list #filtre #tableCheckIn tbody").html(rows)
    }
}
class ListReservation {
    async Filter() {
        let data = {
            "TO": "ListReservation",
            "FOR": "filtre",
            "ACTION": "view",
            "nameOrId": $("#list-reservation-list #filtre #nameOrId").val(),
            "from": $("#list-reservation-list #filtre #nameOrId").val(),
            "from": $("#list-reservation-list #filtre #from").val(),
            "to": $("#list-reservation-list #filtre #to").val(),
            "allNotes": $("#list-reservation-list #filtre #allNotes").val(),
            "status": $("#list-reservation-list #filtre #status").val(),
            "filterBy": $("#list-reservation-list #filtre #filterBy").val(),
            "textFilterBy": $("#list-reservation-list #filtre #textFilterBy").val(),
            "sortBy": $("#list-reservation-list #filtre #sortBy").val(),
            "typeReservation": $("#list-reservation-list #filtre #typeReservation").val(),
            "dayUseRes": $("#list-reservation-list #filtre #trl-dayUseRes").val()
        }
        let datos = GetInformation(data);
        let row = "";
        datos.forEach(data => {
            rows +=
                `<tr>
                <td></td>
                <td>081830</td>
                <td>Anastacia Grey</td>
                <td>18 Aug - 24 Aug(6)</td>
                <td>N/A /Standard Room / N/A / N/A</td>
                <td>2(A)0(C)</td>
                <td>Reserve</td>
                <td class="text-right px-0">$ 1035.00</td>
                <td></td>
                <td>
                <button class="btn btn-primary btn-sm"><i class="fas fa-print"></i></button>
                <button class="btn btn-danger btn-sm"><i class="fas fa-envelope-open-text"></i></button>
                </td>
            </tr>`;
        });
        $("#list-reservation-list #filtre #tableCheckIn tbody").html(rows)
    }
    async HoldTill() {
        let data =
        {
            "TO": "ListReservation",
            "FOR": "holdTill",
            "ACTION": "set"
        }
        let datos = await GetInformation(data);
    }
    async Print() {
        let data =
        {
            "TO": "ListReservation",
            "FOR": "print",
            "ACTION": "print"
        }
        let datos = await GetInformation(data);
    }
    async Export() {
        let data =
        {
            "TO": "ListReservation",
            "FOR": "print",
            "ACTION": "print"
        }
        let datos = await GetInformation(data);
    }
}
class ListTempRoom {
    async Filter() {
        let data = {
            "TO": "ListReservation",
            "FOR": "filtre",
            "ACTION": "view",
            "nameOrId": $("#list-temp-room-list #filtre #nameOrId").val(),
            "from": $("#list-temp-room-list #filtre #nameOrId").val(),
            "from": $("#list-temp-room-list #filtre #from").val(),
            "to": $("#list-temp-room-list #filtre #to").val(),
            "allNotes": $("#list-temp-room-list #filtre #allNotes").val(),
            "filterBy": $("#list-temp-room-list #filtre #filterBy").val(),
            "sortBy": $("#list-temp-room-list #filtre #sortBy").val(),
            "typeReservation": $("#list-temp-room-list #filtre #typeReservation").val(),
            "dayUseRes": $("#list-temp-room-list #filtre #trl-dayUseRes").val()
        }
        let datos = GetInformation(data);
        let row = "";
        datos.forEach(data => {
            rows +=
                `<tr>
                <td></td>
                <td>081830</td>
                <td>Anastacia Grey</td>
                <td>18 Aug - 24 Aug(6)</td>
                <td>N/A /Standard Room / N/A / N/A</td>
                <td>2(A)0(C)</td>
                <td>Reserve</td>
                <td class="text-right px-0">$ 1035.00</td>
                <td></td>
                <td>
                <button class="btn btn-primary btn-sm"><i class="fas fa-print"></i></button>
                <button class="btn btn-danger btn-sm"><i class="fas fa-envelope-open-text"></i></button>
                </td>
            </tr>`;
        });
        $("#list-temp-room-list #filtre #tableTempRoom tbody").html(rows)
    }
    async HoldTill() {
        let data =
        {
            "TO": "ListTempRoom",
            "FOR": "holdTill",
            "ACTION": "set"
        }
        let datos = await GetInformation(data);
    }
    async Print() {
        let data =
        {
            "TO": "ListTempRoom",
            "FOR": "print",
            "ACTION": "print"
        }
        let datos = await GetInformation(data);
    }
    async Export() {
        let data =
        {
            "TO": "ListTempRoom",
            "FOR": "print",
            "ACTION": "print"
        }
        let datos = await GetInformation(data);
    }
}
class NoShowList {
    async Filter() {
        let data = {
            "TO": "NoShowList",
            "FOR": "filtre",
            "ACTION": "view",
            "nameOrId": $("#list-no-show-list #filtre #nameOrId").val(),
            "from": $("#list-no-show-list #filtre #nameOrId").val(),
            "from": $("#list-no-show-list #filtre #from").val(),
            "to": $("#list-no-show-list #filtre #to").val(),
            "allNotes": $("#list-no-show-list #filtre #allNotes").val(),
            "filterBy": $("#list-no-show-list #filtre #filterBy").val(),
            "sortBy": $("#list-no-show-list #filtre #sortBy").val(),
            "typeReservation": $("#list-no-show-list #filtre #typeReservation").val(),
            "dayUseRes": $("#list-no-show-list #filtre #nsl-dayUseRes").val()
        }
        let datos = GetInformation(data);
        let row = "";
        datos.forEach(data => {
            rows +=
                `<tr>
                <td></td>
                <td>081830</td>
                <td>Anastacia Grey</td>
                <td>18 Aug - 24 Aug(6)</td>
                <td>N/A /Standard Room / N/A / N/A</td>
                <td>2(A)0(C)</td>
                <td>Reserve</td>
                <td class="text-right px-0">$ 1035.00</td>
                <td></td>
                <td>
                <button class="btn btn-primary btn-sm"><i class="fas fa-print"></i></button>
                <button class="btn btn-danger btn-sm"><i class="fas fa-envelope-open-text"></i></button>
                </td>
            </tr>`;
        });
        $("#list-no-show-list #filtre #tableNoShowList tbody").html(rows)
    }
    async Print() {
        let data =
        {
            "TO": "ListTempRoom",
            "FOR": "print",
            "ACTION": "print"
        }
        let datos = await GetInformation(data);
    }
}
class CancellationList {
    async Filter() {
        let data = {
            "TO": "CancellationList",
            "FOR": "filtre",
            "ACTION": "view",
            "nameOrId": $("#list-cancellation-list #filtre #nameOrId").val(),
            "from": $("#list-cancellation-list #filtre #nameOrId").val(),
            "from": $("#list-cancellation-list #filtre #from").val(),
            "to": $("#list-cancellation-list #filtre #to").val(),
            "typeReservation": $("#list-cancellation-list #filtre #typeReservation").val(),
            "excludePartyResId": $("#list-cancellation-list #filtre #cancellationList-exclude"),
            "dayUseRes": $("#list-cancellation-list #filtre #cancellationList-dayUseRes").val(),
            "excludeNoShow": $("#list-cancellation-list #filtre #cancellationList-exludeNoShow").val()
        }
        let datos = GetInformation(data);
        let row = "";
        datos.forEach(data => {
            rows +=
                `<tr>
                <td></td>
                <td>081830</td>
                <td>Anastacia Grey</td>
                <td>18 Aug - 24 Aug(6)</td>
                <td>N/A /Standard Room / N/A / N/A</td>
                <td>2(A)0(C)</td>
                <td>Reserve</td>
                <td class="text-right px-0">$ 1035.00</td>
                <td></td>
                <td>
                <button class="btn btn-primary btn-sm"><i class="fas fa-print"></i></button>
                <button class="btn btn-danger btn-sm"><i class="fas fa-envelope-open-text"></i></button>
                </td>
            </tr>`;
        });
        $("#list-cancellation-list #filtre #tableCancellationList tbody").html(rows)
    }
    async Print() {
        let data =
        {
            "TO": "CancellationList",
            "FOR": "print",
            "ACTION": "print"
        }
        let datos = await GetInformation(data);
    }
}
class ListCheckoutPending {
    async Filter() {
        let data = {
            "TO": "ListCheckoutPending",
            "FOR": "filtre",
            "ACTION": "view",
            "nameOrId": $("#list-checkout-Pending-list #filtre #nameOrId").val(),
            "from": $("#list-checkout-Pending-list #filtre #from").val(),
            "to": $("#list-checkout-Pending-list #filtre #to").val(),
            "typeReservation": $("#list-checkout-Pending-list #filtre #typeReservation").val(),
            "excludePartyResId": $("#list-checkout-Pending-list #filtre #cancellationList-exclude"),
            "dayUseRes": $("#list-checkout-Pending-list #filtre #cancellationList-dayUseRes").val(),
            "excludeNoShow": $("#list-checkout-Pending-list #filtre #cancellationList-exludeNoShow").val()
        }
        let datos = GetInformation(data);
        let row = "";
        datos.forEach(data => {
            rows +=
                `<tr>
                <td></td>
                <td>081830</td>
                <td>Anastacia Grey</td>
                <td>18 Aug - 24 Aug(6)</td>
                <td>N/A /Standard Room / N/A / N/A</td>
                <td>2(A)0(C)</td>
                <td>Reserve</td>
                <td class="text-right px-0">$ 1035.00</td>
                <td></td>
                <td>
                <button class="btn btn-primary btn-sm"><i class="fas fa-print"></i></button>
                <button class="btn btn-danger btn-sm"><i class="fas fa-envelope-open-text"></i></button>
                </td>
            </tr>`;
        });
        $("#list-checkout-Pending-list #filtre #tableCheckOutPendingList tbody").html(rows)
    }
    async Print() {
        let data =
        {
            "TO": "ListCheckoutPending",
            "FOR": "print",
            "ACTION": "print"
        }
        let datos = await GetInformation(data);
    }
}
class PendingFolio {
    async Filter() {
        let data = {
            "TO": "PendingFolio",
            "FOR": "filtre",
            "ACTION": "view",
            "from": $("#list-checkout-Pending-list #filtre #from").val(),
            "to": $("#list-pending-folio #filtre #to").val(),
            "showRefundable": $("#list-pending-folio #filtre #pendingFolio-show-refundable").val(),
            "typeReservation": $("#list-pending-folio #filtre #typeReservation").val(),
            "showDayUseOnly": $("#list-pending-folio #filtre #pendingFolio-showDayUseOnly").val()
        }
        let datos = GetInformation(data);
        let row = "";
        datos.forEach(data => {
            rows +=
                `<tr>
                <td></td>
                <td>081830</td>
                <td>Anastacia Grey</td>
                <td>18 Aug - 24 Aug(6)</td>
                <td>N/A /Standard Room / N/A / N/A</td>
                <td>2(A)0(C)</td>
                <td>Reserve</td>
                <td class="text-right px-0">$ 1035.00</td>
                <td></td>
                <td>
                <button class="btn btn-primary btn-sm"><i class="fas fa-print"></i></button>
                <button class="btn btn-danger btn-sm"><i class="fas fa-envelope-open-text"></i></button>
                </td>
            </tr>`;
        });
        $("#list-checkout-Pending-list #filtre #tableCheckOutPendingList tbody").html(rows)
    }
    async Print() {
        let data =
        {
            "TO": "PendingFolio",
            "FOR": "print",
            "ACTION": "print"
        }
        let datos = await GetInformation(data);
    }
}
class BookingDeposit {
    async Filter() {
        let data = {
            "TO": "BookingDeposit",
            "FOR": "filtre",
            "ACTION": "view",
            "date": $("#list-booking-deposit #filtre #date").val(),
            "typeReservation": $("#list-booking-deposit #filtre #typeReservation").val(),
            "deposit": $("#list-booking-deposit #filtre #deposit").val()
        }
        let datos = GetInformation(data);
        let rows = "";

        datos.forEach(data => {
            rows +=
                `<tr>
                <td></td>
                <td>081830</td>
                <td>Anastacia Grey</td>
                <td>18 Aug - 24 Aug(6)</td>
                <td>N/A /Standard Room / N/A / N/A</td>
                <td>2(A)0(C)</td>
                <td>Reserve</td>
                <td class="text-right px-0">$ 1035.00</td>
                <td></td>
                <td>
                <button class="btn btn-primary btn-sm"><i class="fas fa-print"></i></button>
                <button class="btn btn-danger btn-sm"><i class="fas fa-envelope-open-text"></i></button>
                </td>
            </tr>`;
        });
        $("#list-booking-deposit #filtre #tableBookingDeposit tbody").html(rows);
    }
    async ReleaseBooking() {
        let data =
        {
            "TO": "BookingDeposit",
            "FOR": "releaseBooking",
            "ACTION": "set"
        }
        let datos = await GetInformation(data);
    }
    async Print() {
        let data =
        {
            "TO": "BookingDeposit",
            "FOR": "print",
            "ACTION": "print"
        }
        let datos = await GetInformation(data);
    }
}
class PaymentTracker {
    async Filter() {
        let data = {
            "TO": "PaymentTracker",
            "FOR": "filtre",
            "ACTION": "view",
            "from": $("#list-payment-tracker #filtre #stayFrom").val(),
            "to": $("#list-payment-tracker #filtre #stayto").val(),
            "due": $("#list-payment-tracker #filtre #due").val(),
            "dueValue": $("#list-payment-tracker #filtre #dueValue").val(),
            "typeReservation": $("#list-payment-tracker #filtre #typeReservation").val()
        }
        let datos = GetInformation(data);
        let rows = "";

        datos.forEach(data => {
            rows +=
                `<tr>
                <td></td>
                <td>081830</td>
                <td>Anastacia Grey</td>
                <td>18 Aug - 24 Aug(6)</td>
                <td>N/A /Standard Room / N/A / N/A</td>
                <td>2(A)0(C)</td>
                <td>Reserve</td>
                <td class="text-right px-0">$ 1035.00</td>
                <td></td>
                <td>
                <button class="btn btn-primary btn-sm"><i class="fas fa-print"></i></button>
                <button class="btn btn-danger btn-sm"><i class="fas fa-envelope-open-text"></i></button>
                </td>
            </tr>`;
        });
        $("#list-payment-tracker #filtre #tablePaymentTracker tbody").html(rows);
    }
    async Print() {
        let data =
        {
            "TO": "PaymentTracker",
            "FOR": "print",
            "ACTION": "print"
        }
        let datos = await GetInformation(data);
    }
}
class ListGuestInHouse {
    async Filter() {
        let data = {
            "TO": "ListGuestInHouse",
            "FOR": "filtre",
            "ACTION": "view",
            "nameOrId": $("#list-guest-in-house-list #filtre #nameOrId").val(),
            "from": $("list-guest-in-house-list #filtre #from").val(),
            "to": $("#list-guest-in-house-list #filtre #to").val(),
            "guestStatus": $("#list-guest-in-house-list #filtre #guestStatus").val(),
            "typeReservation": $("#list-guest-in-house-list #filtre #typeReservation").val(),
            "filterByType": $("#list-payment-tracker #filtre #filterByType").val(),
            "filterByDescription": $("#list-guest-in-house-list #filtre #filterByDescription").val(),
            "roomType": $("#list-guest-in-house-list #filtre #roomType").val(),
            "paxDetails": $("#list-guest-in-house-list #filtre #gihl-paxDetails").val()
        }
        let datos = GetInformation(data);
        let rows = "";

        datos.forEach(data => {
            rows +=
                `<tr>
                <td></td>
                <td>081830</td>
                <td>Anastacia Grey</td>
                <td>18 Aug - 24 Aug(6)</td>
                <td>N/A /Standard Room / N/A / N/A</td>
                <td>2(A)0(C)</td>
                <td>Reserve</td>
                <td class="text-right px-0">$ 1035.00</td>
                <td></td>
                <td>
                <button class="btn btn-primary btn-sm"><i class="fas fa-print"></i></button>
                <button class="btn btn-danger btn-sm"><i class="fas fa-envelope-open-text"></i></button>
                </td>
            </tr>`;
        });
        $("#list-guest-in-house-list #filtre #tableGuestInHouse tbody").html(rows);
    }
    async Print() {
        let data =
        {
            "TO": "ListGuestInHouse",
            "FOR": "print",
            "ACTION": "print"
        }
        let datos = await GetInformation(data);
    }
    async Export() {
        let data =
        {
            "TO": "ListGuestInHouse",
            "FOR": "print",
            "ACTION": "print"
        }
        let datos = await GetInformation(data);
    }
}
class ListPatyReservation {
    async Filter() {
        let data = {
            "TO": "ListPatyReservation",
            "FOR": "filtre",
            "ACTION": "view",
            "searchType": $("#llist-party-reservation-list #filtre #searchTypeChk").val(),
            "from": $("list-party-reservation-list #filtre #stayFrom").val(),
            "to": $("#list-party-reservation-list #filtre #stayTo").val(),
            "guestStatus": $("#list-party-reservation-list #filtre #guestStatus").val(),
            "msgStatus": $("#list-party-reservation-list #filtre #msgStatus").val()
        }
        let datos = GetInformation(data);
        let rows = "";

        datos.forEach(data => {
            rows +=
                `<tr>
                <td></td>
                <td>081830</td>
                <td>Anastacia Grey</td>
                <td>18 Aug - 24 Aug(6)</td>
                <td>N/A /Standard Room / N/A / N/A</td>
                <td>2(A)0(C)</td>
                <td>Reserve</td>
                <td class="text-right px-0">$ 1035.00</td>
                <td></td>
                <td>
                <button class="btn btn-primary btn-sm"><i class="fas fa-print"></i></button>
                <button class="btn btn-danger btn-sm"><i class="fas fa-envelope-open-text"></i></button>
                </td>
            </tr>`;
        });
        $("#list-party-reservation-list #filtre #tablePartyReservation tbody").html(rows);
    }
    async Print() {
        let data =
        {
            "TO": "ListPatyReservation",
            "FOR": "print",
            "ACTION": "print"
        }
        let datos = await GetInformation(data);
    }
    async Export() {
        let data =
        {
            "TO": "ListPatyReservation",
            "FOR": "export",
            "ACTION": $("#list-party-reservation-list #filtre #convertTo").val()
        }
        let datos = await GetInformation(data);
    }
}
class AlertAndNotification {
    async Filter() {
        let data = {
            "TO": "AlertAndNotification",
            "FOR": "filtre",
            "ACTION": "view",
            "from": $("list-alertAndNotifications #filtre #stayFrom").val(),
            "to": $("#list-alertAndNotifications #filtre #stayTo").val(),
            "msgStatus": $("#list-alertAndNotifications #filtre #msgStatus").val()
        }
        let datos = GetInformation(data);
        let rows = "";

        datos.forEach(data => {
            rows +=
                `<tr>
                <td></td>
                <td>081830</td>
                <td>Anastacia Grey</td>
                <td>18 Aug - 24 Aug(6)</td>
                <td>N/A /Standard Room / N/A / N/A</td>
                <td>2(A)0(C)</td>
                <td>Reserve</td>
                <td class="text-right px-0">$ 1035.00</td>
                <td></td>
                <td>
                <button class="btn btn-primary btn-sm"><i class="fas fa-print"></i></button>
                <button class="btn btn-danger btn-sm"><i class="fas fa-envelope-open-text"></i></button>
                </td>
            </tr>`;
        });
        $("#list-alertAndNotifications #filtre #tableAlertAndNotification tbody").html(rows);
    }
    async Print() {
        let data =
        {
            "TO": "AlertAndNotification",
            "FOR": "print",
            "ACTION": "print"
        }
        let datos = await GetInformation(data);
    }
}
class ListDNRHouseReport {
    async Filter() {
        let data = {
            "TO": "ListDNRHouseReport",
            "FOR": "filtre",
            "ACTION": "view",
            "from": $("#list-dnr-house-report #filtre #stayFrom").val(),
            "to": $("#list-dnr-house-report #filtre #stayTo").val(),
            "reportType": $("#list-dnr-house-report #filtre #reportType").val(),
            "roomType": $("#list-dnr-house-report #filtre #roomType").val()
        }
        let datos = GetInformation(data);
        let rows = "";

        datos.forEach(data => {
            rows +=
                `<tr>
                <td></td>
                <td>081830</td>
                <td>Anastacia Grey</td>
                <td>18 Aug - 24 Aug(6)</td>
                <td>N/A /Standard Room / N/A / N/A</td>
                <td>2(A)0(C)</td>
                <td>Reserve</td>
                <td class="text-right px-0">$ 1035.00</td>
                <td></td>
                <td>
                <button class="btn btn-primary btn-sm"><i class="fas fa-print"></i></button>
                <button class="btn btn-danger btn-sm"><i class="fas fa-envelope-open-text"></i></button>
                </td>
            </tr>`;
        });
        $("#list-dnr-house-report #filtre #tableDNRHouseReport tbody").html(rows);
    }
    async Print() {
        let data =
        {
            "TO": "AlertAndNotification",
            "FOR": "print",
            "ACTION": "print"
        }
        let datos = await GetInformation(data);
    }
    async Export() {
        let data =
        {
            "TO": "ListDNRHouseReport",
            "FOR": "print",
            "ACTION": "print"
        }
        let datos = await GetInformation(data);
    }
}
class RatePostingReport {
    async Filter() {
        let data = {
            "TO": "RatePostingReport",
            "FOR": "filtre",
            "ACTION": "view",
            "date": $("#list-rate-posting-report #filtre #reportDate").val(),
            "filterBy": $("#list-rate-posting-report #filtre #filterByType").val(),
            "filterByDescripcion": $("#list-rate-posting-report #filtre #filterByDescription").val(),
            "shoePreferencesNotes": $("#list-rate-posting-report #filtre #ratePR-showPN").val(),
            "notes": $("#list-rate-posting-report #filtre #notes").val(),
            "includeNoShowsCancellation": $("#list-rate-posting-report #filtre #ratePR-includeNoShowsC").val()
        }
        let datos = GetInformation(data);
        let rows = "";

        datos.forEach(data => {
            rows +=
                `<tr>
                <td></td>
                <td>081830</td>
                <td>Anastacia Grey</td>
                <td>18 Aug - 24 Aug(6)</td>
                <td>N/A /Standard Room / N/A / N/A</td>
                <td>2(A)0(C)</td>
                <td>Reserve</td>
                <td class="text-right px-0">$ 1035.00</td>
                <td></td>
                <td>
                <button class="btn btn-primary btn-sm"><i class="fas fa-print"></i></button>
                <button class="btn btn-danger btn-sm"><i class="fas fa-envelope-open-text"></i></button>
                </td>
            </tr>`;
        });
        $("#list-dnr-house-report #filtre #tableDNRHouseReport tbody").html(rows);
    }
    async Print() {
        let data =
        {
            "TO": "RatePostingReport",
            "FOR": "print",
            "ACTION": "print"
        }
        let datos = await GetInformation(data);
    }
}
class GuestLookUp {
    async Filter() {
        let data = {
            "TO": "GuestLookUp",
            "FOR": "filtre",
            "ACTION": "view",
            "guestId": $("#list-guest-lookUp #filtre #guestId").val(),
            "vip": $("#list-rate-posting-report #filtre #vip").val(),
            "room": $("#list-guest-lookUp #filtre #room").val(),
            "partialName": $("list-guest-lookUp #filtre #partialName").val(),
            "firstName": $("#list-guest-lookUp #filtre #firstName").val(),
            "lastName": $("#list-guest-lookUp #filtre #lastName").val(),
            "idType": $("#list-guest-lookUp #filtre #IDType").val(),
            "id": $("#list-guest-lookUp #filtre #ID").val(),
            "searchType": $("#list-guest-lookUp #filtre #searchType").val(),
            "noSearchType": $("#list-guest-lookUp #filtre #noSearchType").val(),
            "address": $("#list-guest-lookUp #filtre #address").val(),
            "city": $("#list-guest-lookUp #filtre #city").val(),
            "country": $("#list-guest-lookUp #filtre #country").val(),
            "state": $("#list-guest-lookUp #filtre #state").val(),
            "zipCode": $("#list-guest-lookUp #filtre #zipCode").val(),
            "sourceOfBusiness": $("#list-guest-lookUp #filtre #sourceOfBusiness").val(),
            "guestStatus": $("#list-guest-lookUp #filtre #guestStatus").val(),
            "accompanyng": $("#list-guest-lookUp #filtre #accompanyng").val(),
            "checkIn": $("#list-guest-lookUp #filtre #checkIn").val(),
            "checkOut": $("#list-guest-lookUp #filtre #checkOut").val(),
            "guestOrganization": $("#list-guest-lookUp #filtre #guestOrgnization").val(),
            "emailId": $("#list-guest-lookUp #filtre #emailId").val(),
            "includeCancellation": $("#list-guest-lookUp #filtre #guestLookUp-includeC").val()
        }
        let datos = GetInformation(data);
        let rows = "";

        datos.forEach(data => {
            rows +=
                `<tr>
                
            </tr>`;
        });
        $("#list-guest-lookUp #filtre #tableDNRHouseReport tbody").html(rows);
    }
    async Print() {
        let data =
        {
            "TO": "GuestLookUp",
            "FOR": "print",
            "ACTION": "print"
        }
        let datos = await GetInformation(data);
    }
    async AddGuest() {
        let data =
        {
            "TO": "GuestLookUp",
            "FOR": "print",
            "ACTION": "print"
        }
        let datos = await GetInformation(data);
    }
    async Export() {
        let data =
        {
            "TO": "GuestLookUp",
            "FOR": "print",
            "ACTION": "print"
        }
        let datos = await GetInformation(data);
    }
}
class ListHouseStatus {
    async loadTables() {
        let data =
        {
            "TO": "ListHouseStatus",
            "FOR": "loadTables",
            "ACTION": "view"
        }
        let datos = await GetInformation(data);
        let rowsTableONe, rowsTableTwo, rowsTableThree, rowsTableFour = "";
        $("#calendar #ListHouseStatus #tableOne tbody").html();
        $("#calendar #ListHouseStatus #tableTwo tbody").html();
        $("#calendar #ListHouseStatus #tableThree tbody").html();
        $("#calendar #ListHouseStatus #tableFour tbody").html();
    }
    async Print() {
        let data =
        {
            "TO": "ListHouseStatus",
            "FOR": "print",
            "ACTION": "print"
        }
        let datos = await GetInformation(data);
    }
}
class TariffChart {
    async Filter() {
        let data = {
            "TO": "TariffChart",
            "FOR": "filtre",
            "ACTION": "view",
            "from": $("#list-tariff-chart #filtre #from").val(),
            "to": $("#list-tariff-chart #filtre #to").val(),
            "selMode": $("#list-tariff-chart #filtre #selMode").val(),
            "showCorp": $("#list-tariff-chart #filtre #panelTariffChart-selCorp").val(),
            "selCorp": $("#list-tariff-chart #filtre #tariffChart-selCorp").val()
        }
        let datos = GetInformation(data);
        let seasonalRate, tableRackRate, tableFullBoard, rowsTableFour = "";

        datos.forEach(data => {
            rows +=
                ``;
        });
        $("#calendar #list-tariff-chart #seasonalRate #bodyContent").html();
        $("#calendar #list-tariff-chart #tableRackRate #bodyContent").html();
        $("#calendar #list-tariff-chart #tableFullBoard #bodyContent").html();
        $("#calendar #list-tariff-chart #tableHoneyMoon #bodyContent").html();
    }
    async Print() {
        let data =
        {
            "TO": "TariffChart",
            "FOR": "print",
            "ACTION": "print"
        }
        let datos = await GetInformation(data);
    }
}

class GroupReservation {
    async CreateTypeReservation(typeReservation = $("#tab-content #createGroupReservation #personalInformation #groupOwner").val()) {

        let data = {
            "TO": "GroupReservation",
            "FOR": "CreateTypeReservation",
            "ACTION": "view",
            "typeReservation": typeReservation
        }
        let datos = await GetInformation(data);
        $(`#tab-content #createGroupReservation #personalInformation #groupOwner option`).removeAttr("selected");
        $(`#tab-content #createGroupReservation #personalInformation #groupOwner option[value='${typeReservation}']`).attr("selected", "selected");

        $("#tab-content #createGroupReservation #personalInformation #contentTypeClient").html(datos['content']);
    }
}

class Housekeeping {
    async RoomStatus() {
        let data = {
            "TO": "Housekeeping",
            "FOR": "roomStatus",
            "ACTION": "view"
        }
        let datos = await GetInformation(data);
        let rows = "";
        if (datos.length) {
            datos.forEach(data => {
                rows +=
                    `<tr>
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
                </tr>`;
            });
            $("#housekeeping #roomStatus").html(rows)
        }
    }
    async PrintRoomStatus() {

    }
    async setHousekeepingStatus() {
        let data = {
            "TO": "Housekeeping",
            "FOR": "setHousekeepingStatus",
            "ACTION": "update",
            "status": $("#housekeeping .filter #setHpgS").val()
        }
        let datos = await GetInformation(data);
        this.RoomStatus();
    }
    async AssignSelectRooomTo() {
        let data = {
            "TO": "Housekeeping",
            "FOR": "AssignSelectRooomTo",
            "ACTION": "update",
            "status": $("#housekeeping .filter #assignRoomTo").val()
        }
        let datos = await GetInformation(data);
        this.RoomStatus();
    }
    async TodaysRoomStatus() {
        let data = {
            "TO": "Housekeeping",
            "FOR": "TodaysRoomStatus",
            "ACTION": "view"
        }
        let datos = await GetInformation(data);
        $("#housekeeping #tableTodaysRoomStatus #todaysCheckIn").text(datos[''])
        $("#housekeeping #tableTodaysRoomStatus #todaysCheckOut").text(datos[''])
        $("#housekeeping #tableTodaysRoomStatus #available").text(datos[''])
        $("#housekeeping #tableTodaysRoomStatus #reserved").text(datos[''])
        $("#housekeeping #tableTodaysRoomStatus #occupied").text(datos[''])
        $("#housekeeping #tableTodaysRoomStatus #blocked").text(datos[''])
        $("#housekeeping #tableTodaysRoomStatus #overBooking").text(datos[''])
        $("#housekeeping #tableTodaysRoomStatus #checkOut").text(datos[''])
    }
    async HousekeepingStatus() {
        let data = {
            "TO": "Housekeeping",
            "FOR": "housekeepingStatus",
            "ACTION": "view"
        }
        let datos = await GetInformation(data);
        $("#housekeeping #housekeepingStatus #dirty").text(datos[''])
        $("#housekeeping #housekeepingStatus #touchUp").text(datos[''])
        $("#housekeeping #housekeepingStatus #clean").text(datos[''])
        $("#housekeeping #housekeepingStatus #repair").text(datos[''])
        $("#housekeeping #housekeepingStatus #inspect").text(datos[''])
    }
    async TodaysCheckIn() {
        let data = {
            "TO": "Housekeeping",
            "FOR": "todaysCheckIn",
            "ACTION": "view"
        }
        let datos = await GetInformation(data);
        let rows = "";
        datos.forEach(data => {
            rows +=
                `<tr>
                <td>G 09195/091917</td>
                <td>Anastacia grey</td>
                <td>Sept 16-2020 - Sept 19-2020</td>
                <td>3</td>
                <td>DLX-116/Deluxe</td>
                <td>3(A) 0(C)</td>
                <td>Check In</td>
                <td>$ 663.50</td>
                <td></td>
            </tr>`
        });
        $("#housekeeping #modalTodaysCheckInRooom .modal-body table tbody").html(rows);
    }
    async TodaysCheckOut() {
        let data = {
            "TO": "Housekeeping",
            "FOR": "todaysCheckOut",
            "ACTION": "view"
        }
        let datos = await GetInformation(data);
        let rows = "";
        datos.forEach(data => {
            rows +=
                `<tr>
                <td>G 09195/091917</td>
                <td>Anastacia grey</td>
                <td>Sept 16-2020 - Sept 19-2020</td>
                <td>3</td>
                <td>DLX-116/Deluxe</td>
                <td>3(A) 0(C)</td>
                <td>Check In</td>
                <td>$ 663.50</td>
                <td></td>
            </tr>`
        });
        $("#housekeeping #modalTodaysCheckOutRooom .modal-body table tbody").html(rows);
    }
    async UpdateRoomStatus() {
        let data = {
            "TO": "Housekeeping",
            "FOR": "UpdateRoomStatus",
            "ACTION": "update",
            "status": $("#housekeeping #tableRoomStatus #roomStatus").val()
        }
        let datos = await GetInformation(data);
    }
    async UpdateRemarks() {
        let id = $("#modalRemarks .modal-footer #save").attr("data-id");
        let data = {
            "TO": "Housekeeping",
            "FOR": "UpdateRemarks",
            "ACTION": "update",
            "status": $("#housekeeping #modalRemarks .modal-body #remarks").val(),
            "id": id
        }
        let datos = await GetInformation(data);
        $(`#housekeeping #tableRoomStatus #remarks[data-id='${id}']`).text(datos[''])
    }
    async ViewDiscrepancy(ID) {
        let data = {
            "TO": "Housekeeping",
            "FOR": "Discrepancy",
            "ACTION": "view",
            "id": ID
        }
        let datos = await GetInformation(data);
        $("#housekeeping #modalAddDiscrepancy .modal-body #roomName").val()
        $("#housekeeping #modalAddDiscrepancy .modal-body #roomType").val(datos[''])
        $("#housekeeping #modalAddDiscrepancy .modal-body #roomStatus").val(datos[''])
        $("#housekeeping #modalAddDiscrepancy .modal-body #foStatus").val(datos[''])

        $("#housekeeping #modalAddDiscrepancy .modal-body #hkStatus").val(datos[''])
        $("#housekeeping #modalAddDiscrepancy .modal-body #fooAdults").val(datos[''])
        $("#housekeeping #modalAddDiscrepancy .modal-body #fooChilds").val(datos[''])
        $("#housekeeping #modalAddDiscrepancy .modal-body #hkoAdults").val(datos[''])
        $("#housekeeping #modalAddDiscrepancy .modal-body #hkoChilds").val(datos[''])
        $("#housekeeping #modalAddDiscrepancy .modal-body #discrepancy").val(datos[''])
    }
    async AddDiscrepancy() {
        let hkStatus = $("#housekeeping #modalAddDiscrepancy .modal-body #hkStatus")
        let fooAdults = $("#housekeeping #modalAddDiscrepancy .modal-body #fooAdults")
        let fooChilds = $("#housekeeping #modalAddDiscrepancy .modal-body #fooChilds")
        let hkoAdults = $("#housekeeping #modalAddDiscrepancy .modal-body #hkoAdults")
        let hkoChilds = $("#housekeeping #modalAddDiscrepancy .modal-body #hkoChilds")
        let discrepancy = $("#housekeeping #modalAddDiscrepancy .modal-body #discrepancy")
        let id = ("#housekeeping #modalAddDiscrepancy .modal-footer #save").attr("data-id")
        let data = {
            "TO": "Housekeeping",
            "FOR": "Discrepancy",
            "ACTION": "update",
            "hkStatus": hkStatus,
            "fooAdults": fooAdults,
            "fooChilds": fooChilds,
            "hkoAdults": hkoAdults,
            "hkoChilds": hkoChilds,
            "discrepancy": discrepancy,
            "id": id
        }
        await GetInformation(data)
    }
    async UpdateHkName(ID, STATUS) {
        let data = {
            "TO": "Housekeeping",
            "FOR": "HkName",
            "ACTION": "update",
            "status": STATUS,
            "id": ID
        }
        let datos = await GetInformation(data);

        //$(`#housekeeping #tableRoomStatus #hkName`).html(row)
        $(`#housekeeping #tableRoomStatus #hkName option[value='${datos[""]}']`).attr("selected", "selected")
    }
    async WorkArea() {
        let data = {
            "TO": "Housekeeping",
            "FOR": "WorkArea",
            "ACTION": "view",
            "workAreaType": $("#housekeeping #modalAddTask #workAreaType").val(),
            "taskFor": $("#housekeeping #modalAddTask #taskFor").val()
        }
        let options = "";
        let datos = await GetInformation(data);
        $("#housekeeping #modalAddTask #workArea").html(datos['options']);
    }
    async AuditTrailFilter() {
        let from = $("#modalAuditTrail .filter #fromDate").val();
        let to = $("#modalAuditTrail .filter #toDate").val();
        let roomType = $("#modalAuditTrail .filter #roomType").val();
        let roomName = $("#modalAuditTrail .filter #roomName").val();
        let filterFor = $("#modalAuditTrail .filter #filter").val();

        let data = {
            "TO": "Housekeeping",
            "FOR": "AuditTrailFilter",
            "ACTION": "view",
            "from": from,
            "to": to,
            "roomType": roomType,
            "roomName": roomName,
            "filterFor": filterFor
        }
        let datos = await GetInformation(data);
        let rows = "";
        datos.forEach(data => {
            rows +=
                `<tr>
                <td><b>Sep. 22-2020 08:58PM: </b> Room STD-102 assigned to Hotelogix Support by
                    <span class="text-info">Jhon Smith</span> </td>
            </tr>`
        });
        $("#modalAuditTrail #tableAuditTrail tbody").html(rows)
    }
    async TaskList() {
        let typeSearch = $("#housekeeping #modalAllTask .filter #typeSearch").val();
        let from = $("#housekeeping #modalAllTask .filter #from").val();
        let to = $("#housekeeping #modalAllTask .filter #to").val();
        let status = $("#housekeeping #modalAllTask .filter #status").val();
        let data = {
            "TO": "Housekeeping",
            "FOR": "TaskList",
            "ACTION": "view",
            "typeSearch": typeSearch,
            "from": from,
            "to": to,
            "status": status
        }
        let datos = await GetInformation(data);
        let rows = "";
        if (datos.length) {
            datos.forEach(data => {
                rows += ``
            });
            $("#housekeeping #modalAllTask #tableAllTask tbody").html(rows)
        }
    }
}
function ASSelectItems(elemen) {

    let check = $(elemen).val();
    let padre = $(elemen).closest("table");
    console.log(padre);
    $(padre).each(function () {
        if (check == "on") {
            $(this).find("tbody tr input[disabled!='disabled']").attr("checked", "");
        }
        else {
            $(this).find("input[type='checkbox']").removeAttr("checked");
        }
    });
}
async function loadTypeRooms() {
    let data =
    {
        "TO": "Rooms",
        "FOR": "TypeRooms",
        "ACTION": "view"
    }
    let datos = await GetInformation(data);
    return datos;
}
async function loadRooms(TYPEROOM, PARENT = "") {
    let data =
    {
        "TO": "ListRooms",
        "ACTION": "view",
        "typeRoom": TYPEROOM
    }
    let datos = await GetInformation(data);
    $(PARENT).find("#rooms").html(datos['rooms']);
}
function parseToDecimal(n) {
    let t = n.toString();
    let regex = /(\d*.\d{0,2})/;
    return t.match(regex)[0];
}
function validationFields(PARENT) {
    result = true;
    $($(PARENT).find("input[required],select[required]")).each(function () {
        if ($(this).val() == "") {
            $(this).addClass("field-required");
            result = false;
        }
        else {
            $(this).removeClass("field-required")
        }
    });
    return result;
}
function GetInformation(datos) {
    datos["_token"] = csrf_token
    let route = window.location.pathname;
    route = route.endsWith("/")? "getinformation" : route+"/getinformation";
    console.log(route)
    $(".loading-status").removeClass("hide");
    let result =
        $.ajax({
            type: 'post',
            url: route,
            dataType: "json",
            data: datos,
            
            success: function (res) {
                $(".loading-status").addClass("hide");
                console.log(res)
                result = res;
                return res;

            }, error: function (res) {
                $(".loading-status").addClass("hide");
                let error = `
            <div class="alert alert-danger alert-dismissible fade show fixed-bottom mb-4 w-25" style="z-index:1060; left:10px;">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <div class="alert-body">
                    <strong>An error has ocurred!</strong> Please try again, in a moment.
                </div>
            </div>`;
                $("body #content-alert").append(error);
                return result = "";
            }
        });
    return Promise.resolve(result)
}