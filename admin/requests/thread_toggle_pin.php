<?
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/forums.php");
    include("../../phpscripts/logs.php");

    if(isset($_POST["id"])){
        if(tag_has_permission(get_current_usertag(), "forums_threadpinunpin")){
            thread_toggle_pin($_POST["id"]);
            $thread = get_forum_by_id($_POST["id"]);
            if($thread->pinned){
                create_log(get_current_account()->username . " pinned the thread '$thread->name'");
            }else{
                create_log(get_current_account()->username . " unpinned the thread '$thread->name'");
            }
            echo "success";
        }else{
            echo "error:no permission!";
        }
    }else{
        echo "error:missing information";
    }
?>
