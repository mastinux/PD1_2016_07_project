<?php

    include 'functions.php';
    include 'functions_database.php';
    
    set_https();
    check_enabled_cookies();

    switch($_SERVER['REQUEST_METHOD']) {
        case 'GET': {
            redirect_with_message("auth_login.php", "w", "Login action must be with post method.");
            break;
        }
        case 'POST': {
            if ( !isset($_POST['username']) || !isset($_POST['password']) )
                redirect_with_message("auth_login.php", "w", "Email or password not set in login form.");
            $username = $_POST['username'];
            $password = $_POST['password'];
            break;
        }
    }
 
    if ( $username == ""  || $password == "") {
        redirect_with_message("auth_login.php", "w", "Email or password not inserted in login form.");
    }
    else{
        if ( filter_var($username, FILTER_VALIDATE_EMAIL) ) {
            // valid email
            $username = sanitizeString($username);
            $password = sanitizeString($password);

            $connection = connect_to_database();

            $username = mysqli_real_escape_string($connection, $username);
            $password = mysqli_real_escape_string($connection, $password);

            $sql_statement = "select * from theater_user where email = '$username' and pw = md5('$password')";

            try {
                if (!($result = mysqli_query($connection, $sql_statement)))
                    throw new Exception("query '" . $sql_statement . "' failed.");
            } catch (Exception $e) {
                echo $e->getMessage();
            }

            $rows = $result->num_rows;
            mysqli_free_result($result);
            mysqli_close($connection);

            if ($rows == 1) {
                session_start();
                $_SESSION['231826_user'] = $username;
                $_SESSION['231826_time'] = time();
                check_and_store_to_book_seats($username);
                check_and_store_to_cancel_seats($username);
                redirect_with_message("index.php", "s", "Logged in as " . $username . ".");
            } else {
                redirect_with_message("auth_login.php", "d", "Invalid username or password inserted in login form.");
            }
        }
        else{
            // invalid email
            redirect_with_message("auth_login.php", "d", "Invalid email inserted in login form.");
        }
    }
?>
