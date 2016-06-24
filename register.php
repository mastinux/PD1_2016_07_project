<?php
    switch($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        header('HTTP/1.1 307 temporary redirect');
        header('Location: login.php');
        exit;
    case 'POST':
        $username = $_POST['email'];
        $password = $_POST['password'];
        $password_repeated = $_POST['password-repeated'];
        break;
    }

    if (isset($username) and isset($password) and isset($password_repeated)) {
        echo $username, "\n", $password, "\n", $password_repeated;
    }
    else{
        header('HTTP/1.1 307 temporary redirect');
        header('Location: login.php');
        exit;
    }
?>