<div class="panel panel-default" style="margin-top:18px;">
    <div class="panel-heading">Sub-forums</div>
    <div class="panel-body" style="padding:0px;">
        <?
        include("../getsql.php");
        include("../accounts.php");
        include("../usertags.php");
        include("../forums.php");

        foreach(get_all_subforums($_GET["id"]) as $value){
            if($value){
                $lastActiveThread = get_last_thread($value->id);
                $lastThreadClass = ($lastActiveThread) ? "" : "subforum_inactive";
                if($lastActiveThread){
                    $lastThreadOP = get_account_by_id($lastActiveThread->poster);
                    $lastThreadOPName = get_account_display_name($lastThreadOP->id);
                }
                $lastThreadHTML = ($lastActiveThread) ? "<a href='thread?id=$lastActiveThread->id'>$lastActiveThread->name</a><br><a href='#'>$lastThreadOPName</a>" : "No activity";
                $hiddenText = ($lastActiveThread && $lastActiveThread->hidden) ? "<span class='label label-info'><span class='glyphicon glyphicon-eye-close'></span></span>" : "";
                $lockedText = ($lastActiveThread && $lastActiveThread->locked) ? "<span class='label label-info'><span class='glyphicon glyphicon-lock'></span></span>" : "";
                $pinnedText = ($lastActiveThread && $lastActiveThread->pinned) ? "<span class='label label-info'><span class='glyphicon glyphicon-pushpin'></span></span>" : "";
                echo "
                    <a href='/subforum?id=$value->id'><div class='subforum_div'>
                        <table>
                            <tr>
                            <td class='exempt_base'><div class='subforum_name'>
                                $value->name<br><font style='padding-left:6px;color:grey;font-size:12px;'>$value->posttext</font></div><div class='subforum_activity $lastThreadClass'>$hiddenText $lockedText $pinnedText $lastThreadHTML</div>
                            </td>
                            </tr>
                        </table>
                    </div></a>
                ";
            }
        }
        ?>
    </div>
</div>
