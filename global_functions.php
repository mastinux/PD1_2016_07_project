<?php
    include 'global_settings.php';

    function connect_to_database(){
        $connection = mysqli_connect(db_host, db_user, db_password, db_database);

        if ( mysqli_connect_error() ){
            redirect_with_message("", "Error during connection to DB");
        }

        return $connection;
    }

    function get_non_user_taken_seat($username){
        $connection = connect_to_database();

        $sql_statement = "select * from theater_booked_seat where username != '$username'";

        if ( !($result = mysqli_query($connection, $sql_statement)) ){
            redirect_with_message("", mysqli_error($connection));
        }

        $connection->close();

        return $result;

    }

    function get_user_taken_seat($username){
        $connection = connect_to_database();

        $sql_statement = "select * from theater_booked_seat where username = '$username'";

        if ( !($result = mysqli_query($connection, $sql_statement)) ){
            redirect_with_message("", mysqli_error($connection));
        }

        $connection->close();

        return $result;
    }

    function format_as_json($result){
        $rows = array();

        while ($row = mysqli_fetch_assoc($result)){
            $rows[] = $row;
        }

        return json_encode($rows);
    }

    function store_booked_seats($username, $seats){
        $connection = connect_to_database();

        foreach ($seats as $s) {
            $row = $s['row'];
            $col = $s['col'];
            $sql_statement = "insert into theater_booked_seat(cln, rwn, username) values('$col','$row','$username')";

            if (!mysqli_query($connection, $sql_statement)) {
                redirect_with_message("", mysqli_error($connection));
            }
        }

        $connection->close();
    }

    function check_and_store_booked_seats($username){
        if ( isset($_COOKIE['selected']) ){
            $selected_seats = json_decode($_COOKIE['selected'], true);
            store_booked_seats($username, $selected_seats);
            setcookie("selected", "", time()-60*60);
            redirect_with_message("index.php", "Selected seats have been booked.");
        }
    }

    function redirect_with_message($page = "/", $message = ""){
        header("HTTP/1.1 307 temporary redirect");
        $head = "Location: ".$page;
        if (!empty($message)){
            $head = $head."?msg=".urlencode($message);
        }
        header($head);
        exit;
    }

    function user_logged_in() {
        if (isset($_SESSION['231826_user'])) {
            return $_SESSION['231826_user'];
        } else {
            return false;
        }
    }

    function destroy_user_session() {
        $_SESSION=array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time()-3600*24,
                $params["path"],$params["domain"],
                $params["secure"], $params["httponly"]);
        }
        session_destroy(); // destroy session
    }
?>