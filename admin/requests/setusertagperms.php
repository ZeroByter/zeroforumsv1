<?
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/essentials.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");

    if(isset($_POST["usertag"]) && isset($_POST["permissions"])){
        // TODO: Make sure current account has sufficicent permissions
        update_usertag_permissions($_POST["usertag"], $_POST["permissions"]);
    }else{
        echo "error:no information given!";
    }
?>
