var selectedSeat;
var seatObjects;

function  initObjects(n, m) {
    selectedSeat = new Object();

    seatObjects = new Array(n);

    for (var i=0; i<n; i++) {
        seatObjects[i] = new Array(m);
        for (var j=0; j<m; j++)
            seatObjects[i][j] = new Object();
    }
}

function initTheaterMap(b, h){
    initObjects(b, h);
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

function selectSeat(seat) {
    var id = seat.getAttribute("id");
    var col_row = id.replace("seat-", "").split("-");
    var col = col_row[0];
    var row = col_row[1];

    var span_selected = document.getElementById("selected-seats");
    var selected_seats = parseInt(span_selected.innerHTML, 10);

    var span_free = document.getElementById("free-seats");
    var free_seats = parseInt(span_free.innerHTML, 10);

    var status = seat.getAttribute("class");
    if (status == "selected") {
        seat.setAttribute("class", "free");
        selected_seats = selected_seats - 1;
        free_seats = free_seats + 1;
    }
    else {
        seat.setAttribute("class", "selected");
        selected_seats = selected_seats + 1;
        free_seats = free_seats - 1;
    }
    span_selected.innerHTML = selected_seats;
    span_free.innerHTML = free_seats;


}

function clearBookedSeats() {
    var seats = document.getElementsByTagName("td");
    for (var i = 0; i < seats.length; i++) {
        if( seats[i].getAttribute("class") == "selected"){
            seats[i].setAttribute("class", "free");
        }
    }

    var span_selected = document.getElementById("selected-seats");
    var selected_seats = parseInt(span_selected.innerHTML, 10);

    var span_free = document.getElementById("free-seats");
    var free_seats = parseInt(span_free.innerHTML, 10);

    span_selected.innerHTML = 0;
    span_free.innerHTML = free_seats + selected_seats;
}