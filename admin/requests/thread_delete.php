<?php
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/forums.php");
    include("../../phpscripts/logs.php");

    if(isset($_POST["id"])){
        $thread = get_forum_by_id($_POST["id"]);
        $currAccount = get_current_account();
        if($thread->poster == $currAccount->id || tag_has_permission(get_current_usertag(), "forums_editothers")){
            if($thread->poster == $currAccount->id && tag_has_permission(get_current_usertag(), "forums_deletepost")){
                thread_delete($_POST["id"]);
                echo "success";
            }else{
                echo "error:no permission!";
            }
        }else{
            echo "error:no permission!";
        }
    }else{
        echo "error:missing information";
    }
?>
