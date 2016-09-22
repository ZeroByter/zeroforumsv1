<?
    include("../../phpscripts/getsql.php");
    include("../../phpscripts/accounts.php");
    include("../../phpscripts/usertags.php");
    include("../../phpscripts/navigatebar.php");
?>

<style>
    #link_main_div{
        width: 80%;
        margin: 0px auto;
    }

    .link_canview_list_div{
        width: 367px;
        float: right;
        padding: 6px 16px;
        border: 1px solid #cccccc;
        border-radius: 4px;
    }

    .link_canview_div{
        text-align: center;
        margin-top: 20px;
        margin-bottom: 18px;
    }
</style>

<div id="link_main_div" class="panel panel-default">
    <div class="panel-body">
        <div class="input-group">
            <span class="input-group-addon">Navigation bar title</span>
            <input type="text" class="form-control" id="navbar_title_in" value="<?echo get_navbar_title()->text;?>">
        </div>
        <button type="button" class="btn btn-success" style="width:100%;" id="edit_title">Edit title</button>
    </div>
</div>

<script>
    $("#edit_title").click(function(){
        var title = $("#navbar_title_in").val()

        $.post("/admin/requests/updatenavbartitle", {title: title}, function(html){
            $("#fillin_navigatebar").html("")
            redo_navigatelist()
        })
    })
</script>
