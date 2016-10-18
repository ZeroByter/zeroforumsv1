<?
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/navigatebar.php");
    include("../../phpscripts/logs.php");

    if(isset($_POST["name"]) && isset($_POST["listorder"]) && isset($_POST["isstaff"])){
        if(tag_has_permission(get_current_usertag(), "usertagpnl_create_usertag")){
            add_usertag($_POST["name"], ";", $_POST["listorder"], false, $_POST["isstaff"]);
            create_log(get_current_account()->username . " created the usertag '".$_POST["name"]."'");
            echo "success";
        }else{
            echo "error:no permissions";
        }
    }else{
        echo "error:missing information";
    }
?>
