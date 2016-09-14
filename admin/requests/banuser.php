<?
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/navigatebar.php");
    include("../../phpscripts/logs.php");

    if(isset($_POST["id"]) && isset($_POST["reason"]) && isset($_POST["time"])){
        // TODO: Make sure user has permissions to do this!
        issue_user_ban($_POST["id"], $_POST["reason"], $_POST["time"]);
        echo "success";
    }else{
        echo "error:missing information";
    }
?>
