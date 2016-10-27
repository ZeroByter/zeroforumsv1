<?php
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
            <span class="input-group-addon">Name</span>
            <input type="text" class="form-control" id="usertag_name_in" value="">
        </div>
        <div class="input-group">
            <span class="input-group-addon">The usertag order</span>
            <input type="text" class="form-control" id="usertag_listorder_in" value="">
        </div>
        <div class="checkbox" data-toggle="tooltip" title="Is this usertag considered a staff usertag? If so, it will be shown in the 'staff' page.">
            <label><input type="checkbox" id="usertag_isstaff_in">Is this usertag a staff usertag?</label>
        </div>
        <button type="button" class="btn btn-success" style="width:100%;" id="create_usertag">Create new usertag</button>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    })

    $("#create_usertag").click(function(){
        var name = $("#usertag_name_in").val()
        var listorder = $("#usertag_listorder_in").val()
        var isstaff = $("#usertag_isstaff_in").val()

        $.post("/admin/requests/createusertag", {name: name, listorder: listorder, isstaff: isstaff}, function(html){
            console.log(html)
            $("#fillin_usertag").html("")
            redo_usertaglist()
        })
    })
</script>
