function seat(r, c, s) {
    this.row = r;
    this.col = c;
    this.status = s;
}

var seatObjects; /* seat[row][col] */

function  initObjects(n, m) {
    seatObjects = new Array(n);

    for (var i=0; i<n; i++) {
        seatObjects[i] = new Array(m);
    }
}

function initTheaterMap(b, h){
    initObjects(h, b);
    var div = document.getElementById("theater-map");

    var table = document.createElement("table");
    table.setAttribute("id", "theater-map-table");
    table.setAttribute("class", "table");
    div.appendChild(table);

    for (var i = 0; i < h; i++){
        var row = table.insertRow(i);
        for (var j = 0; j < b; j++){
            var cell = row.insertCell(j);
            seatObjects[i][j] = new seat(i, j, "free");
            
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
    var row = col_row[0];
    var col = col_row[1];

    var span_selected = document.getElementById("selected-seats");
    var selected_seats = parseInt(span_selected.innerHTML, 10);

    var span_free = document.getElementById("free-seats");
    var free_seats = parseInt(span_free.innerHTML, 10);

    var status = seat.getAttribute("class");
    if (status == "selected") {
        seat.setAttribute("class", "free");
        selected_seats = selected_seats - 1;
        free_seats = free_seats + 1;
        seatObjects[row][col].status = "free" ;
    }
    else {
        seat.setAttribute("class", "selected");
        selected_seats = selected_seats + 1;
        free_seats = free_seats - 1;
        seatObjects[row][col].status = "selected";
    }

    span_selected.innerHTML = selected_seats;
    span_free.innerHTML = free_seats;
}

function clearBookedSeats() {
    var seats = document.getElementsByTagName("td");
    for (var i = 0; i < seats.length; i++) {
        if( seats[i].getAttribute("class") == "selected"){
            seats[i].setAttribute("class", "free");

            var id = seats[i].getAttribute("id");
            var col_row = id.replace("seat-", "").split("-");
            var row = col_row[0];
            var col = col_row[1];

            seatObjects[row][col].status = "free";
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
    sessionStorage.setItem("seatsObject", seatObjects);
    window.location.replace("login.php");
}