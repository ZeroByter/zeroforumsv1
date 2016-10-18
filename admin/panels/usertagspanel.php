<?
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/navigatebar.php");
    include("../../phpscripts/essentials.php");

    if(!tag_has_permission(get_current_usertag(), "adminpnl_usertags_tab")){
        echo "<script>window.close()</script>";
    }
?>

<style>
    #usertag_links_list_div{
        width: 150px;
        height: calc(100% - 42px);
        border-right: 1px solid #dddddd;
        float: left;
    }

    .usertag_link_list_div, .usertag_fake_link_list_div{
        text-align: center;
        cursor: pointer;
        padding: 10px;
    }
    .usertag_link_list_div:hover, .usertag_fake_link_list_div:hover, .row_active{
        background: #dddddd;
    }
    .usertag_link_list_div[disabled]{
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

<div id="usertag_links_list_div">
    <center><br><span class="glyphicon glyphicon-link"></span> Navigation links</center>
    <br>
    <div class='usertag_fake_link_list_div' id="create_new_link" style="color: green;">Create a new usertag</div>
    <span id="fillin_usertaglist"></span>
</div>
<div id="main_usertag_div">
    <span id="fillin_usertag"></span>
</div>

<?
    if(!tag_has_permission(get_current_usertag(), "usertagpnl_create_usertag")){
        removeHTMLElement("#create_new_link");
    }
?>

<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    })

    $("#create_new_link").click(function(){
        $.get("fillin/getcreateusertag", function(html){
            $("#fillin_usertag").html(html)
            $(".usertag_link_list_div").removeClass("row_active")
        })
    })

    selectedUsertag = undefined

    function redo_usertaglist(active){
        if(active){
            $.get("fillin/getusertaglist", {active: active}, function(html){
                $("#fillin_usertaglist").html(html)
            })
        }else{
            $.get("fillin/getusertaglist", function(html){
                $("#fillin_usertaglist").html(html)
            })
        }
    }
    redo_usertaglist()

    function redo_panel(){
        $.get("fillin/getusertagfillin", {id: $(selectedUsertag).data("id")}, function(html){
            $("#fillin_usertag").html(html)
        })
    }
</script>
