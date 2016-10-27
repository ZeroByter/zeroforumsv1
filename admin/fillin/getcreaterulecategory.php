<?php
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/navigatebar.php");
    include("../../phpscripts/rules.php");
    include("../../phpscripts/essentials.php");
?>

<style>
    #create_rule_category_main_div{
        width: 80%;
        margin: 30px auto;
    }

    .input-group{
        margin: 4px 0px;
    }
</style>

<div id="create_rule_category_main_div" class="panel panel-default">
    <div class="panel-body">
        <form id="create_rule_category">
            <div class="input-group">
                <span class="input-group-addon">Category name</span>
                <input type="text" class="form-control" id="cat_name_in" value="" required>
            </div>
            <div class="input-group">
                <span class="input-group-addon">Category list order</span>
                <input type="number" class="form-control" id="cat_listorder_in" value="1" required>
            </div><br>
            <button type="submit" class="btn btn-success" style="width:100%;">Create new rule category</button>
        </form>
    </div>
</div>

<script>
    var name = ""
    var listorder = 1

    $("#cat_name_in").bind("change keyup", function(){
        name = $("#cat_name_in").val()
    })
    $("#cat_listorder_in").bind("change keyup", function(){
        listorder = $("#cat_listorder_in").val()
    })
    $("#create_rule_category").submit(function(){
        $.post("/admin/requests/createrulecategory", {name: name, listorder: listorder}, function(html){
            console.log(html)
            $("#fillin_rules").html("")
            redo_rules_list()
        })
        return false
    })
</script>
