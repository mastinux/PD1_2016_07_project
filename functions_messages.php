<?php

    function print_message($type, $message){
        return "<div class=\"alert alert-".$type." alert-dismissible\" role=\"alert\">
                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
                        <span aria-hidden=\"true\">&times;</span>
                    </button>".$message."
                  </div>";
    }

    function manage_messages(){
        if (isset($_REQUEST['smsg'])){
            $smsg = $_REQUEST['smsg'];
            $smsg = strip_tags($smsg);
            echo "<div class='col-lg-12'>", print_message("success", $smsg),"</div>";
        }
        else if (isset($_REQUEST['imsg'])){
            $imsg = $_REQUEST['imsg'];
            $imsg = strip_tags($imsg);
            echo "<div class='col-lg-12'>", print_message("info", $imsg),"</div>";
        }
        else if (isset($_REQUEST['wmsg'])){
            $wmsg = $_REQUEST['wmsg'];
            $wmsg = strip_tags($wmsg);
            echo "<div class='col-lg-12'>", print_message("warning", $wmsg),"</div>";
        }
        else if (isset($_REQUEST['dmsg'])){
            $dmsg = $_REQUEST['dmsg'];
            $dmsg = strip_tags($dmsg);
            echo "<div class='col-lg-12'>", print_message("danger", $dmsg),"</div>";
        }
    }

?>