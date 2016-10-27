<?php
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/forums.php");
    include("../../phpscripts/logs.php");

    if(isset($_POST["id"])){
        if(tag_has_permission(get_current_usertag(), "forumspnl_create_forum")){
            $forum = get_forum_by_id($_POST["id"]);

            if($forum->type == "forum"){
                forum_delete($_POST["id"]);
            }elseif($forum->type == "subforum"){
                subforum_delete($_POST["id"]);
            }
            echo "success";
        }else{
            echo "error:no permissions!":
        }
    }else{
        echo "error:missing information";
    }
?>
