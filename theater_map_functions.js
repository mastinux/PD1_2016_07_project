var Seat = function(r, c, s) {
    this.row = r;
    this.col = c;
    this.status = s;
};

var toBookObjects;
var toReleaseObjects;

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

function deleteCookie(name) {
    document.cookie = name + '=;expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}

function removeElementById(id) {
    var element = document.getElementById(id);
    element.parentNode.removeChild(element);
}

function printCookieDisabledMessage(){
    document.write( "<div class='col-lg-12'>" +
                        "<div class=\"alert alert-warning\" role=\"alert\">" +
                            "Cookies are disabled. Please enable them to use this site." +
                        "</div>" +
                    "</div>");
}

function initTheaterMap(cols, rows){
    toBookObjects = [];
    toReleaseObjects = [];

    var div = document.getElementById("theater-map");

    var table = document.createElement("table");
    table.setAttribute("id", "theater-map-table");
    table.setAttribute("class", "table");
    div.appendChild(table);

    for (var i = 0; i < rows; i++){
        var row = table.insertRow(i);
        for (var j = 0; j < cols; j++){
            var cell = row.insertCell(j);

            var span = document.createElement("span");
            span.setAttribute("id", ("seat-" + i + "-" + j));
            span.setAttribute("class", "label label-default seat free lrg visible");
            span.setAttribute("onclick", "selectSeat(this)");
            span.innerHTML = (i + 1) + "-" + (j + 1);
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
    document.getElementById("taken-seats").innerHTML = (takenN + seats.length).toString();

    var freeN =  parseInt(document.getElementById("free-seats").innerHTML);
    document.getElementById("free-seats").innerHTML = (freeN - seats.length).toString();
}

function setBookedSeats(seats) {
    for (var i = 0; i< seats.length; i++){
        var id = "seat-"+ seats[i]['rwn'] + "-" + seats[i]['cln'];
        var seat = document.getElementById(id);
        seat.setAttribute("class", seat.getAttribute("class").replace("free", "booked"));
    }

    var bookedSeats = document.getElementById("booked-seats");
    if (bookedSeats){
        var bookedN = parseInt(bookedSeats.innerHTML);
        document.getElementById("booked-seats").innerHTML = (bookedN + seats.length).toString();
    }

    var freeN =  parseInt(document.getElementById("free-seats").innerHTML);
    document.getElementById("free-seats").innerHTML = (freeN - seats.length).toString();

    var takenN =  parseInt(document.getElementById("taken-seats").innerHTML);
    document.getElementById("taken-seats").innerHTML = (takenN + seats.length).toString();
}

function setToBookSeats(alreadyTakenSeats){
    var c = getCookie("toBook");

    if (c == "")
        return;

    toBookObjects = JSON.parse(getCookie("toBook"));

    // in case previous book action fails
    for (var i = 0; i< alreadyTakenSeats.length; i++){
        var row = alreadyTakenSeats[i]['rwn'];
        var col = alreadyTakenSeats[i]['cln'];

        toBookObjects = toBookObjects.filter(
            function (obj){
                return !(obj.row == row && obj.col == col);
            }
        );
    }

    for (var i = 0; i < toBookObjects.length; i++){
        var id = "seat-"+ toBookObjects[i]['row'] + "-" + toBookObjects[i]['col'];
        var seat = document.getElementById(id);
        seat.setAttribute("class", seat.getAttribute("class").replace("free", "selected"));
    }

    var selectedN = parseInt(document.getElementById("selected-seats").innerHTML);
    document.getElementById("selected-seats").innerHTML = (selectedN + toBookObjects.length).toString();

    var freeN = parseInt(document.getElementById("free-seats").innerHTML);
    document.getElementById("free-seats").innerHTML = (freeN - toBookObjects.length).toString();

    console.log(toBookObjects);
}

function selectSeat(seat) {
    var status = seat.getAttribute("class");

    if (status.indexOf("taken") >= 0)
        return;

    var id = seat.getAttribute("id");
    var col_row = id.replace("seat-", "").split("-");
    var row = col_row[0];
    var col = col_row[1];

    var span_selected = document.getElementById("selected-seats");
    var selectedN = parseInt(span_selected.innerHTML, 10);

    var span_free = document.getElementById("free-seats");
    var freeN = parseInt(span_free.innerHTML, 10);

    if (status.indexOf("selected") >= 0) {
        seat.setAttribute("class", seat.getAttribute("class").replace("selected", "free"));
        selectedN = selectedN - 1;
        freeN = freeN + 1;

        // removing seat from toBookObjects
        toBookObjects = toBookObjects.filter(
            function (obj){
                return !(obj.row == row && obj.col == col);
            }
        );
    }
    else if(status.indexOf("free") >= 0) {
        seat.setAttribute("class", seat.getAttribute("class").replace("free", "selected"));
        selectedN = selectedN + 1;
        freeN = freeN - 1;

        // adding seat to toBookObjects
        toBookObjects.push(new Seat(row, col, "selected"));
    }
    else if(status.indexOf("booked") >= 0){
        seat.setAttribute("class", seat.getAttribute("class").replace("booked", "canceled"));
        freeN = freeN + 1;

        // adding seat to toReleaseObjects
        toReleaseObjects.push(new Seat(row, col, "free"));
    }

    else if(status.indexOf("canceled") >= 0){
        seat.setAttribute("class", seat.getAttribute("class").replace("canceled", "booked"));

        // removing seat from toBookObjects
        toReleaseObjects = toReleaseObjects.filter(
            function (obj){
                return !(obj.row == row && obj.col == col);
            }
        );
    }
    
    span_selected.innerHTML = selectedN;
    span_free.innerHTML = freeN;
}

function clearSelectedSeats() {
    var seats = document.getElementsByTagName("span");

    for (var i = 0; i < seats.length; i++) {
        if ( seats[i].getAttribute("class") )
            if ( (seats[i]).getAttribute("class").indexOf("seat") >= 0 ) {
                if ((seats[i]).getAttribute("class").indexOf("selected") >= 0) {
                    (seats[i]).setAttribute("class", (seats[i]).getAttribute("class").replace("selected", "free"));
                }
                if ((seats[i]).getAttribute("class").indexOf("canceled") >= 0) {
                    (seats[i]).setAttribute("class", (seats[i]).getAttribute("class").replace("canceled", "booked"));
                }
            }
    }

    toBookObjects = [];
    deleteCookie("toBook");

    toReleaseObjects = [];

    var span_selected = document.getElementById("selected-seats");
    var selected_seats = parseInt(span_selected.innerHTML, 10);

    var span_free = document.getElementById("free-seats");
    var free_seats = parseInt(span_free.innerHTML, 10);

    span_selected.innerHTML = 0;
    span_free.innerHTML = free_seats + selected_seats;
}

function releaseSelectedSeats() {
    if (toReleaseObjects.length == 0)
        return false;
    document.cookie = "toCancel=" + JSON.stringify(toReleaseObjects);
    window.location.replace("auth_login.php");
}

function bookSelectedSeats() {
    if (toBookObjects.length == 0)
        return false;
    document.cookie = "toBook=" + JSON.stringify(toBookObjects);
    window.location.replace("auth_login.php");
}