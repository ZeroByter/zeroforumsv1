<?
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/navigatebar.php");

    if(isset($_POST["id"])){
        // TODO: Make sure user has permissions to do this!
        if(get_navlink_by_id($_POST["id"])->candelete){
            remove_navbar_link($_POST["id"]);
            echo "success";
        }else{
            echo "error:cant delete this link!";
        }
    }else{
        echo "error:missing information";
    }
?>
