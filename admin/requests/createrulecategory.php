<?php
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/rules.php");
    include("../../phpscripts/logs.php");

    if(isset($_POST["name"]) && isset($_POST["listorder"])){
        if(tag_has_permission(get_current_usertag(), "rulespnl_create_rule")){
            create_new_rules_category($_POST["name"], $_POST["listorder"]);
            create_log(get_current_account()->username . " created the rule category '".$_POST["name"]."'");
            echo "success";
        }else{
            echo "error:no permissions";
        }
    }else{
        echo "error:missing information";
    }
?>
