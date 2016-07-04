<?php

    function sanitizeString($var) {
        $var = strip_tags($var);
        $var = htmlentities($var);
        $var = stripcslashes($var);
        return $var;
    }

    function connect_to_database() {
        $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

        try{
            if ( mysqli_connect_error() ) {
                throw new Exception("Error during connection to DB");
            }
        }
        catch(Exception $e){
            echo $e->getMessage();
        }

        return $connection;
    }

    function get_non_user_taken_seat($username){
        $rows = Array();

        $connection = connect_to_database();

        $username = sanitizeString($username);
        $username = mysqli_real_escape_string($connection, $username);

        $sql_statement = "select * from theater_booked_seat where username != '$username'";

        try{
            if ( !($result = mysqli_query($connection, $sql_statement)) )
                throw new Exception("Query '" . $sql_statement . "' failed.");
        }catch (Exception $e){
            echo $e->getMessage();
        }

        while ($row = mysqli_fetch_assoc($result))
                $rows[] = $row;

        mysqli_free_result($result);
        mysqli_close($connection);

        return $rows;
    }

    function get_user_taken_seat($username){
        $rows = Array();

        $connection = connect_to_database();

        $username = sanitizeString($username);
        $username = mysqli_real_escape_string($connection, $username);

        $sql_statement = "select * from theater_booked_seat where username = '$username'";

        try{
            if ( !($result = mysqli_query($connection, $sql_statement)) )
                throw new Exception("Query '" . $sql_statement . "' failed.");
        }catch(Exception $e){
            echo $e->getMessage();
        }

        while ($row = mysqli_fetch_assoc($result))
            $rows[] = $row;

        mysqli_free_result($result);
        mysqli_close($connection);

        return $rows;
    }

    function format_as_json($rows){
        return json_encode($rows);
    }

    function store_to_book_seats($username, $seats){
        $completed_transaction = true;
        $connection = connect_to_database();

        $username = sanitizeString($username);
        $username = mysqli_real_escape_string($connection, $username);

        try {
            mysqli_autocommit($connection,false);

            foreach ($seats as $s) {
                $row = $s['row'];
                $col = $s['col'];
                $sql_statement = "insert into theater_booked_seat(cln, rwn, username) values('$col','$row','$username')";

                if (!mysqli_query($connection, $sql_statement))
                    throw new Exception("Query '" . $sql_statement . "' failed.");
            }
            if (!mysqli_commit($connection))
                throw new Exception("Commit failed.");
        } catch (Exception $e) {
            mysqli_rollback($connection);
            $completed_transaction = false;
            //echo $e->getMessage();
        }

        mysqli_close($connection);

        if( !$completed_transaction )
            redirect_with_message("index.php", "d", "Selected seats already taken.");
    }

    function store_to_cancel_seats($username, $seats){
        $completed_transaction = true;
        $connection = connect_to_database();

        $username = sanitizeString($username);
        $username = mysqli_real_escape_string($connection, $username);

        try {
            mysqli_autocommit($connection,false);

            foreach ($seats as $s) {
                $row = $s['row'];
                $col = $s['col'];
                $sql_statement = "delete from theater_booked_seat where cln='$col' and rwn='$row' and username='$username'";

                if (!mysqli_query($connection, $sql_statement)) {
                    throw new Exception("Query '" . $sql_statement . "' failed.");
                }
            }
            if ( !mysqli_commit($connection) ){
                throw new Exception("Commit failed");
            }
        }
        catch (Exception $e){
            mysqli_rollback($connection);
            $completed_transaction = false;
            //echo $e->getMessage();
        }

        mysqli_close($connection);

        if( !$completed_transaction ){
            redirect_with_message("index.php", "d", "Selected seats have not been booked by you.");
        }
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