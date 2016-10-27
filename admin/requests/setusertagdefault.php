<?php
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/navigatebar.php");
    include("../../phpscripts/logs.php");

    if(isset($_POST["id"])){
        if(tag_has_permission(get_current_usertag(), "usertagpnl_create_usertag")){
            $usertag = get_usertag_by_id($_POST["id"]);
            make_usertag_default($_POST["id"]);
            create_log(get_current_account()->username . " made the usertag '$usertag->name' the default usertag");
            echo "success";
        }else{
            echo "error: no permissions!";
        }
    }else{
        echo "error:missing information";
    }
?>
