<?php
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/navigatebar.php");
    include("../../phpscripts/forums.php");
?>

<style>
    #forum_main_div{
        width: 80%;
        margin: 30px auto;
    }

    .input-group{
        margin: 4px 0px;
    }
</style>

<div id="forum_main_div" class="panel panel-default">
    <div class="panel-body">
        <div class="input-group">
            <span class="input-group-addon">Name</span>
            <input type="text" class="form-control" id="forum_name_in" value="">
        </div>
        <div class="input-group">
            <span class="input-group-addon">Description</span>
            <input type="text" class="form-control" id="forum_posttext_in" value="">
        </div>
        <div class="input-group">
            <span class="input-group-addon">The list order</span>
            <input type="number" class="form-control" id="forum_listorder_in" value="1">
        </div><br>
        <button type="button" class="btn btn-success" style="width:100%;" id="create_forum">Create forum</button>
    </div>
</div>

<script>
    var name = ""
    var posttext = ""
    var listorder = ""

    $("#forum_name_in").bind("change keyup", function(){
        name = $("#forum_name_in").val()
    })
    $("#forum_posttext_in").bind("change keyup", function(){
        posttext = $("#forum_posttext_in").val()
    })
    $("#forum_listorder_in").bind("change keyup", function(){
        listorder = $("#forum_listorder_in").val()
    })
    $("#create_forum").click(function(){
        $.post("/admin/requests/createforum", {name: name, posttext: posttext, listorder: listorder}, function(html){
            console.log(html)
            $("#fillin_forums").html("")
            redo_forums_list()
        })
    })
</script>
