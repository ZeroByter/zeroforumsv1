<?
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/navigatebar.php");

    if(isset($_POST["id"]) && isset($_POST["text"]) && isset($_POST["link"]) && isset($_POST["listorder"]) && isset($_POST["canview"])){
        // TODO: Make sure user has permissions to do this!
        if(get_navlink_by_id($_POST["id"])->canedit){
            update_navbar_link($_POST["id"], $_POST["text"], $_POST["link"], $_POST["canview"], $_POST["listorder"]);
            echo "success";
        }else{
            echo "error:cant edit this link!";
        }
    }else{
        echo "error:missing information";
    }
?>
