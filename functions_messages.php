<?php

function print_success_message($message){
    return "<div class=\"alert alert-success alert-dismissible\" role=\"alert\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                    <span aria-hidden=\"true\">&times;</span>
                </button>".$message."
              </div>";
}

function print_info_message($message){
    return "<div class=\"alert alert-info alert-dismissible\" role=\"alert\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                    <span aria-hidden=\"true\">&times;</span>
                </button>".$message."
              </div>";
}

function print_warning_message($message){
    return "<div class=\"alert alert-warning alert-dismissible\" role=\"alert\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                    <span aria-hidden=\"true\">&times;</span>
                </button>".$message."
              </div>";
}

function print_danger_message($message){
    return "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                    <span aria-hidden=\"true\">&times;</span>
                </button>".$message."
              </div>";
}

function manage_messages(){
    if (isset($_REQUEST['smsg'])){
        $smsg = $_REQUEST['smsg'];
        echo "<div class='col-lg-12'>", print_success_message($smsg),"</div>";
    }
    if (isset($_REQUEST['imsg'])){
        $imsg = $_REQUEST['imsg'];
        echo "<div class='col-lg-12'>", print_info_message($imsg),"</div>";
    }
    if (isset($_REQUEST['wmsg'])){
        $wmsg = $_REQUEST['wmsg'];
        echo "<div class='col-lg-12'>", print_warning_message($wmsg),"</div>";
    }
    if (isset($_REQUEST['emsg'])){
        $emsg = $_REQUEST['emsg'];
        echo "<div class='col-lg-12'>", print_danger_message($emsg),"</div>";
    }
}

?>