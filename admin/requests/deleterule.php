<?
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/rules.php");
    include("../../phpscripts/logs.php");

    if(isset($_POST["id"])){
        if(tag_has_permission(get_current_usertag(), "rulespnl_create_rule")){
            $rule = get_rule_by_id($_POST["id"]);
            create_log(get_current_account()->username . " deleted the rule '$rule->text'");
            delete_rule($_POST["id"]);
            echo "success";
        }else{
            echo "error:no permissions";
        }
    }else{
        echo "error:missing information";
    }
?>
