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
    div.appendChild(table)

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
    var col_row = id.replace("seat-", "").split("-")
    var col = col_row[0];
    var row = col_row[1];

    var status = seat.getAttribute("class");
    if (status == "selected") {
        seat.setAttribute("class", "free")
    }
    else {
        seat.setAttribute("class", "selected");
    }

}