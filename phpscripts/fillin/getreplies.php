<?
    include("../getsql.php");
    include("../accounts.php");
    include("../forums.php");

    if($_GET["id"]){
        $allReplies = get_all_replies($_GET["id"]);
        foreach($allReplies as $value){
            if($value){
                $displayname = get_account_display_name($value->poster);
                $numthreads = get_account_by_id($value->poster)->posts;
                echo "
                    <div class='panel panel-default'>
                        <div class='panel-body'>
                            <div id='thread_poster_div'>
                                <a href='#'>$displayname</a><br>
                                $numthreads posts<br>
                            </div>
                            <div style='float:left;'>
                                $value->posttext
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
