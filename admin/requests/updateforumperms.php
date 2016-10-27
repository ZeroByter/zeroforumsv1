<?php
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/essentials.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/forums.php");
    include("../../phpscripts/logs.php");

    if(isset($_POST["id"]) && isset($_POST["type"]) && isset($_POST["permissions"])){
        if(tag_has_permission(get_current_usertag(), "forumspnl_create_forum")){
            set_forums_can_perms($_POST["id"], $_POST["type"], $_POST["permissions"]);
            echo "success";
        }else{
            echo "error: no permissions!";
        }
    }else{
        echo "error:no information given!";
    }
?>
