<?php
    include 'global_functions.php';
    set_https();
    session_start();
    destroy_user_session();
 
    redirect_with_message("index.php", "s", "Logged out.");
?>