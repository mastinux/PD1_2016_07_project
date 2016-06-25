<?php
    include 'global_settings.php';

    function connect_to_database(){
        $connection = mysqli_connect(db_host, db_user, db_password, db_database);

        if ( mysqli_connect_error() ){
            redirect_with_message("", "Error during connection to DB");
        }

        return $connection;
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