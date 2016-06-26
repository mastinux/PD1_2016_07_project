<?php
    include 'global_settings.php';
    include 'global_functions.php';
    set_https();

    switch($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // request is not post
        redirect_with_message("auth_login.php", "e", "Register action must be with post method.");
        break;
    case 'POST':
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password_repeated = $_POST['password-repeated'];
        break;
    }

    if ( !(isset($email) and isset($password) and isset($password_repeated)) ) {
        // request does not contain email or password or password_repeated
        redirect_with_message("auth_login.php", "e", "Email or password not set in post method.");
    }
    else{
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $username = $email;
            if ( strcmp($password, $password_repeated) == 0){
                // valid email and password
                $connection = connect_to_database();
                
                $sql_statement = "insert into theater_user(email, pw) values('$email',md5('$password'))";
                
                if ( !mysqli_query($connection, $sql_statement) ){
                    redirect_with_message("", "e", mysqli_error($connection));
                }
                $connection->close();

                session_start();
                $_SESSION['231826_user'] = $username;
                $_SESSION['time'] = time();
                check_and_store_to_book_seats($username);
                redirect_with_message("index.php", "s", "Registered and logged in.");
            }
            else{
                // passwords mismatch
                redirect_with_message("auth_login.php", "e", "Password inserted do not match.");
            }
        }
        else{
            // invalid email
            redirect_with_message("auth_login.php", "e", "Invalid email.");
        }
    }
?>