<?php
    include 'global_functions.php';

    session_start();
    destroy_user_session();

    redirect_with_message("index.php", "Logged out.");
?>