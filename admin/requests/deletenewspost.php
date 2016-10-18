<?
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/newsposts.php");
    include("../../phpscripts/logs.php");

    if(isset($_POST["id"])){
        if(tag_has_permission(get_current_usertag(), "newspnl_create_post")){
            $post = get_newspost_by_id($_POST["id"]);
            create_log(get_current_account()->username . " deleted news post '$post->posttitle'");
            delete_newspost($_POST["id"]);
            echo "success";
        }else{
            echo "error:no permissions!";
        }
    }else{
        echo "error:missing information";
    }
?>
