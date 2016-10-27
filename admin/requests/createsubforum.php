<?php
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/navigatebar.php");
    include("../../phpscripts/forums.php");
    include("../../phpscripts/logs.php");

    if(isset($_POST["parent"]) && isset($_POST["name"]) && isset($_POST["posttext"]) && isset($_POST["listorder"])){
        if(tag_has_permission(get_current_usertag(), "forumspnl_create_forum")){
            forums_create_subforum($_POST["parent"], $_POST["name"], $_POST["posttext"], $_POST["listorder"], $canview="all;", $canpost="all;", $canedit="all;");
            create_log(get_current_account()->username . " created subforum '{$_POST["name"]}' under forum '".get_forum_by_id($_POST["parent"])->name."'");
            echo "success";
        }else{
            echo "error:no permissions!";
        }
    }else{
        echo "error:missing information";
    }
?>
