<?php

    function sanitizeString($var) {
        $var = strip_tags($var);
        $var = htmlentities($var);
        $var = stripcslashes($var);
        return $var;
    }

?>