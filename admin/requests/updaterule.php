<?php
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/rules.php");
    include("../../phpscripts/logs.php");

    if(isset($_POST["id"]) && isset($_POST["text"]) && isset($_POST["listorder"])){
        if(tag_has_permission(get_current_usertag(), "adminpnl_rules_tab")){
            $rule = get_rule_by_id($_POST["id"]);
            create_log(get_current_account()->username . " updated rule '$rule->text' to '".$_POST["text"]."'");
            edit_rule($_POST["id"], $_POST["text"], $_POST["listorder"]);
            echo "success";
        }else{
            echo "error:no permissions!";
        }
    }else{
        echo "error:missing information";
    }
?>
