<?
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/navigatebar.php");
    include("../../phpscripts/logs.php");

    if(isset($_POST["id"])){
        // TODO: Make sure user has permissions to do this!
        $navlink = get_navlink_by_id($_POST["id"]);
        if($navlink->candelete){
            remove_navbar_link($_POST["id"]);
            create_log(get_current_account()->username . " deleted the navigation link '$navlink->text'");
            echo "success";
        }else{
            echo "error:cant delete this link!";
        }
    }else{
        echo "error:missing information";
    }
?>
