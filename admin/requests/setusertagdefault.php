<?
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/navigatebar.php");

    if(isset($_POST["id"])){
        // TODO: Make sure user has permissions to do this!
        make_usertag_default($_POST["id"]);
        echo "success";
    }else{
        echo "error:missing information";
    }
?>
