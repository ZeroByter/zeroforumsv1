<?
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/essentials.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/forums.php");

    if(isset($_GET["id"]) && isset($_GET["type"])){
        echo get_forums_can_perms($_GET["id"], $_GET["type"]);
    }else{
        echo "error:no information given!";
    }
?>
