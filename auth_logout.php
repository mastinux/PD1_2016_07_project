<?php
    include 'functions.php';

    set_https();
    check_enabled_cookies();
    session_start();
    destroy_user_session();

    redirect_with_message("index.php", "i", "Logged out.");
?>