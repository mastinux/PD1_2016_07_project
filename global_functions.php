<?php
    include 'global_settings.php';

    function print_success_message($message){
        return "<div class=\"alert alert-success alert-dismissible\" role=\"alert\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                    <span aria-hidden=\"true\">&times;</span>
                </button>".$message."
              </div>";
    }

    function print_info_message($message){
        return "<div class=\"alert alert-info alert-dismissible\" role=\"alert\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                    <span aria-hidden=\"true\">&times;</span>
                </button>".$message."
              </div>";
    }

    function print_warning_message($message){
        return "<div class=\"alert alert-warning alert-dismissible\" role=\"alert\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                    <span aria-hidden=\"true\">&times;</span>
                </button>".$message."
              </div>";
    }

    function print_danger_message($message){
        return "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                    <span aria-hidden=\"true\">&times;</span>
                </button>".$message."
              </div>";
    }

    function manage_messages(){
        if (isset($_REQUEST['smsg'])){
            $smsg = $_REQUEST['smsg'];
            echo "<div class='col-lg-12'>", print_success_message($smsg),"</div>";
        }
        if (isset($_REQUEST['imsg'])){
            $imsg = $_REQUEST['imsg'];
            echo "<div class='col-lg-12'>", print_info_message($imsg),"</div>";
        }
        if (isset($_REQUEST['wmsg'])){
            $wmsg = $_REQUEST['wmsg'];
            echo "<div class='col-lg-12'>", print_warning_message($wmsg),"</div>";
        }
        if (isset($_REQUEST['emsg'])){
            $emsg = $_REQUEST['emsg'];
            echo "<div class='col-lg-12'>", print_danger_message($emsg),"</div>";
        }
    }

    function set_https(){
        if ($_SERVER["HTTPS"] != "on") {
            header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
            exit();
        }
    }

    function unset_https(){
        if(isset($_SERVER["HTTPS"])){
            if($_SERVER["HTTPS"] == "on") {
                header("Location: http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
                exit();
            }
        }
    }

    function connect_to_database(){
        $connection = mysqli_connect(db_host, db_user, db_password, db_database);

        if ( mysqli_connect_error() ){
            redirect_with_message("", "e", "Error during connection to DB");
        }

        return $connection;
    }

    function get_non_user_taken_seat($username){
        $connection = connect_to_database();

        $sql_statement = "select * from theater_booked_seat where username != '$username'";

        if ( !($result = mysqli_query($connection, $sql_statement)) ){
            redirect_with_message("", "e", mysqli_error($connection));
        }

        $connection->close();

        return $result;

    }

    function get_user_taken_seat($username){
        $connection = connect_to_database();

        $sql_statement = "select * from theater_booked_seat where username = '$username'";

        if ( !($result = mysqli_query($connection, $sql_statement)) ){
            redirect_with_message("", "e", mysqli_error($connection));
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

    function store_to_book_seats($username, $seats){
        $connection = connect_to_database();

        try {
            mysqli_autocommit($connection,false);

            foreach ($seats as $s) {
                $row = $s['row'];
                $col = $s['col'];
                $sql_statement = "insert into theater_booked_seat(cln, rwn, username) values('$col','$row','$username')";

                if (!mysqli_query($connection, $sql_statement)) {
                    redirect_with_message("index.php", "w", "Selected seats are already taken.");
                    //throw new Exception("query: '", $sql_statement, "' failed");
                }
            }
            if (!mysqli_commit($connection)) {
                throw Exception("Commit fails");
            }

        } catch (Exception $e) {
            mysqli_rollback($connection);
            redirect_with_message("index.php", "e", $e->getMessage());
            //echo "Rollback ".$e->getMessage();
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

                if (!mysqli_query($connection, $sql_statement)) {
                    redirect_with_message("index.php", "w", "query: ".$sql_statement." failed");
                    //throw new Exception("query: '", $sql_statement, "' failed");
                }
            }
            if (!mysqli_commit($connection)) {
                throw Exception("Commit fails");
            }

        } catch (Exception $e) {
            mysqli_rollback($connection);
            redirect_with_message("index.php", "e", $e->getMessage());
            //echo "Rollback ".$e->getMessage();
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

    function redirect_with_message($page, $message_type, $message){
        header("HTTP/1.1 307 temporary redirect");
        $head = "Location: ".$page;
        /*
        if ($_SERVER['HTTPS'] == "off")
            $head = "Location: http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        else
            $head = "Location: ".$page;
        */
        echo $head;
        if (!((empty($message_type) || empty($message)))){
            $head = $head."?".$message_type."msg=".urlencode($message);
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