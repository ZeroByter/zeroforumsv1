<?
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/navigatebar.php");

    if(isset($_POST["id"]) && isset($_POST["name"]) && isset($_POST["listorder"]) && isset($_POST["isstaff"])){
        // TODO: Make sure user has permissions to do this!
        edit_usertag($_POST["id"], $_POST["name"], get_usertag_by_id($_POST["id"]->permissionstring), $_POST["listorder"], $_POST["isstaff"]);
        echo "success";
    }else{
        echo "error:missing information";
    }
?>
