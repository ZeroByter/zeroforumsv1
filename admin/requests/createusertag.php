<?
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/navigatebar.php");

    if(isset($_POST["name"]) && isset($_POST["listorder"]) && isset($_POST["isstaff"])){
        // TODO: Make sure user has permissions to do this!
        add_usertag($_POST["name"], ";", $_POST["listorder"], false, $_POST["isstaff"]);
        echo "success";
    }else{
        echo "error:missing information";
    }
?>
