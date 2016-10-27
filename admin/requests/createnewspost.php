<?php
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/navigatebar.php");
    include("../../phpscripts/newsposts.php");
    include("../../phpscripts/logs.php");

    if(isset($_POST["title"]) && isset($_POST["text"]) && isset($_POST["canview"])){
        if(tag_has_permission(get_current_usertag(), "newspnl_create_post")){
            newsposts_create_newspost($_POST["title"], $_POST["text"], $_POST["canview"]);
            create_log(get_current_account()->username . " posted a new news post with title '{$_POST["title"]}' and text '{$_POST["text"]}'");
            echo "success";
        }else{
            echo "error:no permissions";
        }
    }else{
        echo "error:missing information";
    }
?>
