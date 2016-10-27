<?php
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/navigatebar.php");
    include("../../phpscripts/forums.php");
    include("../../phpscripts/logs.php");

    if(isset($_POST["id"]) && isset($_POST["name"]) && isset($_POST["posttext"]) && isset($_POST["listorder"])){
        if(tag_has_permission(get_current_usertag(), "forumspnl_create_forum")){
            forum_edit($_POST["id"], $_POST["name"], $_POST["posttext"], $_POST["listorder"]);
            echo "success";
        }else{
            echo "error: no permissions!";
        }
    }else{
        echo "error:missing information";
    }
?>
