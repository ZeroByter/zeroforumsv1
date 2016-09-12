<div class="panel" style="border-color:#6033b7;">
    <div class="panel-heading" style="background:#6033b7;color:white;">All the latest threads</div>
    <div class="panel-body" style='padding:4px;'>
        <?
            include("../getsql.php");
            include("../accounts.php");
            include("../forums.php");
            include("../essentials.php");

            $lastestThreads = get_lastest_threads();
            if(count($lastestThreads) != 1){
                foreach($lastestThreads as $value){
                    if($value){
                        $hiddenText = ($value->hidden) ? "<span class='label label-info'><span class='glyphicon glyphicon-eye-close'></span></span>" : "";
                        $lockedText = ($value->locked) ? "<span class='label label-info'><span class='glyphicon glyphicon-lock'></span></span>" : "";
                        $pinnedText = ($value->pinned) ? "<span class='label label-info'><span class='glyphicon glyphicon-pushpin'></span></span>" : "";
                        echo "
                            <a href='thread?id=$value->id'><div style='font-size:13px;margin:6px;'>
                                <div><b>$hiddenText $pinnedText $lockedText $value->name</b></div>
                                <div>" . get_human_time($value->lastactive) . " by " . get_account_display_name($value->poster) . "</div>
                                <a href='/subforum?id=$value->parent'><div>" . get_forum_by_id($value->parent)->name . "</div></a>
                            </div></a>
                        ";
                    }
                }
            }else{
                echo "<center style='margin-bottom:7px;margin-top:5px;'><span class='label label-danger'>There is no activity</span></center>";
            }
        ?>
    </div>
</div>
