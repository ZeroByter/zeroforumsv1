<?php
    include("../getsql.php");
    include("../usertags.php");
    include("../accounts.php");
    include("../forums.php");

    foreach(get_all_forums() as $value){
        if($value){
            if(!can_tag_do(get_current_usertag_or_default(), $value->canview)){
                continue;
            }
            $subforumsstr = "";
            foreach(get_all_subforums($value->id) as $subvalue){
                if($subvalue){
                    $lastActiveThread = get_last_thread($subvalue->id);
                    $lastThreadClass = ($lastActiveThread) ? "" : "subforum_inactive";
                    if($lastActiveThread){
                        $lastThreadOP = get_account_by_id($lastActiveThread->poster);
                        $lastThreadOPName = get_account_display_name($lastThreadOP->id);
                    }
                    $lastThreadHTML = ($lastActiveThread) ? "<a href='thread?id=$lastActiveThread->id'>$lastActiveThread->name<br></a><a href='profile?id=$lastThreadOP->id'>$lastThreadOPName</a>" : "No activity";
                    $hiddenText = ($lastActiveThread && $lastActiveThread->hidden) ? "<span class='label label-info'><span class='glyphicon glyphicon-eye-close'></span></span>" : "";
                    $lockedText = ($lastActiveThread && $lastActiveThread->locked) ? "<span class='label label-info'><span class='glyphicon glyphicon-lock'></span></span>" : "";
                    $pinnedText = ($lastActiveThread && $lastActiveThread->pinned) ? "<span class='label label-info'><span class='glyphicon glyphicon-pushpin'></span></span>" : "";
                    $subforumsstr = $subforumsstr . "
                        <a href='/subforum?id=$subvalue->id'><div class='subforum_div'>
                            <table>
                                <tr>
                                    <td class='exempt_base'><div class='subforum_name'>
                                        $hiddenText $lockedText $pinnedText $subvalue->name<br><font style='padding-left:6px;color:grey;font-size:12px;'>$subvalue->posttext</font></div><div class='subforum_activity $lastThreadClass'>$lastThreadHTML</div>
                                    </td>
                                </tr>
                            </table>
                        </div></a>
                    ";
                }
            }

            echo "
                <div class='panel panel-default'>
                    <div class='panel-heading'>
                        <h3 class='panel-title'><b>$value->name</b></h3>
                        <h3 class='panel-title' style='color:grey;'>$value->posttext</h3>
                    </div>
                    <div class='panel-body forumbody_div'>
                        $subforumsstr
                    </div>
                </div>
            ";
        }
    }
?>
