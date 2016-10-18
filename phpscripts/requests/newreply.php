<?
    include("../getsql.php");
    include("../accounts.php");
    include("../usertags.php");
    include("../forums.php");
    include("../logs.php");

    $thread = $_POST["id"];
    $text = $_POST["text"];

    if(isset($thread)){
        $thread = get_forum_by_id($thread);
        if($thread->id){
            $parent = get_forum_by_id($thread->parent);
            $currenttag = get_current_usertag();
            $account = get_current_account();
            if(can_tag_do($currenttag, $parent->canpost)){
                if(tag_has_permission($currenttag, "forums_createreply")){
                    forums_create_reply($thread->id, $text);
                    create_log($account->username . " posted a reply on '$thread->name' -> '$parent->name' with text '$text'");
                    forums_update_lastactive($thread->id);
                    forums_update_lastactive($parent->id);
                    add_user_posts($account->id);
                    echo "success";
                }else{
                    echo "error:You don't have permission to post a reply!";
                }
            }else{
                echo "error:You can't post a reply here!";
            }
        }else{
            echo "error:Invalid thread!";
        }
    }else{
        echo "error:no parent supplied!";
    }
?>
