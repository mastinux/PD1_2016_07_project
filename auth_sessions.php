<?php

    $t=time();
    $diff=0;
    $new=false;

    if (isset($_SESSION['231826_time'])){
        $t0=$_SESSION['231826_time'];
        $diff=($t-$t0);  // inactivity period
    } else {
        $new=true;
    }

    if ($new || ($diff > SESSION_TIMEOUT)) { // new or with inactivity period too long
        $_SESSION=array();
        // If it's desired to kill the session, also delete the session cookie.
        // Note: This will destroy the session, and not just the session data!
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 60*60*24,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]);
        }
        session_destroy();  // destroy session
        // redirect client to login page
        redirect_with_message("auth_login.php", "w", "Session time out.");
        exit; // IMPORTANT to avoid further output from the script
    } else {
        $_SESSION['231826_time']=time(); /* update time */
    }

?>