<?
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/navigatebar.php");
    include("../../phpscripts/logs.php");

    if(isset($_POST["id"])){
        // TODO: Make sure user has permissions to do this!
        $usertag = get_usertag_by_id($_POST["id"]);
        make_usertag_default($_POST["id"]);
        create_log(get_current_account()->username . " made the usertag '$usertag->name' the default usertag");
        echo "success";
    }else{
        echo "error:missing information";
    }
?>
