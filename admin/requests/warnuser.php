<?php
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/navigatebar.php");
    include("../../phpscripts/logs.php");

    if(isset($_POST["id"]) && isset($_POST["reason"])){
        if(tag_has_permission(get_current_usertag(), "userspnl_warn_user")){
            add_user_warning($_POST["id"], $_POST["reason"]);
            create_log(get_current_account()->username . " issued a warning to '".get_account_by_id($_POST["id"])->username."' for '{$_POST["reason"]}'");
            echo "success";
        }else{
            echo "error:no permissions!";
        }
    }else{
        echo "error:missing information";
    }
?>
