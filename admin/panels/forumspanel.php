<?php
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/essentials.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/forums.php");

    if(!tag_has_permission(get_current_usertag(), "adminpnl_users_tab")){
        echo "<script>window.close()</script>";
    }
?>

<style>
    #forums_list_div{
        width: 200px;
        height: calc(100% - 42px);
        border-right: 1px solid #dddddd;
        float: left;
    }

    .forum_parent_div{
        border-top: 1px solid #dddddd;
    }

    .forum_list_div, .forum_fake_list_div{
        text-align: left;
        cursor: pointer;
        padding: 10px;
        padding-left: 15px;
    }
    .subforum_list_div, .subforum_fake_list_div{
        text-align: left;
        cursor: pointer;
        padding: 10px;
        padding-left: 30px;
    }
    .forum_list_div:hover, .forum_fake_list_div:hover, .subforum_list_div:hover, .subforum_fake_list_div:hover, .row_active{
        background: #dddddd;
    }

    #forums_main_div{
        float: left;
        height: calc(100% - 42px);
        width: calc(100% - 200px);
    }
</style>

<div id="forums_list_div">
    <center><br><span class="fa fa-comments"></span> Forums</center>
    <br>
    <span id="fillin_forums_list"></span>
</div>
<div id="forums_main_div">
    <span id="fillin_forums"></span>
</div>

<script>
    var selectedForumItem = undefined

    function redo_forums_list(active){
        if(active){
            $.get("fillin/getforumslist", {active: active}, function(html){
                $("#fillin_forums_list").html(html)
            })
        }else{
            $.get("fillin/getforumslist", function(html){
                $("#fillin_forums_list").html(html)
            })
        }
    }
    redo_forums_list()

    function redo_forums_panel(){
        $.get("/admin/fillin/getforumfillin", {id: $(selectedForumItem).data("id")}, function(html){
            $("#fillin_forums").html(html)
        })
    }
</script>
