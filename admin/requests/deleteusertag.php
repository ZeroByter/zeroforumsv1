<?
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/navigatebar.php");

    if(isset($_POST["id"])){
        // TODO: Make sure user has permissions to do this!
        if(get_usertag_by_id($_POST["id"])->isdefault){
            echo "error:cant delete default usertag! link!";
        }else{
            delete_usertag($_POST["id"]);
            kick_all_users_from_usertag($_POST["id"]);
            echo "success";
        }
    }else{
        echo "error:missing information";
    }
?>
