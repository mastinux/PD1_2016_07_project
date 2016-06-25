<?php
    include 'global_settings.php';
    include 'global_functions.php';

    switch($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // request is not post
        redirect_with_message("auth_login.php", $message="Register action must be with post method.");
    case 'POST':
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password_repeated = $_POST['password-repeated'];
        break;
    }

    if ( !(isset($email) and isset($password) and isset($password_repeated)) ) {
        // request does not contain email or password or password_repeated
        redirect_with_message("auth_login.php", $message="Email or password not set in post method.");
    }
    else{
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $username = substr($email, 0, strpos($email, "@"));
            if ( strcmp($password, $password_repeated) == 0){
                // valid email and password
                $connection = connect_to_database();

                $sql_statement = "insert into theater_user(email, pw, username) values('$email',md5('$password'),'$username')";
                echo $sql_statement;
                if ( !mysqli_query($connection, $sql_statement) ){
                    echo mysqli_error($connection);
                }
                $connection->close();

                session_start();
                $_SESSION['231826_user'] = $username;
                $_SESSION['time'] = time();
                redirect_with_message("index.php", $message="Logged in.");
            }
            else{
                // passwords mismatch
                redirect_with_message("auth_login.php", $message="Password inserted do not match.");
            }
        }
        else{
            // invalid email
            redirect_with_message("auth_login.php", $message="Invalid email.");
        }
    }
?>