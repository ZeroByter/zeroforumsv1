<?php
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/newsposts.php");
    include("../../phpscripts/logs.php");

    if(isset($_POST["id"]) && isset($_POST["title"]) && isset($_POST["text"]) && isset($_POST["canview"])){
        if(tag_has_permission(get_current_usertag(), "adminpnl_newsposts_tab")){
            $post = get_newspost_by_id($_POST["id"]);
            create_log(get_current_account()->username . " updated news post '$post->posttitle', new name '{$_POST["title"]}'");
            update_newspost($_POST["id"], $_POST["title"], $_POST["text"], $_POST["canview"]);
            echo "success";
        }else{
            echo "error:no permissions!";
        }
    }else{
        echo "error:missing information";
    }
?>
