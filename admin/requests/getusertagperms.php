<?php
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/essentials.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");

    if(isset($_GET["id"])){
        echo get_usertag_permissions_stacked($_GET["id"]);
    }else{
        echo "error:no information given!";
    }
?>
