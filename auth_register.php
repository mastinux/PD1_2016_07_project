<?php
    include 'global_settings.php';
    include 'functions.php';
    include 'functions_database.php';

    set_https();
    check_enabled_cookies();

    switch($_SERVER['REQUEST_METHOD']) {
        case 'GET': {
            redirect_with_message("auth_login.php", "w", "Register action must be with post method.");
            break;
        }
        case 'POST':{
            if ( !isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['password-repeated']) )
                redirect_with_message("auth_login.php", "w", "Email or password not set in registration form.");
            $email = $_POST['email'];
            $password = $_POST['password'];
            $password_repeated = $_POST['password-repeated'];
            break;
        }
    }

    if ( $email == "" || $password == "" || $password_repeated == "" ) {
        // request does not contain email or password or password_repeated
        redirect_with_message("auth_login.php", "w", "Email or password not inserted in registration form.");
    }
    else{
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // checking unique email
            $connection = connect_to_database();
            
            $email = sanitize_string($email);
            $email = mysqli_real_escape_string($connection, $email);

            $sql_statement = "select * from theater_user where email = '$email'";

            try{
                if ( !($result = mysqli_query($connection, $sql_statement)) )
                    throw new Exception("query '" . $sql_statement . "' failed.");
            }catch (Exception $e){
                echo $e->getMessage();
            }

            $rows = $result->num_rows;
            mysqli_free_result($result);
            $connection->close();

            if ( $rows == 1)
                redirect_with_message("auth_login.php", "w", "Email already used.");

            if ( strcmp($password, $password_repeated) == 0){
                // valid email and password
                $connection = connect_to_database();

                $password = sanitize_string($password);
                $password = mysqli_real_escape_string($connection, $password);
                
                $password_repeated = sanitize_string($password_repeated);
                $password_repeated = mysqli_real_escape_string($connection, $password_repeated);

                $sql_statement = "insert into theater_user(email, pw) values('$email',md5('$password'))";

                try{
                    if ( !mysqli_query($connection, $sql_statement) )
                        throw new Exception("query '" . $sql_statement . "' failed.");
                }catch (Exception $e){
                    echo $e->getMessage();
                }

                mysqli_close($connection);

                session_start();
                $_SESSION['231826_user'] = $email;
                $_SESSION['231826_time'] = time();
                check_and_store_to_book_seats($email);
                redirect_with_message("index.php", "s", "Registered and logged in as " . $email . ".");
            }
            else{
                // passwords mismatch
                redirect_with_message("auth_login.php", "d", "Passwords inserted do not match.");
            }
        }
        else{
            // invalid email
            redirect_with_message("auth_login.php", "d", "Invalid email inserted in registration form.");
        }
    }
?>