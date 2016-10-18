<?
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/rules.php");
    include("../../phpscripts/logs.php");

    if(isset($_POST["parent"]) && isset($_POST["text"]) && isset($_POST["listorder"])){
        if(tag_has_permission(get_current_usertag(), "rulespnl_create_rule")){
            create_new_rule($_POST["parent"], $_POST["text"], $_POST["listorder"]);
            $parent = get_rule_by_id($_POST["parent"]);
            create_log(get_current_account()->username . " created the rule '".$_POST["text"]."' under category '$parent->text'");
            echo "success";
        }else{
            echo "error:no permissions";
        }
    }else{
        echo "error:missing information";
    }
?>
