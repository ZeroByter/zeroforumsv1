<?php
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/essentials.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/rules.php");

    if(!tag_has_permission(get_current_usertag(), "adminpnl_rules_tab")){
        echo "<script>window.close()</script>";
    }
?>

<style>
    #rules_list_div{
        width: 150px;
        height: calc(100% - 42px);
        border-right: 1px solid #dddddd;
        float: left;
    }

    .rules_list_item_div, .rules_fake_list_item_div{
        text-align: left;
        padding: 10px;
        padding-left: 30px;
    }
    .rule_category_list_item_div{
        border-top: 1px solid #ddd;
    }
    .rule_category_list_item_div, .rule_category_fake_list_item_div{
        text-align: left;
        padding: 10px;
        padding-left: 15px;
    }
    .rule_category_list_item_div, .rules_list_item_div, .rule_category_fake_list_item_div, .rules_fake_list_item_div{
        text-align: left;
        cursor: pointer;
    }
    .rule_category_list_item_div:hover, .rules_list_item_div:hover, .rules_fake_list_item_div:hover, .rule_category_fake_list_item_div:hover, .row_active{
        background: #dddddd;
    }

    #rules_main_div{
        width: calc(100% - 150px);
        float: left;
        margin: 15px auto;
    }

    #rules_main_panel_div{
        width: 80%;
        margin: 30px auto;
    }

    .input-group{
        margin: 4px 0px;
    }
</style>

<div id="rules_list_div">
    <center><br><span class="glyphicon glyphicon-list"></span> Rules</center>
    <br>
    <div class='rule_category_fake_list_item_div' id="create_new_rule_category" style="color: green;">Create a new rule category</div>
    <span id="fillin_ruleslist"></div>
</div>
<div id="rules_main_div">
    <div id="users_actions_div">
    </div>
    <span id="fillin_rules"></div>
</div>

<script>
    var selectedRule
    function redo_rules_panel(){
        $.get("/admin/fillin/getrulefillin", {id: $(selectedRule).data("id")}, function(html){
            $("#fillin_rules").html(html)
        })
    }

    function redo_rules_list(active){
        if(active){
            $.get("fillin/getruleslist", {active: active}, function(html){
                $("#fillin_ruleslist").html(html)
            })
        }else{
            $.get("fillin/getruleslist", function(html){
                $("#fillin_ruleslist").html(html)
            })
        }
    }
    redo_rules_list()

    $("#create_new_rule_category").click(function(){
        $.get("/admin/fillin/getcreaterulecategory", function(html){
            $("#fillin_rules").html(html)
            $(".rule_category_list_item_div").removeClass("row_active")
            $(".rule_list_item_div").removeClass("row_active")
        })
    })
</script>
