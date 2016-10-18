<?
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/forums.php");
    include("../../phpscripts/logs.php");

    if(isset($_POST["id"])){
        $thread = get_forum_by_id($_POST["id"]);
        if($thread->poster == get_current_account()->id || tag_has_permission(get_current_usertag(), "forums_editothers")){
            thread_delete($_POST["id"]);
            $postername = get_account_display_name($thread->poster);
            create_log(get_current_account()->username . " deleted $postername's reply");
            echo "success";
        }else{
            echo "error:no permission!";
        }
    }else{
        echo "error:missing information";
    }
?>
