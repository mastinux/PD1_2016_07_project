var Seat = function(r, c, s) {
    this.row = r;
    this.col = c;
    this.status = s;
    console.log("created seat:", this.row, " ", this.col, " ", this.status, "\n");
};

var selectedObjects;

function getCookie(name) {
    var name = name + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length,c.length);
        }
    }
    return "";
}

function initTheaterMap(b, h){
    selectedObjects = Array();
    var div = document.getElementById("theater-map");

    var table = document.createElement("table");
    table.setAttribute("id", "theater-map-table");
    table.setAttribute("class", "table");
    div.appendChild(table);

    for (var i = 0; i < h; i++){
        var row = table.insertRow(i);
        for (var j = 0; j < b; j++){
            var cell = row.insertCell(j);

            var span = document.createElement("span");
            span.setAttribute("id", ("seat-" + i + "-" + j));
            span.setAttribute("class", "label label-default seat free");
            span.setAttribute("onclick", "selectSeat(this)");
            span.innerHTML = "seat-" + (i + 1) + "-" + (j + 1);
            cell.appendChild(span);
        }
    }
}

function setTakenSeats(seats){
    for (var i = 0; i< seats.length; i++){
        var id = "seat-"+ seats[i]['rwn'] + "-" + seats[i]['cln'];
        var seat = document.getElementById(id);
        seat.setAttribute("class", seat.getAttribute("class").replace("free", "taken"));
    }

    var takenN =  parseInt(document.getElementById("taken-seats").innerHTML);
    document.getElementById("taken-seats").innerHTML = takenN + seats.length;

    var freeN =  parseInt(document.getElementById("free-seats").innerHTML);
    document.getElementById("free-seats").innerHTML = freeN - seats.length;
}

function setBookedSeats(seats) {
    for (var i = 0; i< seats.length; i++){
        var id = "seat-"+ seats[i]['rwn'] + "-" + seats[i]['cln'];
        var seat = document.getElementById(id);
        seat.setAttribute("class", seat.getAttribute("class").replace("free", "booked"));
    }

    var bookedN = parseInt(document.getElementById("booked-seats").innerHTML);
    document.getElementById("booked-seats").innerHTML = bookedN + seats.length;

    var freeN =  parseInt(document.getElementById("free-seats").innerHTML);
    document.getElementById("free-seats").innerHTML = freeN - seats.length;

    var takenN =  parseInt(document.getElementById("taken-seats").innerHTML);
    document.getElementById("taken-seats").innerHTML = takenN + seats.length;
}

function selectSeat(seat) {
    var status = seat.getAttribute("class");

    console.log(status);
    console.log(status.indexOf("booked"));
    console.log(status.indexOf("taken"));
    if ( (status.indexOf("booked") >= 0) || (status.indexOf("taken") >= 0)){
        return;
    }

    var id = seat.getAttribute("id");
    var col_row = id.replace("seat-", "").split("-");
    var row = col_row[0];
    var col = col_row[1];

    console.log(row, col);

    var span_selected = document.getElementById("selected-seats");
    var selected_seats = parseInt(span_selected.innerHTML, 10);

    var span_free = document.getElementById("free-seats");
    var free_seats = parseInt(span_free.innerHTML, 10);

    if (status.indexOf("selected") >= 0) {

        console.log("selected");
        console.log(seat.getAttribute("class"));

        seat.setAttribute("class", seat.getAttribute("class").replace("selected", "free"));
        selected_seats = selected_seats - 1;
        free_seats = free_seats + 1;

        selectedObjects = selectedObjects.filter(
            function (obj){
                return !(obj.row == row && obj.col == col);
            }
        );
    }
    else {
        console.log("non-selected");
        seat.setAttribute("class", seat.getAttribute("class").replace("free", "selected"));
        selected_seats = selected_seats + 1;
        free_seats = free_seats - 1;
        selectedObjects.push(new Seat(row, col, "selected"));
    }

    span_selected.innerHTML = selected_seats;
    span_free.innerHTML = free_seats;
}

function clearSelectedSeats() {
    var seats = document.getElementsByTagName("span");
    for (var i = 0; i < seats.length; i++) {
        var seat = seats[i];
        if( seat.getAttribute("class").indexOf("seat selected") >= 0){
            seat.setAttribute("class", seat.getAttribute("class").replace("selected", "free"));

            selectedObjects = Array();

        }
    }

    var span_selected = document.getElementById("selected-seats");
    var selected_seats = parseInt(span_selected.innerHTML, 10);

    var span_free = document.getElementById("free-seats");
    var free_seats = parseInt(span_free.innerHTML, 10);

    span_selected.innerHTML = 0;
    span_free.innerHTML = free_seats + selected_seats;
}

function bookSeats() {
    if (selectedObjects.length == 0)
        return false;
    document.cookie = "selected=" + JSON.stringify(selectedObjects);
    window.location.replace("auth_login.php");
}