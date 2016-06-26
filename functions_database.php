<?php

function connect_to_database(){
    $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, db_database);

    try{
        if ( mysqli_connect_error() )
            throw new Exception("Error during connection to DB");
    }
    catch(Exception $e){
        echo $e->getMessage();
    }

    return $connection;
}

function get_non_user_taken_seat($username){
    $connection = connect_to_database();
    $sql_statement = "select * from theater_booked_seat where username != '$username'";

    try{
        if ( !($result = mysqli_query($connection, $sql_statement)) )
            throw new Exception("query '" . $sql_statement . "' failed.");
    }catch (Exception $e){
        echo $e->getMessage();
    }

    $connection->close();
    return $result;
}

function get_user_taken_seat($username){
    $connection = connect_to_database();
    $sql_statement = "select * from theater_booked_seat where username = '$username'";

    try{
        if ( !($result = mysqli_query($connection, $sql_statement)) )
            throw new Exception("query '" . $sql_statement . "' failed.");
    }catch(Exception $e){
        echo $e->getMessage();
    }

    $connection->close();
    return $result;
}

function format_as_json($result){
    $rows = array();

    while ($row = mysqli_fetch_assoc($result))
        $rows[] = $row;

    return json_encode($rows);
}

function store_to_book_seats($username, $seats){
    $connection = connect_to_database();

    try {
        mysqli_autocommit($connection,false);

        foreach ($seats as $s) {
            $row = $s['row'];
            $col = $s['col'];
            $sql_statement = "insert into theater_booked_seat(cln, rwn, username) values('$col','$row','$username')";

            if (!mysqli_query($connection, $sql_statement))
                throw new Exception("query '" . $sql_statement . "' failed.");
        }
        if (!mysqli_commit($connection))
            throw Exception("Commit fails");
    } catch (Exception $e) {
        mysqli_rollback($connection);
        echo $e->getMessage();
    }

    $connection->close();
}

function store_to_cancel_seats($username, $seats){
    $connection = connect_to_database();

    try {
        mysqli_autocommit($connection,false);

        foreach ($seats as $s) {
            $row = $s['row'];
            $col = $s['col'];
            $sql_statement = "delete from theater_booked_seat where cln='$col' and rwn='$row' and username='$username'";

            if (!mysqli_query($connection, $sql_statement))
                throw new Exception("query '" . $sql_statement . "' failed.");
        }
        if ( !mysqli_commit($connection) )
            throw Exception("Commit fails");
    } catch (Exception $e) {
        mysqli_rollback($connection);
        echo $e->getMessage();
    }

    $connection->close();

}

function check_and_store_to_book_seats($username){
    if ( isset($_COOKIE['toBook']) ){
        $to_book_seats = json_decode($_COOKIE['toBook'], true);
        store_to_book_seats($username, $to_book_seats);
        setcookie("toBook", "", time()-60*60);
        redirect_with_message("index.php", "s", "Selected seats have been booked.");
    }
}

function check_and_store_to_cancel_seats($username){
    if ( isset($_COOKIE['toCancel']) ){
        $to_cancel_seats = json_decode($_COOKIE['toCancel'], true);
        store_to_cancel_seats($username, $to_cancel_seats);
        setcookie("toCancel", "", time()-60*60);
        redirect_with_message("index.php", "s", "Selected booked seats have been canceled.");
    }
}

?>