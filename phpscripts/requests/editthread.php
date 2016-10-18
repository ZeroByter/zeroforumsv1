<?
    include("../getsql.php");
    include("../accounts.php");
    include("../usertags.php");
    include("../forums.php");
    include("../logs.php");

    if(isset($_POST["id"]) && isset($_POST["subject"]) && isset($_POST["body"])){
        $thread = get_forum_by_id($_POST["id"]);
        if($thread->id){
            $currenttag = get_current_usertag();
            if($thread->poster == get_current_account()->id || tag_has_permission(get_current_usertag(), "forums_editothers")){
                thread_edit($_POST["id"], $_POST["subject"], $_POST["body"]);
                update_user_lastactive(get_current_account()->id);
                echo "success";
            }else{
                echo "error:no permissions!";
            }
        }else{
            echo "error:Invalid subforum!";
        }
    }else{
        echo "error:no parent supplied!";
    }
?>
