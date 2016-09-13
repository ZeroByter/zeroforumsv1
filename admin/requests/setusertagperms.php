<?
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/essentials.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/logs.php");

    if(isset($_POST["usertag"]) && isset($_POST["permissions"])){
        // TODO: Make sure current account has sufficicent permissions
        update_usertag_permissions($_POST["usertag"], $_POST["permissions"]);
        $usertag = get_usertag_by_id($_POST["usertag"]);
        log_create(get_current_account()->username . " changed permissions for usertag '$usertag->name'"); // TODO: add so it also says what permission was deleted or removed
    }else{
        echo "error:no information given!";
    }
?>
