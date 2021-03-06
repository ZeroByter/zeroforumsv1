<?php
    include("../getsql.php");
    include("../usertags.php");
    include("../accounts.php");
    include("../forums.php");

    $allThreads = get_all_pinned_threads($_GET["id"]);

    if(count($allThreads) > 1){
        echo "
            <br><div class='panel panel-default'>
                <div class='panel-heading'>Pinned threads</div>
                <div class='panel-body' style='padding-top:0px;'>
        ";
    }

    foreach($allThreads as $key => $value){
        if($value){
            if($value->hidden){
                continue;
            }
            $parent = get_forum_by_id($value->parent);
            if(!can_tag_do(get_current_usertag_or_default(), $parent->canview)){
                continue;
            }
            $posterName = get_account_display_name($value->poster);
            $replies = count(get_all_replies($value->id)) - 1;
            $views = 0;
            $lockedText = ($value->locked) ? "<span class='label label-info'><span class='glyphicon glyphicon-lock'></span> Locked</span>" : "";
            $pinnedText = ($value->pinned) ? "<span class='label label-info'><span class='glyphicon glyphicon-pushpin'></span> Pinned</span>" : "";
            echo "
            <a href='thread?id=$value->id'><div class='panel panel-default thread_div' style='margin-bottom:0px;margin-top:18px;'>
                <table>
                    <tr>
                        <td class='exempt_base'>
                            <div class='thread_name'>$pinnedText $lockedText $value->name</div>
                            <div class='thread_stats_secondary'>Replies: $replies<br>Views: $views</div>
                            <div class='thread_stats'>Posted by: $posterName</div>
                        </td>
                    </tr>
                </table>
            </div></a>
            ";
        }
    }

    if(count($allThreads) > 1){
        echo "
                </div>
            </div>
        ";
    }
?>
