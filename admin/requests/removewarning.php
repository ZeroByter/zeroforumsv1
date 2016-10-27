<?php
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/navigatebar.php");
    include("../../phpscripts/logs.php");
    
    if(isset($_POST["userid"]) && isset($_POST["warningid"])){
        if(tag_has_permission(get_current_usertag(), "userspnl_remove_warning")){
            $warnings = get_user_warnings($_POST["userid"]);
            foreach($warnings as $key=>$value){
                if($key == $_POST["warningid"]){
                    unset($warnings[$key]);
                }
            }

            $warningsArray = json_encode($warnings);
            $conn = sql_connect();
    		mysqli_query($conn, "UPDATE accounts SET warnings='$warningsArray' WHERE id='{$_POST["userid"]}'");
    		mysqli_close($conn);
            echo "success";
        }else{
            echo "error:no permission!";
        }
    }else{
        echo "error:missing information";
    }
?>
