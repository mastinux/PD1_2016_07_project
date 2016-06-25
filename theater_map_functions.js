var Seat = function(r, c, s) {
    this.row = r;
    this.col = c;
    this.status = s;
    console.log("created seat:", this.row, " ", this.col, " ", this.status, "\n");
}

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
            
            cell.innerHTML = "seat-" + (i + 1) + "-" + (j + 1);
            cell.setAttribute("id", ("seat-" + i + "-" + j));
            cell.setAttribute("class", "free");
            cell.setAttribute("onclick", "selectSeat(this)");
        }
    }
}

function setTakenSeats(seats){
    for (var i = 0; i< seats.length; i++){
        var id = "seat-"+ seats[i]['cln'] + "-" + seats[i]['rwn'];
        document.getElementById(id).setAttribute("class", "taken");
    }
}

function setUserTakenSeats(seats) {
    for (var i = 0; i< seats.length; i++){
        var id = "seat-"+ seats[i]['cln'] + "-" + seats[i]['rwn'];
        document.getElementById(id).setAttribute("class", "booked");
    }
}

function selectSeat(seat) {
    var status = seat.getAttribute("class");

    var id = seat.getAttribute("id");
    var col_row = id.replace("seat-", "").split("-");
    var row = col_row[0];
    var col = col_row[1];

    var span_selected = document.getElementById("selected-seats");
    var selected_seats = parseInt(span_selected.innerHTML, 10);

    var span_free = document.getElementById("free-seats");
    var free_seats = parseInt(span_free.innerHTML, 10);

    if (status == "selected") {
        seat.setAttribute("class", "free");
        selected_seats = selected_seats - 1;
        free_seats = free_seats + 1;

        selectedObjects = selectedObjects.filter(
            function (obj){
                return !(obj.row == row && obj.col == col);
            }
        );
    }
    else {
        seat.setAttribute("class", "selected");
        selected_seats = selected_seats + 1;
        free_seats = free_seats - 1;
        selectedObjects.push(new Seat(row, col, "selected"));
    }

    span_selected.innerHTML = selected_seats;
    span_free.innerHTML = free_seats;
}

function clearSelectedSeats() {
    var seats = document.getElementsByTagName("td");
    for (var i = 0; i < seats.length; i++) {
        if( seats[i].getAttribute("class") == "selected"){
            seats[i].setAttribute("class", "free");

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
    document.cookie = "selected=" + JSON.stringify(selectedObjects);
    window.location.replace("auth_login.php");
}