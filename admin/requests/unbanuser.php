<?
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/navigatebar.php");
    include("../../phpscripts/logs.php");

    if(isset($_POST["id"])){
        if(tag_has_permission(get_current_usertag(), "userspnl_unban_user")){
            unban_user($_POST["id"]);
            $unbanned = get_account_by_id($_POST["id"]);
            create_log(get_current_account()->username . " unbanned '$unbanned->username'");
            echo "success";
        }else{
            echo "error:no permissions!";
        }
    }else{
        echo "error:missing information";
    }
?>
