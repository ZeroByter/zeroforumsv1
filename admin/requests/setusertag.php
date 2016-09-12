<?
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/essentials.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/logs.php");

    if(isset($_POST["userid"]) && isset($_POST["usertagid"])){
        $userid = $_POST["userid"];
        $usertagid = $_POST["usertagid"];
        // TODO: Make sure current account has sufficicent permissions
        assign_usertag($userid, $usertagid);
        create_log(get_account_display_name(get_current_account()->id) . " assigned " . get_account_display_name($userid) . " to usertag '" . get_usertag_by_id($usertagid)->name . "'");
        echo "success";
    }else{
        echo "error:no information given!";
    }
?>
