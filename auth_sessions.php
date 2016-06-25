<?php
    include 'global_settings.php';

    session_start();
    $t=time();
    $diff=0;
    $new=false;

    if (isset($_SESSION['time'])){
        $t0=$_SESSION['time'];
        $diff=($t-$t0);  // inactivity period
    } else {
        $new=true;
    }

    if ($new || ($diff > session_timeout)) { // new or with inactivity period too long
        //session_unset(); 	// Deprecated
        $_SESSION=array();
        // If it's desired to kill the session, also delete the session cookie.
        // Note: This will destroy the session, and not just the session data!
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 3600*24,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();  // destroy session
        // redirect client to login page
        //header('HTTP/1.1 307 temporary redirect');
        //header('Location: auth_login.php');
        exit; // IMPORTANT to avoid further output from the script
    } else {
        $_SESSION['time']=time(); /* update time */
    }

?>