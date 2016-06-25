<?php

    include 'global_functions.php';

    switch($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            redirect_with_message("auth_login.php", "e", "Login action must be with post method.");
        case 'POST':
            $username = $_POST['username'];
            $password = $_POST['password'];
            break;
    }

    if ( !(($username != "") and ($password != "")) ) {
        // invalid request
        redirect_with_message("auth_login.php", "e", "Email or password not inserted.");
    }
    else{
        // valid request
        $connection = connect_to_database();

        // username and password validation
        $username = mysqli_real_escape_string($connection, $username);
        $password = mysqli_real_escape_string($connection, $password);

        $sql_statement = "select * from theater_user where email = '$username' and pw = md5('$password')";

        if ( !($result = mysqli_query($connection, $sql_statement)) ){
            redirect_with_message("", "e", mysqli_error($connection));
        }
        $connection->close();

        if ( $result->num_rows == 1){
            session_start();
            $_SESSION['231826_user'] = $username;
            $_SESSION['time'] = time();
            check_and_store_booked_seats($username);
            redirect_with_message("index.php", "s", "Logged in.");
        }
        else{
            destroy_user_session();
            redirect_with_message("auth_login.php", "e", "Invalid username or password inserted");
        }
    }
?>
