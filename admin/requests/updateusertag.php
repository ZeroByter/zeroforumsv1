<?
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/navigatebar.php");
    include("../../phpscripts/logs.php");

    if(isset($_POST["id"]) && isset($_POST["name"]) && isset($_POST["listorder"]) && isset($_POST["isstaff"])){
        // TODO: Make sure user has permissions to do this!
        $usertag = get_usertag_by_id($_POST["id"]);
        create_log(get_current_account()->username . " updated usertag '$usertag->name' with new properties: name = '".$_POST["name"]."'");
        edit_usertag($_POST["id"], $_POST["name"], get_usertag_by_id($_POST["id"])->permissionstring, $_POST["listorder"], ($_POST["isstaff"] === "true") ? true : false);
        echo "success";
    }else{
        echo "error:missing information";
    }
?>
