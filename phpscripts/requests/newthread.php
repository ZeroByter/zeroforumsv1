<?
    include("../getsql.php");
    include("../accounts.php");
    include("../usertags.php");
    include("../forums.php");
    include("../logs.php");

    if(isset($_POST["parent"]) && isset($_POST["subject"]) && isset($_POST["body"])){
        $parent = get_forum_by_id($_POST["parent"]);
        if($parent->id){
            $currenttag = get_current_usertag();
            $account = get_current_account();
            if(can_tag_do($currenttag, $parent->canpost)){
                if(tag_has_permission($currenttag, "forums_createthread")){
                    $newid = forums_create_thread($parent->id, $_POST["subject"], $_POST["body"]);
                    create_log($account->username . " posted a thread with subject '".$_POST["subject"]."' and body '".$_POST["body"]."'");
                    add_user_posts($account->id);
                    forums_update_lastactive(get_current_account()->id);
                    forums_update_lastactive($parent->id);
                    echo $newid;
                }else{
                    echo "error:You don't have permission to post a reply!";
                }
            }else{
                echo "error:You can't post a thread here!";
            }
        }else{
            echo "error:Invalid subforum!";
        }
    }else{
        echo "error:no parent supplied!";
    }
?>
