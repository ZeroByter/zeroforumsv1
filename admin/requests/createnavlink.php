<?
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/navigatebar.php");
    include("../../phpscripts/logs.php");

    if(isset($_POST["text"]) && isset($_POST["link"]) && isset($_POST["listorder"]) && isset($_POST["canview"])){
        // TODO: Make sure user has permissions to do this!
        add_navbar_link($_POST["text"], $_POST["link"], $_POST["listorder"], $_POST["canview"]);
        create_log(get_current_account()->username . " created the navigation link '".$_POST["text"]."' with link '".$_POST["link"]."'");
        echo "success";
    }else{
        echo "error:missing information";
    }
?>
