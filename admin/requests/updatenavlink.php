<?php
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/navigatebar.php");
    include("../../phpscripts/logs.php");

    if(isset($_POST["id"]) && isset($_POST["text"]) && isset($_POST["link"]) && isset($_POST["listorder"]) && isset($_POST["canview"])){
        if(tag_has_permission(get_current_usertag(), "navigatepnl_create_new_link")){
            $navlink = get_navlink_by_id($_POST["id"]);
            if($navlink->canedit){
                create_log(get_current_account()->username . " updated navigation link '$navlink->text' with new properties: text = '".$_POST["text"]."', link = '".$_POST["link"]."'");
                update_navbar_link($_POST["id"], $_POST["text"], $_POST["link"], $_POST["canview"], $_POST["listorder"]);
                echo "success";
            }else{
                echo "error:cant edit this link!";
            }
        }else{
            echo "error: no permissions!";
        }
    }else{
        echo "error:missing information";
    }
?>
