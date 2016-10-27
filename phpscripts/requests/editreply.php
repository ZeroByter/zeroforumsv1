<?php
    include("../getsql.php");
    include("../accounts.php");
    include("../usertags.php");
    include("../forums.php");
    include("../logs.php");

    if(isset($_POST["id"]) && isset($_POST["body"])){
        $reply = get_forum_by_id($_POST["id"]);
        if($reply->id){
            $currenttag = get_current_usertag();
            if($reply->poster == get_current_account()->id || tag_has_permission(get_current_usertag(), "forums_editothers")){
                create_log(get_current_account()->username . " edited '".get_account_by_id($thread->poster)->username."'s reply");
                reply_edit($_POST["id"], $_POST["body"]);
                update_user_lastactive(get_current_account()->id);
                echo "success";
            }else{
                echo "error:no permissions!";
            }
        }else{
            echo "error:Invalid thread!";
        }
    }else{
        echo "error:no parent supplied!";
    }
?>
