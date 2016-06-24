<?php
    switch($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            header('HTTP/1.1 307 temporary redirect');
            header('Location: login.php');
            exit;
        case 'POST':
            $username = $_POST['username'];
            $password = $_POST['password'];
            break;
    }

    if (isset($username) and isset($password)) {
        echo $username, "\n", $password;
    }
    else{
        header('HTTP/1.1 307 temporary redirect');
        header('Location: login.php');
        exit;
    }
?>
