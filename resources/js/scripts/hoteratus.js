function activeTable(cellData, action) {
    if (cellData == 1) {
        return '<td><span class="chip lighten-5 green green-text"><a onclick="' + action + '">Active</a></span></td>';
    }
    return '<td><span class="chip lighten-5 red red-text"><a onclick="' + action + '">Deactivated</a></span></td>';
}

function buttonsTable(show, edit, deleted) {

    var row = '<td> <div class="invoice-action" style="display: flex;">';

    if (show != '') {
        row += '<a href="' + show + '" class="invoice-action-view mr-6"> <i class="material-icons">remove_red_eye</i> </a>';
    }
    if (edit != '') {
        row += '<a href="' + edit + '" class="invoice-action-edit mr-6" > <i class="material-icons">edit</i> </a>';
    }
    if (deleted != '') {
        row += '<a href="' + deleted + '" class="invoice-action-edit" > <i class="material-icons">delete</i> </a>';
    }
    row += '</div></td>';
    return row;
}

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 46 && charCode != 44)
        return false;
    return true;
}