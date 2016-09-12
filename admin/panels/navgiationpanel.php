<?
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/navigatebar.php");

    if(!tag_has_permission(get_current_usertag(), "adminpnl_navigation_tab")){
        echo "<script>window.close()</script>";
    }
?>

<style>
    #navigation_links_list_div{
        width: 150px;
        height: calc(100% - 42px);
        border-right: 1px solid #dddddd;
        float: left;
    }

    .navigation_link_list_div, .navigation_fake_link_list_div{
        text-align: center;
        cursor: pointer;
        padding: 10px;
    }
    .navigation_link_list_div:hover, .navigation_fake_link_list_div:hover, .row_active{
        background: #dddddd;
    }
    .navigation_link_list_div[disabled]{
        color: grey;
        cursor: not-allowed;
    }

    #main_navigation_div{
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

<div id="navigation_links_list_div">
    <center><br><span class="glyphicon glyphicon-link"></span> Navigation links</center>
    <br>
    <div class='navigation_fake_link_list_div' id="create_new_link" style="color: green;">Create a new link</div>
    <span id="fillin_navigatelist"></span>
</div>
<div id="main_navigation_div">
    <span id="fillin_navigatebar"></span>
</div>

<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    })

    $("#create_new_link").click(function(){
        $.get("fillin/getcreatenavigatelink", function(html){
            $("#fillin_navigatebar").html(html)
        })
    })

    selectedNavigatelink = undefined

    function redo_navigatelist(active){
        if(active){
            $.get("fillin/getnavigatelist", {active: active}, function(html){
                $("#fillin_navigatelist").html(html)
            })
        }else{
            $.get("fillin/getnavigatelist", function(html){
                $("#fillin_navigatelist").html(html)
            })
        }
    }
    redo_navigatelist()

    function redo_panel(){
        $.get("fillin/getnavigatelink", {id: $(selectedNavigatelink).data("id")}, function(html){
            $("#fillin_navigatebar").html(html)
        })
    }
</script>
