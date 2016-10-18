<?
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/navigatebar.php");
    include("../../phpscripts/forums.php");
    include("../../phpscripts/logs.php");

    if(isset($_POST["name"]) && isset($_POST["posttext"]) && isset($_POST["listorder"])){
        if(tag_has_permission(get_current_usertag(), "forumspnl_create_forum")){
            forums_create_forum($_POST["name"], $_POST["posttext"], $_POST["listorder"], $canview="all;", $canpost="all;", $canedit="all;");
            echo "success";
        }else{
            echo "error:no permissions!";
        }
    }else{
        echo "error:missing information";
    }
?>
