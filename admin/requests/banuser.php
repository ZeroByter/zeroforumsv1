<?
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/navigatebar.php");
    include("../../phpscripts/logs.php");

    if(isset($_POST["id"]) && isset($_POST["reason"]) && isset($_POST["time"])){
        if(tag_has_permission(get_current_usertag(), "userspnl_ban_user")){
            issue_user_ban($_POST["id"], $_POST["reason"], $_POST["time"]);
            $banned = get_account_by_id($_POST["id"]);
            create_log(get_current_account()->username . " banned '$banned->username' for '".$_POST["time"]."' seconds and for reason '".$_POST["reason"]."'");
            echo "success";
        }else{
            echo "error:no permissions!";
        }
    }else{
        echo "error:missing information";
    }
?>
