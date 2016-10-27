<?php
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/navigatebar.php");
    include("../../phpscripts/essentials.php");

    if(!tag_has_permission(get_current_usertag(), "adminpnl_newsposts_tab")){
        echo "<script>window.close()</script>";
    }
?>

<style>
    #newsposts_list_div{
        width: 150px;
        height: calc(100% - 42px);
        border-right: 1px solid #dddddd;
        float: left;
    }

    .newsposts_list_item_div, .newsposts_fake_link_list_div{
        text-align: center;
        cursor: pointer;
        padding: 10px;
    }
    .newsposts_list_item_div:hover, .newsposts_fake_link_list_div:hover, .row_active{
        background: #dddddd;
    }
    .newsposts_list_item_div[disabled]{
        color: grey;
        cursor: not-allowed;
    }

    #main_usertag_div{
        width: calc(100% - 150px);
        float: left;
        margin: 30px auto;
    }

    .input-group{
        margin: 4px 0px;
    }

    .toggle_btn{
        border-style: none;
		border-radius: 8px;
		padding: 4px 6px;
		margin: 2px;
		outline: none;
		box-shadow: 1px 1px 3px;
    }
    .toggle_btn[data-state=false]{
		color: black;
		background: #FF4F4F;
	}
	.toggle_btn[data-state=true]{
		color: black;
		background: #00CC00;
	}
</style>

<div id="newsposts_list_div">
    <center><br><span class="fa fa-newspaper-o"></span> News posts</center>
    <br>
    <div class='newsposts_fake_link_list_div' id="create_new_post" style="color: green;">Create a new news post</div>
    <span id="fillin_newspostslist"></span>
</div>
<div id="main_usertag_div">
    <span id="fillin_newsposts"></span>
</div>

<?php
    if(!tag_has_permission(get_current_usertag(), "newspnl_create_post")){
        removeHTMLElement("#create_new_post");
    }
?>

<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    })

    $("#create_new_post").click(function(){
        $.get("fillin/getcreatenewsposts", function(html){
            $("#fillin_newsposts").html(html)
            $(".newsposts_list_item_div").removeClass("row_active")
        })
    })

    selectedPost = undefined

    function redo_newspostslist(active){
        if(active){
            $.get("fillin/getnewspostslist", {active: active}, function(html){
                $("#fillin_newspostslist").html(html)
            })
        }else{
            $.get("fillin/getnewspostslist", function(html){
                $("#fillin_newspostslist").html(html)
            })
        }
    }
    redo_newspostslist()

    function redo_panel(){
        $.get("fillin/getnewspost", {id: $(selectedPost).data("id")}, function(html){
            $("#fillin_newsposts").html(html)
        })
    }
</script>
