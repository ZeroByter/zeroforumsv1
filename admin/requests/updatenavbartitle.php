<?
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/navigatebar.php");
    include("../../phpscripts/logs.php");

    if(isset($_POST["title"])){
        // TODO: Make sure user has permissions to do this!
        $navlink = get_navlink_by_id($_POST["id"]);
        create_log(get_current_account()->username . " updated the navigation bar title to '" . $_POST["title"] . "'");
        set_navbar_title($_POST["title"]);
        echo "success";
    }else{
        echo "error:missing information";
    }
?>
