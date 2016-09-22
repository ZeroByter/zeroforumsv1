<?
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/forums.php");
    include("../../phpscripts/logs.php");

    if(isset($_POST["id"])){
        if(tag_has_permission(get_current_usertag(), "forums_threadlockunlock")){
            thread_toggle_lock($_POST["id"]);
            echo "success";
        }else{
            echo "error:no permission!";
        }
    }else{
        echo "error:missing information";
    }
?>
