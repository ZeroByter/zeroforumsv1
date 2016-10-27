<?php
    include("../getsql.php");
    include("../accounts.php");
    include("../forums.php");
    include("../usertags.php");
    include("../essentials.php");

    if($_GET["id"]){
        $allReplies = get_all_replies($_GET["id"]);
        foreach($allReplies as $value){
            if($value){
                $displayname = get_account_display_name($value->poster);
                $numthreads = get_account_by_id($value->poster)->posts;
                $reply_actions_str = "<span><a href='/editreply?id=$value->id'><span class='fa fa-edit'></span> Edit</a> <a href='javascript:void(0)' data-id='$value->id' class='delete_reply'><span class='fa fa-eraser'></span> Delete</a></span>";
                if(isset(get_current_account()->id)){
                    if($value->poster == get_current_account()->id || tag_has_permission(get_current_usertag(), "forums_editothers")){

                    }else{
                        $reply_actions_str = "";
                    }
                    if($value->poster != get_current_account()->id){
                        $reply_actions_str = $reply_actions_str . " <span><a class='reply2reply_link' data-id='$value->id' href='javascript:void(0)'><span class='fa fa-mail-reply'></span> Reply";
                    }
                }else{
                    $reply_actions_str = "";
                }
                $lastedited_string = "";
                if($value->lastedited > $value->firstposted){
                    $editorDisplayName = get_account_display_name($value->lastediteduser);
                    $lastedited_string = " | Last edited on " . timestamp_to_date($value->lastedited, true) . " by $editorDisplayName";
                }
                $replyto_string = "";
                if($value->name != ""){
                    $reply2reply = get_forum_by_id($value->name);
                    if(isset($reply2reply->id)){
                        if($value->parent == $reply2reply->parent){
                            $replyto_string = "
                                <div class='reply2reply_main_div'><div class='reply2reply_title_div'>".get_account_display_name($reply2reply->poster)." posted:</div><div class='reply2repy_body_div'>".filterXSS($reply2reply->posttext)."</div></div>
                            "; //no new lines in this string format because otherwise they get auto formatted into <br>s
                        }
                    }
                }
                echo "
                    <div class='panel panel-default'>
                        <div class='panel-body thread_main_body_div'>
                            <div id='thread_poster_div'>
                                <a href='profile?id=$value->poster'>$displayname</a><br>
                                $numthreads posts<br>
                            </div>
                            <div class='thread_reply_div' style='float:left;'>
                                ".$replyto_string.filterXSS($value->posttext)."
                                <span class='thread_posted_date'><br>Posted ".timestamp_to_date($value->firstposted, true)." $lastedited_string</span>
                            </div>
                            <div class='reply_actions_div'>
                                $reply_actions_str
                            </div>
                        </div>
                    </div>
                ";
            }
        }
        if(count($allReplies) == 1){
            echo "<center style='color:grey;'>There are no replies here yet</center>";
        }
    }
?>

<script>
$(".thread_reply_div").each(function(i, v){
    $(v).html(filter_bbcode($(v).html()))
})

$(".delete_reply").click(function(){
    $.post("/admin/requests/reply_delete", {id: $(this).data("id")}, function(html){
        $.get("/phpscripts/fillin/getreplies", {url: window.location.pathname, id: $("#getid").data("id")}, function(content){
            $("#fillin_replies").html(content)
        })
    })
})

$(".reply2reply_link").click(function(){
    window.location = "/postreplytoreply?id=" + $(this).data("id")
})
</script>
